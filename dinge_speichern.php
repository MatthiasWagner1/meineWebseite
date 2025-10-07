<?php
	include "dinge_verbinden.php"; // db wird geöffnet

	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_POST['ID'])):

	 $qu = "INSERT INTO dinge.tab_dinge set typ='".$_POST['typ']."', ";
	 $qu.="besitzer='".$_POST['besitzer']."', ";
	 $qu.="name_dinge='".$_POST['name_dinge']."', ";
	 $qu.="beschreibung_dinge='".$_POST['beschreibung_dinge']."', ";

	 // Achtung beim letzten Teil KEIN Komma!!!
	 $qu.="fs_ort='".$_POST['ort']."' ";

	  //echo $qu;
	  //exit;


	else:

		// wenn eine ID vorhanden ist wird geändert

		$qu = "UPDATE dinge.tab_dinge set typ='".$_POST['typ']."', ";
		$qu.="besitzer='".$_POST['besitzer']."', ";
		$qu.="name_dinge='".$_POST['name_dinge']."', ";
		$qu.="beschreibung_dinge='".$_POST['beschreibung_dinge']."', ";

		// Achtung beim letzten Teil KEIN Komma!!!
		$qu.="fs_ort='".$_POST['ort']."' ";
		 // Achtung beim letzten Teil KEIN Komma!!!

		$qu.="where ID='".$_POST['ID']."' ";

		//echo $qu;
		//exit;

	endif;


	$qu = $pdo->prepare($qu);
   	$result = $qu->execute();
   header("location: dinge.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
