<?php
require 'db.php';

$stmt = $pdo->query("SELECT e.*, a.name as autorname FROM ebooks.tab_ebooks e
JOIN ebooks.tab_autor a ON e.fs_autor = a.id_autor
ORDER BY e.eingetragen_am DESC");

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Meine EPUB-Bibliothek</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background: #f8f8f8; }
        .book { border: 1px solid #ccc; padding: 15px; background: white; margin-bottom: 20px; display: flex; gap: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .cover { width: 120px; height: 180px; background: #eee; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .cover img { max-width: 100%; max-height: 100%; }
        .info { flex-grow: 1; }
        h2 { margin: 0 0 10px; }
    </style>
</head>
<body>

<h1>📚 Meine EPUB-Bibliothek</h1>

<?php foreach ($books as $book): ?>
    <div class="book">
        <div class="cover">
            <?php if ($book['cover']): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($book['cover']) ?>" alt="Cover">
            <?php else: ?>
                <span>Kein Cover</span>
            <?php endif; ?>
        </div>
        <div class="info">
            <h2><?= htmlspecialchars($book['titel']) ?></h2>
            <p><strong>Autor:</strong> <?= htmlspecialchars($book['autorname']) ?></p>
            <p><strong>Sprache:</strong> <?= htmlspecialchars($book['sprache']) ?></p>
            <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
            <p><strong>Beschreibung:</strong><br><?= nl2br(htmlspecialchars($book['beschreibung'])) ?></p>
            <p><strong>Veröffentlicht:</strong> <?= $book['veroeffentlichung'] ?: 'Unbekannt' ?></p>
            <p><strong>Eingetragen:</strong> <?= $book['eingetragen_am'] ?></p>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
