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
    error_reporting(level -1);
    include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>    
  <h1>Stammdaten </h1>

<?php
 include "dinge_verbinden.php"; // db wird geöffnet

// ab hier wird die Seite aufgebaut


// Stockwerk
$erg = $pdo->prepare("SELECT name_stockwerk FROM tab_stockwerk");
$result = $erg->execute();

echo 	'<table>';
echo 	'<thead><tr><td>Stockwerk</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['id'];
    echo '<tr class="privat">';
    //echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['id_stockwerk'] . '</a></td>';
    echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_stockwerk'] . '</a></td>';
    echo '</tr>';
}
echo'</tbody>';
echo'</table>';	
echo'<br>';	

// Zimmer
$erg = $pdo->prepare("SELECT * FROM tab_zimmer
LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk");
$result = $erg->execute();

echo 	'<table>';
echo 	'<thead><tr><td>Zimmer</td><td>Stockwerk</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['id'];
    echo '<tr class="privat">';
    //echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['id_stockwerk'] . '</a></td>';
    echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_zimmer'] . '</a></td>';
    echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_stockwerk'] . '</a></td>';
    echo '</tr>';
}
echo'</tbody>';
echo'</table>';	
echo'<br>';	

?>





<!-- hier wird die Dropdownliste Stockwerk aus der DB erstellt -->


<form method="post" action='dinge_stammdaten_speichern.php?i=1'>

<input type="text" name="zimmer" size="20" maxlength="20" >

<input type="Submit" name='neues_zimmer'>


<select name='stockwerk' size='1'>


<?php
$erg = $pdo->prepare("SELECT id_stockwerk, name_stockwerk FROM tab_stockwerk"); 
$result = $erg->execute();
	while($data = $erg->fetch()) {
    $id=$data['id'];
    // echo '<option value = "'.$id.''. $data['name_stockwerk'].'"></option>';
    echo '<option value = '.$id.''. $data['name_stockwerk'].'>'.$id.''. $data['name_stockwerk'].'</option>';
}
echo'</select>';
?>
 
 <!-- hier wird das Zimmer und das Stockwerk an den php script übergeben i=1 -->




<?php


echo'<br>';












// Regal
$erg = $pdo->prepare("SELECT * FROM tab_regal
LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer");
$result = $erg->execute();

echo 	'<table>';
echo 	'<thead><tr><td>Regal</td><td>Zimmer</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['id'];
    echo '<tr class="privat">';
    //echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['id_stockwerk'] . '</a></td>';
    echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_regal'] . '</a></td>';
    echo '<td><a href=dinge_formular_stammdaten.php'.$id.'>'. $data['name_zimmer'] . '</a></td>';
    echo '</tr>';
}
echo'</tbody>';
echo'</table>';	
echo'<br>';

// Ort
$erg = $pdo->prepare("SELECT * FROM tab_ort
LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal");
$result = $erg->execute();

echo 	'<table>';
echo 	'<thead><tr><td>Ort</td><td>Regal</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['id'];
    echo '<tr class="privat">';

    echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['name_ort'] . '</a></td>';
    echo '<td><a href=dinge_formular_stammdaten.php?ID='.$id.'>'. $data['name_regal'] . '</a></td>';
    echo '</tr>';
}
echo'</tbody>';
echo'</table>';	
echo'<br>';


?>





</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden