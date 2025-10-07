<?php
// hier öffnen wir die Verbindung zur Datenbank
include "verbinden_musiksammlung.php";


$erg = $mysqli->query("SELECT genre FROM lieder ORDER BY id_lieder DESC")
	or die($mysqli->error);	

$i=0;

while ($zeile = $erg->fetch_object()) 
	{
		$genres[]=$zeile->genre;
		// echo "$genres[$i]" . "\n";
		// $i++;

	}

$zaehle = array_count_values ( $genres );

while ( list ( $key, $val ) = each ( $zaehle ) )
{
    echo "$key" . ", " . "$val" . ""."\n";
    $i++;
}

echo "\n";

echo $i;

$mysqli->close();
?>


