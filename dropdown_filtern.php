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
  
<?php	

    $qu = $pdo->prepare("SELECT * from tab_dinge 
    LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort
    LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal
    LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
    LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk  

    where ID='".($_REQUEST['ID'])."'");
  
  $result = $qu->execute();
  $data = $qu->fetch();
?>

<h1>Dropdown filtern</h1> 



<div class = "dinge_formular" >
<form method="POST">

<input type="Submit" name="" formaction="dropdown_filtern.php" value="filtern">


<table>

<!-- hier werden die Variablen geholt um im Dropdown zu selektieren-->
<?php
    $st = $data['name_stockwerk'];
    $zi = $data['name_zimmer'];
    $re = $data['name_regal'];
    $or = $data['name_ort'];

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


    // wenn fs_stockwerk gleich id gewähltes stockwerk dann darstellen
    if ($data['id_stockwerk'] != $data['fs_stockwerk']) {
  
            // wenn ein zimmer übergeben wird dann soll es hier selektiert werden
        if ($zi == $data['name_zimmer']) {
            echo '<option value = '.$id.''. $data['name_zimmer'].' selected="selected">'.$id.''. $data['name_zimmer'].'</option>';
        } else {
            echo '<option value = '.$id.''. $data['name_zimmer'].'>'.$id.''. $data['name_zimmer'].'</option>';
        }
    }


} // ende while



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

<!-- hier kommen die Buttons -->

<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="dinge_speichern.php" value="übernehmen"></td>
 <td><input type="Submit" name="" formaction="dinge.php" value="zurück"></td>
</tr>
</table>
</form>
</div>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden

?>

