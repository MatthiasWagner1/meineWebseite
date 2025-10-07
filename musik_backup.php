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
  <nav>
    <ul>
      <li><a href="../index.php">Startseite</a></li>
      <li><a href="buecher.php">Bücher</a></li>
      <li><a href="filme.php">Filme</a></li>
      <li><a href="musik.php">Musik</a></li>
      <li><a href="golf.php">Golf</a></li>
      <li><a href="privat.php">Privat</a></li>
    </ul>

  </nav>
	<!-- <a id="navlink" title="zum Navigationsmenü" href="#navigation">☰</a>  -->
  <h1 class="ribbon">
   <!-- INTRANET<br/><span>Matthias Wagner</span>-->
   <a id="logo" title="zurück zur Startseite!" href="../index.php">Intranet<br/><span>Matthias Wagner</span></a>
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

  <input type="Submit" name="" formaction="musik_suchen_in.php?i=1" value="?">	<!-- Genre -->
  <input type="Submit" name="" formaction="musik_suchen_in.php?i=2" value="?">	<!-- Beschreibung -->
  <br>
 <input type="Submit" name="" formaction="musik_formular.php" value="NEU">	<!-- Neu oder bearbeiten (id_lieder leer oder nicht) -->
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=5" value="?">	<!-- Lesezeichen -->
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=4" value="?">	<!-- Empfehlung -->
 <input type="Submit" name="" formaction="musik_suchen_in.php?i=6" value="?">	<!-- Filmwunsch -->
</div>
<?php
 include "verbinden_musiksammlung.php"; // db wird geöffnet

function ausgabe($id_lieder, $titel, $interpret, $laenge, $genre, $jahr)
	{
		echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
		/*<td>Lesezeichen:</td><td><input type="checkbox" name="lesezeichen" value="1" <?php if($zeile->lesezeichen=="1") echo "checked"; ?>></td>*/
		?><td><input type="checkbox" name="markiert" value="1"' <?php if($zeile->markiert=="1") echo "checked"; ?>></td><?php //ob das passt???*/
		echo '<td><a href=musik_formular.php?id_lieder='.$id_lieder.'>' . $id_lieder . '</a></td>';
		echo '<td><a href=musik_formular.php?id_lieder='.$id_lieder.'>'. $titel . '</a></td>'; // die id_lieder wird übergeben!!
		echo '<td><a href=privat.php>' . $interpret . '</a></td>';
		echo '<td><a href=privat.php>' . $laenge . '</a></td>';
		echo '<td style="text-align: center; font-weight: bold; color:green">' . $jahr . '</td>';
		//echo '<td><a href=privat.php>' . $genre . '</a></td>';
		echo '</tr>';
	}

// Ausgabe der letzten 30 Lieder die hinzugefügt wurden
$erg = $mysqli->query("SELECT * FROM lieder ORDER BY id_lieder DESC LIMIT 30")
	or die($mysqli->error);	

// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td>id_lieder</td><td>Titel</td><td>Interpret</td><td>laenge</td><td>Jahr</td><td>Genre</td></tr></thead>';
echo 	'<br>';
echo	'<tbody>';
// hier werden die Daten von $erg durchlaufen und an die Funktion ausgabe übergeben
	while ($zeile = $erg->fetch_object()) 
	{
		$id_lieder=$zeile->id_lieder;	
		$titel=$zeile->titel;
		$interpret=$zeile->interpret;
		$laenge=$zeile->laenge;
		$genre=$zeile->genre;	 
		$jahr=$zeile->jahr;
		ausgabe($id_lieder, $titel, $interpret, $laenge, $genre, $jahr);	
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


