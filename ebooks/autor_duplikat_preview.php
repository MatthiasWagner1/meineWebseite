<?php
// autor_duplikat_preview.php

include "ebooks_verbinden.php"; // Datenbankverbindung

// Prüfen, ob Hauptautor-ID gesetzt ist
if (!isset($_GET['haupt_id'])) {
    die("Bitte Hauptautor-ID angeben.");
}

$haupt_id = (int)$_GET['haupt_id'];

// 1. Hauptautor abrufen
$sql = "SELECT * FROM tab_autor WHERE id_autor = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $haupt_id]);
$hauptautor = $stmt->fetch();

if (!$hauptautor) {
    die("Hauptautor nicht gefunden.");
}

// 2. Mögliche Duplikate abrufen (Namensähnlichkeit)
$sql2 = "SELECT * FROM tab_autor WHERE id_autor != :id AND name LIKE :name";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([
    ':id' => $haupt_id,
    ':name' => "%".$hauptautor['name']."%"
]);
$duplikate = $stmt2->fetchAll();

echo "<h2>Hauptautor</h2>";
echo "<p>ID: {$hauptautor['id_autor']}<br>";
echo "Name: {$hauptautor['name']}<br>";
echo "Vorname: {$hauptautor['vorname']}</p>";

if (count($duplikate) === 0) {
    echo "<p>Keine Duplikate gefunden.</p>";
} else {
    echo "<h2>Gefundene Duplikate</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Name</th><th>Vorname</th><th>Aktion</th></tr>";

    foreach ($duplikate as $dup) {
        echo "<tr>";
        echo "<td>{$dup['id_autor']}</td>";
        echo "<td>{$dup['name']}</td>";
        echo "<td>{$dup['vorname']}</td>";
        echo "<td><a href='autor_duplikat_merge.php?haupt_id={$haupt_id}&dup_id={$dup['id_autor']}'>Mit Hauptautor zusammenführen</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<br><a href='autor_verwaltung.php'>Zurück zur Autorenverwaltung</a>";
?>
