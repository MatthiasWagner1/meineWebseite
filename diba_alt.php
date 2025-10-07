<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../diba_formate.css" type="text/css">
  <title>ING</title>
</head> 
<body>

<main>
<!-- hier beginnt die Tabelle -->
<div class = "privat">
<table>
<tr><th>Datum</th><th>Empfänger</th><th>Betrag</th></tr>
 <?php
 include "heimnetz_verbinden.php"; // db wird geöffnet




// CSV-Datei auslesen

// hier werdn Kunde, IBAN und Saldo geholt
$daten = file("../Umsatzanzeige_Matthias05-2022-05-2023.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($daten as $nr => $data) {
 list($spalte1, $spalte2, $spalte3, $spalte4, $spalte5, $spalte6, $spalte7, $spalte8, $spalte9) = explode(";", $data); // ; Trennzeichen
 if ($nr == 1) {
    $iban = $spalte2;
    }
    if ($nr == 4) {
      $kunde = $spalte2;
      }
      if ($nr == 5) {
        $zeitraum = $spalte2;
        }
      if ($nr == 6) {
      $saldo = $spalte2;
      }
}
echo "<h2>Umsätze: ".$kunde."<br>";
echo "Saldo: ".$saldo." €</h2>";
echo "Zeitraum: ".$zeitraum."<br>";
echo "IBAN: ".$iban."<br>";

// hier werden die Kontodaten geholt
$daten = file("../Umsatzanzeige_Matthias_test.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($daten as $nr => $data) {
 list($spalte1, $spalte2, $spalte3, $spalte4, $spalte5, $spalte6, $spalte7, $spalte8, $spalte9) = explode(";", $data); // ; Trennzeichen
 if ($nr > 11) {
    $konto = 1; // Konto Matthias, Claudi = 2
    $datum = $spalte1;
    $empfang = $spalte3;
    $buchung = $spalte4;
    $notiz = $spalte5;
    $verwendung = $spalte6;
    $saldo = $spalte7;
    $betrag = $spalte9;
    
    
    $qu = "INSERT INTO heimnetz.konten set konto='".$konto."', ";
    $qu.="datum='".$datum."', ";
    $qu.="empfang='".$empfang."', ";
    $qu.="buchung='".$buchung."', ";
    $qu.="notiz='".$notiz."', ";
    $qu.="verwendung='".$verwendung."', ";
    $qu.="saldo='".$saldo."', ";
    // Achtung beim letzten Teil KEIN Komma!!!
    $qu.="betrag='".$betrag."' ";
    
 
    //echo $qu;
    //exit;

    $qu = $pdo->prepare($qu);
   	$result = $qu->execute();



    
    //echo "<tr><td>".$datum."</td><td>".$empfang."</td><td align=right>".$betrag."</td></tr>";
   
  
  
  
  
  
  
  }
}
echo "Anzahl Buchungen: ".$nr;
?> 
</table>
</div>



