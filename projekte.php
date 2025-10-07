<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../projekte_formate.css" type="text/css">
  <title>Projekte</title>
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
 include "projekte_verbinden.php"; // db wird geöffnet

// hier wird die Tabelle ausgegeben
 function ausgabe($erg)
 {
  echo 	'<table class="privat">';
  echo 	'<thead><tr><td>ID</td><td>Name</td><td>Datum</td><td>Typ</td><td>Priorietät</td></tr></thead>';
	echo	'<tbody>';
	while($data = $erg->fetch()) {
		$id=$data['id'];

    switch($data['prio']) {
      case("1"): $prio="***"; break;
      case("2"): $prio="**"; break;
      case("3"): $prio="*"; break;
    }
    if($data['erledigt']=="1"):
      $erledigt="√";
		else:
      $erledigt=" ";
    endif;
		echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $data['id'] . '</a></td>';
    echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $data['name_projekte'] . '</a></td>';
    echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $data['datum'] . '</a></td>';
    echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $data['typ'] . '</a></td>';
    echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $prio . '</a></td>';
    //echo '<td><a href=projekte_formular.php?ID='.$id.'>'. $erledigt . '</a></td>';
		echo '</tr>';
	}
}

?>

<h1>Projekte </h1>
<center>Suchbegriff eingeben:</center>


<center>
<label for='suche'></label>
  <div id = "suche">
  <form method='post' action="projekt_suchen.php?i=3">
    <label for='suche'></label>
    <input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
    <br style="clear:both;">
    <button id = "buttons_suche">finden</button>
    </center>
  </form>

<form method='post' action="projekte_formular.php">
   <input id = "buttons_film" type="Submit" name="" value="Neues Projekt anlegen">
</form>


<?php
$erg = $pdo->prepare("SELECT * FROM projekte WHERE prio='1' and erledigt=0 ORDER BY PRIO");
$result = $erg->execute();
ausgabe($erg);
echo'<h2>hohe Priorität</h2>';

$erg = $pdo->prepare("SELECT * FROM projekte WHERE prio='2' and erledigt=0 ORDER BY PRIO");
$result = $erg->execute();
ausgabe($erg);
echo'<h2>mittlere Priorität</h2>';

$erg = $pdo->prepare("SELECT * FROM projekte WHERE prio='3' and erledigt=0 ORDER BY PRIO");
$result = $erg->execute();
ausgabe($erg);
echo'<h2>keine Priorität</h2>';

$erg = $pdo->prepare("SELECT * FROM projekte WHERE erledigt=1 ORDER BY ID DESC");
$result = $erg->execute();
ausgabe($erg);
echo'<h2>Erledigt</h2>';


echo'</tbody>';
echo'</table>';
?>
<br>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
