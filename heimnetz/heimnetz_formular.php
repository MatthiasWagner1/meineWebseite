<?php
	include "heimnetz_verbinden.php"; // db wird geöffnet
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../heimnetz_formate.css' type='text/css'>
  <title>Heimnetz</title>
</head>
<body>

<header>
  <?php
  include "header.php"; // die Kopfzeile einbinden
  $stamm_ip = "192.168.59."; // es werden nur noch die letzten ziffern eingegeben
  ?>
</header>

<main>
<div class = "heimnetz_formular" >
<form method="GET">

<?php	// wenn id vorhanden (besser leer?) dann daten ändern sonst neu anlegen
	if (isset ($_REQUEST['ID'])):
    $qu = $pdo->prepare("SELECT * from liste where ID='".($_REQUEST['ID'])."'");
    $result = $qu->execute();
    $data = $qu->fetch();
    $ip=$data['ip_n'];
?>
  <h2>Eintrag bearbeiten</h2>
  
<?php else: 
    // dann muss man nur die letzten Ziffern eingeben
    //$ip="192.168.59."; 
?>
  <h2>Neuen Eintrag anlegen</h2>
<?php endif; ?>

<!-- hier kommt das css

hier kommt ein neues formular mit flexbox
dadurch soll das formular flexibler auf
Änderungen der Grösse reagieren

-->

<table>
<tr><td>ID:</td><td><input type="text" name="ID" size="1"value="<?php echo $data['id'] ?>" readonly></td></tr>
<tr><td>IP: 192.168.59.</td><td><input type="text" name="ip_n" size="10"value="<?php echo $ip ?>" autofocus></td></tr>
<tr><td>Name:</td><td><input type="text" name="name" value="<?php echo $data['name'] ?>"></td></tr>
<tr><td>Host:</td><td><input type="text" name="host" value="<?php echo $data['host'] ?>"></td></tr>
<tr><td>Beschreibung:</td><td><textarea name="beschreibung"><?php echo $data['beschreibung'] ?></textarea></td></tr>
</table>

<br>
<!-- hier kommen die Buttons -->

<input type="Submit" name="" formaction="heimnetz_speichern.php" value="speichern">
<input onclick="history.back()" type="button"  value="Zur&uuml;ck">
<!-- <input type="Submit" name="" formaction="heimnetz.php" value="zurück"> -->
<input type="Submit" name="" formaction="heimnetz_loeschen.php" value="löschen">





</form>
</div>
<br>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
