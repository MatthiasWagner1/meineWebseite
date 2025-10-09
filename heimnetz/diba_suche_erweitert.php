<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../diba_formate.css" type="text/css">
  <title>erweiterte Suche</title>
</head>
<body>

<header>
    <?php
    include "header.php"; // die Menüs einbinden
    ?>
  </header>

<main>
<?php
echo "Übergeben wurde der Name " . $_GET["erg"];
?>


<h1><a href="heimnetz.php"> erweiterte Suche</a></h1>

 <!-- Button Seite neu laden -->
<form method='post' >
      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">
      <input formaction="diba.php" type="Submit" name="" value="ING">
</form>
<br>
<div class = "diba_formular1" >
<br>

<form method='post' action="diba_suche_erweitert.php?i=0">

<table>

<tr><td>Konto:</td><td> <select name="konto">
  <option value="alle">Alle</option>
  <option selected="selected" value="matthias">Matthias</option>
  <option value="claudia">Claudia</option>
</select></td></tr>

<tr><td>Kategorie:</td><td> <select name="kategorie" id="kategorie">
<option value="alle">Alle</option>
<?php
include "heimnetz_verbinden.php"; // db wird geöffnet

$erg = $pdo->prepare("SELECT * FROM konten_kategorie");
$result = $erg->execute();
	while($kat = $erg->fetch()) {
    $id=$kat['id_kat'];

  // wenn eine kategorie übergeben wird dann soll es hier selektiert werden
  if ($kategorie == $kat['name_kategorie']) {
      echo '<option value = '. $kat['name_kategorie'].' selected="selected">'.$kat['name_kategorie'].'</option>';
  } else {
      echo '<option value = '. $kat['name_kategorie'].'>'.$kat['name_kategorie'].'</option>';
  }
}
?>
</select></td></tr>

<tr><td>Jahr:</td><td> <select name="jahr">
  <option value="alle">Alle</option>
  <option selected="selected" value="2023">2023</option>
  <option value="2022">2022</option>
</select></td></tr>

<tr><td>Monat:</td><td> <select name="monat">
  <option value="alle">Alle</option>
  <option value="januar">Januar</option>
  <option value="februar">Februar</option>
  <option value="maerz">März</option>
  <option value="april">April</option>
  <option value="mai">Mai</option>
  <option value="juni">Juni</option>
  <option value="julie">Julie</option>
  <option value="august">August</option>
  <option value="september">September</option>
  <option value="oktober">Oktober</option>
  <option value="november">November</option>
  <option value="dezember">Dezember</option>
</select></td></tr>



<tr><td>Betrag:</td><td> <input id='betrag' name='betrag' value=''>



<tr><td>Suchbegriff:</td><td> <input id='suche' name='suche' value=''>




</table>



</form>

<div id = "suche">
  <form method='post' action="diba_suche_erweitert.php?i=0">
    <label for='suche'></label>
    <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>

    <button id = "buttons_suche">suchen</button>
   
  </form>
</div>
</div>
<br>

<!-- hier beginnt die Tabelle -->
<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th><th>Kategorie</th></tr>

<?php
	//include "heimnetz_verbinden.php"; // db wird geöffnet
	// hier wird die Tabelle ausgegeben


function ausgabe($id, $konto, $datum, $empfang, $betrag, $kategorie)
{

	echo '<tr>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $konto . '</a></td>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $datum . '</a></td>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $empfang . '</a></td>';
	echo '<td align=right><a href=diba_formular.php?ID='.$id.'>'. $betrag . '</a></td>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $kategorie . '</a></td>';
	echo '</tr>';
}

$eingabe = $_POST['suche'];
$z=$_GET['i'];

echo "Eingabe: " .$eingabe;
echo "<br>";
echo "i: " .$z;
echo "<br>";

//exit;



// hier wird die Datenbank durchlaufen

//while ($zeile = $erg->fetch_object()) {
$erg = $pdo->prepare("SELECT * FROM konten");
$result = $erg->execute();

while($data = $erg->fetch()) {

	$id = $data['id'];
	$konto = $data['konto'];
	$datum = $data['datum'];
	$empfang = $data['empfang'];
	$kategorie = $data['kategorie'];
	$betrag = $data['betrag'];

	$summe = $summe + $betrag;
	$betrag = number_format($betrag,2, ",", ".");
	$az = $az +1;

	if ($konto == 1) {
		$konto = "Matthias";
		}
		if ($konto == 2) {
		$konto = "Claudia";
		}

	// Datum in dd.mm.yyyy umwandeln
	$originalDate = $data['datum'];
	//original date is in format YYYY-mm-dd
	$timestamp = strtotime($originalDate);
	$datum = date("d.m.Y", $timestamp );

	
	
	
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



//ausgabe($id, $konto, $datum, $empfang, $betrag, $kategorie);
	//exit;
	


	$qu = "UPDATE heimnetz.konten set kategorie='".$kategorie."' ";

	// Achtung beim letzten Teil KEIN Komma!!!
	//$qu.="kategorie='".$_GET['kategorie']."' ";
		// Achtung beim letzten Teil KEIN Komma!!!

	$qu.="where ID='".$id."' ";

	echo $qu;




	//$qu = $pdo->prepare($qu);
	//$kateg = $qu->execute();

exit;




} // ende der while schleife


$summe = number_format($summe,2, ",", ".");
echo 'Summe: '.$summe.' Anzahl: '.$az;
echo '<br>';
echo '<br>';
echo'</tbody>';
echo'</table>';

?>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
