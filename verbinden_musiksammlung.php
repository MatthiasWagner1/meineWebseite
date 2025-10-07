<?php

$DB_HOST = "localhost"; // Host-Adresse
$DB_NAME = "musiksammlung"; // Datenbankname
$DB_BENUTZER = "matthias"; // Benutzername
$DB_PASSWORT = "seppel"; // Passwort 


// $mysqli = new mysqli('localhost', 'matthias', 'seppel', 'musiksammlung');

$mysqli = new mysqli($DB_HOST, $DB_BENUTZER, $DB_PASSWORT,$DB_NAME );
$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {
	echo 'Fehler bei der Verbindung: '.mysqli_connect_error();
	exit();
	}
if (!$mysqli->set_charset("utf8")) {
	echo 'Fehler beim Laden von UTF8 '. $mysqli->error;
}	


?>
