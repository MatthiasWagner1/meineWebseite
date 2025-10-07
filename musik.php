<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../formate.css" type="text/css">
  <title>Musik</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Menüs einbinden
    ?>
  </header>

<!-- ab hier kommt nur noch Text -->
<main>
 <h1>Musik </h1>
  <form method='post' action="musik_suchen_in.php?i=3">

  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
   <div id = "buttons"><button>finden</button>
  </form>

  <input type="Submit" name="" formaction="musik_suchen_in.php?i=1" value="Album">	<!-- Genre -->
  <input type="Submit" name="" formaction="musik_suchen_in.php?i=2" value="?">	<!-- Beschreibung -->
  <br>
 <input type="Submit" name="" formaction="musik_formular.php" value="NEU">	<!-- Neu oder bearbeiten (id_lieder leer oder nicht) -->
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=5" value="?">	<!-- Lesezeichen -->
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=4" value="?">	<!-- Empfehlung -->
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=6" value="?">	<!-- Filmwunsch -->
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


// Ausgabe der letzten 30 Lieder die hinzugefügt wurden

$erg = $mysqli->query("SELECT * FROM lieder ORDER BY id_lieder ASC LIMIT 30")
	or die($mysqli->error);

// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:10px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td></td><td></td><td>ID</td><td>Titel</td><td>Interpret</td><td>Album</td><td>Länge</td><td></td><td>Genre</td></tr></thead>';
echo 	'<br>';
echo	'<tbody>';
// hier werden die Daten von $erg durchlaufen und an die Funktion ausgabe übergeben
	while ($zeile = $erg->fetch_object())
	{
		$id_lieder=$zeile->id_lieder;
		$titel=$zeile->titel;
		$interpret=$zeile->interpret;
		$album=$zeile->album;
		$laenge=$zeile->laenge;
		$genre=$zeile->genre;
		$jahr=$zeile->jahr;
		$bewertung=$zeile->bewertung;
		$markiert=$zeile->markiert;
		$pfad=$zeile->pfad;
		$dateiname=$zeile->dateiname;


		ausgabe($id_lieder, $titel, $interpret, $album, $laenge, $genre, $bewertung, $markiert, $pfad, $dateiname);
		//exit;
	}
echo'</tbody>';
echo'</table>';

?>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
