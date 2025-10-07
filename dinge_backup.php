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
  <h1>Dinge </h1>
  <form method='post' action="dinge_suchen_in.php?i=3">
  
  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
  <div id = "buttons"><button>finden</button>
  <input type="Submit" name="" formaction="dinge_formular.php" value="NEU">

<!--
  <input type="Submit" name="" formaction="film_suchen_in.php?i=1" value="in Genre">
  <input type="Submit" name="" formaction="film_suchen_in.php?i=2" value="in Beschreibung">
  <input type="Submit" name="" formaction="film_suchen_in.php?i=5" value="Lesezeichen">
  <input type="Submit" name="" formaction="film_suchen_in.php?i=4" value="Empfehlung">
  <input type="Submit" name="" formaction="film_suchen_in.php?i=6" value="Filmwunsch"> 
-->
 </form>
 </div>
<?php
 include "dinge_verbinden.php"; // db wird geöffnet

 function ausgabe($erg)
 {
  echo 	'<table class="privat">';
  echo 	'<thead><tr><td>ID</td><td>Name</td><td>Kiste</td><td>Typ</td><td>Beschreibung Kiste</td><td>Besitzer</td></tr></thead>';
	echo	'<tbody>';
	while ($zeile = $erg->fetch_object()) {
		$id=$zeile->id;
		echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
		// echo '<td>' . $zeile->dateiname . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->id . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->name_dinge . '</a></td>'; // die ID wird übergeben!!
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->name_kiste . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->typ . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->name_regal . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->besitzer . '</a></td>';
		echo '</tr>';
	}
}

//   echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $zeile->zimmer . '</a></td>';

//  $erg = $mysqli->query("SELECT * FROM tab_dinge ORDER BY id DESC LIMIT 25")

?>

<h2>Neuzugänge</h2>
 <?php
 $erg = $mysqli->query("SELECT * FROM tab_dinge 
 LEFT JOIN tab_kiste ON tab_dinge.fs_kiste = tab_kiste.id_kiste
 LEFT JOIN tab_regal ON tab_kiste.fs_regal = tab_regal.id_regal
 LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
 LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk
 ")
  or die($mysqli->error);	

  ausgabe($erg);
 echo'</tbody>';
 echo'</table>';	

?>





</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>