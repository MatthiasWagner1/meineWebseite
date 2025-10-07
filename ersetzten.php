<?php
// hier öffnen wir die Verbindung zur Datenbank
include "verbinden_musiksammlung.php";


$erg = $mysqli->query("SELECT id_lieder, interpret, titel, album, pfad, dateiname FROM lieder")
	or die($mysqli->error);
$i=0;

$e="Jon Bon Jovi";			// suche
$s="Bon Jovi";			// wird ersetzt

while ($zeile = $erg->fetch_object()) 
	{
		
		$id_lieder=$zeile->id_lieder;
		$interpret=$zeile->interpret;
		// $titel=$zeile->titel;
		// $album=$zeile->album;
		// $dateiname=$zeile->dateiname;
		// $pfad=$zeile->pfad;
		
		// echo "$interpret" . "\n";
		// echo "$titel" . "\n";
		
		if ($interpret == $e) { 
		
			$interpret=str_replace ( $e, $s, $interpret );
			// $titel=str_replace ( $e, $s, $titel );
			// $album=str_replace ( $e, $s, $album );
			
			// $pfad=str_replace ( $e, $s, $pfad );
			// $dateiname=str_replace ( $e, $s, $dateiname );
			
			// echo "$interpret" . "\n";
			// echo "$titel" . "\n";
			// echo "$album" . "\n";
			// echo "$pfad" . "\n";
			// echo "$dateiname" . "\n";
			
			// echo "\n";
		
			$qu= "UPDATE lieder set interpret='".mysqli_real_escape_string($mysqli, $interpret)."' ";		
			// $qu.="album='".mysqli_real_escape_string($mysqli, $album)."', ";
			// $qu.="dateiname='".mysqli_real_escape_string($mysqli, $dateiname)."' ";
			$qu.="where id_lieder='".$id_lieder."' ";
			
			 // echo $qu . "\n";;
			 // exit;
		
			 $mysqli->query($qu);
			
			$i++;
		echo "$i" . "\n";
		}
	}

echo "\n";
echo "$i" . "\n";

$mysqli->close();
?>


