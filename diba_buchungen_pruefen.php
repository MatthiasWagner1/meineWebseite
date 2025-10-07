<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../diba_formate.css" type="text/css">
  <title>ING</title>
</head>
<body>


<h1><a href="heimnetz.php"> Heimnetz - Konten</a></h1>
<h2></a></h1>

<h5><a href="diba_buchungen_pruefen.php?i=1"> DiBa Matthias</a></h5>
<h5><a href="diba_buchungen_pruefen.php?i=2"> DiBa Claudia</a></h5>

<?php
include "heimnetz_verbinden.php"; // db wird geöffnet

$konto=$_REQUEST['i']; // welches Konto

if ($i == 0) { 
    echo "<h1>Konto wählen</h1>";
} elseif ($i == 1) {
    
    
} elseif ($i == 2) {
    
}


if ($konto == 1) {
    $name = "Matthias";
  }
  if ($konto == 2) {
    $name = "Claudia";
  }


// ============== hier geht es nur weiter wenn in DB übernommen wird =====================================================

?>    
   

<!-- hier beginnt die Tabelle 

<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th><th>Saldo</th></tr>

-->


<?php
// ============= Anfang der db schleife =================================================================


$erg = $pdo->prepare("SELECT * FROM konten WHERE konto = $konto ORDER BY datum ASC");
$result = $erg->execute();
$z = 0;
while ($data = $erg->fetch()) {
    
    $id = $data['id'];
    // Datum in dd.mm.yyyy umwandeln
    $originalDate = $data['datum'];
    //original date is in format YYYY-mm-dd
    $timestamp = strtotime($originalDate);
    $datum = date("d.m.Y", $timestamp);
    $empfang = $data['empfang'];
    $betrag = $data['betrag'];
    $verwendung = $data['verwendung'];
    $saldo = $data['saldo'];


   

    //echo "betrag: ".$betrag;
/*
    echo '<tr>';
    echo '<td><a href=diba_formular.php?ID=' . $id . '>' . $name . '</a></td>';
    echo '<td><a href=diba_formular.php?ID=' . $id . '>' . $datum . '</a></td>';
    echo '<td><a href=diba_formular.php?ID=' . $id . '>' . $empfang . '</a></td>';

    if ($betrag > 0) {
      echo '<span style="color: red;">';
      echo '<td align=right><font color="green">' . $betrag . '</td>';
      echo '</span>';
    } else {
      echo '<td align=right><a href=diba_formular.php?ID=' . $id . '>' . $betrag . '</a></td>';
    }
    echo '<td align=right><a href=diba_formular.php?ID=' . $id . '>' . $saldo . '</a></td>';
    echo '</tr>';

*/

      $bu[$z] = array('id' => $id, 
      'betrag'   => $betrag, 
      'saldo'  => $saldo);
 

    $z++;

}
// der erste saldo wird mit dem 2. betrag addiert oder subtrahiert das ergibt den 2.saldo
// in ein array einlesen id betrag und saldo dann mit schleife durch das array und rechnen

echo $z." Datensätze durchlaufen. ";


while ($z > 0) {
$saldo_neu = $bu[$z2]['saldo'] + $bu[$z-1]['betrag'];

/*
echo "z: ".$z;
echo " id: ".$bu[$z]['id'];
echo " betrag: ".$bu[$z]['betrag'];
echo " saldo: ".$bu[$z]['saldo'];
echo " nächster Saldo: ".$saldo_neu;
echo "<br>";
*/

if ($saldo_neu = $bu[$z-1]['saldo']) {
    //echo "Passt!<br>";
} else {
    echo " id: ".$bu[$z]['id'];
    echo "Passt Nicht!<br>";
    exit;
}


$z--;

}
echo "Passt!<br>";






?>


<br><br>

<form>
    <input formaction="diba.php" type="Submit" name="" value="zurück">
</form>
<br>

