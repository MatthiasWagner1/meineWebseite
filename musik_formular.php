<?php
	include "verbinden_musiksammlung.php"; // db wird geöffnet
?>

<!doctype html>
<html lang=de>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width; initial-scale=1.0;' />
  <link rel='stylesheet' href='../formate.css' type='text/css'>
  <title>Musik</title>
</head>
<body>

<header></header>
<main>  

<?php	// wenn id_lieder vorhanden (besser leer?) dann daten ändern sonst neu anlegen
	if (isset ($_REQUEST['id_lieder'])):
	$qu = "SELECT * from lieder where id_lieder='".($_REQUEST['id_lieder'])."'";
	$erg = $mysqli->query($qu);
	$zeile = $erg->fetch_object();
?>
<h1>Musik bearbeiten</h1> 
<?php else: ?>
 <h1>Neue Musik anlegen</h1>
<?php endif; ?>


<!--  -->




<div class = "formular" >
<form method="GET">


<table>
<tr>
<td style="width:90px">
</tr>
<td>Markiert:</td><td><input type="checkbox" name="markiert" value="1" <?php if($zeile->markiert=="1") echo "checked"; ?>></td>
<tr><td>id_lieder:</td><td><input type="text" name="id_lieder" value="<?php echo $zeile->id_lieder ?>" readonly></td></tr>
<tr><td>Bemerkung:</td><td><input type="Text" name="bemerkung" value="<?php echo $zeile->bemerkung ?>" size="50" maxlength="100" ></td></tr>
<tr><td>Titel:</td><td><input type="Text" name="titel" value="<?php echo $zeile->titel ?>" size="50" maxlength="100"></td></tr>
<tr><td>Interpret:</td><td><input type="Text" name="interpret" value="<?php echo $zeile->interpret ?>" size="50" maxlength="100"></td></tr>
<tr><td>Album:</td><td><input type="Text" name="album" value="<?php echo $zeile->album ?>" size="50" maxlength="100"></td></tr>
<tr><td>Jahr:</td><td><input type="Text" name="jahr" value="<?php echo $zeile->jahr ?>" size="4" maxlength="100">
Länge: <input type="Text" name="laenge" value="<?php echo $zeile->laenge ?>" size="5" maxlength="100">
Größe: <input type="Text" name="groesse" value="<?php echo $zeile->groesse ?>" size="8" maxlength="100"></td></tr>
<tr><td>Pfad:</td><td><input type="Text" name="pfad" value="<?php echo $zeile->pfad ?>" size="50" maxlength="100" ></td></tr>
<tr><td>Dateiname:</td><td><input type="Text" name="dateiname" value="<?php echo $zeile->dateiname ?>" size="50" maxlength="100" ></td></tr>
<tr><td>Genre:</td><td><input type="Text" name="genre" value="<?php echo $zeile->genre ?>" size="50" maxlength="100"></td></tr>
<!--<tr><td>Bewertung:</td><td><input type="Text" name="bewertung" value="<?php echo $zeile->bewertung ?>" size="50" maxlength="100"></td></tr> -->
<tr><td>Playlist:</td><td><input type="Text" name="playlist" value="<?php echo $zeile->playlist ?>" size="50" maxlength="100"></td></tr>
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

</td></tr>
<tr><td>5 Sterne = The very Best!! - 4 Sterne = Super - 3 Sterne = Gut - 2 Sterne = geht so - 1 Stern = LÖSCHEN!</td></tr>
</table>  

<table>
 <tr>
  <td style="width:90px">
</tr>
<br>
<tr align=top>
<td><textarea name="beschreibung" cols="85" rows="10"> <?php echo trim($zeile->beschreibung) ?></textarea></td>
</tr>
</table>
<br>
<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="musik_speichern.php" value="übernehmen"></td>
 <td><input type="Submit" name="" formaction="musik_loeschen.php" value="löschen"></td>
</tr>
</table>

</div>
</form> 

<table>
<form target="_blank" action="https://google.de/search">
	<td><button>Google suchen</button></td>
	<td><label>	<input name="q" value="<?php echo $zeile->titel ?>"></label></td>
</form>  
</table>
</div>	



</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
