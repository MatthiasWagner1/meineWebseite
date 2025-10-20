<?php
	include "ebooks_verbinden.php"; // db wird geöffnet
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../ebook_formate.css' type='text/css'>
  <title>eBooks</title>
</head>
<body>

<header>
  <?php
  include "../header.php"; // die Kopfzeile einbinden
  ?>
</header>

<main>

<?php
if (!empty($_REQUEST['ID'])) {
$qu = $pdo->prepare("
SELECT 
    tab_ebooks.id,
    tab_ebooks.titel,
    tab_ebooks.pfad,
    tab_ebooks.herausgeber,
    tab_ebooks.isbn,
    tab_ebooks.beschreibung,
    tab_ebooks.date,
    tab_autor.id_autor,
    tab_autor.vorname,
    tab_autor.name
    
    
FROM tab_ebooks
INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor

WHERE tab_ebooks.id = ?
");
    $qu->execute([$_REQUEST['ID']]);
    $data = $qu->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo "<h1>eBook bearbeiten</h1>";
    } else {
        echo "<p>Keine Daten gefunden für ID: " . htmlspecialchars($_REQUEST['ID']) . "</p>";
        $data = []; // leeres Array, damit das Formular nicht crasht
        echo "<h1>Neues eBook anlegen</h1>";
    }
} else {
    $data = []; // keine ID → leeres Array für neues Formular
    echo "<h1>Neues eBook anlegen</h1>";
}
?>

<div class="ebook_formular">
  <form method="POST">

    <table>
      <tr>
        <td>ID:</td>
        <td>
          <input type="text" name="ID" value="<?php echo htmlspecialchars($data['id']); ?>" size="3" maxlength="20" readonly>
          Datum:
          <input type="text" name="datum" value="<?php echo htmlspecialchars($data['date']); ?>" size="12" maxlength="20" readonly>
        </td>
      </tr>
      <tr>
        <td>Name:</td>
        <td><input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" size="20" maxlength="50">
      </tr>
      <tr>
        <td>Name:</td>
        <td><input type="text" name="vornamename" value="<?php echo htmlspecialchars($data['vorname']); ?>" size="20" maxlength="50">
      </tr>
      <tr>
        <td>Titel:</td>
        <td><input type="text" name="titel" value="<?php echo htmlspecialchars($data['titel']); ?>" size="70" maxlength="50"></td>
      </tr>
      <tr>
        <td>Pfad:</td>
        <td><input type="text" name="pfad" value="<?php echo htmlspecialchars($data['pfad']); ?>" size="70" maxlength="50"></td>
      </tr>
      <tr>
        <td>Herausgeber:</td>
        <td><input type="text" name="herausgeber" value="<?php echo htmlspecialchars($data['herausgeber']); ?>" size="70" maxlength="50"></td>
      </tr>
      <tr>
        <td>ISBN:</td>
        <td><input type="text" name="isbn" value="<?php echo htmlspecialchars($data['isbn']); ?>" size="70" maxlength="50"></td>
      </tr>
    </table>

    <table>
      <tr>
        <td>Beschreibung:</td>
      </tr>
      <tr>
        <td>
          <textarea name="beschreibung" cols="100" rows="10"><?php echo htmlspecialchars($data['beschreibung']); ?></textarea>
        </td>
      </tr>
    </table>

<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="ebook_speichern.php" value="übernehmen"></td>
 <td><input type="Submit" name="" formaction="javascript:history.back()" value="zurück"></td>
</tr>
</table>
</form>
</div>
<br>
</main>
</body>
</html>
<?php
include "../footer.php"; // die Fusszeile einbinden
?>
