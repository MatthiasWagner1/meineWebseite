<?php

function isEpub($filePath) {
    $zip = new ZipArchive;
    if ($zip->open($filePath) === TRUE) {
        $mimetype = $zip->getFromName('mimetype');
        $zip->close();
        return trim($mimetype) === 'application/epub+zip';
    }
    return false;
}

function scanDirectory($directory, $pdo, $zielVerzeichnis, &$counter) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($rii as $file) {
        if ($file->isDir()) continue;

        $filePath = $file->getPathname();

        if (isEpub($filePath)) {
            echo "Verarbeite EPUB: $filePath<br>";

            try {
                $zip = new ZipArchive;
                $zip->open($filePath);
                $opfPath = getOpfPath($zip);
                $opfContent = $zip->getFromName($opfPath);

                $dom = new DOMDocument();
                @$dom->loadXML($opfContent);

                $autor = normalizeautor(getNodeValue($dom, 'creator'));
                $titel = getNodeValue($dom, 'title');

                if (empty($autor) || empty($titel)) {
                    $_SESSION['errors'][] = "Fehlende Metadaten (Autor oder Titel) [$filePath]";
                    $counter['errors']++;
                    continue;
                }

                processEpub($filePath, $pdo, $zielVerzeichnis, $counter);
                $counter['epubs']++;

            } catch (Exception $e) {
                $_SESSION['errors'][] = "Fehler bei Verarbeitung [$filePath] - " . $e->getMessage();
                $counter['errors']++;
            }

        } else {
            echo "Übersprungen (kein gültiger EPUB): $filePath<br>";
        }
    }
}

function getOpfPath($zip) {
    $container = $zip->getFromName('META-INF/container.xml');
    $xml = new DOMDocument();
    @$xml->loadXML($container);
    $rootfile = $xml->getElementsByTagName('rootfile')->item(0);
    return $rootfile->getAttribute('full-path');
}

function getNodeValue($doc, $tag) {
    $nodes = $doc->getElementsByTagName($tag);
    return $nodes->length ? trim($nodes->item(0)->nodeValue) : '';
}

function normalizeautor($autor) {
    $autor = preg_replace("/[\$'\\\\!]/", '', $autor);
    if (strpos($autor, ',') !== false) {
        [$nachname, $vorname] = array_map('trim', explode(',', $autor));
        $autor = "$vorname $nachname";
    }
    return trim($autor);
}

