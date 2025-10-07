<?php
	include "projekte_verbinden.php"; // db wird geöffnet
	$z=$_GET['i'];
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../projekte_formate.css' type='text/css'>
  <title>Projekte</title>
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
	$qu = $pdo->prepare("SELECT * from projekte where ID='".($_REQUEST['ID'])."'");

  $result = $qu->execute();
  $data = $qu->fetch();
	$beschreibung_projekte=$data['beschreibung_projekte'];
	//$beschreibung_projekte=$_POST['beschreibung_projekte'];

// wenn im Formular der Button Aktion hinzufügen gedrückt wird füge ich das aktuelle Datum hinzu
if ($z == 1) {
	// falls der Button Einträge hinzufügen gedrückt wird dann soll er
	// den Inhalt der Textarea verwenden - nicht was in der DB steht
	$beschreibung_projekte=$_POST['beschreibung_projekte'];
	$beschreibung_projekte=$beschreibung_projekte."\r\n\n".date('d.m.Y'." ")."\n";
	//echo $beschreibung_projekte;
	//exit;
}
?>

<h1>Projekt bearbeiten</h1>
<?php else: ?>
 <h1>Neues Projekt anlegen</h1>
<?php endif; ?>

<div class = "projekte_formular" >
<form method="POST">

<table>
<tr><td>ID:</td><td><input type="text" name="ID" value="<?php echo $data['id'] ?>" size="3" maxlength="20" readonly>
Datum:<input type="text" name="datum" value="<?php echo $data['datum'] ?>" size="10" maxlength="10"  readonly></td></tr>
<td>Erledigt:</td><td><input type="checkbox" name="erledigt" value="1" <?php if($data['erledigt']=="1") echo "checked"; ?>></td>
<tr><td>Name:</td><td><input type="text" name="name_projekte" value="<?php echo $data['name_projekte'] ?>" size="50" maxlength="50"></td></tr>
<tr><td>Wiedervorlage:</td><td><input type="text" name="wiedervorlage" value="<?php echo $data['wiedervorlage'] ?>" size="10" maxlength="10"></td></tr>
<td>Priorität:</td><td><input type="radio" name="prio" value="1" <?php if($data['prio']=="1") echo "checked"; ?>>hoch
<input type="radio" name="prio" value="2" <?php if($data['prio']=="2") echo "checked"; ?>>mittel
<input type="radio" name="prio" value="3" <?php if($data['prio']=="3") echo "checked"; ?>>keine</td>
</table>

<table>
<!-- hier wird die Dropdownliste Typ aus der DB erstellt -->
<tr><td>Typ:</td><td> <select name="typ">
<?php
$ty = $data['typ'];
$erg = $pdo->prepare("SELECT * FROM tab_typ");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id_typ'];
    // echo "<option value =".$id.'>'. $data['name_stockwerk']."</option>";
    // echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';

  // wenn ein typ übergeben wird dann soll es hier selektiert werden
  if ($ty == $data['name_typ']) {
      echo '<option value = '. $data['name_typ'].' selected="selected">'.$data['name_typ'].'</option>';
  } else {
      echo '<option value = '. $data['name_typ'].'>'.$data['name_typ'].'</option>';
  }
}
?>
</select></td></tr>


</table>
<br>
<input type="Submit" name="neueAktion" formaction="projekte_formular.php?i=1" value="Eintrag hinzufügen">



<br>
<br>
<tr><td>Beschreibung:</td></tr>


<textarea name="beschreibung_projekte" cols="100" rows="5"><?php echo $beschreibung_projekte ?></textarea>


<!-- hier kommen die Buttons -->

<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="projekte_speichern.php" value="speichern"></td>
 <td><input type="Submit" name="" formaction="projekte.php" value="zurück"></td>
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
