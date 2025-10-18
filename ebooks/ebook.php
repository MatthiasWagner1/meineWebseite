<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "ebooks_verbinden.php"; // DB öffnen

// Variablen sauber setzen
$eingabe = $_POST['suche'] ?? '';
$i = $_POST['i'] ?? $_GET['i'] ?? null;
$treffer = 0;

?>

<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0;">
<link rel="stylesheet" href="../ebook_formate.css">
<title>Bücher</title>
</head>
<body>

<header>
<?php include "../header.php"; ?>
</header>

<main>
<h1>eBooks</h1>

<form>
    <input type="submit" formaction="ebook-import.php" value="eBook Import">
    <input type="submit" formaction="ebook_autor.php" value="Liste Autoren">
</form>
<br><br>

Suchbegriff eingeben:
<div id="suche">
<form method="post" action="ebook.php">
    <label for="suche"></label>
    <input id="suche" name="suche" value="<?php echo htmlspecialchars($eingabe); ?>">
    <button id="buttons_suche" type="submit" name="i" value="1">finden</button>
    <br><br>
    <input id="buttons_suche" type="submit" name="i" value="2" value="nach eBooks">
    <input id="buttons_suche" type="submit" name="i" value="3" value="nach Autoren">
</form>
</div>
<br><br>

<?php

// Suchbegriffe vorbereiten
$suche = explode(" ", $eingabe);
if (!isset($suche[1])) {
    $suche[1] = substr($suche[0], 0, 1);
}

// Query vorbereiten
$erg = "SELECT * FROM tab_ebooks
        INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor
        ORDER BY tab_ebooks.id DESC";
$erg = $pdo->prepare($erg);
$erg->execute();

// Tabelle starten
echo '<table class="privat">';
echo '<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
echo '<tbody>';

// Durch die Datensätze loopen
while($data = $erg->fetch()) {

    $match = false;
    switch ($i) {
        case 1: // Titel + Autor
            $name = $data['titel'] . $data['name'];
            $match = stripos($name, $suche[0]) !== false && stripos($name, $suche[1]) !== false;
            break;
        case 2: // nur Titel
            $name = $data['titel'];
            $match = stripos($name, $suche[0]) !== false && stripos($name, $suche[1]) !== false;
            break;
        case 3: // nur Autor
            $name = $data['name'];
            $match = stripos($name, $suche[0]) !== false && stripos($name, $suche[1]) !== false;
            break;
        default: // Standard: 20 neueste
            $match = true;
            break;
    }

    if ($match) {
        ausgabe(
            $data['id'],
            $data['id_autor'],
            $data['titel'],
            $data['name'],
            $data['date'],
            $data['isbn']
        );
        $treffer++;
    }
}

echo '</tbody></table>';

echo "<h3>Treffer: $treffer</h3>";

include "../footer.php";

// Funktion zur Tabellenzeile
function ausgabe($id, $id_autor, $titel, $autor, $date, $isbn)
{
    echo '<tr class="privat">';
    echo '<td><a href="ebook_formular.php?ID='.$id.'">'.$id.'</a></td>';
    echo '<td><a href="ebook_formular.php?ID='.$id.'">'.$titel.'</a></td>';
    echo '<td><a href="ebook_autor_formular.php?ID='.$id_autor.'">'.$autor.'</a></td>';
    echo '<td>'.$date.'</td>';
    echo '<td>'.$isbn.'</td>';
    echo '</tr>';
}

?>
</main>
</body>
</html>
