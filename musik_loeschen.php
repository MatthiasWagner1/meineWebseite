<?php
	include "verbinden_musiksammlung.php"; // db wird geöffnet
	
	// $qu= "DELETE FROM filme where ID='".$_REQUEST['ID']."', ";
	$qu= "DELETE FROM lieder where id_lieder=".$_REQUEST['id_lieder'];
	
	//echo $qu;
	
	$mysqli->query($qu);

	header("location: musik.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
