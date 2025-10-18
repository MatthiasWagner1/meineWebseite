<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="formate1.css" type="text/css">
  <title>Startseite</title>
</head>
<body>
<header>

<!-- Das würde ein Zufallsbild anzeigen. Dateiname: bild1-5.png
<?php
 	$zz = rand(1,5);
	$bild = 'img/bild'.$zz.'.png';
	echo "<img class='bild' src='$bild'> ";
?>
-->
<img class='bild' alt='Diepoltsdorf' src='img/bild4.png'>

<nav>
  <ul>
    <li><a href="index.php">Startseite</a></li>
    <li><a href="filme/filme.php">Filme</a></li>
    <li><a href="dinge/dinge.php">Dinge</a></li>
    <li><a href="projekte/projekte.php">Projekte</a></li>
    <li><a href="ebooks/ebook.php">Bücher</a></li>
    <li><a href="musik/musik.php">Musik</a></li>
    <li><a href="heimnetz/heimnetz.php">Heimnetz</a></li>
  </ul>
</nav>

	<!-- <a id="navlink" title="zum Navigationsmenü" href="#navigation">☰</a>  -->
  <h1 class="ribbon">
   <!-- INTRANET<br/><span>Matthias Wagner</span>-->
   <a id="logo" title="zurück zur Startseite!" href="index.php"><span>Matthias Wagner</span></a>
  </h1>


</header>

<!-- ab hier kommt nur noch Text -->
<main>

<?php
  $lines = file ('../temp.txt');
  $letzte_zeile = $lines[count($lines)-1];
  $datum = substr($letzte_zeile,1,5);
  $zeit = substr($letzte_zeile,12,5);
  $topic = substr($letzte_zeile,22,13);
  $temperatur = substr($letzte_zeile,-6);

  echo '<h2>';
  echo "hier passiert gerade nichts...".' <br>';

  echo '</h2>';
?>

<div class="flex-container">
  <div>


  </div>


  <div>

  </div>
 </div>

<br>
</main>
</body>
</html>
<?php
echo '<footer>';
	echo '© 2016 - 2023 Matthias Wagner - ';
	echo '<a href="kontakt.php"> <img src="img/Design03-icon-contact.png"> Kontakt - </a>';
	echo '<a href="impressum.php"><img src="img/icon-imprint.png"> Impressum - </a>';
  echo '<a href="historie.php"><img src="img/icon-historie.png"> Historie</a>';
echo '</footer>';
?>
