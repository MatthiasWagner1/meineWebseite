<?php
	include "verbinden.php"; // db wird geöffnet
?>

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
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<main>

<?php	// wenn id vorhanden dann daten ändern sonst neu anlegen
	if (isset ($_REQUEST['ID'])):
	$qu = "SELECT * from filme where ID='".($_REQUEST['ID'])."'";
	$erg = $mysqli->query($qu);
	$zeile = $erg->fetch_object();
	?>
	<h1>Film bearbeiten</h1>
	<?php else: ?>
	 <h1>Neuen Film anlegen</h1>
	<?php endif;
	//if (stripos($zeile->genre, "serie")!==false) $zeile->serie="1";
	 ?>

<div class = "formular" >
<form method="GET">
<table>
<tr>
<!--hier wird geprüft ob die Checkbox gesetzt ist -->
<td>Lesezeichen:</td><td><input type="checkbox" name="lesezeichen" value="1" <?php if($zeile->lesezeichen=="1") echo "checked"; ?>></td>
<td>Empfehlung:</td><td><input type="checkbox" name="empfehlung" value="1" <?php if($zeile->empfehlung=="1") echo "checked"; ?>></td>
<td>Filmwunsch:</td><td><input type="checkbox" name="filmwunsch" value="1" <?php if($zeile->filmwunsch=="1") echo "checked"; ?>></td>
<td>Serie:</td><td><input type="checkbox" name="serie" value="1" <?php if($zeile->serie=="1") echo "checked"; ?>></td>

</tr>
</table>
<table>
<tr><td>ID:</td><td><input type="text" name="ID" value="<?php echo $zeile->id ?>" readonly></td></tr>
<tr><td>Bemerkung:</td><td><input type="Text" name="bemerkung" value="<?php echo $zeile->bemerkung ?>" size="50" maxlength="100" ></td></tr>
<tr><td>Name:</td><td><input type="Text" name="name" value="<?php echo $zeile->name ?>" size="50" maxlength="100"></td></tr>
<tr><td>Jahr:</td><td><input type="Text" name="jahr" value="<?php echo $zeile->jahr ?>" size="4" maxlength="100"></td></tr>
<tr><td>Pfad:</td><td><input type="Text" name="pfad" value="<?php echo $zeile->pfad ?>" size="50" maxlength="100" ></td></tr>
<tr><td>Dateiname:</td><td><input type="Text" name="dateiname" value="<?php echo $zeile->dateiname ?>" size="50" maxlength="100" ></td></tr>

<tr>
 <td>Genre:</td><td><input type="Text" name="genre" value="<?php echo $zeile->genre ?>" size="50" maxlength="100"></td>
</tr>
</table>

<table>
<tr><td>Bewertung:

	<span class="rating">
	  <input id="rating5" type="radio" name="rating" value="5" <?php if($zeile->bewertung=="5") echo "checked"; ?>>
	  <label for="rating5">5</label>
	  <input id="rating4" type="radio" name="rating" value="4" <?php if($zeile->bewertung=="4") echo "checked"; ?>>
	  <label for="rating4">4</label>
	  <input id="rating3" type="radio" name="rating" value="3" <?php if($zeile->bewertung=="3") echo "checked"; ?>>
	  <label for="rating3">3</label>
	  <input id="rating2" type="radio" name="rating" value="2" <?php if($zeile->bewertung=="2") echo "checked"; ?>>
	  <label for="rating2">2</label>
	  <input id="rating1" type="radio" name="rating" value="1" <?php if($zeile->bewertung=="1") echo "checked"; ?>>
	  <label for="rating1">1</label>
	</span>

<!--<tr><td>5 Sterne = The very Best!! - 4 Sterne = Super - 3 Sterne = Gut - 2 Sterne = geht so - 1 Stern = LÖSCHEN!</td></tr>-->

<br><br>
<tr align=top>
<td><textarea name="beschreibung" cols="110" rows="15"><?php echo trim($zeile->beschreibung) ?></textarea></td>
</tr>
</table>

