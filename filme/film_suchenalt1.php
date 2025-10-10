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
  <nav>
    <ul>
      <li><a href='../index.php'>Startseite</a></li>
      <li><a href='buecher.php'>Bücher</a></li>
      <li><a href='filme.php'>Filme</a></li>
      <li><a href='musik.php'>Musik</a></li>
      <li><a href='golf.html'>Golf</a></li>
      <li><a href='privat.html'>Privat</a></li>
    </ul>

  </nav>
	<!-- <a id='navlink' title='zum Navigationsmenü' href='#navigation'>☰</a>  -->
  <h1 class='ribbon'>
   <!-- INTRANET<br/><span>Matthias Wagner</span>-->
   <a id='logo' title='zurück zur Startseite!' href='../index.php'>Intranet<br/><span>Matthias Wagner</span></a>
  </h1>
</header>

<!-- ab hier kommt nur noch Text -->
<main>    
 <h1>Filme </h1>
 
  <form method='post' action='film_suchen.php'>
  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
   <div id = "buttons"><button>finden</button>
 </form>
 <input type="Submit" name="" formaction="film_formular.php" value="NEU">
 <input type="Submit" name="" formaction="lesezeichen.php?i=1" value="Lesezeichen">
 <input type="Submit" name="" formaction="lesezeichen.php?i=2" value="Empfehlung">
</div>


<?php
	include "verbinden.php"; // db wird geöffnet
	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

	echo "$z";

	$erg = $mysqli->query("SELECT * FROM filme order by name")
	or die($mysqli->error);

if ($z == 1) {	
	echo' <h1>Suche</h1>';

}

if ($z == 2) {
	echo' <h1>Suche in Genre</h1>';

}


$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}
	
function ausgabe($erg, $zeile)
 {
	echo 	'<table >';
	// echo 	'<table class="privat" border="1">';	
	// echo 	'<thead><tr><td>Name</td></tr></thead>';
	// echo 	'<br>';
	echo	'<tbody>';
	while ($zeile = $erg->fetch_object()) {
		$id=$zeile->id;
		echo '<tr>';						// gann schreibe die Zeile (row) in die Tabelle
		// echo '<td>' . $zeile->dateiname . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		//echo '<td><a href=film_formular.php?ID='.$id.'>' . $zeile->id . '</a></td>';
		echo '<td><a href=film_formular.php?ID='.$id.'>'. $zeile->name . '</a></td>'; // die ID wird übergeben!!
		// echo '<td><a href=privat.html>' . $zeile->pfad . '</a></td>';
		echo '</tr>';
	}
}














// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td>ID</td><td>Name</td><td>Pfad</td><td>*</td><td>Info</td><td>Genre</td></tr></thead>';

echo 	'<br>';
echo	'<tbody>';

// hier wird die Datenbank durchlaufen und nach dem Suchbegriff gefiltert
while ($zeile = $erg->fetch_object()) {
	
	// hier wird der Haken gesetzt wenn die Beschreibung nicht leer ist
	$beschreibung=$zeile->beschreibung;
	if (strlen($zeile->beschreibung)>3) {
			$beschreibung="√";
	}
	
	$id=$zeile->id;
	$datei=$zeile->name.$zeile->pfad;	// hier wird erstmal pfad und datei zusammen gesetzt
	$pos = stripos($datei, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($datei, $suche[1]); // stripos() Klein- Großschreibung egal
	
	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		echo '<tr>';						// gann schreibe die Zeile (row) in die Tabelle
		// echo '<td>' . $zeile->dateiname . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		echo '<td><a href=film_formular.php?ID='.$id.'>' . $zeile->id . '</a></td>';
		echo '<td><a href=film_formular.php?ID='.$id.'>'. $zeile->name . '</a></td>'; // die ID wird übergeben!!
		echo '<td><a href=privat.html>' . $zeile->pfad . '</a></td>';
		echo '<td><a href=privat.html>' . $zeile->bewertung . '</a></td>';
		echo '<td style="text-align: center; font-weight: bold; color:green">' . $beschreibung . '</td>';
		
		echo '<td><a href=privat.html>' . $zeile->genre . '</a></td>';
		echo '</tr>';
		
		$treffer++;
	} 
}

echo'</tbody>';
echo'</table>';

//hier wird die Anzahl der Treffer gezeigt. id=treffer: an welche position, kommt aus css
echo '<div id = "treffer" >';

if ($erg->num_rows) {
	echo "Datensätze gesamt: ".$erg->num_rows;
	echo ", Treffer: ".$treffer;

}
echo '</div>';

$erg->free();
$mysqli->close();
?>

</main>
<footer>
	© 2016 - 2017 Matthias Wagner - 
	<a href="kontakt.html" title="Kontakt"><img alt="Kontakt | "></a>
	<a href="impressum.html" title="Impressum"><img alt="Impressum"></a>
</footer>
</body>
</html>
