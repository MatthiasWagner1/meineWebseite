<?php
	include "dinge_verbinden.php"; // db wird geöffnet
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../dinge_formate.css' type='text/css'>
  <title>Dinge</title>
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
	$qu = $pdo->prepare("SELECT * from tab_dinge
  LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort
  LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal
  LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
  LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk

  where ID='".($_REQUEST['ID'])."'");

  $result = $qu->execute();
  $data = $qu->fetch();
?>

<h1>Teil bearbeiten</h1>
<?php else: ?>
 <h1>Neues Teil anlegen</h1>
<?php endif; ?>

<!-- hier werden die Variablen geholt um im Dropdown zu selektieren-->
<?php
    $st = $data['name_stockwerk'];
    $zi = $data['name_zimmer'];
    $re = $data['name_regal'];
    $or = $data['name_ort'];
		$ty = $data['typ'];
		$be = $data['besitzer'];
   //echo $ty;
   //exit;
?>


<div class = "dinge_formular" >
<form method="POST">

<table>
<tr><td>ID:</td><td><input type="text" name="ID" value="<?php echo $data['id'] ?>" size="3" maxlength="20" readonly>
Datum:<input type="text" name="datum" value="<?php echo $data['datum'] ?>" size="12" maxlength="20"  readonly></td></tr>
<tr><td>Name:</td><td><input type="text" name="name_dinge" value="<?php echo $data['name_dinge'] ?>" size="20" maxlength="50"></td></tr>
<!--
<tr><td>Typ:</td><td><input type="text" name="typ" value="<?php echo $data['typ'] ?>" size="20" maxlength="50"></td></tr>
<tr><td>Besitzer:</td><td><input type="Text" name="besitzer" value="<?php echo $data['besitzer'] ?>" size="20" maxlength="50" ></td></tr>
-->
</table>
<table>
<tr><td>Beschreibung:</td></tr>

<tr><td><textarea name="beschreibung_dinge" cols="41" rows="5"><?php echo $data['beschreibung_dinge']?></textarea></td></tr>

</table>

<table>
<!-- hier wird die Dropdownliste Typ aus der DB erstellt -->
<tr><td>Typ:</td><td> <select name="typ">
<?php
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

<!-- hier wird die Dropdownliste Besitzer aus der DB erstellt -->
<tr><td>Besitzer:</td><td> <select name="besitzer">
<?php
$erg = $pdo->prepare("SELECT * FROM tab_besitzer");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id_besitzer'];
    // echo "<option value =".$id.'>'. $data['name_stockwerk']."</option>";
    // echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';

  // wenn ein besitzer übergeben wird dann soll es hier selektiert werden
  if ($be == $data['name_besitzer']) {
      echo '<option value = '.$data['name_besitzer'].' selected="selected">'.$data['name_besitzer'].'</option>';
  } else {
      echo '<option value = '.$data['name_besitzer'].'>'.$data['name_besitzer'].'</option>';
  }
}
?>

<!-- hier wird die Dropdownliste Ort aus der DB erstellt -->
<tr><td>Ort:</td><td> <select name="ort">
<?php

$erg = $pdo->prepare("SELECT * FROM tab_ort");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // echo "<option value =".$id.'>'. $data['name_stockwerk']."</option>";
    // echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';

  // wenn ein ort übergeben wird dann soll es hier selektiert werden
  if ($or == $data['name_ort']) {
      echo '<option value = '.$id.''. $data['id_ort'].' selected="selected">'.$id.''. $data['name_ort'].'</option>';
  } else {
      echo '<option value = '.$id.''. $data['id_ort'].'>'.$id.''. $data['name_ort'].'</option>';
  }
}
?>
</select></td></tr>

<!-- hier wird die Dropdownliste Stockwerk aus der DB erstellt -->
<tr><td>Stockwerk:</td><td> <select name="stockwerk" disabled>
<?php

$erg = $pdo->prepare("SELECT id_stockwerk, name_stockwerk FROM tab_stockwerk");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // echo "<option value =".$id.'>'. $data['name_stockwerk']."</option>";
    // echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';

  // wenn ein Stockwerk übergeben wird dann soll es hier selektiert werden
  if ($st == $data['name_stockwerk']) {
      echo '<option value = '.$id.''. $data['name_stockwerk'].' selected="selected">'.$id.''. $data['name_stockwerk'].'</option>';
  } else {
      echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';
  }
}
?>
</select></td></tr>

<!-- hier wird die Dropdownliste Zimmer aus der DB erstellt -->
<tr><td>Zimmer:</td><td> <select name="zimmer" disabled>
<?php
$erg = $pdo->prepare("SELECT id_zimmer, name_zimmer, fs_stockwerk FROM tab_zimmer");
$result = $erg->execute();
	while($data = $erg->fetch()) {
		$id=$data['id'];
    // echo "<option value =".$id.'>'. $data['name_zimmer']."</option>";
    // echo '<option value = '.$id.''. $data['name_zimmer'].'>'.$id.''. $data['name_zimmer'].'</option>';

  // wenn ein zimmer übergeben wird dann soll es hier selektiert werden
  if ($zi == $data['name_zimmer']) {
    echo '<option value = '.$id.''. $data['name_zimmer'].' selected="selected">'.$id.''. $data['name_zimmer'].'</option>';
  } else {
    echo '<option value = '.$id.''. $data['name_zimmer'].'>'.$id.''. $data['name_zimmer'].'</option>';
  }
}
?>
</select></td></tr>

<!-- hier wird die Dropdownliste Regal aus der DB erstellt -->
<tr><td>Regal:</td><td> <select name="regal" disabled>
<?php
$erg = $pdo->prepare("SELECT id_regal, name_regal, fs_zimmer FROM tab_regal");
$result = $erg->execute();
	while($data = $erg->fetch()) {
		$id=$data['id'];
    // echo "<option value =".$id.'>'. $data['name_regal']."</option>";
    //echo '<option value = '.$id.''. $data['name_regal'].'>'.$id.''. $data['name_regal'].'</option>';

    // wenn ein regal übergeben wird dann soll es hier selektiert werden
    if ($re == $data['name_regal']) {
      echo '<option value = '.$id.''. $data['id_regal'].' selected="selected">'.$id.''. $data['name_regal'].'</option>';
    } else {
      echo '<option value = '.$id.''. $data['id_regal'].'>'.$id.''. $data['name_regal'].'</option>';
    }
  }
  ?>
</select></td></tr>
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