<table>
<tr>
 <td><input type="Submit" name="" formaction="film_speichern.php" value="speichern"></td>
 <td><input type="Submit" name="" formaction="filme.php" value="zurück"></td>
 <td><input type="Submit" name="" formaction="film_loeschen.php" value="löschen"></td>
</tr>
</table>

<!--
<?php echo (stripos($zeile->genre, "thriller")) ?>

Hier werden die Checkboxen gebaut und geprüft ob der inhalt in $zeile->genre vorhanden ist und dann gesetzt.
das !==false wird verwendet weil php 0(anfang des strings) als false interpretiert.
-->
<div class="genre">
	<table>

	<tr>
	<td><input type="checkbox" name="Abenteuer" value="Abenteuer " <?php if (stripos($zeile->genre, "abenteuer")!==false){ echo " checked"; } ?>>Abenteuer</td>
	<td><input type="checkbox" name="Action" value="Action " <?php if (stripos($zeile->genre, "action")!==false){ echo " checked"; } ?>>Action</td>
	</tr>
	<tr>
	<td><input type="checkbox" name="Animation" value="Animation "<?php if (stripos($zeile->genre, "animation")!==false){ echo " checked"; } ?>>Animation</td>
	<td><input type="checkbox" name="Dokumentation" value="Dokumentation " <?php if (stripos($zeile->genre, "dokumentation")!==false){ echo " checked"; } ?>>Dokumentation</td>
	</tr>
	<tr>
	<td><input type="checkbox" name="Drama" value="Drama " <?php if (stripos($zeile->genre, "drama")!==false){ echo " checked"; } ?>>Drama</td>
	<td><input type="checkbox" name="Fantasy" value="Fantasy " <?php if (stripos($zeile->genre, "fantasy")!==false){ echo " checked"; } ?>>Fantasy</td>
	</tr>
	<tr>
	<td><input type="checkbox" name="Historie" value="Historie " <?php if (stripos($zeile->genre, "historie")!==false){ echo " checked"; } ?>>Historie</td>
	<td><input type="checkbox" name="Horror" value="Horror " <?php if (stripos($zeile->genre, "horror")!==false){ echo " checked"; } ?>>Horror</td>
	</tr>
	<tr>
	<td><input type="checkbox" name="Komödie" value="Komödie " <?php if (stripos($zeile->genre, "komödie")!==false){ echo " checked"; } ?>>Komödie</td>
	<td><input type="checkbox" name="Liebesfilm" value="Liebesfilm " <?php if (stripos($zeile->genre, "liebesfilm")!==false){ echo " checked"; } ?>>Liebesfilm</td>
	</tr>
	<tr>
	<td><input type="checkbox" name="Musik" value="Musik " <?php if (stripos($zeile->genre, "musik")!==false){ echo " checked"; } ?>>Musik</td>
	<td><input type="checkbox" name="SciFi" value="SciFi " <?php if (stripos($zeile->genre, "scifi")!==false){ echo " checked"; } ?>>SciFi</td>
	</tr>
	<td><input type="checkbox" name="Sport" value="Sport " <?php if (stripos($zeile->genre, "sport")!==false){ echo " checked"; } ?>>Sport</td>
	<td><input type="checkbox" name="Thriller" value="Thriller " <?php if (stripos($zeile->genre, "thriller")!==false){ echo " checked"; } ?>>Thriller</td>
	<tr>
	<td><input type="checkbox" name="Western" value="Western " <?php if (stripos($zeile->genre, "western")!==false){ echo " checked"; } ?>>Western</td>
	<td><input type="checkbox" name="Zeichentrick" value="Zeichentrick" <?php if (stripos($zeile->genre, "zeichentrick")!==false){ echo " checked"; } ?>>Zeichentrick</td>
	</tr>
	</table>
</div>
</form>

<table>
<form target="_blank" action="https://google.de/search">
	<td><button>Google suche</button></td>
	<td><input size="52" name="q" value="<?php echo "filmstarts " . $zeile->name ?>"></td>
</form>
</table>
</div>
<br>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
