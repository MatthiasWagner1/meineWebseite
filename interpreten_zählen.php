<?php
// hier öffnen wir die Verbindung zur Datenbank
include "verbinden_musiksammlung.php";


$erg = $mysqli->query("SELECT interpret FROM lieder ORDER BY id_lieder DESC")
	or die($mysqli->error);	

$i=0;

while ($zeile = $erg->fetch_object()) 
	{
		$interpreten[]=$zeile->interpret;
		// echo "$interpreten[$i]" . "\n";
		// $i++;

	}

$zaehle = array_count_values ( $interpreten );

while ( list ( $key, $val ) = each ( $zaehle ) )
{
    echo "$key" . " kommt " . "$val" . " mal vor"."\n";
    $i++;
}

echo "\n";

echo $i;

$mysqli->close();
?>


