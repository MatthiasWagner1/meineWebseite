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
      <li><a href="golf.php">Golf</a></li>
      <li><a href="privat.php">Privat</a></li>
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
 <h1>Privat </h1>

     <form method="post" action="privat_inhalt.php">
     Username: <input name="name" type="text" value="matthias"><br>
     Kennwort : <input name="pass" type="password" value="seppel"><br>
     <input type="submit" value="Login">
     </form>

 

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
