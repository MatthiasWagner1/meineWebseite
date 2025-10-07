<?php
	include "heimnetz_verbinden.php"; // db wird geöffnet

	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_GET['ID'])):

	 $qu= "INSERT INTO liste set host='".$_GET['host']."', ";
	 $qu.="name='".$_GET['name']."', ";
	 //$qu.="beschreibung='".mysqli_real_escape_string($mysqli, $_GET['beschreibung'])."', ";
	 $qu.="beschreibung='".$_GET['beschreibung']."', ";
	
	 // der letzte Datensatz ohne Komma!
	 $qu.="ip_n='".$_GET['ip_n']."' ";

	//echo $qu;
	//exit;


	// wenn eine ID vorhanden ist wird geändert
	else:

	 $qu= "UPDATE liste set host='".$_GET['host']."', ";
	 $qu.="name='".$_GET['name']."', ";
	 //$qu.="beschreibung='".mysqli_real_escape_string($mysqli, $_GET['beschreibung'])."', ";
	 $qu.="beschreibung='".$_GET['beschreibung']."', ";
	
	 // der letzte Datensatz ohne Komma!
	 $qu.="ip_n='".$_GET['ip_n']."' ";
	 $qu.="where ID='".$_GET['ID']."' ";

	endif;

	//echo $qu;
	//exit;

	$qu = $pdo->prepare($qu);
	$result = $qu->execute();

	header("location: heimnetz_ip.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
