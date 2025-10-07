<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;">
  
  <link rel="stylesheet" href="../ebook_formate.css">
  <title>Bücher</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Kopfzeile einbinden
    ?>
  </header>

<main>

  <h1> eBooks</h1>



Suchbegriff eingeben:

<div id = "suche">
<form method='post' action="ebook.php?i=1">
<label for='suche'></label>
<input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
<button id = "buttons_suche">finden</button>
<br><br>
<input id = "buttons_suche" type="Submit" name="" formaction="ebook.php?i=2" value="nach eBooks">
<input id = "buttons_suche" type="Submit" name="" formaction="ebook.php?i=3" value="nach Autoren">
</form>
<br><br>


<?php
include "ebooks_verbinden.php"; // db wird geöffnet

$eingabe = $_POST['suche'];
$i=$_GET['i'];

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						    // falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}

	$erg = "SELECT * FROM tab_ebooks
    INNER JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor ORDER BY tab_ebooks.id DESC LIMIT 100
    ";   // hier werden tab_ebooks und tab_autor über tab_autor.id_autor und tab_ebooks.fs_autor verbunden

//echo $erg;
//exit;

/*
	$erg = "SELECT 
    tab_ebooks.titel,
    tab_ebooks.id,
    tab_ebooks.date,
    tab_ebooks.isbn,
    tab_autor.name AS autor
    
    FROM tab_ebooks
    JOIN tab_autor ON tab_ebooks.fs_autor = tab_autor.id_autor ORDER BY tab_ebooks.id DESC LIMIT 30
  	
    ";
*/

$erg = $pdo->prepare($erg);
$result = $erg->execute();

echo "Suche: ".$eingabe."<br>";
echo "i: ".$i;

//exit;



ausgabe($erg);

/*
==================================================================================================
wie 
==================================================================================================


==================================================================================================
*/


 function ausgabe($erg)
 {
  echo 	'<table class="privat">';
  echo 	'<thead><tr><td>ID</td><td>Titel</td><td>Autor</td><td>Veröffentlicht</td><td>ISBN</td></tr></thead>';
	echo	'<tbody>';
	while($data = $erg->fetch()) {
		$id=$data['id'];
    $id_autor=$data['id_autor'];


    
		echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $data['id'] . '</a></td>';
    echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $data['titel'] . '</a></td>';
    echo '<td><a href=ebook_autor_formular.php?ID='.$id_autor.'>'. $data['name'] . '</a></td>';
    echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $data['date'] . '</a></td>';
    echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $data['isbn'] . '</a></td>';
    //echo '<td><a href=ebook_formular.php?ID='.$id.'>'. $erledigt . '</a></td>';
		echo '</tr>';
	}
}

// include "footer.php"; // die Fusszeile einbinden
?>

</main>
</body>
</html>