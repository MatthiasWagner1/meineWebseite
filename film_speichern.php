<?php
	include "verbinden.php"; // db wird geöffnet

	// hier werden die Checkboxen gespeichert

	//$id = $_GET['Thriller'];
	//echo $id;
	//exit;

$var1 = $var1.''.$_GET['Serie'];
$var1 = $var1.''.$_GET['Thriller'];
$var1 = $var1.''.$_GET['Dokumentation'];
$var1 = $var1.''.$_GET['Drama'];
$var1 = $var1.''.$_GET['Komödie'];
$var1 = $var1.''.$_GET['SciFi'];
$var1 = $var1.''.$_GET['Zeichentrick'];
$var1 = $var1.''.$_GET['Western'];
$var1 = $var1.''.$_GET['Action'];
$var1 = $var1.''.$_GET['Abenteuer'];
$var1 = $var1.''.$_GET['Fantasy'];
$var1 = $var1.''.$_GET['Historie'];
$var1 = $var1.''.$_GET['Liebesfilm'];
$var1 = $var1.''.$_GET['Animation'];



	//echo phpinfo();
	//echo $var1;
	///exit;





	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_GET['ID'])):

	 $qu= "INSERT INTO filme set dateiname='".$_GET['dateiname']."', ";
	 $qu.="pfad='".$_GET['pfad']."', ";
	 $qu.="jahr='".$_GET['jahr']."', ";
	 $qu.="genre='".$var1."', ";
	 $qu.="lesezeichen='".$_GET['lesezeichen']."', ";
	 $qu.="filmwunsch='".$_GET['filmwunsch']."', ";
	 $qu.="empfehlung='".$_GET['empfehlung']."', ";
	 $qu.="serie='".$_GET['serie']."', ";
	 $qu.="beschreibung='".mysqli_real_escape_string($mysqli, $_GET['beschreibung'])."', ";
	 //$qu.="beschreibung='".$_GET['beschreibung']."', ";
	 $qu.="bemerkung='".$_GET['bemerkung']."', ";
	 $qu.="bewertung='".$_GET['rating']."', ";
	 $qu.="name='".$_GET['name']."' ";

	//echo $qu;
	//exit;


	// wenn eine ID vorhanden ist wird geändert
	else:

	 $qu= "UPDATE filme set dateiname='".$_GET['dateiname']."', ";
	 $qu.="pfad='".$_GET['pfad']."', ";
	 $qu.="jahr='".$_GET['jahr']."', ";
	 //$qu.="genre='".$_GET['genre']."', ";
	 $qu.="genre='".$var1."', ";
	 $qu.="lesezeichen='".$_GET['lesezeichen']."', ";
	 $qu.="filmwunsch='".$_GET['filmwunsch']."', ";
	 $qu.="empfehlung='".$_GET['empfehlung']."', ";
	 $qu.="serie='".$_GET['serie']."', ";
	 $qu.="beschreibung='".mysqli_real_escape_string($mysqli, $_GET['beschreibung'])."', ";
	 //$qu.="beschreibung='".$_GET['beschreibung']."', ";
	 $qu.="bemerkung='".$_GET['bemerkung']."', ";
	 // $qu.="bewertung='".$_GET['bewertung']."', ";
	 if (empty($_GET['rating']))
	 {
		$_GET['bewertung']='0';
		$qu.="bewertung='".$_GET['bewertung']."', "; // Achtung beim letzten Teil KEIN Komma!!!
	 }
	 	 else
	 {
		$qu.="bewertung='".$_GET['rating']."', "; // Achtung beim letzten Teil KEIN Komma!!!
	 }


	 $qu.="name='".$_GET['name']."' ";
	 $qu.="where ID='".$_GET['ID']."' ";

	endif;

	//echo $qu;
	//exit;
	$mysqli->query($qu);

	header("location: filme.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
