<?php
	include "dinge_verbinden.php"; // db wird geöffnet
	error_reporting(-1);

	$z=$_GET['i'];
	$x=$_REQUEST['x'];
	//echo $x.' ';
	//echo $z;
  //exit;

    if ($z == 1) { // hier wird das Zimmer mit dem fs_stockwerk gespeichert

			//wenn $x (id_zimmer) > 0 dann update tab_zimmer
			if ($x>0) {
				$qu = "UPDATE dinge.tab_zimmer set name_zimmer='".$_POST['zimmer']."', ";
				$qu.="fs_stockwerk='".$_POST['stockwerk']."', ";

				// Achtung beim letzten Teil KEIN Komma!!!
				$qu.="beschreibung_zimmer='".$_POST['beschreibung_zimmer']."' ";
				$qu.="where ID_zimmer='".$x."' ";
				//echo $qu.' UPDATE';
				//exit;  // noch nicht getestet
			} else {
					$qu = "INSERT INTO dinge.tab_zimmer set name_zimmer='".$_POST['zimmer']."', ";
					$qu.="fs_stockwerk='".$_POST['stockwerk']."', ";

					// Achtung beim letzten Teil KEIN Komma!!!
					$qu.="beschreibung_zimmer='".$_POST['beschreibung_zimmer']."' ";
					//echo $qu.' INSERT';
					//exit;  // noch nicht getestet
				 }
			}

			if ($z == 2) { // hier wird das Regal mit dem fs_zimmer gespeichert

					//wenn $x (id_regal) > 0 dann update tab_regal
	 	 		 if ($x>0) {
	 	 			 $qu = "UPDATE dinge.tab_regal set name_regal='".$_POST['regal']."', ";
	 	 			 $qu.="fs_zimmer='".$_POST['zimmer']."', ";

	 	 			 // Achtung beim letzten Teil KEIN Komma!!!
	 	 			 $qu.="beschreibung_regal='".$_POST['beschreibung_regal']."' ";
	 	 			 $qu.="where ID_regal='".$x."' ";
	 	 			 //echo $qu;
	 	 			 //exit; // noch nicht gemacht
	 	 	} else {
		 			$qu = "INSERT INTO tab_regal set name_regal='".$_POST['regal']."', ";
		 			$qu.="fs_zimmer='".$_POST['zimmer']."', ";

		 			// Achtung beim letzten Teil KEIN Komma!!!
		 			$qu.="beschreibung_regal='".$_POST['beschreibung_regal']."' ";
		 		  //echo $qu;
		 			//exit;
		 		 	}
				}

		 if ($z == 3) { // hier wird der Ort mit dem fs_regal gespeichert
			 if ($x>0) {
				 $qu = "UPDATE dinge.tab_ort set name_ort='".$_POST['ort']."', ";
				 $qu.="fs_regal='".$_POST['regal']."', ";

				 // Achtung beim letzten Teil KEIN Komma!!!
				 $qu.="beschreibung_ort='".$_POST['beschreibung_ort']."' ";
				 $qu.="where ID_ort='".$x."' ";

					//echo $qu;
			 		//exit;
		 	} else {
				 $qu = "INSERT INTO dinge.tab_ort set name_ort='".$_POST['ort']."', ";
				 $qu.="fs_regal='".$_POST['regal']."', ";
				 // Achtung beim letzten Teil KEIN Komma!!!
				 $qu.="beschreibung_ort='".$_POST['beschreibung_ort']."' ";
				 //echo $qu;
				 //exit;
	 		}
	   }

		 if ($z == 4) { // hier wird der Typ gespeichert
			 if ($x>0) {
				 $qu = "UPDATE dinge.tab_typ set name_typ='".$_POST['typ']."' ";

				 $qu.="where ID_typ='".$x."' ";

					//echo $qu;
			 		//exit;
		 	} else {
				 $qu = "INSERT INTO dinge.tab_typ set name_typ='".$_POST['typ']."' ";

				 //echo $qu;
				 //exit;
	 		}
	   }

$qu = $pdo->prepare($qu);
$result = $qu->execute();
header("location: dinge_stammdaten.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!








?>
