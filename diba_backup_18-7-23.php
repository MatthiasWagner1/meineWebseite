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

<br>

 <!--  -->
<form method='post' >
      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">     
      <input formaction="diba.php" type="Submit" name="" value="ING">
  </form>


<h1><a href="heimnetz.php"> Heimnetz - Konten</a></h1>
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

<div id = "suche">
<form method='post' action="diba_suchen.php?i=1">
<label for='suche'></label>
<button id = "buttons_suche">suchen</button>
<input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>

</form>
</div>
</div>

<?php 
  $konto = "alle";
  $jahr = "2023";
  $monat = "juli"; // hier soll der letzte Monat stehen
  $kategorie = "alle";
  $sortierung = "datum";

// falls die Daten vom Formular kommen:
if (isset($_POST["konto"],
    $_POST["jahr"],
    $_POST["monat"],
    $_POST["kategorie"],
    $_POST["sortierung"])) { 

  $konto = $_POST['konto'];
  $jahr = $_POST['jahr'];
  $monat = $_POST['monat'];
  $kategorie = $_POST['kategorie'];
  $sortierung = $_POST['sortierung'];





}

?>


<br>
<!-- =========================== Filter =========================================================== -->
<div class = "filter">

<!-- das Formular ruft sich selber auf -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for='filter'></label>
<button id = "filter">filtern</button>

<table>

<tr><td>Konto: <select name="konto">
  <option <?php if ($konto == "alle") echo "selected='selected'";?> value="alle">Alle</option> 
  <option <?php if ($konto == "matthias") echo "selected='selected'";?> value="matthias">Matthias</option> 
  <option <?php if ($konto == "claudia") echo "selected='selected'";?> value="claudia">Claudia</option> 
</select></td>


<td>Jahr: <select name="jahr">
  <option <?php if ($konto == "alle") echo "selected='selected'";?> value="alle">Alle</option> 
  <option <?php if ($jahr == "2023") echo "selected='selected'";?> value="2023">2023</option> 
  <option <?php if ($jahr == "2022") echo "selected='selected'";?> value="2022">2022</option> 
</select></td>


<td>Monat: <select name="monat">
  <option <?php if ($monat == "alle") echo "selected='selected'";?> value="alle">Alle</option> 
  <option <?php if ($monat == "januar") echo "selected='selected'";?> value="januar">Januar</option> 
  <option <?php if ($monat == "februar") echo "selected='selected'";?> value="februar">Februar</option> 
  <option <?php if ($monat == "märz") echo "selected='selected'";?> value="märz">März</option> 
  <option <?php if ($monat == "april") echo "selected='selected'";?> value="april">April</option> 
  <option <?php if ($monat == "mai") echo "selected='selected'";?> value="mai">Mai</option> 
  <option <?php if ($monat == "juni") echo "selected='selected'";?> value="juni">Juni</option> 
  <option <?php if ($monat == "juli") echo "selected='selected'";?> value="juli">Juli</option> 
  <option <?php if ($monat == "august") echo "selected='selected'";?> value="august">August</option> 
  <option <?php if ($monat == "september") echo "selected='selected'";?> value="september">September</option> 
  <option <?php if ($monat == "oktober") echo "selected='selected'";?> value="oktober">Oktober</option> 
  <option <?php if ($monat == "november") echo "selected='selected'";?> value="november">November</option> 
  <option <?php if ($monat == "dezember") echo "selected='selected'";?> value="dezember">Dezember</option> 

</select></td>

<td>Kategorie: <select name="kategorie" id="kategorie">
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

<td>Sortierung: <select name="sortierung">
  <option <?php if ($sortierung == "datum") echo "selected='selected'";?> value="datum">Datum</option> 
  <option <?php if ($sortierung == "empfänger") echo "selected='selected'";?> value="empfänger">Empfänger</option> 
  <option <?php if ($sortierung == "betrag") echo "selected='selected'";?> value="betrag">Betrag</option> 
</select></td>

</tr>
</table>
</div>
<br>








<!-- hier wird die variable $erg erstellt -->




<div class = "privat">
<table>
<tr><th>Konto</th><th>Datum</th><th>Empfänger</th><th>Betrag</th></tr>
 
 <?php

 // echo "Konto: ".$konto."<br>";
 // echo "Jahr: ".$jahr."<br>";
  //echo "monat: ".$monat."<br>";
  //echo "Kategorie: ".$kategorie."<br>";
  //echo "Sortierung: ".$sortierung."<br>";

  //exit;








$erg = "SELECT * FROM konten";


if ($konto != "alle") {
  if ($konto == "matthias") {  
    $konto_nr = "1";
  }
  if ($konto == "claudia") {  
    $konto_nr = "2";
  }
  $abfrage = " WHERE konto = ".$konto_nr;
  $z++;
  $erg.= $abfrage;

//echo $erg." ".$z." ".$konto;
//exit;



}

if ($jahr != "alle") {
  if ($z == 0) $abfrage = " WHERE jahr = ".$jahr;
  if ($z != 0) $abfrage = " AND jahr = ".$jahr;
    
  $z++;
  $erg.= $abfrage;


}


if ($monat != "alle") {
  if ($z == 0) $abfrage = " WHERE monat = ".$monat;
  if ($z != 0) $abfrage = " AND monat = ".$monat;
  $z++;
  $erg.= $abfrage;
}


if ($mokategorienat !== "alle") {
  if ($z == 0) $abfrage = " WHERE kategorie = ".$kategorie;
  if ($z != 0) $abfrage = " AND kategorie = ".$kategorie;
  $z++;
  $erg.= $abfrage;
}

 $erg.= " ORDER BY $sortierung DESC"; 












echo $erg;
exit;



 $konto=$_REQUEST['i']; // das übergebene Konto
// =============================== Funktion Ausgabe ==========================================================
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



