<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../heimnetz_formate.css' type='text/css'>
  <title>Heimnetz</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>
  <h1>Heimnetz</h1>



<label for='suche'></label>

 <div id = "suche">
 <form method='post' action="heimnetz_suchen.php?i=3">
  Suchbegriff eingeben:  
  <label for='suche'></label>
   <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
   <button id = "buttons_suche">finden</button>
   <!--
   <input id = "buttons_suche" type="Submit" name="" formaction="film_suchen_in.php?i=1" value="nach Typ">
   <input id = "buttons_suche" type="Submit" name="" formaction="film_suchen_in.php?i=2" value="in Beschreibung">
   -->
 
 </form>
 <br><br>
 <form method='post' action="heimnetz_formular.php">
     <input id = "buttons_film" type="Submit" name="" value="neuer Eintrag">
     <input id = "buttons_film" type="Submit" formaction="heimnetz.php" name="" value="zurück">
 </form>

<?php


	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

	//echo "$z";

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}

// hier wird NUR die Sortierung der Suchen festgelegt (und limit)!!!


//
include "projekte_verbinden.php"; // db wird geöffnet
//$erg = $mysqli->query("SELECT * FROM projekte order by id DESC")
  //	or die($mysqli->error);

$erg = $pdo->prepare("SELECT * FROM projekte order by id DESC");
$result = $erg->execute();


// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td>ID</td><td>Name</td><td>Priorität</td></tr></thead>';
//echo 	'<br>';
echo	'<tbody>';

// hier wird die Datenbank durchlaufen
while($data = $erg->fetch()) {

//Hier kommen die verschiedenen Suchen. Durch die Übergabe von i ($Z) wird die richtige Suche gewählt
// hier wird nach Name und Beschreibung durchsucht ==========================================================================================
if ($z == 3) {
	//echo' <h1>Suche Name</h1>';

  $name = $data['name_projekte'].$data['beschreibung_projekte'];
	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
    $id=$data['id'];
    $name=$data['name_projekte'];
		$prio=$data['prio'];

		$treffer++;
		ausgabe($id, $name, $prio);
		//exit;
   }
 }
} // ende der while schleife

echo'</tbody>';
echo'</table>';

//hier wird die Anzahl der Treffer gezeigt. id=treffer: an welche position kommt aus css
echo '<div id = "treffer" >';
if ($erg->num_rows) {
  echo "<center>";
  echo "Datensätze gesamt: ".$erg->num_rows;
	echo ", Treffer: ".$treffer;
  echo "</center>";
}
echo '</div>';

function ausgabe($id, $name, $prio)
{
		echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
		//echo '<td>' . $datei . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		echo '<td><a href=projekte_formular.php?ID='.$id.'>' . $id . '</a></td>';
		echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $name . '</a></td>'; // die ID wird übergeben!!
		//echo '<td><a href=privat.html>'. $pfad . '</a></td>';
		//echo '<td style="text-align: left; font-weight: bold; color:blueviolet">' . $sterne . '</a></td>';
		//echo '<td style="text-align: center; font-weight: bold; color:green">' . $beschreibung . '</td>';

		echo '<td><a href=privat.html>' . $prio . '</a></td>';
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
