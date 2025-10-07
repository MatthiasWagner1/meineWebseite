<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../formate.css" type="text/css">
  <title>Privat</title>
</head>
<body>

<header>
  <nav>
    <ul>
      <li><a href="../index.php">Startseite</a></li>
      <li><a href="buecher.php">Bücher</a></li>
      <li><a href="filme.php">Filme</a></li>
      <li><a href="musik.php">Musik</a></li>
      <li><a href="golf.html">Golf</a></li>
      <li><a href="privat.html">Privat</a></li>
    </ul>

  </nav>
	<!-- <a id="navlink" title="zum Navigationsmenü" href="#navigation">☰</a>  -->
  <h1 class="ribbon">
   <!-- INTRANET<br/><span>Matthias Wagner</span>-->
   <a id="logo" title="zurück zur Startseite!" href="../index.php">Intranet<br/><span>Matthias Wagner</span></a>
  </h1>
</header>

<!-- ab hier kommt nur noch Text -->
<main>
  <?php
    $user = $_POST['name'];
    $pass = $_POST['pass'];
    $okuser = "matthias" ;
    $okpass = "seppel" ;
    if ($user == $okuser && $pass == $okpass) {
      // echo "Korrekte Eingabe" ;
    } else {
      // echo "Falsche Eingabe" ;
    }
  ?>
	
<h1>Privat </h1>
<table class="privat">
 <thead>
		<tr><td>Name</td><td>Mobil</td><td>Privat</td><td>Büro</td><td>E-Mail</td></tr>
</thead>
<tbody>
	<tr><td>Claudia </td><td>0178/1351466</td><td>09155/927448</td><td></td><td>claudia.sy.wagner@gmail.com</td></tr>
	<tr><td>Matthias</td><td>0179/9083100</td><td>09155/927448</td><td></td><td>matthi.wagner@gmail.com</td></tr>
	<tr><td>Leni</td><td>0174/4238749</td><td>09155/464</td><td></td><td></td></tr>
	<tr><td>Karl </td><td>0170/2404499</td><td>09155/464</td><td></td><td>karl.schwarzmann@web.de</td></tr>
	<tr><td>Barbara</td><td>0175/8256801</td><td>09155/1704</td><td></td><td>barbara.schwarzmann@martha-maria.de</td></tr>
	<tr><td>Harald </td><td>0176/34064820</td><td>09155/1704</td><td></td><td></td></tr>
	<tr><td>Andrea</td><td>0173/3565592</td><td>09123/985352</td><td></td><td></td></tr>
	<tr><td>Thomas </td><td>0179/5123782</td><td>09123/985352</td><td>09123/186438</td><td>t.schwarzmann@web.de</td></tr>
	
</tbody>
</table>
 

</main>
<footer>
	© 2016 - 2017 Matthias Wagner - 
	<a href="kontakt.html" title="Kontakt"><img alt="Kontakt | "></a>
	<a href="impressum.html" title="Impressum"><img alt="Impressum"></a>
</footer>
</body>
</html>

