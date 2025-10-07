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
    // error_reporting(level -1);
    error_reporting(-1);
    include "header.php"; // die Kopfzeile einbinden
  ?>
</header>
<!-- ab hier kommt nur noch Text -->
<main>
  <h1>Stammdaten anlegen oder ändern</h1>
<?php
 include "dinge_verbinden.php"; // db wird geöffnet

$z=$_GET['i'];   // Zimmer Regal oder Ort? was wird bearbeitet

// ab hier wird die Seite aufgebaut

// Typ ==================================================================================================
$erg = $pdo->prepare("SELECT * FROM tab_typ");
$result = $erg->execute();
echo 	'<table>';
echo 	'<thead><tr><td>Typ</td></tr></thead>';
echo	'<tbody class="privat">';
while($data = $erg->fetch()) {
    $id=$data['id_typ'];
    //echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['id_typ'] . '</a></td>';
    //echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_typ'] . '</a></td>';
    echo '<td><a href=dinge_stammdaten.php?ID='.$id.'&i=4>'. $data['name_typ'] . '</a></td>'; //i=4 für Bereich Typ
    //echo '<td>'. $data['name_typ'] .'</td>';
}
echo'</tbody>';
echo'</table>';
// echo'<br>';

// hier muss die Abfrage nach 1 für Zimmer, 2 für Regal ... rein
if ($z == 4) {
    $qu = $pdo->prepare("SELECT * from tab_typ where id_typ='".($_REQUEST['ID'])."'");
    $result = $qu->execute();
    $data = $qu->fetch();

    $x = $_REQUEST['ID']; // wenn $x > 0 dann wird beim speichern geändert nicht neu angelegt
}

?>

<form method="post" action="dinge_stammdaten_speichern.php?i=4&x=<?php echo $x?>">
<br>
<td>Typ:</td><td><input type="text" name="typ" value="<?php echo $data['name_typ'] ?>"size="20" maxlength="30" ></td>
<td><input type="Submit" name='neuer_typ' value="Typ speichern"></td>
<br><br>
<?php

// Stockwerk ==================================================================================================
$erg = $pdo->prepare("SELECT name_stockwerk FROM tab_stockwerk");
$result = $erg->execute();
echo 	'<table>';
echo 	'<thead><tr><td>Stockwerke</td></tr></thead>';
echo	'<tbody class="privat">';
while($data = $erg->fetch()) {
    $id=$data['id'];
    //echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['id_stockwerk'] . '</a></td>';
    //echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_stockwerk'] . '</a></td>';
    echo '<td>'. $data['name_stockwerk'] .'</td>';
}
echo'</tbody>';
echo'</table>';
echo'<br>';


// Zimmer ====================================================================================================

$erg = $pdo->prepare("SELECT * FROM tab_zimmer
LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk");
$result = $erg->execute();

echo 	'<table style="float:left;width:40%;">';
//echo 	'<table>';

echo 	'<thead><tr><td>Zimmer</td><td>Stockwerk</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id_zimmer=$data['id_zimmer'];
    echo '<tr class="privat">';
    echo '<td><a href=dinge_stammdaten.php?ID='.$id_zimmer.'&i=1>'. $data['name_zimmer'] . '</a></td>'; //i=1 für Bereich Zimmer
    echo '<td>'. $data['name_stockwerk'] .'</td>';
    echo '</tr>';
}

//echo'</tbody>';
//echo'</table>';

// hier muss die Abfrage nach 1 für Zimmer, 2 für Regal ... rein
if ($z == 1) {
    $qu = $pdo->prepare("SELECT * from tab_zimmer where id_zimmer='".($_REQUEST['ID'])."'");
    $result = $qu->execute();
    $data = $qu->fetch();
    $st = $data['fs_stockwerk'];
    $x = $_REQUEST['ID']; // wenn $x > 0 dann wird beim speichern geändert nicht neu angelegt
}
?>
<form method="post" action="dinge_stammdaten_speichern.php?i=1&x=<?php echo $x?>">

<tr><td>Zimmer:</td><td><input type="text" name="zimmer" value="<?php echo $data['name_zimmer'] ?>"size="20" maxlength="30" ></td></tr>
<tr><td>Beschreibung:</td><td><input type="text" name="beschreibung_zimmer" value="<?php echo $data['beschreibung_zimmer'] ?>"size="20" maxlength="30"></td></tr>
<td>
<!-- hier wird die Dropdownliste Stockwerk aus der DB erstellt -->
<select name='stockwerk' size='1'>
<?php
$erg = $pdo->prepare("SELECT id_stockwerk, name_stockwerk FROM tab_stockwerk");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // im Dropdown wird das Stockwerk angezeigt - übergeben wird die ID. die brauchen wir für den FS_ID
    // wenn ein ort übergeben wird dann soll es hier selektiert werden
    //echo '<option value = '.$id.''. $data['id_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';
    if ($st == $data['id_stockwerk']) {
        echo '<option value = '.$id.''. $data['id_stockwerk'].' selected="selected">'.$id.''. $data['name_stockwerk'].'</option>';
    } else {
        echo '<option value = '.$id.''. $data['id_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';
    }
}
echo'</select>';
?>
</td>
<td><input type="Submit" name='neues_zimmer' value="Zimmer speichern"></td>
</tr>
</table>
</form>
<?php

