<?php
session_start();

if (!isset($_SESSION['epubs'])) $_SESSION['epubs'] = [];
if (!isset($_SESSION['errors'])) $_SESSION['errors'] = [];

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'functions.php';
require 'db.php';

if (!$pdo instanceof PDO) {
    die("Fehler: Keine PDO-Verbindung.");
}

$startDir = '/media/daten/Buecher/ebooks/';
$zielVerzeichnis = '/media/daten/Buecher/ebooks_neu/';

$counter = ['epubs' => 0, 'errors' => 0];

scanDirectory($startDir, $pdo, $zielVerzeichnis, $counter);

// Ergebnis anzeigen
echo "<h2>Verarbeitete EPUB-Dateien</h2>";
if (!empty($_SESSION['epubs'])) {
    echo "<ul>";
    foreach ($_SESSION['epubs'] as $msg) {
        echo "<li style='color:green;'>$msg</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:gray;'>Keine EPUB-Dateien verarbeitet.</p>";
}

echo "<h2>Fehlermeldungen</h2>";
if (!empty($_SESSION['errors'])) {
    echo "<ul>";
    foreach ($_SESSION['errors'] as $err) {
        echo "<li style='color:red;'>$err</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:gray;'>Keine Fehler aufgetreten.</p>";
}

echo "<br><strong>Zusammenfassung:</strong>";
echo "<br>Erfolgreich verarbeitet: {$counter['epubs']}";
echo "<br>Fehler: {$counter['errors']}";

// Sitzung zurücksetzen
$_SESSION['epubs'] = [];
$_SESSION['errors'] = [];
?>
