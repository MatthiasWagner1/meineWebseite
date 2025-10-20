<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "ebooks_verbinden.php"; // erzeugt $pdo

// Hilfsfunktion für Namensvergleich
function nameÄhnlich($name1, $vorname1, $name2, $vorname2) {
    $n1 = mb_strtolower($name1.' '.$vorname1);
    $n2 = mb_strtolower($name2.' '.$vorname2);
    if (levenshtein($n1, $n2) <= 2) return true;
    if (levenshtein($vorname1.' '.$name1, $n2) <= 2) return true;
    return false;
}

// Prüfen, ob nur Duplikate angezeigt werden sollen
$nur_duplikate = isset($_GET['nur_duplikate']) && $_GET['nur_duplikate']==1;

// Button oben
echo '<div style="text-align:center; margin-bottom:10px;">';
if ($nur_duplikate) {
    echo '<a href="autor_verwaltung.php"><button>Alle Autoren anzeigen</button></a>';
} else {
    echo '<a href="autor_verwaltung.php?nur_duplikate=1"><button>Nur Duplikate anzeigen</button></a>';
}
echo '</div>';

// Alle Autoren abrufen
$autoren = $pdo->query("SELECT * FROM tab_autor ORDER BY name, vorname")->fetchAll();

$erkannt = [];
echo '<table class="autor_verwaltung" border="1" cellpadding="5" cellspacing="0">';
echo '<thead><tr><th>Hauptautor / Duplikat</th><th>Vorname</th><th>Duplikate</th><th>Aktion</th></tr></thead>';
echo '<tbody>';

foreach ($autoren as $haupt) {
    if (isset($erkannt[$haupt['id_autor']])) continue;

    $duplikate = [];
    foreach ($autoren as $a) {
        if ($a['id_autor'] == $haupt['id_autor']) continue;
        if (nameÄhnlich($haupt['name'], $haupt['vorname'], $a['name'], $a['vorname'])) {
            $duplikate[] = $a;
            $erkannt[$a['id_autor']] = true;
        }
    }

    if ($nur_duplikate && count($duplikate) == 0) continue;

    // Hauptautor-Zeile
    echo '<tr class="hauptautor">';
    echo "<td>{$haupt['name']}</td>";
    echo "<td>{$haupt['vorname']}</td>";
    echo "<td>".count($duplikate)."</td>";
    echo '<td>Hauptautor</td>';
    echo '</tr>';

    // Duplikate anzeigen
    foreach ($duplikate as $d) {
        echo '<tr class="duplikat">';
        echo "<td>{$d['name']}</td>";
        echo "<td>{$d['vorname']}</td>";
        echo "<td>–</td>";
        echo "<td><a href='autor_duplikat_merge.php?haupt_id={$haupt['id_autor']}&dup_id={$d['id_autor']}'>Mit Hauptautor zusammenführen</a></td>";
        echo '</tr>';
    }
}

echo '</tbody></table>';
?>

<style>
.autor_verwaltung {
    width: 80%;
    border-collapse: collapse;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

.autor_verwaltung th {
    background-color: #0c7a71;
    color: white;
    text-align: left;
}

.hauptautor {
    background-color: #d0f0f0;
    font-weight: bold;
}

.duplikat {
    background-color: #f9f9f9;
}

.duplikat:hover {
    background-color: #ffe0e0;
}

button {
    padding: 5px 12px;
    font-size: 1em;
    cursor: pointer;
}
</style>
