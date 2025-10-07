<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../diba_formate.css' type='text/css'>
  <title>ING</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>

<h1>Heimnetz - Konten </h1>

 <!-- Button Seite neu laden -->
<form method='post' >
      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">
      <input formaction="diba.php" type="Submit" name="" value="ING">
  </form>

  <br>

  <div id = "suche">
  <form method='post' action="diba_suchen.php?i=1">
    <label for='suche'></label>
   
    <button id = "buttons_suche">suchen</button>
 <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>

	
	<input onclick="history.back()" type="button"  value="Zur&uuml;ck">
    
  </form>
  </div>
  <br>


<?php 
  $konto = "alle";
  $jahr = "2023";
  $monat = "06"; // hier soll der letzte Monat stehen
  $kategorie = "alle";
  $sortierung = "datum";

// falls die Daten vom Formular kommen:
if (isset($_POST["konto"],
    $_POST["jahr"],
    $_POST["monat"],
    $_POST["kategorie"],
    $_POST["sortierung"])) { 

  $konto = $_POST['konto'];
  $jahr = $_POST['jahr'];
  $monat = $_POST['monat'];
  $kategorie = $_POST['kategorie'];
  $sortierung = $_POST['sortierung'];
}

?>

<br>
<!-- =========================== Filter =========================================================== -->
<div class = "filter">

<!-- das Formular ruft sich selber auf -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for='filter'></label>
<button id = "filter">filtern</button>

<table>

<tr><td>Konto: <select name="konto">
  <option <?php if ($konto == "alle") echo "selected='selected'";?> value="alle">Alle</option> 
  <option <?php if ($konto == "matthias") echo "selected='selected'";?> value="matthias">Matthias</option> 
  <option <?php if ($konto == "claudia") echo "selected='selected'";?> value="claudia">Claudia</option> 
</select></td>


<td>Jahr: <select name="jahr">
  <option <?php if ($konto == "alle") echo "selected='selected'";?> value="alle">Alle</option> 
  <option <?php if ($jahr == "2023") echo "selected='selected'";?> value="2023">2023</option> 
  <option <?php if ($jahr == "2022") echo "selected='selected'";?> value="2022">2022</option> 
</select></td>


<td>Monat: <select name="monat">
  <option <?php if ($monat == "alle") echo "selected='selected'";?> value="alle">Alle</option> 
  <option <?php if ($monat == "01") echo "selected='selected'";?> value="01">Januar</option> 
  <option <?php if ($monat == "02") echo "selected='selected'";?> value="02">Februar</option> 
  <option <?php if ($monat == "03") echo "selected='selected'";?> value="03">März</option> 
  <option <?php if ($monat == "04") echo "selected='selected'";?> value="04">April</option> 
  <option <?php if ($monat == "05") echo "selected='selected'";?> value="05">Mai</option> 
  <option <?php if ($monat == "06") echo "selected='selected'";?> value="06">Juni</option> 
  <option <?php if ($monat == "07") echo "selected='selected'";?> value="07">Juli</option> 
  <option <?php if ($monat == "08") echo "selected='selected'";?> value="08">August</option> 
  <option <?php if ($monat == "09") echo "selected='selected'";?> value="09">September</option> 
  <option <?php if ($monat == "10") echo "selected='selected'";?> value="10">Oktober</option> 
  <option <?php if ($monat == "11") echo "selected='selected'";?> value="11">November</option> 
  <option <?php if ($monat == "12") echo "selected='selected'";?> value="12">Dezember</option> 

</select></td>

<td>Kategorie: <select name="kategorie" id="kategorie">
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
</select></td>

<td>Sortierung: <select name="sortierung">
  <option <?php if ($sortierung == "datum") echo "selected='selected'";?> value="datum">Datum</option> 
  <option <?php if ($sortierung == "empfang") echo "selected='selected'";?> value="empfang">Empfänger</option> 
  <option <?php if ($sortierung == "betrag") echo "selected='selected'";?> value="betrag">Betrag</option> 
