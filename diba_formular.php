<?php
	include "heimnetz_verbinden.php"; // db wird geöffnet
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../diba_formate.css' type='text/css'>
  <title>Diba</title>
</head>
<body>

<header>
  <?php
  // include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<main>
<div class = "diba_formular" >
<form method="GET">

<?php	// wenn id null dann alle konten, sonst übergebenes konto

$qu = $pdo->prepare("SELECT * from konten where ID='".($_REQUEST['ID'])."'");
//$erg = $pdo->prepare("SELECT * FROM konten ORDER BY datum DESC");
    $result = $qu->execute();
    $data = $qu->fetch();
    $id=$data['id'];
    $id_vor = $id + 1;
    $id_zurueck = $id - 1;
    $konto = $data['konto'];
    if ($konto == 1) {
      $name = "Matthias";
    }
    if ($konto == 2) {
      $name = "Claudia";
    }
    $kategorie = $data['kategorie'];
  echo '<h4>Konto: '.$name.'</h3>';
  echo "<br>";
?> 

<?php
// Datum in dd.mm.yyyy umwandeln
   $originalDate = $data['datum'];
   //original date is in format YYYY-mm-dd
   $timestamp = strtotime($originalDate); 
   $datum = date("d.m.Y", $timestamp );
?>


<table>

<tr><td>ID:</td><td><input type="text" name="ID" size="10"value="<?php echo $id?>" readonly></td></tr>
<tr><td>Datum:</td><td><input type="text" name="datum" size="10"value="<?php echo $datum?>" readonly></td></tr>
<tr><td>Buchung:</td><td><input type="text" name="betrag" value="<?php echo $data['buchung'] ?>"readonly></td></tr>
<tr><td>Betrag:</td><td><input type="text" name="betrag" value="<?php echo $data['betrag'] ?>"readonly></td></tr>
<tr><td>Saldo:</td><td><input type="text" name="saldo" value="<?php echo $data['saldo'] ?>" readonly></td></tr>

<!-- hier wird die Dropdownliste Typ aus der DB erstellt -->
<tr><td>Kategorie:</td><td> <select name="kategorie">
<?php
$erg = $pdo->prepare("SELECT * FROM konten_kategorie");
$result = $erg->execute();
	while($kat = $erg->fetch()) {
    $id=$kat['id_kat'];

  // wenn eine kategorie übergeben wird dann soll es hier selektiert werden
  if ($kategorie == $kat['name_kategorie']) {
      echo '<option value = '. $kat['name_kategorie'].' selected="selected">'.$kat['name_kategorie'].'</option>';
  } else {
      echo '<option value = '. $kat['name_kategorie'].'>'.$kat['name_kategorie'].'</option>';
  }
}
?>
</select></td></tr>

<tr><td>Empfänger:</td><td><textarea name="empfang" readonly><?php echo $data['empfang'] ?></textarea></td></tr>
<tr><td>Verwendungszweck:</td><td><textarea name="verwendung" readonly><?php echo $data['verwendung'] ?></textarea></td></tr>
<tr><td>Notiz: </td><td><textarea name="notiz"><?php echo $data['notiz'] ?></textarea></td></tr>
<tr><td></td><td><input type="Submit" name="" formaction="diba_speichern.php" value="speichern"></td><td>
</table>
</form>

<!-- hier kommen die Buttons -->

<div class="flex">
<?php echo '<a href=diba_formular.php?ID='.$id_zurueck.'> <img src="../img/l2.png" width="66" height="66"></a>';?>
<input onclick="history.back()" type="button"  value="Zur&uuml;ck">
<?php echo '<a href=diba_formular.php?ID='.$id_vor.'> <img src="../img/r2.png" align="top" width="66" height="66"></a>';?>
</div>

</div>

<br>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
