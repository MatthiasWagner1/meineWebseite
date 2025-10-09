<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../diba_formate.css" type="text/css">
  <title>ING</title>
</head>
<body>

// Hier wird die Datei ausgewählt und die Daten übernommen
<main>
    <h2>CSV Datei auswählen</h1>
    <form action="diba_csv_lesen.php?s=1" method="post" enctype="multipart/form-data">
        <label for="csvFile"></label>
        <input type="file" name="csvFile" id="csvFile" accept=".csv">
        <br>
        <br>
        <input style="height: 40px; width: 200px; margin: 15px 0px" type="submit" value="in Datenbank übernehmen">
    </form>
</body>
</html>

<?php

// Hier können Sie den Pfad einstellen, in dem die Dateien gespeichert werden sollen
$uploadPath = "/var/www/html/meineWebseite/";
$s = ($_REQUEST['s']); // wenn $s = 1 dann schreibe die Daten in die DB

if ($_FILES["csvFile"]["error"] > 0) {
    echo "Fehler beim Hochladen der Datei: " . $_FILES["csvFile"]["error"];
} else {
    $filename = $_FILES["csvFile"]["name"];
    $filetype = $_FILES["csvFile"]["type"];
    $filesize = $_FILES["csvFile"]["size"];
    $tmpFile = $_FILES["csvFile"]["tmp_name"];

    // Überprüfen, ob es sich um eine CSV-Datei handelt
    if ($filetype == "text/csv" || $filetype == "application/vnd.ms-excel") {
        // Pfad zum Zielordner und Dateinamen
        $targetPath = $uploadPath . $filename;

        // Verschieben Sie die hochgeladene Datei an den Zielort
        if (move_uploaded_file($tmpFile, $targetPath)) {
            //echo "Datei erfolgreich hochgeladen und gespeichert: " . $targetPath;

            // Öffne die CSV-Datei und zeige den Inhalt an
            if (($handle = fopen($targetPath, "r")) == false) {
                echo "<table border='1'>";
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    echo "<tr>";
                    foreach ($data as $cell) {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
                    }
                    echo "</tr>";
                }
                fclose($handle);
                echo "</table>";
            } else {
                //echo "Fehler beim Öffnen der Datei.";
            }
        } else {
            echo "Fehler beim Speichern der Datei.";
        }
    } else {
        //echo "Nur CSV-Dateien sind erlaubt.";
    }
}

