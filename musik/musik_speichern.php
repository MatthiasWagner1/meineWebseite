<?php
	include "verbinden_musiksammlung.php"; // db wird geöffnet
	
	
	// wenn die ID leer ist dann wird ein neuer datensatz angelegt
	if (empty($_GET['id_lieder'])):
	
	 $qu= "INSERT INTO lieder set dateiname='".$_GET['dateiname']."', ";
	 $qu.="album='".$_GET['album']."', ";
	 $qu.="groesse='".$_GET['groesse']."', ";
	 $qu.="laenge='".$_GET['laenge']."', ";
	 $qu.="pfad='".$_GET['pfad']."', ";
	 $qu.="jahr='".$_GET['jahr']."', ";
	 $qu.="beschreibung='".mysqli_real_escape_string($mysqli, $_GET['beschreibung'])."', ";
	 $qu.="bemerkung='".$_GET['bemerkung']."', ";
	 $qu.="titel='".$_GET['titel']."', ";
	 $qu.="interpret='".$_GET['interpret']."', ";
	 $qu.="markiert='".$_GET['markiert']."', ";
	 $qu.="genre='".$_GET['genre']."', ";
	 // ab hier werden integer übergeben, kein String!!	 
	 // wenn diese felder keine Zahl enthalten dann 0
	 if (is_numeric($_GET['playlist'])) 
	 {
		$qu.="playlist=".$_GET['playlist'].", ";
	 }
	 else 
	 {
		$_GET['playlist']=0;
		$qu.="playlist=".$_GET['playlist'].", ";			
	 }
	 if (is_numeric($_GET['bewertung'])) 
	 {
		$qu.="bewertung=".$_GET['bewertung']." "; // Achtung beim letzten Teil KEIN Komma!!!
	 }
	 else 
	 {
		$_GET['bewertung']=0;
		$qu.="bewertung=".$_GET['bewertung']." "; // Achtung beim letzten Teil KEIN Komma!!!
	 }	 

	 //echo $qu;
	 //exit;
	
	// wenn eine ID vorhanden ist wird geändert
	else:

	 $qu= "UPDATE lieder set dateiname='".mysqli_real_escape_string($mysqli, $_GET['dateiname'])."', ";
	 $qu.="album='".mysqli_real_escape_string($mysqli, $_GET['album'])."', ";
	 $qu.="groesse='".$_GET['groesse']."', ";
	 $qu.="laenge='".$_GET['laenge']."', ";
	 $qu.="pfad='".mysqli_real_escape_string($mysqli, $_GET['pfad'])."', ";
	 $qu.="jahr='".$_GET['jahr']."', ";
	 $qu.="beschreibung='".mysqli_real_escape_string($mysqli, $_GET['beschreibung'])."', ";
	 $qu.="bemerkung='".$_GET['bemerkung']."', ";
	 $qu.="titel='".mysqli_real_escape_string($mysqli, $_GET['titel'])."', ";
	 $qu.="interpret='".mysqli_real_escape_string($mysqli, $_GET['interpret'])."', ";
	 $qu.="markiert='".$_GET['markiert']."', ";
	 $qu.="genre='".$_GET['genre']."', ";
	 // ab hier werden integer übergeben, kein String!!
	 $qu.="playlist=".$_GET['playlist'].", ";
	 // wenn es kein Rating gibt dann ist das rating 0
	 if (is_numeric($_GET['rating'])) 
	 {
		$qu.="bewertung=".$_GET['rating']." "; // Achtung beim letzten Teil KEIN Komma!!!
	 }
	 else 
	 {
		$_GET['rating']=0;
		$qu.="bewertung=".$_GET['rating']." "; // Achtung beim letzten Teil KEIN Komma!!!
	 }	  
	 
	 $qu.="where id_lieder='".$_GET['id_lieder']."' ";
	
	endif;
	
	// echo $qu;
	// exit;
	
	$mysqli->query($qu);

	header("location: musik.php"); // funktioniert nur wenn hier keine ausgabe erfolgt ist kein echo kein leerzeichen!!!
?>