function processEpub($filePath, $pdo, $zielVerzeichnis, &$counter)
{
    if (!file_exists($filePath)) {
        $_SESSION['errors'][] = "Datei nicht gefunden: $filePath";
        $counter['errors']++;
        return;
    }

    $zip = new ZipArchive;
    if ($zip->open($filePath) === TRUE) {
        $opfPath = '';
        $container = $zip->getFromName('META-INF/container.xml');
        if ($container) {
            $xml = simplexml_load_string($container);
            $opfPath = (string) $xml->rootfiles->rootfile['full-path'];
        }

        $opfContent = $opfPath && $zip->locateName($opfPath)
            ? $zip->getFromName($opfPath)
            : null;

        if (!$opfContent) {
            $_SESSION['errors'][] = "OPF-Datei nicht gefunden in: $filePath";
            $autor = 'keinAutor';
            $title = 'keinTitel';
            $isbn = '';
            $beschreibung = '';
            $sprache = '';
            $veroeffentlichung = null;
            $cover = null;
        } else {
            $opf = new DOMDocument();
            @$opf->loadXML($opfContent);

            $autor = normalizeautor(getNodeValue($opf, 'creator')) ?: 'keinAutor';
            $title = getNodeValue($opf, 'title') ?: 'keinTitel';
            $sprache = getNodeValue($opf, 'language');
            $isbn = getNodeValue($opf, 'identifier');
            $beschreibung = getNodeValue($opf, 'description');

            $veroeffentlichung = getNodeValue($opf, 'date');
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $veroeffentlichung)) {
                $veroeffentlichung = null;
            }

            // Cover extrahieren
            $cover = null;
            try {
                $opfXml = simplexml_load_string($opfContent);
                $opfXml->registerXPathNamespace('opf', 'http://www.idpf.org/2007/opf');
                $opfXml->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');
                $coverId = '';
                foreach ($opfXml->metadata->meta as $meta) {
                    if ((string)$meta['name'] === 'cover') {
                        $coverId = (string)$meta['content'];
                        break;
                    }
                }

                $coverPath = '';
                foreach ($opfXml->manifest->item as $item) {
                    if ((string)$item['id'] === $coverId) {
                        $coverPath = dirname($opfPath) . '/' . (string)$item['href'];
                        break;
                    }
                }

                if ($coverPath && $zip->locateName($coverPath)) {
                    $cover = $zip->getFromName($coverPath);
                }
            } catch (Exception $e) {
                $cover = null; // falls fehlerhaft
            }
        }

        $zip->close();

        // Autor-ID holen oder anlegen
        $autor_id = getOrInsertautor($pdo, $autor);

        // Zielpfad aufbauen
        $autorVerzeichnis = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '', $autor));
        $zielOrdner = rtrim($zielVerzeichnis, '/') . '/' . $autorVerzeichnis;
        if (!is_dir($zielOrdner)) {
            mkdir($zielOrdner, 0775, true);
        }

        $zielDateiname = $autorVerzeichnis . '/' . str_replace(' ', '_', $autor) . '-' . str_pad($counter['epubs'] + 1, 3, '0', STR_PAD_LEFT) . '_-_' . str_replace(' ', '_', $title) . '.epub';
        $zielPfad = rtrim($zielVerzeichnis, '/') . '/' . $zielDateiname;

        // Datei verschieben
        if (@rename($filePath, $zielPfad)) {
            $_SESSION['epubs'][] = "Verschoben nach: $zielPfad";
        } else {
            $_SESSION['errors'][] = "Fehler beim Verschieben: $filePath ➜ $zielPfad";
            $counter['errors']++;
            return;
        }

        // Eintrag vorbereiten
        $data = [
            'title' => $title,
            'autor_id' => $autor_id,
            'isbn' => $isbn,
            'beschreibung' => $beschreibung,
            'sprache' => $sprache,
            'ausgabe' => '',
            'label' => '',
            'herausgeber' => '',
            'veroeffentlichung' => $veroeffentlichung,
            'eingetragen_am' => date('Y-m-d'),
            'pfad' => $zielDateiname,
            'cover' => empty($cover) ? '' : $cover
        ];

        try {
            insertEpubMetadata($pdo, $data);
            $counter['epubs']++;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Data too long for column \'cover\'')) {
                $data['cover'] = '';
                try {
                    insertEpubMetadata($pdo, $data);
                    $counter['epubs']++;
                    $_SESSION['errors'][] = "Cover zu groß, leer gespeichert: $filePath";
                } catch (PDOException $e2) {
                    $_SESSION['errors'][] = "Fehler beim Einfügen trotz leerem Cover [$filePath]: " . $e2->getMessage();
                    $counter['errors']++;
                }
            } elseif (strpos($e->getMessage(), 'Incorrect date value')) {
                $data['veroeffentlichung'] = null;
                try {
                    insertEpubMetadata($pdo, $data);
                    $counter['epubs']++;
                    $_SESSION['errors'][] = "Ungültiges Datum, leer gespeichert: $filePath";
                } catch (PDOException $e2) {
                    $_SESSION['errors'][] = "Fehler beim Einfügen trotz leerem Datum [$filePath]: " . $e2->getMessage();
                    $counter['errors']++;
                }
            } else {
                $_SESSION['errors'][] = "Fehler beim Einfügen [$filePath]: " . $e->getMessage();
                $counter['errors']++;
            }
        }

    } else {
        $_SESSION['errors'][] = "Datei konnte nicht geöffnet werden: $filePath";
        $counter['errors']++;
    }
}


function insertEpubMetadata($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO ebooks.tab_ebooks
        (titel, fs_autor, isbn, beschreibung, sprache, ausgabe, label, herausgeber, veroeffentlichung, eingetragen_am, pfad, cover)
        VALUES (:title, :autor_id, :isbn, :beschreibung, :sprache, :ausgabe, :label, :herausgeber, :veroeffentlichung, :eingetragen_am, :pfad, :cover)");
    $stmt->execute($data);
}

function getOrInsertautor($pdo, $autor) {
    // Autor suchen
    $stmt = $pdo->prepare("SELECT id_autor FROM ebooks.tab_autor WHERE name = :name");
    $stmt->execute(['name' => $autor]);
    $row = $stmt->fetch();

    if ($row) {
        return $row['id_autor'];
    }

    // Autor einfügen
    $stmt = $pdo->prepare("INSERT INTO ebooks.tab_autor (name) VALUES (:name)");
    $stmt->execute(['name' => $autor]);
    return $pdo->lastInsertId();
}
