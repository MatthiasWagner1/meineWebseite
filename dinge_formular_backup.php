<?php
	include "dinge_verbinden.php"; // db wird geöffnet
?>

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
  include "header.php"; // die Kopfzeile einbinden
  ?>
</header>

<main>  
  
<?php	// wenn id vorhanden (besser leer?) dann daten ändern sonst neu anlegen
	if (isset ($_REQUEST['ID'])):
	$qu = "SELECT * from tab_dinge 
  LEFT JOIN tab_kiste ON tab_dinge.fs_kiste = tab_kiste.id_kiste
  LEFT JOIN tab_regal ON tab_kiste.fs_regal = tab_regal.id_regal
  LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
  LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk  

  where ID='".($_REQUEST['ID'])."'";
  
  $erg = $mysqli->query($qu);
	$zeile = $erg->fetch_object();
?>

<h1>Teil bearbeiten</h1> 
<?php else: ?>
 <h1>Neues Teil anlegen</h1>
<?php endif; ?>

<div class = "dinge_formular" >
<form method="GET">

<table>

<tr><td>ID:</td><td><input type="text" name="ID" value="<?php echo $zeile->id ?>" size="3" maxlength="20" readonly>
Datum:<input type="text" name="datum" value="<?php echo $zeile->datum ?>" size="12" maxlength="20"  readonly></td></tr>
<tr><td>Name:</td><td><input type="text" name="name_dinge" value="<?php echo $zeile->name_dinge ?>" size="20" maxlength="50"></td></tr>
<tr><td>Typ:</td><td><input type="text" name="typ" value="<?php echo $zeile->typ ?>" size="20" maxlength="50"></td></tr>
<tr><td>Besitzer:</td><td><input type="Text" name="besitzer" value="<?php echo $zeile->besitzer ?>" size="20" maxlength="50" ></td></tr>
<tr><td>Kiste:</td><td><input type="text" name="name_kiste" value="<?php echo $zeile->name_kiste ?>" size="20" maxlength="20"></td></tr>

<!--
hier wird die ID der Kiste (des Ortes) versteckt übertragen mit dem namen fs_kiste der beim speichern
benötigt wird
-->
<tr hidden><td>Kiste:</td><td><input type="text" name="fs_kiste" value="<?php echo $zeile->fs_kiste ?>" size="20" maxlength="20"></td></tr>
<tr><td>Regal:</td><td><input type="text" name="regal" value="<?php echo $zeile->name_regal ?>" size="20" maxlength="20"  readonly></td></tr>
<tr><td>Zimmer:</td><td><input type="Text" name="zimmer" value="<?php echo $zeile->name_zimmer ?>" size="20" maxlength="50" readonly></td></tr>
<tr><td>Stockwerk:</td><td><input type="text" name="stockwerk" value="<?php echo $zeile->name_stockwerk ?>" size="20" maxlength="20"  readonly></td></tr>
</table>

<table>
<tr><td>Beschreibung:</td></tr>
<tr><td><textarea name="beschreibung_dinge" cols="69" rows="10"> <?php echo trim($zeile->beschreibung_dinge) ?></textarea></td></tr>
</table>


<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="dinge_speichern.php" value="übernehmen"></td>
 <td><input type="Submit" name="" formaction="dinge_loeschen.php" value="löschen"></td>
</tr>
</table>
</div>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>