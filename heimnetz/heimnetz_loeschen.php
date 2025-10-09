<?php
	include "heimnetz_verbinden.php"; // db wird geöffnet
	
	// $qu= "DELETE FROM liste where ID='".$_REQUEST['ID']."', ";
	$qu= "DELETE FROM liste where ID=".$_REQUEST['ID'];
	
	//echo $qu;
	// exit;
	
	$qu = $pdo->prepare($qu);
	$result = $qu->execute();

	header("location: heimnetz_ip.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
