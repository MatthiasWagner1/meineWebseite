<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../ebook_formate.css">
  <title>Bücher</title>
</head>
<body>

<header>
<?php include "../header.php"; ?>
</header>

<main>
<h1>eBooks</h1>

<!-- Formular für Aktionen -->
<form>
  <input type="submit" formaction="ebook-import.php" value="eBook Import">
  <input type="submit" formaction="ebook_autor.php" value="Liste Autoren">
</form>

<br><br>
Suchbegriff eingeben:

<div id="suche">
<form method="post" action="ebook.php">
  <label for="suche"></label>
  <input id="suche" name="suche" value="<?php echo htmlspecialchars($_POST['suche'] ?? '', ENT_QUOTES); ?>">
  <button id="buttons_suche">finden</button>
  <br><br>
<input id = "buttons_suche" type="Submit" name="" formaction="ebook.php?i=2" value="nach eBooks">
<input id = "buttons_suche" type="Submit" name="" formaction="ebook.php?i=3" value="nach Autoren">
  
</form>
</div>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "ebooks_verbinden.php"; // Datenbank öffnen

$eingabe = $_POST['suche'] ?? '';
$i = $_POST['i'] ?? null;
$treffer = 0; // Initialisierung

// 20 neueste eBooks anzeigen, wenn keine Suche
if (empty($i)) {
    echo "<h3>Die 20 neuesten eBooks.</h3>";
    
    $query = "SELECT * FROM tab_ebooks 
              INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor 
              ORDER BY tab_ebooks.id DESC 
              LIMIT 20";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    echo '<table class="privat">';
    echo '<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
    echo '<tbody>';

    while ($data = $stmt->fetch()) {
        ausgabe($data);
        $treffer++;
    }

    echo "</tbody></table>";
    echo "<h3>Treffer: $treffer</h3>";
    exit;
}

// Suche vorbereiten
$suche = explode(" ", $eingabe);
if (empty($suche[1])) {
    $suche[1] = substr($suche[0], 0, 1);
}

$query = "SELECT * FROM tab_ebooks 
          INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor 
          ORDER BY tab_ebooks.id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute();

echo '<table class="privat">';
echo '<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
echo '<tbody>';

while ($data = $stmt->fetch()) {
    $felder = [
        1 => $data['titel'] . $data['name'], // Suche nach Titel + Autor
        2 => $data['titel'],                 // Suche nach Titel
        3 => $data['name']                    // Suche nach Autor
    ];

    $text = $felder[$i] ?? '';
    $pos0 = stripos($text, $suche[0]);
    $pos1 = stripos($text, $suche[1]);

    if ($pos0 !== false && $pos1 !== false) {
        ausgabe($data);
        $treffer++;
    }
}

echo "</tbody></table>";
echo "<h3>Treffer: $treffer</h3>";

// Ausgabe-Funktion
function ausgabe($data) {
    $id = htmlspecialchars($data['id'], ENT_QUOTES);
    $id_autor = htmlspecialchars($data['id_autor'], ENT_QUOTES);
    $titel = htmlspecialchars($data['titel'], ENT_QUOTES);
    $autor = htmlspecialchars($data['name'], ENT_QUOTES);
    $date = htmlspecialchars($data['date'], ENT_QUOTES);
    $isbn = htmlspecialchars($data['isbn'], ENT_QUOTES);

    echo '<tr class="privat">';
    echo "<td><a href='ebook_formular.php?ID=$id'>$id</a></td>";
    echo "<td><a href='ebook_formular.php?ID=$id'>$titel</a></td>";
    echo "<td><a href='ebook_autor_formular.php?ID=$id_autor'>$autor</a></td>";
    echo "<td>$date</td>";
    echo "<td>$isbn</td>";
    echo '</tr>';
}

?>
</main>
</body>
</html>
