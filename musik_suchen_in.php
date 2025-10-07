<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../formate.css' type='text/css'>
  <title>Musik</title>
</head>
<body>

<header>
  <nav>
    <ul>
      <li><a href='../index.php'>Startseite</a></li>
      <li><a href='buecher.php'>Bücher</a></li>
      <li><a href='filme.php'>Filme</a></li>
      <li><a href='musik.php'>Musik</a></li>
      <li><a href='golf.php'>Golf</a></li>
      <li><a href='privat.php'>Privat</a></li>
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
  <h1>Musik </h1>
  <form method='post' action="musik_suchen_in.php?i=3">

  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
   <div id = "buttons"><button>finden</button>
  </form>

  <input type="Submit" name="" formaction="musik_suchen_in.php?i=1" value="Album">
  <input type="Submit" name="" formaction="musik_suchen_in.php?i=2" value="?">
  <br>


 <input type="Submit" name="" formaction="musik_formular.php" value="NEU">
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=5" value="?">
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=4" value="?">
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=6" value="?">
</div>

<?php
	include "verbinden_musiksammlung.php"; // db wird geöffnet

function ausgabe($id_lieder, $titel, $interpret, $album, $laenge, $genre, $bewertung, $markiert, $pfad, $dateiname)
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

		$mp3=$pfad . "/" . $dateiname;

		echo '<tr class="privat">';		// dann schreibe die Zeile (row) in die Tabelle

		?><td><input type="checkbox" name="markiert" value="1" <?php if($markiert=="1") echo "checked"; ?>></td><?php
		?><td style="font-size: 1.2em; font-weight: bold; color:green"><a target="_blank" href=<?php echo "$mp3"?> type="audio/mp3"> ⏵</a></td><?php
		echo '<td><a href=musik_formular.php?id_lieder='.$id_lieder.'>' . $id_lieder . '</a></td>';
		echo '<td><a href=musik_formular.php?id_lieder='.$id_lieder.'>'. $titel . '</a></td>'; // die id_lieder wird übergeben!!
		echo '<td><a href=privat.php>' . $interpret . '</a></td>';
		echo '<td><a href=privat.php>' . $album . '</a></td>';
		echo '<td><a href=privat.php>' . $laenge . '</a></td>';
		// echo '<td><a href=privat.php>' . $bewertung . '</td>';
		// echo '<td><a href=privat.php>' . '<img src="../img/24px-Full_Star_Blue.svg.png" alt="Sterne">' . '</td>';
		echo '<td style="text-align: left; font-weight: bold; color:blueviolet">' . $sterne . '</td>';
		echo '<td><a href=privat.php>' . $genre . '</a></td>';
		echo '</tr>';
	}

	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	// echo substr ($suche[0], 0, strlen($suche[0]));
	// echo $suche[0];
	// exit;
	$suche[1] = substr ($suche[0], 0, 1);
}

$erg = $mysqli->query("SELECT * FROM lieder order by bewertung DESC")
	or die($mysqli->error);

// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td></td><td></td><td>ID</td><td>Titel</td><td>Interpret</td><td>Album</td><td>Länge</td><td></td><td>Genre</td></tr></thead>';

echo 	'<br>';
echo	'<tbody>';

// hier wird die Datenbank durchlaufen
while ($zeile = $erg->fetch_object()) {

//Hier kommen die verschiedenen Suchbereiche. Durch die Übergabe von i ($Z) wird die richtige Suche gewählt

	// hier wird nach Filmwunsch gesucht ==========================================================================================
if ($z == 6) {

}

	// hier wird nach Lesezeichen gesucht ==========================================================================================
if ($z == 5) {

}

	// hier wird nach Empfehlung gesucht ==========================================================================================
if ($z == 4) {

}

	// hier wird nach Titel und Interpret durchsucht ==========================================================================================
if ($z == 3) {
	//echo' <h1>Suche Titel und Interpret</h1>';
	$titel=$zeile->titel.' '.$zeile->interpret;
	$pos = stripos($titel, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($titel, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id_lieder=$zeile->id_lieder;
		$titel=$zeile->titel;
		$interpret=$zeile->interpret;
		$album=$zeile->album;
		$laenge=$zeile->laenge;
		$jahr=$zeile->jahr;
		$genre=$zeile->genre;
		$bewertung=$zeile->bewertung;
		$markiert=$zeile->markiert;
		$pfad=$zeile->pfad;
		$dateiname=$zeile->dateiname;

		$treffer++;
		ausgabe($id_lieder, $titel, $interpret, $album, $laenge, $genre, $bewertung, $markiert, $pfad, $dateiname);
		//exit;
	}
}

	// hier wird nach Beschreibung durchsucht ==========================================================================================
if ($z == 2) {

}

	// hier wird nach Album durchsucht ==========================================================================================
if ($z == 1) {
	//echo' <h1>Suche Album</h1>';
	$titel=$zeile->album;
	$pos = stripos($titel, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($titel, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id_lieder=$zeile->id_lieder;
		$titel=$zeile->titel;
		$interpret=$zeile->interpret;
		$album=$zeile->album;
		$laenge=$zeile->laenge;
		$jahr=$zeile->jahr;
		$genre=$zeile->genre;
		$bewertung=$zeile->bewertung;
		$markiert=$zeile->markiert;
		$pfad=$zeile->pfad;
		$dateiname=$zeile->dateiname;
		$treffer++;
		ausgabe($id_lieder, $titel, $interpret, $album, $laenge, $genre, $bewertung, $markiert, $pfad, $dateiname);
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





$erg->free();
$mysqli->close();
?>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
