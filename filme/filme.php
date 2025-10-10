<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../formate.css' type='text/css'>
  <title>Filme</title>
</head>
<body>

<header>
  <?php
  include "../header.php"; // die Fusszeile einbinden
  ?>
</header>

<!-- ab hier kommt nur noch Text -->
<main>
   <h1>Filmdatenbank</h1>

<center>Suchbegriff eingeben:
  <div id = "suche">
  <form method='post' action="film_suchen_in.php?i=3">
    <label for='suche'></label>
    <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>

    <button id = "buttons_suche">finden</button>
    <input id = "buttons_suche" type="Submit" name="" formaction="film_suchen_in.php?i=1" value="nach Typ">
    <input id = "buttons_suche" type="Submit" name="" formaction="film_suchen_in.php?i=2" value="in Beschreibung">
    </center>
  </form>
 
  <form method='post' action="film_formular.php">
      <input id = "buttons_film" type="Submit" name="" value="Neuen Film anlegen">
  </form>

<?php
 include "verbinden.php"; // db wird geöffnet

 function ausgabe($erg)
 {
	while ($zeile = $erg->fetch_object()) {
    $id=$zeile->id;
    $name=$zeile->name;
    if($zeile->serie=="1") $name="𝙎 ".$name; //Ⓢ
			echo '<a href=film_formular.php?ID='.$id.'>'. $name . '</a>'; // die ID wird übergeben!!
		echo '<br>';
	}
 }
?>

<!-- hier starten die Boxen -->

<div class="flex-container">
  <div>
    <h5><a href="film_suchen_in.php?i=7" title="Neuzugänge"> neue Filme</a></h5>
    <?php
    $erg = $mysqli->query("SELECT * FROM filme WHERE filmwunsch=0 ORDER BY id DESC LIMIT 15")
      or die($mysqli->error);
    ausgabe($erg);
    ?>
  </div>
  <div>
    <h5><a href="film_suchen_in.php?i=6" title="Filmwunsch"> Filmwunsch</a></h5>
    <?php
    $erg = $mysqli->query("SELECT * FROM filme Where filmwunsch>0 ORDER BY id DESC LIMIT 15")
    or die($mysqli->error);
    ausgabe($erg);
    ?>
  </div>
  <div>
    <h5><a href="film_suchen_in.php?i=8" title="Top"> Top Bewertung</a></h5>
    <?php
    $erg = $mysqli->query("SELECT * FROM filme WHERE filmwunsch=0 ORDER BY bewertung DESC LIMIT 15")
      or die($mysqli->error);
    ausgabe($erg);
    ?>
  </div>  
  <div>
    <h5><a href="film_suchen_in.php?i=4" title="Empfehlungen"> Empfehlungen</a></h5>
    <?php
    $erg = $mysqli->query("SELECT * FROM filme Where empfehlung>0 ORDER BY name LIMIT 15")
    or die($mysqli->error);
    ausgabe($erg);
    ?>
  </div> 
  <div>
    <h5><a href="film_suchen_in.php?i=5" title="Lesezeichen">Lesezeichen</a></h5>
    <?php
    $erg = $mysqli->query("SELECT * FROM filme Where lesezeichen='1' ORDER BY name LIMIT 15")
    or die($mysqli->error);
    ausgabe($erg);
    ?>
  </div>   
  <div>
    <h5><a href="film_suchen_in.php?i=9" title="Serien">Serien</a></h5>
    <?php
    $erg = $mysqli->query("SELECT * FROM filme Where serie='1' ORDER BY bewertung DESC LIMIT 15")
    or die($mysqli->error);
    ausgabe($erg);
    ?>
  </div> 
</div>



</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
