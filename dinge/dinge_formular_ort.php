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

<h1>Ort bearbeiten</h1> 
<?php else: ?>
 <h1>Neuen Ort anlegen</h1>
<?php endif; ?>

<div class = "dinge_formular" >
<form method="POST" action="<?php echo $PHP_SELF ?>">

<table>
<tr><td>ID:</td><td><input type="text" name="ID" value="<?php echo $data['id'] ?>" size="3" maxlength="20" readonly>
Datum:<input type="text" name="datum" value="<?php echo $data['datum'] ?>" size="12" maxlength="20"  readonly></td></tr>
<tr><td>Name:</td><td><input type="text" name="name_dinge" value="<?php echo $data['name_dinge'] ?>" size="20" maxlength="50" readonly></td></tr>
<tr><td>Typ:</td><td><input type="text" name="typ" value="<?php echo $data['typ'] ?>" size="20" maxlength="50" readonly></td></tr>
<tr><td>Besitzer:</td><td><input type="Text" name="besitzer" value="<?php echo $data['besitzer'] ?>" size="20" maxlength="50" readonly></td></tr>
</table>
<br>

<table>

<!-- hier werden die Variablen geholt um im Dropdown zu selektieren-->
<?php
    $st = $_POST['stockwerk'];
    $zi = $_POST['zimmer'];
    $re = $_POST['regal'];
    $or = $_POST['ort'];
?>

<!-- hier wird die Dropdownliste Ort aus der DB erstellt -->
<tr><td>Ort:</td><td> <select name="ort">
<?php

$erg = $pdo->prepare("SELECT id_ort, name_ort FROM tab_ort"); 
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // echo "<option value =".$id.'>'. $data['name_stockwerk']."</option>";
    // echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';

  // wenn ein ort übergeben wird dann soll es hier selektiert werden
  if ($or == $data['name_ort']) {
      echo '<option value = '.$id.''. $data['name_ort'].' selected="selected">'.$id.''. $data['name_ort'].'</option>';
  } else {
      echo '<option value = '.$id.''. $data['name_ort'].'>'.$id.''. $data['name_ort'].'</option>';
  }
}
?>
</select></td></tr>

<!-- hier wird die Dropdownliste Stockwerk aus der DB erstellt -->
<tr><td>Stockwerk:</td><td> <select name="stockwerk">
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
<tr><td>Zimmer:</td><td> <select name="zimmer">
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
<tr><td>Regal:</td><td> <select name="regal">
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

<!--

// echo $stockwerk." ".$fs_stockwerk;

if(isset( $_POST['stockwerk'] )) {
  $stockwerk=($_POST['stockwerk']);
}
-->


<!-- hier kommen die Buttons -->

<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="dinge_ort_speichern.php" value="übernehmen"></td>
 <td><input type="Submit" name="" formaction="ort_loeschen.php" value="löschen"></td>
</tr>
</table>
</div>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>