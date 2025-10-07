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
     include "header.php"; // die Menüs einbinden
  ?>
</header>



<!-- ab hier kommt nur noch Text -->
<main>

<h1>Dinge</h1>

<center>Suchbegriff eingeben:</center>
<center>

  <div id = "suche">
  <form method='post' action="dinge_suchen_in.php?i=3">
  <label for='suche'></label>
  <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
  <button id = "buttons_suche">finden</button>
  </center>
  </form>
  <br><br>
  <form method='post'>
  <input id = "buttons_film" type="Submit" name="" formaction="dinge_formular.php" value="Dinge NEU">
  <input id = "buttons_film" type="Submit" name="" formaction="dinge_stammdaten.php" value="Stammdaten">
  <input id = "buttons_film" type="Submit" name="" formaction="dinge_auswahl_filtern_ort.php?ID=1" value="Auswahl nach Ort">
  <input id = "buttons_film" type="Submit" name="" formaction="dinge_neuzugang.php" value="Neuzugänge">
 </form>
 </div>

<?php
include "dinge_verbinden.php"; // db wird geöffnet

function ausgabe($erg,$ids) {
  while($data = $erg->fetch()) {
    $id=$data['id']; 
    if ($ids == $data['id_stockwerk']) {
      if ($z < 15) {
        echo '<a href=dinge_formular.php?ID='.$id.'>'. $data['name_dinge'] . '</a>';
        echo '<br>';
        ++$z;
      }
    }
  }
}


$erg = $pdo->prepare("SELECT * FROM tab_dinge
LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort
LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal
LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk 
ORDER BY id DESC");

?>

<!-- ab hier wird die Seite aufgebaut -->

<div class="flex-container">
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Dachgeschoss"> Dachgeschoss</a></h5>
    <?php
    $result = $erg->execute();
    ausgabe($erg,1);
    ?>
  </div>
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="1. Stock"> 1. Stock</a></h5>
    <?php
    $result = $erg->execute();
    ausgabe($erg,3);
    ?>
  </div>
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Erdgeschoss"> Erdgeschoss</a></h5>
    <?php
    $result = $erg->execute();
    ausgabe($erg,4);
    ?>
  </div>  
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Keller"> Keller</a></h5>
    <?php
     $result = $erg->execute();
     ausgabe($erg,5);
    ?>
  </div> 
  <div>
    <h5><a href="dinge_zimmer.php?i=6" title="Draussen"> Draussen</a></h5>
    <?php
    $result = $erg->execute();
    ausgabe($erg,6);
    ?>
  </div> 
</div>


</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
