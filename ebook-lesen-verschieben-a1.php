<?php
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
                        $author = $opf->getElementsByTagName('creator')->item(0)->nodeValue;
                        $isbn = $opf->getElementsByTagName('identifier')->item(0)->nodeValue;
                        $beschreibung = $opf->getElementsByTagName('description')->item(0)->nodeValue;
                        $sprache = $opf->getElementsByTagName('language')->item(0)->nodeValue;

                        $ausgabe = $opf->getElementsByTagName('issued')->item(0)->nodeValue;
                        $label = $opf->getElementsByTagName('label')->item(0)->nodeValue;
                        $herausgeber = $opf->getElementsByTagName('publisher')->item(0)->nodeValue;
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
                        
                        //$beschreibung = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $beschreibung); // entfernt alle Sonderzeichen
                        $title = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $title); // entfernt alle Sonderzeichen
                        $author = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $author); // entfernt alle Sonderzeichen
                        //$herausgeber = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $herausgeber); // entfernt alle Sonderzeichen

                        $newtitle = str_replace(" ", "", "$author-$title"); //entfernt alle Leerzeichen
                        $newtitle = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/', "", $newtitle . ".epub"); // entfernt alle Sonderzeichen
                        $newtitle = preg_replace( '/[^A-Za-zÄÖÜäöü0-9.-]/u', '_', $newtitle); // entfernt alle Sonderzeichen



                        // hier werden die Paltzhalter erstellt ==========================================

                        $quellverzeichnnis = $dir;
                        $quelldatei = $file;
                        $quellpfad = $name;

                        $zieldatei = $newtitle;
                        
                        $zielverzeichnis = '/var/www/html/ebooks_neu'; 
                        //$zielverzeichnis = '/var/www/html/ebooks_neu'; //
                        $zielordner = str_replace(" ", "", $author); //entfernt alle Leerzeichen
                        $zielpfad = "$zielverzeichnis/$zielordner/$zieldatei";

                        echo '<br>Quelldaten: ';
                        echo '<br>Author: ' . $author;
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
                        echo "<br>========================================================================<br>";

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
                            if (rename($quellpfad, $zielpfad)) {
                                
                               
                        // =============================================================================================
                        //echo 'hier wird der datensatz in die db geschrieben ....';
                        // =============================================================================================

                                // hier öffnen wir die Verbindung zur Datenbank
                                include "ebooks_verbinden.php"; // db wird geöffnet

                                // exit;
                                // zuerst wird geprüft ob der author bereits in der Tabelle tab_authoren ist
                                $id_author = -1;
                                $erg = $pdo->prepare("SELECT * FROM ebooks.tab_author");
                                $result = $erg->execute();
                                    while ($auth = $erg->fetch()) {
                                        echo '<br>DB Author: ' . $auth['name'];
                                        echo '<br>Author: ' . $author;
                                        if ($author == $auth['name']) {
                                        $id_author = $auth['id_author'];


                                    }
                                                            
                                // der author noch nicht in der Tabelle tab_author => der author wird eingefügt
                                if ($id_author = -1) {
                                    $qa = "INSERT INTO ebooks.tab_author set name='" . $author . "' ";
                                    //echo '<br>sql: ' . $qa;
                                    //exit;
                                    $qa = $pdo->prepare($qa);
                                    $result = $qa->execute(); // or die("SQL Error in: " . $result->queryString . " - " . $result->errorInfo()[2]);
                                    
                                }
                                }
                                // die id des neuen (letzten) datensatzes holen
                                $erg = "SELECT * FROM ebooks.tab_author WHERE id_author = ( SELECT max(id_author) FROM ebooks.tab_author LIMIT 1)";
                                
                                //echo '<br>sql: ' . $erg;
                                //exit;
                                
                                $erg = $pdo->prepare($erg);
                                $result = $erg->execute();
                                while ($auth = $erg->fetch()) {
                                 $id_author = $auth['id_author'];
                                }
                                
                                //echo '<br>Author: ' . $author;
                                //echo '<br>id_author: ' . $id_author;
                                //exit;

                                $qu = "INSERT INTO ebooks.tab_ebooks set titel='" . $title . "', ";
                                $qu .= "fs_author='" . $id_author . "', ";
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

getDir('/var/www/html/ebooks'); // kein / am Ende !!!!

//getDir('/media/daten/Buecher/ebooks/ePub Bücherkiste 43'); // kein / am Ende !!!!
