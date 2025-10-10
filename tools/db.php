<?php
// db.php – Datenbankverbindung über PDO

$host = 'localhost';
$db   = 'ebooks';           // Name deiner Datenbank
$user = 'matthias';     // Hier deinen MySQL-Benutzernamen eintragen
$pass = 'seppel'; // Und hier dein Passwort
$charset = 'utf8mb4';

// DSN = Daten Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // wirft Exceptions bei Fehlern
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // FETCH_ASSOC ist standard
    PDO::ATTR_EMULATE_PREPARES   => false,                  // echte Prepared Statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Verbindung fehlgeschlagen: ' . $e->getMessage());
}
?>
