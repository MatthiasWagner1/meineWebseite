<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../formate.css' type='text/css'>
  <title>Filme</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Fusszeile einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>    
  <h1>Filme </h1>
  <form method='post' action="film_suchen_in.php?i=3">
  
  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
   <div id = "buttons"><button>finden</button>
  </form>
 
  <input type="Submit" name="" formaction="film_suchen_in.php?i=1" value="in Genre">
  <input type="Submit" name="" formaction="film_suchen_in.php?i=2" value="in Beschreibung">
  <br>
   
 <input type="Submit" name="" formaction="film_formular.php" value="NEU">
 <input type="Submit" name="" formaction="film_suchen_in.php?i=5" value="Lesezeichen">
 <input type="Submit" name="" formaction="film_suchen_in.php?i=4" value="Empfehlung">
 <input type="Submit" name="" formaction="film_suchen_in.php?i=6" value="Filmwunsch">
</div>

<?php
	include "verbinden.php"; // db wird geöffnet
	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

	//echo "$z";

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}
	
$erg = $mysqli->query("SELECT * FROM filme order by bewertung DESC")
	or die($mysqli->error);

// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td>ID</td><td>Name</td><td>Pfad</td><td>*</td><td>Info</td><td>Genre</td></tr></thead>';

echo 	'<br>';
echo	'<tbody>';

// hier wird die Datenbank durchlaufen
while ($zeile = $erg->fetch_object()) {

//Hier kommen die verschiedenen Suchen. Durch die Übergabe von i ($Z) wird die richtige Suche gewählt

	// hier wird nach Filmwunsch gesucht ==========================================================================================
if ($z == 6) {	
	if ($zeile->filmwunsch=="1") {	//wenn es 
		$id=$zeile->id;	
		$name=$zeile->name;
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

	// hier wird nach Lesezeichen gesucht ==========================================================================================
if ($z == 5) {	
	if ($zeile->lesezeichen=="1") {	//wenn es 
		$id=$zeile->id;	
		$name=$zeile->name;
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



	// hier wird nach Empfehlung gesucht ==========================================================================================
if ($z == 4) {	
	if ($zeile->empfehlung=="1") {	//wenn es 
		$id=$zeile->id;	
		$name=$zeile->name;
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

	// hier wird nach Name und Pfad durchsucht ==========================================================================================
if ($z == 3) {	
	//echo' <h1>Suche Name</h1>';
	$name=$zeile->name.' '.$zeile->pfad;
	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal
	
	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$zeile->id;	
		$name=$zeile->name;
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

	// hier wird nach Beschreibung durchsucht ==========================================================================================
if ($z == 2) {	
	//echo' <h1>Suche Beschreibung</h1>';
	$beschreibung=$zeile->beschreibung;
	$pos = stripos($beschreibung, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($beschreibung, $suche[1]); // stripos() Klein- Großschreibung egal
	
	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$zeile->id;	
		$name=$zeile->name;
		$pfad=$zeile->pfad;
		$bewertung=$zeile->bewertung;
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

	// hier wird nach Genre durchsucht ==========================================================================================
if ($z == 1) {
	//echo' <h1>Suche in Genre</h1>';
	$genre=$zeile->genre;	
	$pos = stripos($genre, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($genre, $suche[1]); // stripos() Klein- Großschreibung egal
	
	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$zeile->id;	
		$name=$zeile->name;
		$pfad=$zeile->pfad;
		$bewertung=$zeile->bewertung;
 
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

function ausgabe($id, $name, $pfad, $bewertung, $genre, $beschreibung)
{
// hier werden die Anzahl der Sterne aus $bewertung erstellt
		switch ($bewertung) {
			case '1':
				$sterne='★';
				break;
			case '2':
				$sterne='★★';
				break;		
			case '3':
				$sterne='★★★';
				break;
			case '4':
				$sterne='★★★★';
				break;
			case '5':
				$sterne='★★★★★';
				break;	
			default:
				$sterne='☆';
		}
		echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
		//echo '<td>' . $datei . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		echo '<td><a href=film_formular.php?ID='.$id.'>' . $id . '</a></td>';
		echo '<td><a href=film_formular.php?ID='.$id.'>'. $name . '</a></td>'; // die ID wird übergeben!!
		echo '<td><a href=privat.html>'. $pfad . '</a></td>';
		echo '<td style="text-align: left; font-weight: bold; color:blueviolet">' . $sterne . '</a></td>';
		echo '<td style="text-align: center; font-weight: bold; color:green">' . $beschreibung . '</td>';
		
		echo '<td><a href=privat.html>' . $genre . '</a></td>';
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
