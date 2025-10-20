<?php
// Verbindung zur Datenbank
include "ebooks_verbinden.php";

// Hauptautor-ID aus URL
$haupt_id = $_GET['id'] ?? 0;
if (!$haupt_id) {
    echo "Keine Hauptautor-ID übergeben!";
    exit;
}

// Hole Hauptautor
$stmt = $pdo->prepare("SELECT id_autor, name, vorname FROM tab_autor WHERE id_autor = ?");
$stmt->execute([$haupt_id]);
$hauptautor = $stmt->fetch();

if (!$hauptautor) {
    echo "Hauptautor nicht gefunden!";
    exit;
}

// Suche alle möglichen Duplikate (einfaches Beispiel: gleiche Nachnamen, andere Schreibweise oder Vorname leer)
$stmt = $pdo->prepare("
SELECT id_autor, name, vorname
FROM tab_autor
WHERE name = ? AND id_autor != ?
");
$stmt->execute([$hauptautor['name'], $hauptautor['id_autor']]);
$duplikate = $stmt->fetchAll();

?>

<h2>Hauptautor</h2>
<table border="1" style="border-collapse: collapse; margin-bottom: 1em;">
<tr style="background-color: #c8f0c8;">
<th>ID</th>
<th>Name</th>
<th>Vorname</th>
<th>Aktion</th>
</tr>
<tr>
<td><?php echo $hauptautor['id_autor']; ?></td>
<td><?php echo htmlspecialchars($hauptautor['name']); ?></td>
<td><?php echo htmlspecialchars($hauptautor['vorname']); ?></td>
<td>Hauptautor</td>
</tr>
</table>

<?php if ($duplikate): ?>
<h2>Duplikate</h2>
<table border="1" style="border-collapse: collapse;">
<tr style="background-color: #fff3b0;">
<th>ID</th>
<th>Name</th>
<th>Vorname</th>
<th>Aktion</th>
</tr>
<?php foreach ($duplikate as $dup): ?>
<tr>
<td><?php echo $dup['id_autor']; ?></td>
<td><?php echo htmlspecialchars($dup['name']); ?></td>
<td><?php echo htmlspecialchars($dup['vorname']); ?></td>
<td>
<a href="autor_duplikat_merge.php?haupt_id=<?php echo $hauptautor['id_autor']; ?>&dup_id=<?php echo $dup['id_autor']; ?>">Mit Hauptautor zusammenführen</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>Keine Duplikate gefunden.</p>
<?php endif; ?>
