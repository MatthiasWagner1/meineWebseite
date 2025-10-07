<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../dinge_formate.css' type='text/css'>
  <title>Dinge</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>    
  <h1>Dinge: </h1>
  <form method='post' action="dinge_suchen_in.php?i=3">
  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
  <div id = "buttons"><button>finden</button>
  	<input type="Submit" name="" formaction="film_formular.php" value="NEU">

<!--<input type="Submit" name="" formaction="film_suchen_in.php?i=1" value="in Genre">
	<input type="Submit" name="" formaction="film_suchen_in.php?i=2" value="in Beschreibung">
	<input type="Submit" name="" formaction="film_suchen_in.php?i=5" value="Lesezeichen">
	<input type="Submit" name="" formaction="film_suchen_in.php?i=4" value="Empfehlung">
	<input type="Submit" name="" formaction="film_suchen_in.php?i=6" value="Filmwunsch"> -->

</div>
</form>

<?php
	include "dinge_verbinden.php"; // db wird geöffnet
	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

	//echo "$z";

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}
	
//$erg = $mysqli->query("SELECT * FROM tab_dinge order by id DESC")	or die($mysqli->error);

	$erg = $mysqli->query("SELECT * FROM tab_dinge 
	LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort
	LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal
	LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
	LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk
	")
	 or die($mysqli->error);	




// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td>ID</td><td>Name</td><td>Ort</td><td>Typ</td><td>Beschreibung Ort</td><td>Besitzer</td></tr></thead>';

echo 	'<br>';
echo	'<tbody>';

// hier wird die Datenbank durchlaufen
while ($zeile = $erg->fetch_object()) {

//Hier kommen die verschiedenen Suchen. Durch die Übergabe von i ($Z) wird die richtige Suche gewählt

	// hier wird nach Filmwunsch gesucht ==========================================================================================
if ($z == 6) {	
	if ($zeile->filmwunsch=="1") {	//wenn es 
		$id=$zeile->id;	
		$name=$zeile->name_dinge;
		$pfad=$zeile->pfad;
		$bewertung=$zeile->bewertung;
		$genre=$zeile->genre;	 
		// hier wird der Haken gesetzt wenn die Beschreibung nicht leer ist
		$beschreibung=$zeile->beschreibung;
		if (strlen($zeile->beschreibung)>3) {
			$beschreibung="√";
		} 
		$treffer++;		
		ausgabe($id, $name, $pfad, $bewertung, $genre, $beschreibung);	
		//exit;	
	}
}

	// hier wird nach Name und Typ durchsucht ==========================================================================================
if ($z == 3) {	
	//echo' <h1>Suche Name</h1>';
	$name=$zeile->name_dinge.' '.$zeile->typ;
	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal
	
	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$zeile->id;	
		$name=$zeile->name_dinge;
		$ort=$zeile->name_ort;
		$typ=$zeile->typ;
		$beschreibung_ort=$zeile->beschreibung_ort;
		$besitzer=$zeile->besitzer;	 
		
		$treffer++;		
		ausgabe($id, $name, $ort, $typ, $beschreibung_ort, $besitzer);	
		//exit;	
	}
}

	// hier wird nach Beschreibung durchsucht ==========================================================================================
if ($z == 2) {	
	//echo' <h1>Suche Beschreibung</h1>';
	$beschreibung=$zeile->beschreibung;
	$pos = stripos($beschreibung, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($beschreibung, $suche[1]); // stripos() Klein- Großschreibung egal
	
	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$zeile->id;	
		$name=$zeile->name_dinge;
		$ort=$zeile->name_ort;
		$typ=$zeile->typ;
		$genre=$zeile->genre;	 
		// hier wird der Haken gesetzt wenn die Beschreibung nicht leer ist
		//$beschreibung=$zeile->beschreibung;
		if (strlen($zeile->beschreibung)>3) {
			$beschreibung="√";
		} 
		$treffer++;		
		ausgabe($id, $name, $pfad, $bewertung, $genre, $beschreibung);	
		//exit;	
	}
}
} 

echo'</tbody>';
echo'</table>';

//hier wird die Anzahl der Treffer gezeigt. id=treffer: an welche position kommt aus css
echo '<div id = "treffer" >';
if ($erg->num_rows) {
	echo "Datensätze gesamt: ".$erg->num_rows;
	echo ", Treffer: ".$treffer;
}
echo '</div>';

function ausgabe($id, $name_dinge, $name_ort, $typ, $beschreibung_ort, $besitzer)
{
echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $id . '</a></td>';
echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $name_dinge . '</a></td>'; // die ID wird übergeben!!
echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $name_ort . '</a></td>';
echo '<td>' . $typ . '</a></td>';
echo '<td>' . $beschreibung_ort . '</td>';
echo '<td><a href=dinge_formular.php?ID='.$id.'>' . $besitzer . '</a></td>';
echo '</tr>';
}
$erg->free();
$mysqli->close();
?>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
