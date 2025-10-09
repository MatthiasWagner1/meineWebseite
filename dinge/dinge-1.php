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
  <input type="Submit" name="" formaction="dinge_auswahl_filtern_ort.php?ID=1" value="Auswahl nach Ort">
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

Stockwerke
<div class="flex-container">
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Dachgeschoss"> Dachgeschoss</a></h5>
  </div>
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="1. Stock"> 1. Stock</a></h5>
  </div>
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Erdgeschoss"> Erdgeschoss</a></h5>
  </div>  
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Keller"> Keller</a></h5>
  </div> 
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Draussen"> Draussen</a></h5>
  </div> 
</div>

<?php


// Zimmer nach Stockwerk ====================================================================================================

$ort_auswahl=$_REQUEST['ID']; // die übergebene ID des Ortes

$erg = $pdo->prepare("SELECT * FROM tab_dinge
LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort");
$result = $erg->execute();

echo 	'<table style="float:left;width:40%;">';
echo 	'<thead><tr><td>Name</td><td>Ort</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['fs_ort'];
    $id_dinge=$data['id'];
    if ($id==$ort_auswahl) {
      echo '<tr class="privat">';
      echo '<td><a href=dinge_formular.php?ID='.$id_dinge.'>'. $data['name_dinge'] . '</a></td>';
      //echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['name_ort'] . '</a></td>';
      echo '<td>'.$data['name_ort'].'</td>';
      echo '</tr>';
    }
}
echo'</tbody>';
echo'</table>';
?>







<div class="flex-container">
  <div>kleines Zimmer</div>
  <div>Wohnzimmer</div>
  <div>Küche</div>  
  <div>Bad</div> 
</div>
<br>
Regale
<div class="flex-container">
  <div>kleines Zimmer</div>
  <div>Wohnzimmer</div>
  <div>Küche</div>  
  <div>Bad</div> 
</div>
<br>
Orte
<div class="flex-container">
  <div>kleines Zimmer</div>
  <div>Wohnzimmer</div>
  <div>Küche</div>  
  <div>Bad</div> 
</div>
<br>
Dinge als Tabelle?
<div class="flex-container">
  <div>kleines Zimmer</div>
  <div>Wohnzimmer</div>
  <div>Küche</div>  
  <div>Bad</div> 
</div>



<style>
.flex-container {
  display: flex;
  background-color: white;
  height: 60px;  
  width: 100%;
  border: 1px solid black;
  margin: 0;
}

.flex-container > div {
    height: 35px;  
    width: 170px;
    background-color: lightgrey;
    margin: 10px;
    padding: 2px;
    border: 1px solid black;
    font-size: 12pt;
  
}

h5 {
        color: black;
        /* Farbe schwarz */
        font-size: 12pt;
        /* Größe    */
        margin: 3pt;
        text-decoration: underline;
    }
</style>





<h2>-</h2>

<?php


?>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
