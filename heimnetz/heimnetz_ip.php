<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../heimnetz_formate.css" type="text/css">
  <title>Heimnetz</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Menüs einbinden
    ?>
  </header>

<!-- ab hier kommt nur noch Text -->
<main>

<?php
 include "heimnetz_verbinden.php"; // db wird geöffnet
 $stamm_ip = "192.168.59."; // es werden nur noch die letzten ziffern eingegeben
// hier wird die Tabelle ausgegeben
 function ausgabe($erg, $stamm_ip)
 {
	while($data = $erg->fetch()) {
		$id=$data['id'];
    $ip=$stamm_ip.$data['ip_n'];

    //echo $ip;
    //exit;


    echo '<tr>';
    echo '<td><a href=heimnetz_formular.php?ID='.$id.'>'. $data['name'] . '</a></td>';
    echo '<td><a href=heimnetz_formular.php?ID='.$id.'>'. $ip . '</a></td>';
  	echo '</tr>';
	}
}
?>
(nmap -sP 192.168.59.19/24)
<h1><a href="heimnetz.php"> Heimnetz - IP Adressen</a></h1>

 <!-- Buttons -->
<form method='post' >
      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">     
      <input formaction="diba.php" type="Submit" name="" value="ING">
  </form>
  <br>

 <form method='post' action="heimnetz_suchen.php?">
  Suchbegriff eingeben:
  <label for='suche'></label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
  <button id = "buttons_suche">finden</button>
 </form>
 <br>

   <!--

   -->

<form>
  <input type="Submit" name="" formaction="heimnetz_formular.php" value="neuer Eintrag">
</form>
<br>

<div class = "heimnetz">
  <div class = "container">
    <?php
    $erg = $pdo->prepare("SELECT * FROM liste ORDER BY ip_n LIMIT 25");
    $result = $erg->execute();
    echo 	'<table class=privat>';
    //echo 	'<thead><tr><td>Name</td><td>IP</td><td>Host</td><td>Beschreibung</td></tr></thead>';
    echo 	'<thead><tr><td>Name</td><td>IP</td></tr></thead>';
    //echo	'<tbody>';
    ausgabe($erg, $stamm_ip);
    //echo'</tbody>';
    echo'</table>';
    ?>
  </div>
 
  <div class = "container">
    <?php
    $erg = $pdo->prepare("SELECT * FROM liste ORDER BY ip_n LIMIT 25 OFFSET 25");
    $result = $erg->execute();
    echo 	'<table class=privat>';
    //echo 	'<thead><tr><td>Name</td><td>IP</td><td>Host</td><td>Beschreibung</td></tr></thead>';
    echo 	'<thead><tr><td>Name</td><td>IP</td></tr></thead>';
    //echo	'<tbody>';
    ausgabe($erg, $stamm_ip);
    //echo'</tbody>';
    echo'</table>';
    ?>
  </div>
</div>


<br>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
