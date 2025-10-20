<?php
include "ebooks_verbinden.php"; // Datenbank öffnen

// alle Autoren holen, sortiert nach Name
$autoren = $pdo->query("SELECT id_autor, name, vorname FROM tab_autor ORDER BY name, vorname")->fetchAll(PDO::FETCH_ASSOC);

// Duplikate erkennen (exakte Übereinstimmung)
$seen = [];
$duplikate = [];

foreach ($autoren as $autor) {
    $key = strtolower(trim($autor['name'])) . '_' . strtolower(trim($autor['vorname']));
    if (isset($seen[$key])) {
        // schon vorhanden → Duplikat
        $duplikate[$key][] = $autor;
    } else {
        $seen[$key][] = $autor;
    }
}

// Ausgabe
echo '<h2>Autoren</h2>';
echo '<table border="1" cellpadding="5">';
echo '<tr><th>ID</th><th>Name</th><th>Vorname</th><th>Aktionen</th></tr>';

foreach ($seen as $key => $autorenListe) {
    foreach ($autorenListe as $autor) {
        echo '<tr>';
        echo '<td>' . $autor['id_autor'] . '</td>';
        echo '<td>' . htmlspecialchars($autor['name']) . '</td>';
        echo '<td>' . htmlspecialchars($autor['vorname']) . '</td>';
        echo '<td>';
        if (isset($duplikate[$key])) {
            echo '<strong>Duplikat vorhanden!</strong>';
        }
        echo '</td>';
        echo '</tr>';
    }
}

echo '</table>';
?>
