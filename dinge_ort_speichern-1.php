<?php
	include "dinge_verbinden.php"; // db wird geöffnet
	error_reporting(level -1);
	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_GET['ID'])):
	
	 $qu= "INSERT INTO tab_ort set typ='".$_GET['typ']."', ";
	 $qu.="besitzer='".$_GET['besitzer']."', ";
	 $qu.="name_dinge='".$_GET['name_dinge']."', ";
	 
	 // Achtung beim letzten Teil KEIN Komma!!!
	 $qu.="fs_ort='".$_GET['fs_ort']."' ";
	  // Achtung beim letzten Teil KEIN Komma!!!

	 echo $qu;
	 exit;

	else:

	// wenn eine ID vorhanden ist wird geändert

	$qu= "UPDATE tab_dinge set typ='".$_GET['typ']."', ";
	$qu.="besitzer='".$_GET['besitzer']."', ";
	$qu.="name_dinge='".$_GET['name_dinge']."', ";
// 	$qu.="beschreibung_dinge='".$_GET['beschreibung_dinge'])."', ";

	// Achtung beim letzten Teil KEIN Komma!!!
	$qu.="fs_ort='".$_GET['fs_ort']."' ";
 	// Achtung beim letzten Teil KEIN Komma!!!
 
	$qu.="where ID='".$_GET['ID']."' ";
	
	endif; 

    echo $qu;
    exit;

   $qu = $pdo->prepare($qu);
   $result = $qu->execute();
   header("location: dinge.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>