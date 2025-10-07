<?php
	include "verbinden.php"; // db wird geöffnet
	
	// $qu= "DELETE FROM filme where ID='".$_REQUEST['ID']."', ";
	$qu= "DELETE FROM filme where ID=".$_REQUEST['ID'];
	
	//echo $qu;
	
	$mysqli->query($qu);

	header("location: filme.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
