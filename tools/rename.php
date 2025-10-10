<?php
$zielverzeichnis = "/var/www/html/ebooks_neu";

$quellpfad = "/var/www/html/ebooks/Spiegel Bestseller Liste 2022 KW 41 bis KW 44 epub/Gerd Kommer - Der leichte Einstieg in die Welt der ETFs.epub";
$zielordner = "DerleichteEinstiegindieWeltderETFs";
$zielpfad = "/var/www/html/ebooks_neu/DerleichteEinstiegindieWeltderETFs/DerleichteEinstiegindieWeltderETFs-GerdKommer.epub";

if (!is_dir("$zielverzeichnis/$zielordner")) {
    mkdir("$zielverzeichnis/$zielordner");
    chmod("$zielverzeichnis/$zielordner", 0777);
    //chown("$zielverzeichnis/$zielordner", "matthias");
}

// Überprüfen, ob die ePUB-Datei existiert, bevor Sie sie verschieben

if (file_exists($zielpfad)) {
    
    if (@unlink($zielpfad) == true) {
        /**
         * Wenn die PHP-Funktion unlink() ein true
        Zurück gibt, wurde die Datei
        erfolgreich gelöscht. Dafür geben wir
        eine Meldung aus mit den echo Befehl.
         */
        echo 'Die Datei: ' . $zielpfad . ' wurde
        erfolgreich gelöscht.';
    } else {
        /**
         * Sollte ein Fehler beim Löschen der Datei
        auftreten, gibt die PHP-Funktion
        unlink() false zurück.
         */
        echo 'Die Datei: ' . $zielpfad . ' konnte
        nicht gelöscht werden!';
    }


}
    if (file_exists($quellpfad)) {
        if (rename($quellpfad, $zielpfad)) {
            echo "ePUB-Datei erfolgreich verschoben.";
        } else {
            echo "Fehler beim Verschieben der ePUB-Datei.";
        }
    } else {
        echo "ePUB-Datei nicht gefunden.";
    }

