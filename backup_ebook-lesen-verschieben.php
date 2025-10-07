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
                        $author = $opf->getElementsByTagName('creator')->item(0)->nodeValue;
                        $identifier = $opf->getElementsByTagName('identifier')->item(0)->nodeValue;
                        $description = $opf->getElementsByTagName('description')->item(0)->nodeValue;
                        $language = $opf->getElementsByTagName('language')->item(0)->nodeValue;

                        $issued = $opf->getElementsByTagName('issued')->item(0)->nodeValue;
                        $label = $opf->getElementsByTagName('label')->item(0)->nodeValue;
                        $publisher = $opf->getElementsByTagName('publisher')->item(0)->nodeValue;
                        $date = $opf->getElementsByTagName('date')->item(0)->nodeValue;
                        
                        $cover = $opf->getElementsByTagName('cover')->item(0)->nodeValue;



                        str_replace(" ", "", $author);

                        //echo '<br>File: '.$name;

                        //echo '<br>ISBN: '.$identifier;
                        //echo '<br>Sprache: '.$language;
                        //echo '<br>Cover: '.$cover;
                        //echo '<br>Beschreibung: '.$description;

                        // Author mit Komma? -> umwandeln
                        if (stripos($author, ",") !== false) {
                            $trennen = explode(",", $author);
                            $author = $trennen[1] . " " . $trennen[0];
                            trim($author);
                            //echo $author;
                        }
                        //$author = str_replace("ö", "oe", $author); // entfernt Sonderzeichen
                        $author = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $author); // entfernt alle Sonderzeichen
                        //$ordner = "ebooks_neu/".$ordner;
                        $newtitle = str_replace(" ", "", "$author-$title"); //entfernt alle Leerzeichen
                        $newtitle = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $newtitle . ".epub"); // entfernt alle Sonderzeichen

                        // hier werden die Paltzhalter erstellt ==========================================

                        $quellverzeichnnis = $dir;
                        $quelldatei = $file;
                        $quellpfad = $name;

                        $zieldatei = $newtitle;
                        
                        $zielverzeichnis = '/var/www/html/meineWebseite/html/ebooks_neu'; 
                        //$zielverzeichnis = '/var/www/html/ebooks_neu'; //
                        $zielordner = str_replace(" ", "", $author); //entfernt alle Leerzeichen
                        $zielpfad = "$zielverzeichnis/$zielordner/$zieldatei";

                        echo '<br>Quelldaten: ';
                        echo '<br>Author: ' . $author;
                        echo '<br>Titel: ' . $title;

                        echo '<br>identifier: ' . $identifier;
                        echo '<br>description: ' . $description;
                        echo '<br>language: ' . $language;
                        echo '<br>issued: ' . $issued;
                        echo '<br>label: ' . $label;
                        echo '<br>publisher: ' . $publisher;
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
                        //rename($file, "$dir/$author");

                        if (file_exists($zielpfad)) {


                            if (@unlink($quellpfad) == true) {
                                /**
                                * Wenn die PHP-Funktion unlink() ein true
                                Zurück gibt, wurde die Datei
                                erfolgreich gelöscht. Dafür geben wir
                                eine Meldung aus mit den echo Befehl.
                                */
                                echo 'Die Datei: '.$quellpfad.' wurde
                                erfolgreich gelöscht.';
                                } else {
                                /**
                                * Sollte ein Fehler beim Löschen der Datei
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
                            if (rename($quellpfad, $zielpfad)) {
                                echo "ePUB-Datei erfolgreich verschoben.";
                            } else {
                                echo "Fehler beim Verschieben der ePUB-Datei.";
                            }
                        } else {
                            echo "ePUB-Datei nicht gefunden.";
                        }

                        echo '<br>';

                        //$e = $e + 1;
                        //exit;

                    
                    }
                    
                    
                    
                    } else {
                        echo "Keine rootfile-Elemente gefunden.";
                    }
                    $zip->close();
                } else {
                    echo "<br>Fehler beim Öffnen der EPUB-Datei.";
                    echo '<br>File: '.$name;
                    //$f = $f + 1;
                }

            }
        }
    }
    closedir($dh);
    //$mysqli->close();
    //echo "<br>Anzahl epub: " . $e;
    //echo "<br> Anzahl Fehler: " . $f;
}

// die Funktion getDir liest rekursiv das übergebenen Verzeichnis
$e = 0;
$f = 0;
getDir('/var/www/html/meineWebseite/html/ebooks'); // kein / am Ende !!!!
//getDir('/var/www/html/ebooks'); // kein / am Ende !!!!
