<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;">
  
  <link rel="stylesheet" href="../ebook_formate.css">
  <title>Bücher</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Kopfzeile einbinden
    ?>
  </header>

<main>

<h1> eBooks</h1>
<form>
<input type="Submit" name="" formaction="ebook-import.php" value="eBook Import">
<input type="Submit" name="" formaction="ebook_autor.php" value="Liste Autoren">
</form>
<br><br>
Suchbegriff eingeben:

<div id = "suche">
<form method='post' action="ebook.php?i=1">
<label for='suche'></label>
<input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
<button id = "buttons_suche">finden</button>
<br><br>
<input id = "buttons_suche" type="Submit" name="" formaction="ebook.php?i=2" value="nach eBooks">
<input id = "buttons_suche" type="Submit" name="" formaction="ebook.php?i=3" value="nach Autoren">
</form>
<br><br>


<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);




include "ebooks_verbinden.php"; // db wird geöffnet

$eingabe = $_POST['suche'];
$i=$_GET['i'];

if (empty($_GET['i'])) {
  // Die Variable 'meine_variable' ist leer oder nicht gesetzt.
  echo "<h3>Die 20 neuesten eBooks.</h3>";
  
  
$erg = "SELECT * FROM tab_ebooks
INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor 
ORDER BY tab_ebooks.id DESC LIMIT 20
";   // hier werden tab_ebooks und tab_autor über tab_autor.id_autor und tab_ebooks.fs_autor verbunden

$erg = $pdo->prepare($erg);
$result = $erg->execute();

//echo "Suche: ".$suche[0]."<br>";
//echo "i: ".$i;

// hier schreiben wir den Tabellenkopf
echo 	'<table class="privat">';
echo 	'<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
echo	'<tbody>';

while($data = $erg->fetch()) {
  $id=$data['id'];
  $id_autor=$data['id_autor'];
  $titel=$data['titel'];
  $autor=$data['name'];
  $date=$data['date'];
  $isbn=$data['isbn'];

  ausgabe($id, $id_autor, $titel, $autor, $date, $isbn);
} 
exit;

}


$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						    // falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}

$erg = "SELECT * FROM tab_ebooks
  INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor 
  ORDER BY tab_ebooks.id DESC
  ";   // hier werden tab_ebooks und tab_autor über tab_autor.id_autor und tab_ebooks.fs_autor verbunden

$erg = $pdo->prepare($erg);
$result = $erg->execute();

//echo "Suche: ".$suche[0]."<br>";
//echo "i: ".$i;

// hier schreiben wir den Tabellenkopf
echo 	'<table class="privat">';
echo 	'<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
echo	'<tbody>';

while($data = $erg->fetch()) {


//Hier kommen die verschiedenen Suchen. Durch die Übergabe von i ($i) wird die richtige Suche gewählt

// hier wird nach Titel und Autor durchsucht ==========================================================================================
if ($i == 1) {

	$name=$data['titel'].$data['name']; // hier könnte man noch ein weiteres Feld anfügen welches durchsucht werden soll

	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$data['id'];
		$id_autor=$data['id_autor'];
    $titel=$data['titel'];
		$autor=$data['name'];
		$date=$data['date'];
		$isbn=$data['isbn'];
		//$besitzer=$data['besitzer'];

		$treffer++;

		ausgabe($id, $id_autor, $titel, $autor, $date, $isbn);
		//exit;
	}
}

// hier wird der Titel durchsucht ==========================================================================================
if ($i == 2) {

	$name=$data['titel']; // hier könnte man noch ein weiteres Feld anfügen welches durchsucht werden soll

	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$data['id'];
		$id_autor=$data['id_autor'];
    $titel=$data['titel'];
		$autor=$data['name'];
		$date=$data['date'];
		$isbn=$data['isbn'];
		//$besitzer=$data['besitzer'];

		$treffer++;

		//echo "$name";

		ausgabe($id, $id_autor, $titel, $autor, $date, $isbn);
		//exit;
	}
}

// hier wird der Autor durchsucht ==========================================================================================
if ($i == 3) {

	$name=$data['name']; // hier könnte man noch ein weiteres Feld anfügen welches durchsucht werden soll

	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$data['id'];
    $id_autor=$data['id_autor'];
		$titel=$data['titel'];
		$autor=$data['name'];
		$date=$data['date'];
		$isbn=$data['isbn'];
	
		$treffer++;

		ausgabe($id, $id_autor, $titel, $autor, $date, $isbn);
		//exit;
	}
}

}

/*
==================================================================================================
wie 
==================================================================================================


==================================================================================================
*/

function ausgabe($id, $id_autor, $titel, $autor, $date, $isbn)
{
echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $id . '</a></td>';
echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $titel . '</a></td>'; // die ID wird übergeben!!
echo '<td><a href=ebook_autor_formular.php?ID='.$id_autor.'>'. $autor . '</a></td>';
echo '<td>' . $date . '</a></td>';
echo '<td>' . $isbn . '</td>';
echo '</tr>';
}

echo "<h3>Treffer: " .$treffer;

 //include "footer.php"; // die Fusszeile einbinden
?>

</main>
</body>
</html>