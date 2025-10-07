<?php
// hier öffnen wir die Verbindung zur Datenbank
include "verbinden_musiksammlung.php";


$erg = $mysqli->query("SELECT dateiname, pfad FROM lieder")
	or die($mysqli->error);	

$i=0;

while ($zeile = $erg->fetch_object()) 
	{
		$mp3=$zeile->pfad . "/" . $zeile->dateiname;
		echo "$mp3" . "\n";
		$tag = id3_get_version( "/musik/Sammlungen/The_Biggest_Music_Collection_Part_A/MyCulture.mp3" );
		print_r($tag);
		exit;
		// $i++;

	}





echo "\n";

echo $i;

$mysqli->close();
?>


