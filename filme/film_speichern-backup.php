<?php
	include "verbinden.php"; // db wird geöffnet
	
	// hier werden die Checkboxen gespeichert
	$var1 = mysql_real_escape_string($_REQUEST['Thriller']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Drama']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Komödie']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['SciFi']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Zeichentrick']);	
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Western']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Action']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Abenteuer']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Fantasy']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Historie']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Liebesfilm']);
	$var1 = $var1.''.mysql_real_escape_string($_REQUEST['Animation']);
	
				
	
	//echo $var1;
	//exit;	
	
	
	
	
	
	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_REQUEST['ID'])):
	
	 $qu= "INSERT INTO filme set dateiname='".$_REQUEST['dateiname']."', ";
	 $qu.="pfad='".$_REQUEST['pfad']."', ";
	 $qu.="jahr='".$_REQUEST['jahr']."', ";
	 $qu.="genre='".$var1."', ";
	 $qu.="lesezeichen='".$_REQUEST['lesezeichen']."', ";
	 $qu.="filmwunsch='".$_REQUEST['filmwunsch']."', ";
	 $qu.="empfehlung='".$_REQUEST['empfehlung']."', ";
	 $qu.="beschreibung='".mysql_real_escape_string($_REQUEST['beschreibung'])."', ";
	 //$qu.="beschreibung='".$_REQUEST['beschreibung']."', ";
	 $qu.="bemerkung='".$_REQUEST['bemerkung']."', ";
	 $qu.="bewertung='".$_REQUEST['bewertung']."', ";


	 $qu.="name='".$_REQUEST['name']."' ";	
	
	// wenn eine ID vorhanden ist wird geändert
	else:

	 $qu= "UPDATE filme set dateiname='".$_REQUEST['dateiname']."', ";
	 $qu.="pfad='".$_REQUEST['pfad']."', ";
	 $qu.="jahr='".$_REQUEST['jahr']."', ";
	 //$qu.="genre='".$_REQUEST['genre']."', ";
	 $qu.="genre='".$var1."', ";
	 $qu.="lesezeichen='".$_REQUEST['lesezeichen']."', ";
	 $qu.="filmwunsch='".$_REQUEST['filmwunsch']."', ";
	 $qu.="empfehlung='".$_REQUEST['empfehlung']."', ";
	 $qu.="beschreibung='".mysql_real_escape_string($_REQUEST['beschreibung'])."', ";
	 //$qu.="beschreibung='".$_REQUEST['beschreibung']."', ";	 	 
	 $qu.="bemerkung='".$_REQUEST['bemerkung']."', ";
	 $qu.="bewertung='".$_REQUEST['bewertung']."', ";

	 
	 $qu.="name='".$_REQUEST['name']."' ";
	 $qu.="where ID='".$_REQUEST['ID']."' ";
	
	endif;
	
	//echo $qu;
	//exit;
	$mysqli->query($qu);

	header("location: filme.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