// Regal ====================================================================================================

$erg = $pdo->prepare("SELECT * FROM tab_regal
LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer");
$result = $erg->execute();

echo 	'<table style="float:left;width:40%;">';
echo 	'<thead><tr><td>Regal</td><td>Zimmer</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id_regal=$data['id_regal'];
    echo '<tr class="privat">';
    //echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['id_stockwerk'] . '</a></td>';
    //echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_regal'] . '</a></td>';
    echo '<td><a href=dinge_stammdaten.php?ID='.$id_regal.'&i=2'.'>'. $data['name_regal'] . '</a></td>';
    echo '<td>'. $data['name_zimmer'] .'</td>';
    echo '</tr>';
}
//echo'</tbody>';
//echo'</table>';
if ($z == 2) {
    $qu = $pdo->prepare("SELECT * from tab_regal where id_regal='".($_REQUEST['ID'])."'");
    $result = $qu->execute();
    $data = $qu->fetch();
    $re = $data['fs_zimmer'];
    $x = $_REQUEST['ID']; // wenn $x > 0 dann wird beim speichern geändert nicht neu angelegt
    }
?>
<form method="post" action="dinge_stammdaten_speichern.php?i=2&x=<?php echo $x?>">
  <!--
  <table>
   -->
<tr><td>neues Regal:</td><td><input type="text" name="regal" value="<?php echo $data['name_regal'] ?>"size="20" maxlength="30" ></td></tr>
<tr><td>Beschreibung:</td><td><input type="text" name="beschreibung_regal" value="<?php echo $data['beschreibung_regal'] ?>"size="20" maxlength="30"></td></tr>
<td>
<!-- hier wird die Dropdownliste Stockwerk aus der DB erstellt -->
<select name='zimmer' size='1'>
<?php
$erg = $pdo->prepare("SELECT id_zimmer, name_zimmer FROM tab_zimmer");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // im Dropdown wird das Stockwerk angezeigt - übergeben wird die ID. die brauchen wir für den FS_ID
    //echo '<option value = '.$id.''. $data['id_zimmer'].'>'.$id.''. $data['name_zimmer'].'</option>';
    if ($re == $data['id_zimmer']) {
         echo '<option value = '.$id.''. $data['id_zimmer'].' selected="selected">'.$id.''. $data['name_zimmer'].'</option>';
     } else {
         echo '<option value = '.$id.''. $data['id_zimmer'].'>'.$id.''. $data['name_zimmer'].'</option>';
     }
   }
echo'</select>';
?>
 </td>
 <td><input type="Submit" name='neues_regal' value="Regal speichern"></td>
 </tr>
</table>
</form>
<br>
<br style="clear:both;">
<?php
// Ort ====================================================================================================
$erg = $pdo->prepare("SELECT * FROM tab_ort
LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal");
$result = $erg->execute();

//echo 	'<table>';
echo 	'<table style="float:left;width:40%;">';

echo 	'<thead><tr><td>Ort</td><td>Regal</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['id_ort'];
    echo '<tr class="privat">';
    echo '<td><a href=dinge_stammdaten.php?ID='.$id.'&i=3'.'>'.$data['name_ort'] . '</a></td>';
    echo '<td>'. $data['name_regal'] .'</td>';
    echo '</tr>';
}
//echo'</tbody>';
//echo'</table>';
if ($z == 3) {
    $qu = $pdo->prepare("SELECT * from tab_ort where id_ort='".($_REQUEST['ID'])."'");
    $result = $qu->execute();
    $data = $qu->fetch();
    $or = $data['fs_regal'];
    $x = $_REQUEST['ID']; // wenn $x > 0 dann wird beim speichern geändert nicht neu angelegt
    }
?>
<form method="post" action="dinge_stammdaten_speichern.php?i=3&x=<?php echo $x?>">
  <!--
  <table>
   -->
<tr><td>neuer Ort:</td><td><input type="text" name="ort" value="<?php echo $data['name_ort'] ?>"size="20" maxlength="30" ></td></tr>
<tr><td>Beschreibung:</td><td><input type="text" name="beschreibung_ort" value="<?php echo $data['beschreibung_ort'] ?>"size="20" maxlength="30"></td></tr>
<td>
<!-- hier wird die Dropdownliste Stockwerk aus der DB erstellt -->
<select name='regal' size='1'>
<?php
$erg = $pdo->prepare("SELECT id_regal, name_regal FROM tab_regal");
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // im Dropdown wird das Stockwerk angezeigt - übergeben wird die ID. die brauchen wir für den FS_ID
    //echo '<option value = '.$id.''. $data['id_regal'].'>'.$id.''. $data['name_regal'].'</option>';
    if ($or == $data['id_regal']) {
         echo '<option value = '.$id.''. $data['id_regal'].' selected="selected">'.$id.''. $data['name_regal'].'</option>';
     } else {
         echo '<option value = '.$id.''. $data['id_regal'].'>'.$id.''. $data['name_regal'].'</option>';
     }
}
echo'</select>';
?>
 </td>
 <td><input type="Submit" name='neuer_ort' value="Ort speichern"></td>
 </tr>
</table>
</form>
<br>







<br style="clear:both;">

<form method="post" action='dinge.php'>
<table>
  </td>
  <td><input type="Submit" name='zurück' value="zurück"></td>
  </tr>
</table>
</form>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
