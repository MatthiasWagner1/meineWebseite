<?php

function validateOrFallbackDate($inputDate) {
    try {
        $date = new DateTime($inputDate);
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        return '1999-01-01';
    }
}


function getDir($dir)
{
     $dh = opendir($dir);
    while ($file = readdir($dh)) {
        //echo 'bis hier geht es ';

        if ($file != "." && $file != "..") {
            if (is_dir("$dir/$file")) {
                getDir("$dir/$file"); // wenn Verzeichnis dann ruf dich selber auf
            } else {
                //$name="$dir/|$file"."\r\n"; // das zeichen | separiert pfad und file
                $name = ("$dir/$file");
                //echo '<br>File: '.$name;
                //exit;
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
                        $autor = $opf->getElementsByTagName('creator')->item(0)->nodeValue;
                        $isbn = $opf->getElementsByTagName('identifier')->item(0)->nodeValue;
                        $beschreibung = $opf->getElementsByTagName('description')->item(0)->nodeValue;
                        $sprache = $opf->getElementsByTagName('language')->item(0)->nodeValue;

                        $ausgabe = $opf->getElementsByTagName('issued')->item(0)->nodeValue;
                        $label = $opf->getElementsByTagName('label')->item(0)->nodeValue;
                        $herausgeber = $opf->getElementsByTagName('publisher')->item(0)->nodeValue;
                        $date = $opf->getElementsByTagName('date')->item(0)->nodeValue;

                        $date = validateOrFallbackDate($date);  // prüft ob das datum im richtigen format vorliegt
                        
                        $cover = $opf->getElementsByTagName('cover')->item(0)->nodeValue;

                        // wenn kein autor und kein titel
                        if ($title == "") {
                            $keintitel = $keintitel+1;
                            $title = 'kein Titel'.(string)$keintitel;
                        }

                        if ($autor == "") {
                                $autor = 'kein Autor';
                        }

                        str_replace(" ", "", $autor);

                        //echo '<br>File: '.$name;

                        //echo '<br>ISBN: '.$identifier;
                        //echo '<br>Sprache: '.$language;
                        //echo '<br>Cover: '.$cover;
                        //echo '<br>Beschreibung: '.$description;

                        // Autor mit Komma? -> umwandeln
                        if (stripos($autor, ",") !== false) {
                            $trennen = explode(",", $autor);
                            $autor = $trennen[1] . " " . $trennen[0];
                            trim($autor);
                            //echo $autor;
                        }
                        //$autor = str_replace("ö", "oe", $autor); // entfernt Sonderzeichen

                        $beschreibung = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $beschreibung); // entfernt alle Sonderzeichen
                        $title = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $title); // entfernt alle Sonderzeichen
                        $autor = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $autor); // entfernt alle Sonderzeichen
                        $herausgeber = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $herausgeber); // entfernt alle Sonderzeichen

                        $newtitle = str_replace(" ", "", "$autor-$title"); //entfernt alle Leerzeichen
                        $newtitle = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $newtitle . ".epub"); // entfernt alle Sonderzeichen
                        $newtitle = preg_replace( '/[^A-Za-zÄÖÜäöü0-9.-]/u', '_', $newtitle); // entfernt alle Sonderzeichen



                        // hier werden die Paltzhalter erstellt ==========================================

                        $quellverzeichnnis = $dir;
                        $quelldatei = $file;
                        $quellpfad = $name;

                        $zieldatei = $newtitle;

                        $zielverzeichnis = '/var/www/html/ebooks_neu';
                        //$zielverzeichnis = '/var/www/html/ebooks_neu'; //
                        $zielordner = str_replace(" ", "", $autor); //entfernt alle Leerzeichen
                        $zielpfad = "$zielverzeichnis/$zielordner/$zieldatei";

                        echo '<br>Quelldaten: ';
                        echo '<br>Autor: ' . $autor;
                        echo '<br>Titel: ' . $title;

                        echo '<br>identifier: ' . $isbn;
                        echo '<br>description: ' . $beschreibung;
                        echo '<br>language: ' . $sprache;
                        echo '<br>issued: ' . $ausgabe;
                        echo '<br>label: ' . $label;
                        echo '<br>publisher: ' . $herausgeber;
                        echo '<br>date: ' . $date;


                        echo '<br>Quellverzeichnnis: ' . $quellverzeichnnis;
                        echo '<br>Quelldatei: ' . $quelldatei;
                        echo '<br>Quellpfad: ' . $quellpfad;
                        echo "<br>";
                        echo '<br>Zieldaten: ';
                        echo '<br>Zielverzeichnis: ' . $zielverzeichnis;
                        echo '<br>Zielordner: ' . $zielordner;
                        echo '<br>Zieldatei: ' . $zieldatei;
                        echo '<br>Zielpfad: ' . $zielpfad;
                        echo "<br>";
                        echo "<br>========================================================================";

                        //exit;

                        if (!is_dir("$zielverzeichnis/$zielordner")) {
                            mkdir("$zielverzeichnis/$zielordner");
                            chmod("$zielverzeichnis/$zielordner", 0777);
                            //chown("$zielverzeichnis/$zielordner", "matthias");
                        }

                        //rename($name, "$zieldir/$ordner/$newtitle");
                        //rename($file, "$dir/$autor");

                        if (file_exists($zielpfad)) {


                            if (@unlink($quellpfad) == true) {      // unlinl löscht die datei
                                /*
                                Wenn die PHP-Funktion unlink() ein true
                                Zurück gibt, wurde die Datei
                                erfolgreich gelöscht. Dafür geben wir
                                eine Meldung aus mit den echo Befehl.
                                */
                                echo 'Die Datei: '.$quellpfad.' wurde
                                erfolgreich gelöscht.';
                                } else {
                                /*
                                Sollte ein Fehler beim Löschen der Datei
                                auftreten, gibt die PHP-Funktion
                                unlink() false zurück.
                                */
                                echo 'Die Datei: '.$quellpfad.' konnte
                                nicht gelöscht werden!';
                                }

                            }
                            else {




                        // Überprüfen, ob die ePUB-Datei existiert, bevor Sie sie verschieben
                        if (file_exists($quellpfad)) {
                            if (rename($quellpfad, $zielpfad)) {        // rename verschiebt die datei und benennt sie um


                        // =============================================================================================
                        //echo 'hier wird der datensatz in die db geschrieben ....';
                        // =============================================================================================

                        // hier öffnen wir die Verbindung zur Datenbank
                        include "ebooks_verbinden.php"; // db wird geöffnet

                        // exit;
                        // zuerst wird geprüft ob der autor bereits in der Tabelle tab_autoren ist
                        $id_autor = -1;
                        $erg = $pdo->prepare("SELECT * FROM ebooks.tab_autor");
                        $result = $erg->execute();
                            while ($auth = $erg->fetch()) {
                                //echo '<br>DBAutor: ' . $auth['name'];
                                //echo '<br>Autor  : ' . $autor;
                                //echo '<br>';
                                if ($autor == $auth['name']) {
                                    $id_autor = $auth['id_autor'];
                                    //echo '<br>TREFFER';
                                    //echo ' ID: ' . $id_autor;
                                    //echo '<br>';
                                    break; // Autor wurde gefunden => Schleife beenden
                                }
                            } //test
                            // der autor ist noch nicht in der Tabelle tab_autor => der neue autor wird eingefügt
                            if ($id_autor == -1) {
                                $qa = "INSERT INTO ebooks.tab_autor set name='" . $autor . "' ";
                                //echo '<br>sql: ' . $qa;
                                //exit;
                                $qa = $pdo->prepare($qa);
                                $result = $qa->execute();

                                // die id des neuen (letzten) datensatzes holen
                                $erg = "SELECT * FROM ebooks.tab_autor WHERE id_autor = ( SELECT max(id_autor) FROM ebooks.tab_autor LIMIT 1)";
                                //echo '<br>sql: ' . $erg;
                                //exit;
                                $erg = $pdo->prepare($erg);
                                $result = $erg->execute();
                                while ($auth = $erg->fetch()) {
                                    $id_autor = $auth['id_autor'];
                                }
                            }

                        //echo '<br>Autor: ' . $autor;
                        //echo '<br>id_autor: ' . $id_autor;
                        //exit;

                        $qu = "INSERT INTO ebooks.tab_ebooks set titel='" . $title . "', ";
                        $qu .= "fs_autor='" . $id_autor . "', ";
                        $qu .= "isbn='" . $isbn . "', ";
                        $qu .= "beschreibung='" . $beschreibung . "', ";
                        $qu .= "sprache='" . $sprache . "', ";
                        $qu .= "ausgabe='" . $ausgabe . "', ";
                        $qu .= "label='" . $label . "', ";
                        $qu .= "herausgeber='" . $herausgeber . "', ";
                        $qu .= "date='" . $date . "', ";
                        $qu .= "pfad='" . $zielpfad . "', ";
                        // Achtung beim letzten Teil KEIN Komma!!!
                        $qu .= "cover='" . $cover . "' ";

                        //echo $qu;
                        //echo "<br>Konto: ".$konto;
                        //echo "<br>Dopppel: ".$doppel;
                        //exit;

                        $qu = $pdo->prepare($qu);
                        $result = $qu->execute();

                        echo "ePUB-Datei erfolgreich verschoben und in DB eingetragen.";
                        //exit;
                    } else {
                        echo "Fehler beim Verschieben der ePUB-Datei.";
                    }
                } else {
                    echo "ePUB-Datei nicht gefunden.";
                }

                echo '<br>';
                $e = $e + 1;
                //exit;
            }
            } else {
                echo "Keine rootfile-Elemente gefunden.";
            }
            $zip->close();
        } else {
            echo "<br>Fehler beim Öffnen der EPUB-Datei.";
            echo '<br>File: '.$name;
            $f = $f + 1;
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
$keintitel = 0;
getDir('/var/www/html/ebooks'); // kein / am Ende !!!!

//getDir('/media/daten/Buecher/ebooks/ePub Bücherkiste 43'); // kein / am Ende !!!!
