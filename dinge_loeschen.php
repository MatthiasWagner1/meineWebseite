<?php
	include "dinge_verbinden.php"; // db wird geöffnet
	
	// $qu= "DELETE FROM tab_dinge where ID='".$_REQUEST['ID']."', ";
	$qu= "DELETE FROM tab_dinge where ID=".$_REQUEST['ID'];
	
	//echo $qu;
	
	$qu = $pdo->prepare($qu);
	$result = $qu->execute();

	header("location: dinge.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
