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
     include "header.php"; // die Menüs einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>
  <h1>Dinge </h1>
  <form method='post' action="dinge_suchen_in.php?i=3">
  <label for='suche'>Suchbegriff: </label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
  <div id = "buttons"><button>finden</button>
  <input type="Submit" name="" formaction="dinge_formular.php" value="Dinge NEU">
  <input type="Submit" name="" formaction="dinge_stammdaten.php" value="Stammdaten">
  <input type="Submit" name="" formaction="auswahl_filtern_ort.php?ID=1" value="Auswahl nach Ort">
  <input type="Submit" name="" formaction="dinge_neuzugang.php" value="Neuzugänge">

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
  echo 	'<thead><tr><td>ID</td><td>Name</td><td>Ort</td><td>Typ</td><td>Beschreibung Ort</td><td>Besitzer</td></tr></thead>';
	echo	'<tbody>';
	while($data = $erg->fetch()) {
		$id=$data['id'];
		echo '<tr class="privat">';

		echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['id'] . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['name_dinge'] . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['name_ort'] . '</a></td>';
    //echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['fs_ort'] . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['typ'] . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['name_regal'] . '</a></td>';
    echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['besitzer'] . '</a></td>';

		echo '</tr>';
	}
}

?>

<!-- ab hier wird die Seite aufgebaut -->

<h2>Neuzugänge</h2>

<?php

$erg = $pdo->prepare("SELECT * FROM tab_dinge
 LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort
 LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal
 LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
 LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk
 ORDER BY ID DESC
");

$result = $erg->execute();

// echo "$erg";
// exit;

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
