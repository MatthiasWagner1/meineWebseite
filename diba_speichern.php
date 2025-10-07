<?php
	include "heimnetz_verbinden.php"; // db wird geöffnet

		$qu = "UPDATE heimnetz.konten set notiz='".$_GET['notiz']."', ";

		// Achtung beim letzten Teil KEIN Komma!!!
		$qu.="kategorie='".$_GET['kategorie']."' ";
		 // Achtung beim letzten Teil KEIN Komma!!!

		$qu.="where ID='".$_GET['ID']."' ";

		//echo $qu;
		//exit;



	$qu = $pdo->prepare($qu);
   	$result = $qu->execute();
    header("location: diba.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
