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
<center>  <h2>Suchbegriff eingeben: </h2></center>
<center>
<label for='suche'></label>
<input center id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
</center>
  <div id = "suche">
  <form method='post' action="film_suchen_in.php?i=3">


  </div>
<center>
    <input id = "buttons1" type="Submit" name="" formaction="film_suchen_in.php?i=3" value="alles">

    <input id = "buttons1" type="Submit" name="" formaction="film_suchen_in.php?i=1" value="nach Typ">
    <input id = "buttons1" type="Submit" name="" formaction="film_suchen_in.php?i=2" value="in Beschreibung">
    </center>
    <input id = "buttons" type="Submit" name="" formaction="film_formular.php" value="NEU">
    <!-- <input type="Submit" name="" formaction="film_suchen_in.php?i=5" value="Lesezeichen">
    <input type="Submit" name="" formaction="film_suchen_in.php?i=4" value="Empfehlung">
    <input type="Submit" name="" formaction="film_suchen_in.php?i=6" value="Filmwunsch">
    -->

  </form>
  <br>
<?php
 include "verbinden.php"; // db wird geöffnet

 function ausgabe($erg)
 {
	echo 	'<table >';
	echo	'<tbody>';
	while ($zeile = $erg->fetch_object()) {
		$id=$zeile->id;
		echo '<tr>';						// dann schreibe die Zeile (row) in die Tabelle
		// echo '<td>' . $zeile->dateiname . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		//echo '<td><a href=film_formular.php?ID='.$id.'>' . $zeile->id . '</a></td>';
		echo '<td><a href=film_formular.php?ID='.$id.'>'. $zeile->name . '</a></td>'; // die ID wird übergeben!!
		// echo '<td><a href=privat.html>' . $zeile->pfad . '</a></td>';
		echo '</tr>';
	}
echo'</tbody>';
echo'</table>';
 }
?>

<div id="linksoben">
<h5><a href="film_suchen_in.php?i=7" title="Neuzugänge"> neue Filme</a></h5>

 <?php
 $erg = $mysqli->query("SELECT * FROM filme WHERE filmwunsch=0 ORDER BY id DESC LIMIT 17")
	or die($mysqli->error);
 ausgabe($erg);
 ?>
</div>

<div id="rechtsoben">
<h5><a href="film_suchen_in.php?i=8" title="Neuzugänge"> Top Bewertung</a></h5>
 <?php
 $erg = $mysqli->query("SELECT * FROM filme WHERE filmwunsch=0 ORDER BY bewertung DESC LIMIT 17")
	or die($mysqli->error);
 ausgabe($erg);
 ?>
</div>

<div id="mitteoben">
 <h5><a href="film_suchen_in.php?i=4" title="Empfehlungen"> Empfehlungen</a></h5>
 <?php
 $erg = $mysqli->query("SELECT * FROM filme Where empfehlung>0 ORDER BY name LIMIT 17")
	or die($mysqli->error);
 ausgabe($erg);
 ?>
</div>

<div id="linksunten">
 <h5><a href="film_suchen_in.php?i=6" title="Filmwunsch"> Filmwunsch</a></h5>
 <?php
 $erg = $mysqli->query("SELECT * FROM filme Where filmwunsch>0 ORDER BY id LIMIT 17")
	or die($mysqli->error);
 ausgabe($erg);
 ?>
</div>

<div id="rechtsunten">
 <h5><a href="film_suchen_in.php?i=5" title="Lesezeichen"> Lesezeichen</a></h5>
 <?php
 $erg = $mysqli->query("SELECT * FROM filme Where lesezeichen='1' ORDER BY name LIMIT 17")
	or die($mysqli->error);
 ausgabe($erg);
 ?>
</div>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
