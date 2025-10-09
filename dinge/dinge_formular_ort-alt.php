<?php
  error_reporting(level -1);
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
	$qu = $pdo->prepare("SELECT * from tab_dinge 
  LEFT JOIN tab_ort ON tab_dinge.fs_ort = tab_ort.id_ort
  LEFT JOIN tab_regal ON tab_ort.fs_regal = tab_regal.id_regal
  LEFT JOIN tab_zimmer ON tab_regal.fs_zimmer = tab_zimmer.id_zimmer
  LEFT JOIN tab_stockwerk ON tab_zimmer.fs_stockwerk = tab_stockwerk.id_stockwerk  

  where ID='".($_REQUEST['ID'])."'");
  
  $result = $qu->execute();
  $data = $qu->fetch();
?>

<h1>Ort bearbeiten</h1> 
<?php else: ?>
 <h1>Neuen Ort anlegen</h1>
<?php endif; ?>

<div class = "dinge_formular" >
<form method="GET">



<table>

<tr><td>Ort:</td><td><input type="text" name="name_ort" value="<?php echo $data['name_ort'] ?>" size="20" maxlength="20" ></td></tr>

<!--
hier wird die ID der ort (des Ortes) versteckt übertragen mit dem namen fs_ort der beim speichern
benötigt wird
-->
<tr><td>ort:</td><td><input type="text" name="fs_ort" value="<?php echo $data['fs_ort'] ?>" size="20" maxlength="20" ></td></tr>
<tr><td>Regal:</td><td><input type="text" name="regal" value="<?php echo $data['name_regal'] ?>" size="20" maxlength="20"  ></td></tr>
<tr><td>Zimmer:</td><td><input type="Text" name="zimmer" value="<?php echo $data['name_zimmer'] ?>" size="20" maxlength="50" ></td></tr>
<tr><td>Stockwerk:</td><td><input type="text" name="stockwerk" value="<?php echo $data['name_stockwerk'] ?>" size="20" maxlength="20"  ></td></tr>
<tr><td>Beschr. Ort:</td><td><input type="text" name="stockwerk" value="<?php echo$data['beschreibung_ort'] ?>" size="35" maxlength="20"  ></td></tr>
</table>


<table>
<tr></tr>
<tr>
 <td><input type="Submit" name="" formaction="dinge_ort_speichern.php" value="übernehmen"></td>
 <td><input type="Submit" name="" formaction="ort_loeschen.php" value="löschen"></td>
</tr>
</table>
</div>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>