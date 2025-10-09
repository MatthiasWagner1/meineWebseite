<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../diba_formate.css" type="text/css">
  <title>ING</title>
</head> 
<body>

<header>
    <?php
    include "header.php"; // die Menüs einbinden
    ?>
  </header>

<main>

<h1><a href="heimnetz.php"> Heimnetz - Konten</a></h1>

 <!--  -->
<form method='post' >
      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">     
      <input formaction="diba.php" type="Submit" name="" value="ING">
  </form>

<br>

<?php

include "heimnetz_verbinden.php"; // db wird geöffnet

// hier wird der erste Datensatz geholt für Konto Matthias, Name und Saldo
 $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = 1 ORDER BY datum DESC LIMIT 1");
 $result = $erg->execute();
 while($data = $erg->fetch()) {
  $id=$data['id'];
  $konto = $data['konto'];
  $saldo = $data['saldo'];

  // Datum in dd.mm.yyyy umwandeln
  $originalDate = $data['datum'];
  //original date is in format YYYY-mm-dd
  $timestamp = strtotime($originalDate); 
  $datum = date("d.m.Y", $timestamp );

  $name = "Matthias";
  $iban = "DE87 5001 0517 5429 1557 53";
}
?>

<!-- Darstellung der Konten in der grauen Box  -->
<!-- Matthias -->
<div class="flex-container">
  <div>
  <h5><a href="diba.php?i=1"> DiBa <?php echo $name?></a></h5>
    <br>
    <?php
      echo "Saldo: <saldo>€ ".$saldo."</saldo>";
    ?>
    <br>
    <?php
       echo "am ".$datum;
       echo "<br><iban>".$iban."</iban>";
    ?>
  </div>

<?php
// hier wird der erste Datensatz geholt für Konto Claudia, Name und Saldo
 $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = 2 ORDER BY datum DESC LIMIT 1");
 $result = $erg->execute();
 while($data = $erg->fetch()) {
  $id=$data['id'];
  $konto = $data['konto'];
  $saldo = $data['saldo'];
  // Datum in dd.mm.yyyy umwandeln
  $originalDate = $data['datum'];
  //original date is in format YYYY-mm-dd
  $timestamp = strtotime($originalDate); 
  $datum = date("d.m.Y", $timestamp );
  $name = "Claudia";
  $iban = "DE33 5001 0517 5430 0111 01";
  }

?>
<!-- Darstellung der Konten in der grauen Box  -->
<!-- Claudia -->
  <div>
  <h5><a href="diba.php?i=2"> DiBa <?php echo $name?></a></h5>
    <br>
    <?php
      echo "Saldo: <saldo>€ ".$saldo."</saldo>";
    ?>
    <br>
    <?php
       echo "am ".$datum;
       echo "<br><iban>".$iban."</iban>";
    ?>
    
  </div>
</div>
<br>

<div class = "privat">
<table>
  <tr>
  <td><a href="diba_csv_lesen.php" title=""> csv einlesen</a></td>
  <td><a href="diba_suche_erweitert.php" title=""> erweiterte Suche</a></td>
</tr>
</table>
<br>
<br>
</div>



Suchbegriff eingeben:
  <div id = "suche">
  <form method='post' action="diba_suchen.php?i=1">
    <label for='suche'></label>
    <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>

    <button id = "buttons_suche">Matthias</button>
    <input id = "buttons_suche" type="Submit" name="" formaction="diba_suchen.php?i=2" value="Claudia">
    <input id = "buttons_suche" type="Submit" name="" formaction="diba_suchen.php?i=0" value="alle Konten">
    
  </form>


</div>
<br>
<br>


<div class = "privat">
<table>

<tr><td>Konto:</td><td> <select name="konto">
  <option value="alle">Alle</option>
  <option selected="selected" value="matthias">Matthias</option>
  <option value="claudia">Claudia</option>
</select></td>


<td>Jahr:</td><td> <select name="jahr">
  <option value="alle">Alle</option>
  <option selected="selected" value="2023">2023</option>
  <option value="2022">2022</option>
</select></td>

<td>Monat:</td><td> <select name="monat">
  <option value="alle">Alle</option>
  <option value="januar">Januar</option>
  <option value="februar">Februar</option>
  <option value="maerz">März</option>
  <option value="april">April</option>
  <option value="mai">Mai</option>
  <option value="juni">Juni</option>
  <option value="julie">Julie</option>
  <option value="august">August</option>
  <option value="september">September</option>
  <option value="oktober">Oktober</option>
  <option value="november">November</option>
  <option value="dezember">Dezember</option>
</select></td>

<td>Kategorie:</td><td> <select name="kategorie" id="kategorie">
<option value="alle">Alle</option>
<?php
include "heimnetz_verbinden.php"; // db wird geöffnet

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
</select></td>



</tr>
</table>
</div>

<br>



<!-- hier beginnt die Tabelle -->
<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th></tr>
 
 <?php
 $konto=$_REQUEST['i']; // das übergebene Konto
// hier wird die Tabelle ausgegeben
function ausgabe($erg) {
  while($data = $erg->fetch()) {
    $id = $data['id'];
    $konto = $data['konto'];
    if ($konto == 1) {
     $name = "Matthias";
   }
   if ($konto == 2) {
     $name = "Claudia";
   }
   $betrag =  $data['betrag'];

   // Datum in dd.mm.yyyy umwandeln
    $originalDate = $data['datum'];
    //original date is in format YYYY-mm-dd
    $timestamp = strtotime($originalDate); 
    $datum = date("d.m.Y", $timestamp );
 
    echo '<tr>';
    echo '<td><a href=diba_formular.php?ID='.$id.'>'. $name . '</a></td>';
    echo '<td><a href=diba_formular.php?ID='.$id.'>'. $datum . '</a></td>';
    echo '<td><a href=diba_formular.php?ID='.$id.'>'. $data['empfang'] . '</a></td>';
    

    if ($betrag > 0) {
      echo '<span style="color: red;">';
      echo '<td align=right><font color="green">'. $betrag . '</td>';
      echo '</span>';
    }
    else {
      echo '<td align=right><a href=diba_formular.php?ID='.$id.'>'. $betrag . '</a></td>';
    }
  
    
    
    echo '</tr>';
  }
 }

?>

<!--
  hier wurde der erste Datensatz geholt für Konto, Name und Saldo, brauche ich nicht mehr
  
 $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = $konto LIMIT 1");
 $result = $erg->execute();
 while($data = $erg->fetch()) {
  $id=$data['id'];
  $konto = $data['konto'];
  $saldo = $data['saldo'];
  if ($konto == 1) {
    $name = "Matthias";
    $iban = "DE87 5001 0517 5429 1557 53";
  }
  if ($konto == 2) {
    $name = "Claudia";
    $iban = "DE33 5001 0517 5430 0111 01";
  }
}
//echo "<h2>Umsätze: " . $name . "<br>";
//echo "Saldo: ".$saldo." €</h2>";
//echo "IBAN: ".$iban."<br>";
-->

<?php

if ($konto == 0) {
  $erg = $pdo->prepare("SELECT * FROM konten ORDER BY datum DESC");
}
else {
  $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = $konto ORDER BY datum DESC");
}

$result = $erg->execute();
ausgabe($erg);
?>
</table>
</div>



