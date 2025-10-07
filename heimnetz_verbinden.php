<?php
try {
    $server = "mysql:host=localhost;dbname=heimnetz;charset=utf8mb4";
    $user = "matthias";
    $password = "seppel";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // wichtig!
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($server, $user, $password, $options);

} catch (PDOException $e) {
    // Fehler sichtbar machen
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}











/*
error_reporting(level -1);
$server   = 'mysql:dbname=heimnetz;host=localhost; port=3333';
$user     = 'matthias';
$password = 'seppel';
$options  = array
            (
              PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            );
$pdo      = new PDO($server, $user, $password, $options);

// $pdo = new PDO('mysql:host=localhost;dbname=dinge', 'matthias', 'seppel');
*/

/*

// $mysqli = new mysqli('localhost', 'matthias', 'seppel', 'dinge');

$mysqli = new mysqli($DB_HOST, $DB_BENUTZER, $DB_PASSWORT,$DB_NAME );

if ($mysqli->connect_error) {
	echo 'Fehler bei der Verbindung: '.mysqli_connect_error();
	exit();
	}
if (!$mysqli->set_charset("utf8")) {
	echo 'Fehler beim Laden von UTF8 '. $mysqli->error;
}

*/

?>
