<?php
	include "projekte_verbinden.php"; // db wird geöffnet

	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_POST['ID'])):
	 $prio=$_POST['prio'];
	 if ($prio=="") ($prio="3");
	 $qu = "INSERT INTO projekte set erledigt='".$_POST['erledigt']."', ";
	 // $qu.="erledigt='".$_POST['erledigt']."', ";
	 $qu.="name_projekte='".$_POST['name_projekte']."', ";
	 $qu.="beschreibung_projekte='".$_POST['beschreibung_projekte']."', ";
	 $qu.="wiedervorlage='".$_POST['wiedervorlage']."', ";
	 $qu.="typ='".$_POST['typ']."', ";
	 $qu.="datum='".date('d.m.Y')."', ";
	 // Achtung beim letzten Teil KEIN Komma!!!
	 $qu.="prio='".$prio."' ";

	 //echo $qu;
	 //exit;


	else:

		// wenn eine ID vorhanden ist wird geändert

		$qu = "UPDATE projekte set erledigt='".$_POST['erledigt']."', ";
		// $qu.="besitzer='".$_POST['besitzer']."', ";
		$qu.="name_projekte='".$_POST['name_projekte']."', ";
		$qu.="beschreibung_projekte='".$_POST['beschreibung_projekte']."', ";
		$qu.="wiedervorlage='".$_POST['wiedervorlage']."', ";
		$qu.="typ='".$_POST['typ']."', ";
		// Achtung beim letzten Teil KEIN Komma!!!
		$qu.="prio='".$_POST['prio']."' ";
		 // Achtung beim letzten Teil KEIN Komma!!!

		$qu.="where ID='".$_POST['ID']."' ";

		//echo $qu;
		//exit;

	endif;


	$qu = $pdo->prepare($qu);
   	$result = $qu->execute();
   header("location: projekte.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
