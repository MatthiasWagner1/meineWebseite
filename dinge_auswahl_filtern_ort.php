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
  <h1>Auswahl nach Ort</h1>
<?php
 include "dinge_verbinden.php"; // db wird geöffnet

// ab hier wird die Seite aufgebaut

// Ort ====================================================================================================

$erg = $pdo->prepare("SELECT * FROM tab_ort
LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal");
$result = $erg->execute();

echo 	'<table style="float:left;width:40%;">';
echo 	'<thead><tr><td>Ort</td><td>Regal</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['id_ort'];
    echo '<tr class="privat">';
    echo '<td><a href=auswahl_filtern_ort.php?ID='.$id.'>'. $data['name_ort'] . '</a></td>';
    echo '<td>'. $data['name_regal'] .'</td>';
    echo '</tr>';
}
echo'</tbody>';
echo'</table>';

// Dinge nach Ort ====================================================================================================

$ort_auswahl=$_REQUEST['ID']; // die übergebene ID des Ortes

$erg = $pdo->prepare("SELECT * FROM tab_dinge
LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort");
$result = $erg->execute();

echo 	'<table style="float:left;width:40%;">';
echo 	'<thead><tr><td>Name</td><td>Ort</td></tr></thead>';
echo	'<tbody>';
while($data = $erg->fetch()) {
    $id=$data['fs_ort'];
    $id_dinge=$data['id'];
    if ($id==$ort_auswahl) {
      echo '<tr class="privat">';
      echo '<td><a href=dinge_formular.php?ID='.$id_dinge.'>'. $data['name_dinge'] . '</a></td>';
      //echo '<td><a href=dinge_formular.php?ID='.$id.'>'. $data['name_ort'] . '</a></td>';
      echo '<td>'.$data['name_ort'].'</td>';
      echo '</tr>';
    }
}
echo'</tbody>';
echo'</table>';





?>
<!-- immer ein clear nach float! -->
<br style="clear:both;">

<?php
//echo '<h1>ID: </h1>'.$ort_auswahl;
//exit;
?>

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
