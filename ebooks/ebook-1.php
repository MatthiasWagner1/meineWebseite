<?php
function getDir($dir)
{
    $dh = opendir($dir);

    // hier öffnen wir die Verbindung zur Datenbank

    while ($file = readdir($dh)) {
        //echo 'bis hier geht es ';

        if ($file != "." && $file != "..") {
            if (is_dir("$dir/$file")) {
                getDir("$dir/$file"); // wenn Verzeichnis dann ruf dich selber auf
            } else {
                //$name="$dir/|$file"."\r\n"; // das zeichen | separiert pfad und file
                $name = ("$dir/$file");
                echo '<br>File: ' . $name;
                //exit;
                //$name = '/var/www/html/ebooks/Prof. Dr. Andreas Michalsen - Mit Ern';
                //echo '<br>File: ' . $name;
                $zip = new ZipArchive();
                if ($zip->open($name) === true) {
                    $metadataFile = $zip->getFromName('META-INF/container.xml');
                    $container = new DOMDocument();
                    $container->loadXML($metadataFile);
                    $rootfiles = $container->getElementsByTagName('rootfile');
                    if ($rootfiles->length > 0) {
                        $rootfile = $rootfiles->item(0);
                        $rootfilePath = $rootfile->getAttribute('full-path');
                        $opfFile = $zip->getFromName($rootfilePath);
                        $opf = new DOMDocument();
                        $opf->loadXML($opfFile);

                        $title = $opf->getElementsByTagName('title')->item(0)->nodeValue;
                        $author = $opf->getElementsByTagName('creator')->item(0)->nodeValue;

                        echo "<br>Titel: $title\n";
                        echo "<br>Autor: $author\n";
                        exit;
                    } else {
                        echo "Keine rootfile-Elemente gefunden.";
                    }
                    $zip->close();
                } else {
                    echo "<br>Fehler beim Öffnen der EPUB-Datei.";
                    exit;
                }

            }
        }
    }
    closedir($dh);
    //$mysqli->close();
    echo "<br>Anzahl epub: " . $e;
    echo "<br> Anzahl Fehler: " . $f;
}

// die Funktion getDir liest rekursiv das übergebenen Verzeichnis
$e = 0;
$f = 0;
//getDir('/var/www/html/meineWebseite/html/ebooks'); // kein / am Ende !!!!
getDir('/var/www/html/ebooks'); // kein / am Ende !!!!