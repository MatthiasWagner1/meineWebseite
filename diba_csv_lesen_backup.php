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

<h1><a href="heimnetz.php"> Heimnetz - Konten</a></h1>
<h2>Buchungen aus: meineWebseite/Umsatzanzeige.csv geladen....</a></h1>

 <?php
 include "heimnetz_verbinden.php"; // db wird geöffnet






 
 $s = ($_REQUEST['s']); // wenn $s = 1 dann schreibe die Daten in die DB
 // echo " s = : ".$s;

// CSV-Datei auslesen
// hier werdn Kunde, IBAN und Saldo geholt
$daten = file("../Umsatzanzeige.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
      $saldo = str_replace(".","",$saldo);		// löscht punkt im string
      $saldo = str_replace(",",".",$saldo);		// ändert komma in punkt
      $saldo = (float)$saldo;	// ändert string in zahl mit 2 nachkomma stellen
      }
}

if ($kunde == 'Matthias Wagner') {
  $konto = 1;
}
if ($kunde == 'Claudia Wagner') {
  $konto = 2;
}

echo "<h2>Umsätze: ".$kunde."<br>";
echo "Saldo: ".$saldo." €</h2>";
echo "Zeitraum: ".$zeitraum."<br>";
echo "IBAN: ".$iban."<br>";
echo '<br>';

if ($s != 1) {
?> 
<form method='post'>
    <input formaction="diba.php" type="Submit" name="" value="zurück">
    <input formaction="diba_csv_lesen.php?s=1" type="Submit" name="" value="Daten speichern">
</form>
<br>
<?php
exit;
}
?> 

<!-- hier beginnt die Tabelle -->
<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th><th>Saldo</th></tr>
 
<?php
//exit;

// ============= Anfang der csv schleife =================================================================

// hier werden die Kontodaten aus der csv geholt
$doppel = 0;
$anzahl = 0;
$daten = file("../Umsatzanzeige.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($daten as $nr => $data) {
 list($spalte1, $spalte2, $spalte3, $spalte4, $spalte5, $spalte6, $spalte7, $spalte8, $spalte9) = explode(";", $data); // ; Trennzeichen
 if ($nr > 9) {

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
    
    if ($buchung = '�berweisung') $buchung = 'Überweisung';

    // Saldo  umwandeln   
    $saldo = $spalte6;
    $saldo = str_replace(".","",$saldo);		// löscht punkt im string
		$saldo = str_replace(",",".",$saldo);		// ändert komma in punkt
		$saldo = (float)$saldo;	// ändert string in zahl mit 2 nachkomma stellen

    // Betrag  umwandeln    
    $betrag = $spalte8;
		$betrag = str_replace(".","",$betrag);		// löscht punkt im string
		$betrag = str_replace(",",".",$betrag);		// ändert komma in punkt
		$betrag = (float)$betrag;	// ändert string in zahl mit 2 nachkomma stellen

    // Datum  umwandeln
    $originalDate = $datum;
    //original date is in format YYYY-mm-dd
    $timestamp = strtotime($originalDate); 
    $datum_sql = date("y-m-d", $timestamp ); 


 // ====================== Kategorien zuordnen ========================================

  // Einkäufe
  $suchwort = array("edeka", "netto", "norma", "lidl", "rossmann", "toom", "beck", "aldi", "kalchreuther", "fristo", "amazon", "regler", "rewe", "tailor", "kist", "drogerie", "kik", "center", "apotheke"); 

  foreach ($suchwort as $word) {
      if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
         $kategorie = "Einkäufe";
         //echo "Das Wort '$word' ist im Text enthalten.";
         //exit;
      } else {
       //echo "Das Wort '$word' ist NICHT im Text enthalten.";
   }
  }

  // Treibstoff
   $suchwort = array("esso", "shell", "agip", "elan", "total", "omv", "avia", "aral"); 

   foreach ($suchwort as $word) {
       if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
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
		if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
			$kategorie = "Golf";
			//echo "Das Wort '$word' ist im Text enthalten.";
			//exit;
		} else {
		//echo "Das Wort '$word' ist NICHT im Text enthalten.";
	}
	}
	
	// Haus
	$suchwort = array("gemeinde", "landkreis", "n-ergie", "google", "fraenk", "mobil", "m-net", "heimwerk", "verein", "bundeskasse", "powwow", "entega", "ringer"); 

	foreach ($suchwort as $word) {
		if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
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
      if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
         $kategorie = "Versicherung";
         //echo "Das Wort '$word' ist im Text enthalten.";
         //exit;
      } else {
       //echo "Das Wort '$word' ist NICHT im Text enthalten.";
   }
  }

// Einnahmen
$suchwort = array("rente", "winning", "bargeld", "amt", "helene", "bolta", ""); 

foreach ($suchwort as $word) {
	if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
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
	if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
		$kategorie = "Urlaub";
		//echo "Das Wort '$word' ist im Text enthalten.";
		//exit;
	} else {
	//echo "Das Wort '$word' ist NICHT im Text enthalten.";
}
}	 

// Sonstiges
$suchwort = array("paypal"); 

foreach ($suchwort as $word) {
	if (stripos($empfang, $word) !== false) {  // stripos statt strpos = klein- grossschreibung egal
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
while($data = $erg->fetch()) {
  $doppel = 0;
  $id = $data['id'];
  //$datum1 = $data['datum'];

  // Datum in dd.mm.yyyy umwandeln
  $originalDate = $data['datum'];
  //original date is in format YYYY-mm-dd
  $timestamp = strtotime($originalDate); 
  $datum1 = date("d.m.Y", $timestamp );
    
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

// hier werden die Kategorien zugeordnet









  echo "<tr><td>".$konto."</td><td>".$datum."</td><td>".$empfang."</td><td align=right>".$betrag."</td><td align=right>".$saldo."</td></tr>";
  //echo "<tr><td>".$konto."</td><td>".$datum1."</td><td>".$empfang1."</td><td align=right>".$betrag1."</td><td align=right>".$saldo1."</td></tr>";

  //echo 'hier wird der datensatz in die db geschrieben ....';
  // exit;

    
    $qu = "INSERT INTO heimnetz.konten set konto='".$konto."', ";
    $qu.="datum='".$datum_sql."', ";
    $qu.="empfang='".$empfang."', ";
    $qu.="buchung='".$buchung."', ";
    $qu.="kategorie='".$kategorie."', ";
    $qu.="notiz='".$notiz."', ";
    $qu.="verwendung='".$verwendung."', ";
    $qu.="saldo='".$saldo."', ";
    // Achtung beim letzten Teil KEIN Komma!!!
    $qu.="betrag='".$betrag."' ";
    
 
    echo $qu;
    //exit;

    $qu = $pdo->prepare($qu);
    $result = $qu->execute() or die("SQL Error in: ".$result->queryString." - ".$result->errorInfo()[2]);
    //$result = $qu->execute();

    

//exit;


}  

} 
// ============= ende der csv schleife =================================================================
 
}
echo "Anzahl der neuen Buchungen: ".$anzahl;
//$pdo = null;
?> 
</table>
</div>
<br>
<?php echo $anzahl ?> Buchungen eingelesen.
<br><br>
<form>
    <input formaction="diba.php" type="Submit" name="" value="zurück">
</form>
<br>

