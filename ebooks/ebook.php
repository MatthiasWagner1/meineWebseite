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
<input type="Submit" name="" formaction="ebook-import.php" value="eBook Import">
<input type="Submit" name="" formaction="ebook_autor.php" value="Liste Autoren">
</form>
<br><br>

Suchbegriff eingeben:

<div id="suche">
<form method='post' action="ebook.php?i=1">
<label for='suche'></label>
<input id='suche' name='suche' value='<?php echo $_POST['suche'] ?? ''; ?>'>
<button id="buttons_suche">finden</button>
<br><br>
<input id="buttons_suche" type="Submit" name="" formaction="ebook.php?i=2" value="nach eBooks">
<input id="buttons_suche" type="Submit" name="" formaction="ebook.php?i=3" value="nach Autoren">
</form>
<br><br>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "ebooks_verbinden.php";

$eingabe = $_POST['suche'] ?? '';
$i = $_GET['i'] ?? '';
$treffer = 0;

function ausgabe($id, $id_autor, $titel, $name, $vorname, $date, $isbn) {
    echo '<tr class="privat">';
    echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $id . '</a></td>';
    echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $titel . '</a></td>';
    echo '<td><a href=ebook_autor_formular.php?ID='.$id_autor.'>'. $name . '</a></td>';
    echo '<td><a href=ebook_autor_formular.php?ID='.$id_autor.'>'. $vorname . '</a></td>';
    echo '<td>' . $date . '</td>';
    //echo '<td>' . $isbn . '</td>';
    echo '<td>' . $id_autor . '</td>';
    echo '</tr>';
}

// *** Anzeige 20 neueste, wenn kein Suchbegriff ***
if (empty($eingabe) && empty($i)) {
    echo "<h3>Die 20 neuesten eBooks.</h3>";
    $sql = "SELECT * FROM tab_ebooks
            INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor
            ORDER BY tab_ebooks.id DESC
            LIMIT 20";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo '<table class="privat">';
    echo '<thead><tr><td>ID</td><td>Titel</td><td>Name</td><td>Vorname</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
    echo '<tbody>';

    while ($data = $stmt->fetch()) {
        ausgabe($data['id'], $data['id_autor'], $data['titel'], $data['name'], $data['vorname'], $data['date'], $data['isbn']);
    }

    echo '</tbody></table>';
} else {
    // *** Suche oder spezielle Anzeige ***
    $suche = explode(" ", $eingabe);
    if (empty($suche[1])) {
        $suche[1] = substr($suche[0], 0, 1);
    }

    $sql = "SELECT * FROM tab_ebooks
            INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor
            ORDER BY date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo '<table class="privat">';
    echo '<thead><tr><td>ID</td><td>Titel</td><td>Name</td><td>Vorname</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
    echo '<tbody>';

    while ($data = $stmt->fetch()) {     // hier wird selectiert wo gesucht wird Aotor oder Titel oder beides
        // Auswahl nach $i
        if ($i == 1) {
            $name = $data['titel'] . $data['name'] . $data['vorname'];
        } elseif ($i == 2) {
            $name = $data['titel'];
        } elseif ($i == 3) {
            $name = $data['name'] . $data['vorname'];
        } else {
            $name = '';
        }

        $pos = stripos($name, $suche[0]);
        $pos1 = stripos($name, $suche[1]);

        if ($pos !== false && $pos1 !== false) {
            $treffer++;
            ausgabe($data['id'], $data['id_autor'], $data['titel'], $data['name'], $data['vorname'], $data['date'], $data['isbn']);
        }
    }

    echo '</tbody></table>';
    echo "<h3>Treffer: " . $treffer . "</h3>";
}

include "../footer.php";
?>

</main>
</body>
</html>
