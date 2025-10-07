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
  <nav>
    <ul>
      <li><a href='../index.php'>Startseite</a></li>
      <li><a href='buecher.php'>Bücher</a></li>
      <li><a href='filme.php'>Filme</a></li>
      <li><a href='musik.php'>Musik</a></li>
      <li><a href='golf.html'>Golf</a></li>
      <li><a href='privat.html'>Privat</a></li>
    </ul>

  </nav>
	<!-- <a id='navlink' title='zum Navigationsmenü' href='#navigation'>☰</a>  -->
  <h1 class='ribbon'>
   <!-- INTRANET<br/><span>Matthias Wagner</span>-->
   <a id='logo' title='zurück zur Startseite!' href='../index.php'>Intranet<br/><span>Matthias Wagner</span></a>
  </h1>
</header>

<!-- ab hier kommt nur noch Text -->
<main>    

<?php
	include "verbinden.php"; // db wird geöffnet
	$z=$_GET['i'];

if ($z == 1) {	
	echo' <h1>Filme mit Lesezeichen</h1>';
	$erg = $mysqli->query("SELECT * FROM filme where lesezeichen='1'")
		or die($mysqli->error);
}

if ($z == 2) {
	echo' <h1>Filme mit Empfehlung</h1>';
	$erg = $mysqli->query("SELECT * FROM filme where empfehlung='1'")
		or die($mysqli->error);
}

// hier wird die Tabelle erstellt
echo 	'<br><br><br><br>';
echo 	'<table class="privat" border="1">';
echo 	'<thead><tr><td>ID</td><td>Name</td><td>Pfad</td></tr></thead>';
echo 	'<br>';
echo	'<tbody>';
while ($zeile = $erg->fetch_object()) {
		$id=$zeile->id;
		echo '<tr>';						// gann schreibe die Zeile (row) in die Tabelle
		// echo '<td>' . $zeile->dateiname . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		echo '<td><a href=film_formular.php?ID='.$id.'>' . $zeile->id . '</a></td>';
		echo '<td><a href=film_formular.php?ID='.$id.'>'. $zeile->name . '</a></td>'; // die ID wird übergeben!!
		echo '<td><a href=privat.html>' . $zeile->pfad . '</a></td>';
		echo '</tr>';
}

echo'</tbody>';
echo'</table>';

//hier wird die Anzahl der Treffer gezeigt. id=treffer: an welche position kommt aus css
echo '<div id = "treffer" >';

if ($erg->num_rows) {
	echo "Treffer: ".$erg->num_rows;
}
echo '</div>';

$erg->free();
$mysqli->close();
?>

</main>
<footer>
	© 2016 - 2017 Matthias Wagner - 
	<a href="kontakt.html" title="Kontakt"><img alt="Kontakt | "></a>
	<a href="impressum.html" title="Impressum"><img alt="Impressum"></a>
</footer>
</body>
</html>
