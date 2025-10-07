<?php
// hier öffnen wir die Verbindung zur Datenbank
include "verbinden.php";


$erg = $mysqli->query("SELECT * FROM filme")
	or die($mysqli->error);
$i=0;

$e=null;			// suche
$s="0";			// wird ersetzt

while ($zeile = $erg->fetch_object()) 
	{
		$id = $zeile->id;
		$bewertung = $zeile->bewertung;
		// $dateiname=$zeile->dateiname;
		// $pfad=$zeile->pfad;
		
		// echo "$bewertung" . "\n";
		
		if ($bewertung == $e) { 
		
			$bewertung=str_replace ( $e, $s, $bewertung );
			// $pfad=str_replace ( $e, $s, $pfad );
			// $dateiname=str_replace ( $e, $s, $dateiname );
			

			// echo "$pfad" . "\n";
			// echo "$dateiname" . "\n";
			
			// echo "\n";
		
			$qu= "UPDATE filme set bewertung='".mysqli_real_escape_string($mysqli, $bewertung)."' ";		
			// $qu.="dateiname='".mysqli_real_escape_string($mysqli, $dateiname)."', ";
			$qu.="where id='".$id."' ";
			
			 //echo $qu . "\n";;
			 exit;
		
			 //$mysqli->query($qu);
			
			$i++;
		echo "$i" . "\n";
		}
	}

echo "\n";
echo "$i" . "\n";

$mysqli->close();
?>


