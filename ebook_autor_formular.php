<?php
	include "ebooks_verbinden.php"; // db wird geöffnet
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../dinge_formate.css' type='text/css'>
  <title>Bücher</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<main>

<?php	// wenn id vorhanden (besser leer?) dann daten ändern sonst neu anlegen
	if (isset ($_REQUEST['ID'])):
    $qu = $pdo->prepare("SELECT * from tab_autor
    where id_autor = '".($_REQUEST['ID'])."'");

    $result = $qu->execute();
    $data = $qu->fetch();
    ?>
    <h1>Autor bearbeiten</h1>
  <?php else: ?>
    <h1>Neuen Autor anlegen</h1>
  <?php endif; ?>

<div class = "dinge_formular" >
<form method="POST">

<table>
<tr><td>ID:</td><td><input type="text" name="ID" value="<?php echo $data['id_autor'] ?>" size="3" maxlength="20" readonly>
Name:<input type="text" name="name" value="<?php echo $data['name'] ?>" size="12" maxlength="20"  readonly></td></tr>

<table>
<tr><td>Beschreibung:</td></tr>

<tr><td><textarea name="beschreibung" cols="41" rows="5"><?php echo $data['beschreibung']?></textarea></td></tr>

</table>



<!-- hier kommen die Buttons -->

<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="dinge_speichern.php" value="übernehmen"></td>
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
include "footer.php"; // die Fusszeile einbinden
?>