// ============== hier geht es nur weiter wenn in DB übernommen wird =====================================================
if ($s == 1) {
    include "heimnetz_verbinden.php"; // db wird geöffnet
    ?>

<!-- hier beginnt die Tabelle -->
<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th><th>Saldo</th></tr>
<?php



// ============= Anfang der csv schleife =================================================================

// hier werden die Kontodaten aus der csv geholt
    $doppel = 0;
    $anzahl = 0;
    $daten = file($targetPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($daten as $nr => $data) {
        list($spalte1, $spalte2, $spalte3, $spalte4, $spalte5, $spalte6, $spalte7, $spalte8, $spalte9) = explode(";", $data); // ; Trennzeichen

        if ($nr == 4) {
            $kunde = $spalte2;
            if ($kunde == 'Matthias Wagner') {
                $konto = 1;
            }
            if ($kunde == 'Claudia Wagner') {
                $konto = 2;
            }
        }

        if ($nr > 9) { // die 1. Zeile = 0, der erste Datensatz steht in 15 dann > 9, skip empty lines


/*
echo "Kunde: ".$kunde;
echo "<br>";            
echo "File: ".$filename;
echo "<br>";
          
echo "Pfad: ".$targetPath;
echo "<br>";

echo "Spalte1: ".$spalte1;
echo "<br>";
echo "Spalte2: ".$spalte2;
echo "<br>";
echo "Spalte3: ".$spalte3;
echo "<br>";
echo "Spalte4: ".$spalte4;
echo "<br>";
echo "Spalte5: ".$spalte5;
echo "<br>";
echo "Spalte6: ".$spalte6;
echo "<br>";
echo "Spalte7: ".$spalte7;
echo "<br>";
echo "Spalte8: ".$spalte8;
echo "<br>";
echo "Spalte9: ".$spalte9;
echo "<br>";
*/

//exit;


/*  mit notiz in der csv
$datum = $spalte1;
$empfang = $spalte3;
$buchung = $spalte4;
$notiz = $spalte5;
$verwendung = $spalte6;
$saldo = $spalte7;
$betrag = $spalte9;
 */

/*  ohne notiz in der csv */
            $datum = $spalte1;

            $empfang = $spalte3;
            $buchung = $spalte4;
            //$notiz = $spalte5;
            $verwendung = $spalte5;

            if ($buchung = '�berweisung') {
                $buchung = 'Überweisung';
            }
// ============= Falls etwas mit der CSV nicht stimmt =================================================================  

           // echo "Kunde: ".$kunde;
           // echo "Empfänger: ".$empfang;
           // exit;

// =====================================================================================================================

            // Saldo  umwandeln
            $saldo = $spalte6;
            $saldo = str_replace(".", "", $saldo); // löscht punkt im string
            $saldo = str_replace(",", ".", $saldo); // ändert komma in punkt
            $saldo = (float) $saldo; // ändert string in zahl mit 2 nachkomma stellen

            // Betrag  umwandeln
            $betrag = $spalte8;
            $betrag = str_replace(".", "", $betrag); // löscht punkt im string
            $betrag = str_replace(",", ".", $betrag); // ändert komma in punkt
            $betrag = (float) $betrag; // ändert string in zahl mit 2 nachkomma stellen

            // Datum  umwandeln
            $originalDate = $datum;
            //original date is in format YYYY-mm-dd
            $timestamp = strtotime($originalDate);
            $datum_sql = date("y-m-d", $timestamp);

            // ====================== Kategorien zuordnen ========================================

            $kategorie = "Einkäufe";

            // Einkäufe
            $suchwort = array("karstdt", "edeka", "paypal", "netto", "norma", "lidl", "rossmann", "beck", "aldi", "kalchreuther", "fristo", "amazon", "regler", "rewe", "tailor", "kist", "drogerie", "kik", "center", "apotheke");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Einkäufe";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

            // Treibstoff
            $suchwort = array("supol", "esso", "shell", "agip", "elan", "total", "omv", "avia", "aral");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Treibstoff";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

            // Golf
            $suchwort = array("golf");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Golf";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

            // Haus
            $suchwort = array("novalnet", "toom", "gemeinde", "landkreis", "n-ergie", "google", "fraenk", "mobil", "m-net", "heimwerk", "verein", "bundeskasse", "powwow", "entega", "ringer");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Haus";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

            // Versicherung
            $suchwort = array("devk", "allianz", "versicherung", "itzehoer", "wefox", "ergo", "hansemerkur");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Versicherung";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

// Einnahmen
            // $suchwort = array("rente", "winning", "bargeld", "amt", "helene", "bolta", "");
            $suchwort = array("rente", "winning", "bargeld", "amt", "helene", "bolta");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Einnahmen";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

// Urlaub
            $suchwort = array("agoda", "booking", "touristik", "7-11", "udon", "chiang", "trip", "hotel", "flug", "khon");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Urlaub";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

// Sonstiges
            $suchwort = array("parkhaus");

            foreach ($suchwort as $word) {
                if (stripos($empfang, $word) !== false) { // stripos statt strpos = klein- grossschreibung egal
                    $kategorie = "Sonstiges";
                    //echo "Das Wort '$word' ist im Text enthalten.";
                    //exit;
                } else {
                    //echo "Das Wort '$word' ist NICHT im Text enthalten.";
                }
            }

// ====================== Ende Kategorien zuordnen ========================================

// hier eine schleife die die sql db durchläuft und sobald ein doppel auftritt die schleife beenden
// folgende felder müssen identisch sein um ein doppel zu identifizieren:

// konto, datum, betrag, empfänger, verwendungszweck ????

// ============= Anfang der sql schleife =================================================================

// hier durchlaufen wir die sql db und vergleichen mit dem csv datensatz ob er schon vorhanden ist
// dann wird $doppel gesetzt und beendet da dem ersten doppel nur noch weitere doppel kommen
            $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = $konto ORDER BY datum DESC");
            $result = $erg->execute();
            while ($data = $erg->fetch()) {
                $doppel = 0;
                $id = $data['id'];
                //$datum1 = $data['datum'];

                // Datum in dd.mm.yyyy umwandeln
                $originalDate = $data['datum'];
                //original date is in format YYYY-mm-dd
                $timestamp = strtotime($originalDate);
                $datum1 = date("d.m.Y", $timestamp);

                $empfang1 = $data['empfang'];
                $betrag1 = $data['betrag'];
                $verwendung1 = $data['verwendung'];
                $saldo1 = $data['saldo'];

                // hier vergleiche ich Empfänger, Saldo, Betrag und das Datum => wenn gleich dann doppel!
                if (($empfang == $empfang1) && ($saldo == $saldo1) && ($betrag == $betrag1) && ($datum == $datum1)) {
                    $doppel = 1;
                    //echo 'Doppel='.$doppel.' '.$datum.' '.$datum1.' '.$empfang.' '.$empfang1.'<br>';
                    //echo $saldo.' '.$saldo1.' '.$betrag.' '.$betrag1.'<br>';

                    // beendet die sql schleife



                    break;
                }

            }

// ============= ende der sql schleife =================================================================

// wenn $doppel false dann schreibe den Datensatz

            if ($doppel !== 1) {
                
                

                
                
                
                
                $anzahl = $anzahl + 1;

                echo "<tr><td>" . $konto . "</td><td>" . $datum . "</td><td>" . $empfang . "</td><td align=right>" . $betrag . "</td><td align=right>" . $saldo . "</td></tr>";
                //echo "<tr><td>".$konto."</td><td>".$datum1."</td><td>".$empfang1."</td><td align=right>".$betrag1."</td><td align=right>".$saldo1."</td></tr>";

                //echo 'hier wird der datensatz in die db geschrieben ....';
                // exit;

                $qu = "INSERT INTO heimnetz.konten set konto='" . $konto . "', ";
                $qu .= "datum='" . $datum_sql . "', ";
                $qu .= "empfang='" . $empfang . "', ";
                $qu .= "buchung='" . $buchung . "', ";
                $qu .= "kategorie='" . $kategorie . "', ";
                $qu .= "notiz='" . $notiz . "', ";
                $qu .= "verwendung='" . $verwendung . "', ";
                $qu .= "saldo='" . $saldo . "', ";
                // Achtung beim letzten Teil KEIN Komma!!!
                $qu .= "betrag='" . $betrag . "' ";

                //echo $qu;
                //echo "<br>Konto: ".$konto;
                //echo "<br>Dopppel: ".$doppel;
                //exit;

                $qu = $pdo->prepare($qu);
                $result = $qu->execute() or die("FEHLER beim Schreiben der DB in folgendem Datensatz:");
                //$result = $qu->execute() or die("SQL Error in: " . $result->queryString . " - " . $result->errorInfo()[2]);
                //$result = $qu->execute();
//exit;
            }
            else {
                /*
                echo "<br>"; 
                echo "Erste doppelte Buchung erreicht!";
                echo "<br>"; 
                echo "Datum: ".$datum." Empfänger: ".$empfang;
                echo "<br>";
                */
            }
        }
// ============= ende der csv schleife =================================================================
    }
    echo "Anzahl der neuen Buchungen: " . $anzahl;
    ?>
</table>
</div>
<br>
<?php
echo $anzahl . " Buchungen eingelesen.";

} // ============= ende der $s Abfrage (db schreiben)=================================================================
?>


<br><br>

<form>
    <input formaction="diba.php" type="Submit" name="" value="zurück">
</form>
<br>

