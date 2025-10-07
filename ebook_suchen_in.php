<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../ebook_formate.css" type="text/css">
  <title>Bücher</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Kopfzeile einbinden
    ?>
  </header>

<main>
 <h1>eBooks suchen</h1>


Suchbegriff eingeben:

<div id = "suche">
<form method='post' action="ebook_suchen_in.php?i=1">
<label for='suche'></label>
<input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
<button id = "buttons_suche">finden</button>

</form>
<br>
<div id = "suche">
<form method='post' action="ebook_suchen_in.php?i=2">
<label for='suche'></label>
<input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
<button id = "buttons_suche">nur Titel</button>

</form>




<br>
<form method='post'>
<input id = "buttons_suche" type="Submit" name="" formaction="ebook_suchen_in.php?ID=1" value="nur Titel">
<input id = "buttons_suche" type="Submit" name="" formaction="ebook_suchen_in.php?ID=2" value="nur Autor">
</form>



<?php
	include "ebooks_verbinden.php"; // db wird geöffnet
	$eingabe = $_POST['suche'];
	$z=$_GET['i'];

	echo "$z";
	echo "$eingabe";


$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen

	//echo "$suche[0]<br>";
	//echo "$suche[1]";

	if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
	}




	$erg = $pdo->prepare("SELECT 
    tab_ebooks.titel,
    tab_ebooks.id,
    tab_ebooks.date,
    tab_ebooks.isbn,
    tab_autor.name AS autor
    FROM tab_ebooks
    JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor 
  	");

$result = $erg->execute();




 
//echo "$z";
//echo "$erg";

// hier wird die Tabelle erstellt
echo 	'<br>';
echo 	'<table class="privat" border="1">';
// echo 	'<tr><td style="width:50px"</td><td style="width:390px"</td><td style="width:35%"</td><td style="width:50px"</td><td style="width:50px"</td></tr>';
echo 	'<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veroeffentlichung</td><td>ISBN</td></tr></thead>';

echo 	'<br>';
echo	'<tbody>';

//echo "$z";

// hier wird die Datenbank durchlaufen
while($data = $erg->fetch()) {

	$id=$data['id'];
	$titel=$data['titel'];
	$autor=$data['autor'];

	// echo "Titel: $titel - ";
	// echo "Autor: $autor<br>";




//Hier kommen die verschiedenen Suchen. Durch die Übergabe von i ($Z) wird die richtige Suche gewählt

	// hier wird nach Name und Typ durchsucht ==========================================================================================
if ($z == 3) {

	$name=$data['titel'].$data['autor']; // hier könnte man noch ein weiteres Feld anfügen welches durchsucht werden soll

//echo "$z";
// echo "$name";



	$pos = stripos($name, $suche[0]); 	// wenn der suchbegriff in datei dann $pos=true
	$pos1 = stripos($name, $suche[1]); // stripos() Klein- Großschreibung egal

	if ($pos!== false and $pos1!==false) {	//wenn es den string gibt ($pos=true)
		$id=$data['id'];
		$titel=$data['titel'];
		$autor=$data['autor'];
		$veroeffentlichung=$data['date'];
		$isbn=$data['isbn'];
		//$besitzer=$data['besitzer'];

		$treffer++;

		//echo "$name";

		ausgabe($id, $titel, $autor, $veroeffentlichung, $isbn);
		//exit;
	}
}
}

echo'</tbody>';
echo'</table>';


function ausgabe($id, $titel, $autor, $veroeffentlichung, $isbn)
{
echo '<tr class="privat">';						// dann schreibe die Zeile (row) in die Tabelle
echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $id . '</a></td>';
echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $titel . '</a></td>'; // die ID wird übergeben!!
echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $autor . '</a></td>';
echo '<td>' . $veroeffentlichung . '</a></td>';
echo '<td>' . $isbn . '</td>';


echo '</tr>';
}
?>

<form method="post" action='ebook.php'>
<table>
  </td>
  <td><input type="Submit" name='zurück' value="zurück"></td>
  </tr>
</table>
</form>



</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
