<?php
// autor_duplikat_merge.php

include "ebooks_verbinden.php"; // Datenbankverbindung

// Prüfen, ob beide Parameter vorhanden sind
if (!isset($_GET['haupt_id']) || !isset($_GET['dup_id'])) {
    die("Bitte Hauptautor-ID und Duplikat-ID angeben.");
}

$haupt_id = (int)$_GET['haupt_id'];
$dup_id = (int)$_GET['dup_id'];

// 1. Alle ebooks vom Duplikat auf den Hauptautor übertragen
$sql = "UPDATE tab_ebooks SET fs_autor = :haupt_id WHERE fs_autor = :dup_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':haupt_id' => $haupt_id, ':dup_id' => $dup_id]);

// 2. Das Duplikat aus der Autoren-Tabelle löschen
$sql2 = "DELETE FROM tab_autor WHERE id_autor = :dup_id";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([':dup_id' => $dup_id]);

echo "Alle ebooks von Autor-ID $dup_id wurden auf Autor-ID $haupt_id übertragen.<br>";
echo "Duplikat-Autor mit ID $dup_id wurde gelöscht.<br>";
echo "<a href='autor_verwaltung.php'>Zurück zur Autorenverwaltung</a>";
?>
