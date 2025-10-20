<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../ebook_formate.css" type="text/css">
  <title>Bücher</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>
<main>
  <h1> Autoren</h1>
<form>
  <input type="Submit" name="" formaction="ebook.php?ID=1" value="eBooks">
  <input type="Submit" name="" formaction="ebook_autor.php?ID=2" value="Autoren">
</form>
<br><br>
Anfangsbuchstaben wählen:
<table>

<?php
for ($i = ord('A'); $i <= ord('Z'); $i++) {
  $b = chr($i);
  echo '<td style="border: 1px solid black; padding: 10px;"><a href=ebook_autor.php?ID='.$b.' <Titel>'.$b.' </a></td>';
}
?>
</table>

<br>
Suchbegriff eingeben:
<div id = "suche">
<form method='post' action="ebook_autor.php?i=3">
  <label for='suche'></label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
  <button id = "buttons_suche">suchen</button>
</form>
<br>

<?php
 include "ebooks_verbinden.php"; // db wird geöffnet
 $i=$_GET['i'];
$eingabe = $_POST['suche'];
$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}
$erg = "SELECT * FROM tab_autor "; 
   // INNER JOIN tab_ebooks ON tab_autor.id_autor = tab_ebooks.fs_autor ORDER BY tab_autor.id_autor DESC LIMIT 40
   // hier werden tab_ebooks und tab_autor über tab_autor.id_autor und tab_ebooks.fs_autor verbunden

$erg = $pdo->prepare($erg);
$result = $erg->execute();

ausgabe($erg);

/*
==================================================================================================
wie 
==================================================================================================
==================================================================================================
*/


function ausgabe($erg, $spalten = 5)
{
    echo '<table class="namensliste-table"><tr>';
    $count = 0;

    while($data = $erg->fetch()) {
        $id = $data['id_autor'];
        $name = $data['name'];
        $vorname = $data['vorname'];

        echo '<td><a href="ebook_autor_formular.php?ID='.$id.'">'.$name.' / '.$vorname.'</a></td>';

        $count++;
        if ($count % $spalten == 0) {
            echo '</tr><tr>'; // neue Zeile nach X Spalten
        }
    }

    echo '</tr></table>';
}



/*
$erg = $pdo->prepare("SELECT 
            tab_ebooks.titel,
            tab_ebooks.id,
            tab_ebooks.veroeffentlichung,
            tab_ebooks.isbn,
            tab_autor.name AS autor
        FROM 
            tab_ebooks
        JOIN 
            tab_autor
        ON 
            tab_ebooks.fs_autor = tab_autor.id_autor LIMIT 30");

$result = $erg->execute();
ausgabe($erg);
*/



/*
// DB lesen
$sql = "SELECT * FROM ebooks.tab_ebooks ORDER BY ID DESC LIMIT 10";
foreach ($pdo->query($sql) as $row) {
   $id = $row['id'];
   $titel = $row['titel'];
   $autor = $row['fs_autor'];
   $pfad = $row['pfad'];
   
}

*/



?>
</main>
</body>
</html>
<?php
// include "footer.php"; // die Fusszeile einbinden
?>