</select></td>

</tr>
</table>
</div>
<br>


<!-- ===================== hier wird die variable $erg erstellt ===================================== -->

 
 <?php

 // echo "Konto: ".$konto."<br>";
 // echo "Jahr: ".$jahr."<br>";
  //echo "monat: ".$monat."<br>";
  //echo "Kategorie: ".$kategorie."<br>";
//echo "Sortierung: ".$sortierung."<br>";

  //exit;

$erg = "SELECT * FROM konten";

if ($konto != "alle") {
  if ($konto == "matthias") {  
    $konto_nr = "1";
  }
  if ($konto == "claudia") {  
    $konto_nr = "2";
  }
  $abfrage = " WHERE konto = ".$konto_nr;
  $z++;
  $erg.= $abfrage;
}

if ($jahr != "alle") {
  if ($z == 0) $abfrage = " WHERE DATE_FORMAT(datum, '%Y')  = ".$jahr;
  if ($z != 0) $abfrage = " AND DATE_FORMAT(datum, '%Y')  = ".$jahr;
    
  $z++;
  $erg.= $abfrage;


}


if ($monat != "alle") {
  if ($z == 0) $abfrage = " WHERE DATE_FORMAT(datum, '%c')  = ".$monat;
  if ($z != 0) $abfrage = " And DATE_FORMAT(datum, '%c')  = ".$monat;
  $z++;
  $erg.= $abfrage;
}







if ($kategorie != "alle") {
  if ($z == 0) $abfrage = " WHERE kategorie = '".$kategorie."'";
  if ($z != 0) $abfrage = " AND kategorie = '".$kategorie."'";
  $z++;
  $erg.= $abfrage;
}

if ($sortierung == "empfang") {
  $erg.= " ORDER BY $sortierung ASC"; //oder ASC
}
if ($sortierung == "datum") {
  $erg.= " ORDER BY $sortierung DESC"; //oder ASC
}
if ($sortierung == "betrag_ab") {
  $erg.= " ORDER BY betrag DESC"; //oder ASC
}

if ($sortierung == "betrag_auf") {
  $erg.= " ORDER BY betrag ASC"; //oder DESC
}

//echo $erg;
//exit;


function ausgabe($id, $konto, $datum, $empfang, $betrag)
{
	
	echo '<tr>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $konto . '</a></td>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $datum . '</a></td>';
	echo '<td><a href=diba_formular.php?ID='.$id.'>'. $empfang . '</a></td>';
	echo '<td align=right><a href=diba_formular.php?ID='.$id.'>'. $betrag . '</a></td>';
	echo '</tr>';
}

?>

<!-- hier beginnt die Tabelle -->
<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th></tr>

<?php
	include "heimnetz_verbinden.php"; // db wird geöffnet
	// hier wird die Tabelle ausgegeben
	

	
	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

	if (empty($eingabe)) {						// falls leer dann zurück
		//header('Location: diba.php?i='.$z);
	}
	$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
	if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
		$suche[1] = substr ($suche[0], 0, 1);
	}



$summe = 0;
// hier wird die Datenbank durchlaufen
$erg = $pdo->prepare($erg);
$result = $erg->execute();

while($data = $erg->fetch()) {
$suche_in = $data['empfang'].$data['verwendung'].$data['notiz'];
//echo $suche[0];
	



	$pos = stripos($suche_in, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($suche_in, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id = $data['id'];
		$konto = $data['konto'];
		$datum = $data['datum'];
		$empfang = $data['empfang'];
		
		$betrag = $data['betrag'];
		//$betrag = str_replace(".","",$betrag);		// löscht punkt im string
		//$betrag = str_replace(",",".",$betrag);		// ändert komma in punkt
		//$betrag = (float)$betrag;	// ändert string in zahl mit 2 nachkomma stellen
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
  
	//ausgabe($erg, $jahr, $monat);
	ausgabe($id, $konto, $datum, $empfang, $betrag);
		//exit;
	 }

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
