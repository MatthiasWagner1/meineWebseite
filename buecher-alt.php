<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../formate.css" type="text/css">
  <title>Bücher</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Fusszeile einbinden
    ?>
  </header>

<main>
 <h1>Bücher </h1>
			<form action="buecher.php" method="post">
				<label for='suche'>Suchbegriff: </label>
				<input id='suche' name='suche' value='<?php echo $_POST['suche'];?>'>
				<button>finden</button>
			</form>
      <br>
      <form method='post' action="buecher_endungen.php">
	    <input id = "buttons_film" type="Submit" name="" value="Bücher Endungen">
      </form>

<br><br>

<?php

$eingabe = $_POST['suche'];

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}


chdir('/var/www/html/epubs');

function getDir($dir) {
  $dh = opendir($dir);
  static $i = 0; //static damit $i nicht beim rekursiven Aufruf auf 0 gestellt wird
	
	// hier öffnen wir die Verbindung zur Datenbank
	$mysqli = new mysqli('localhost', 'matthias', 'seppel', 'ebooks');
	if ($mysqli->connect_error) {
		echo 'Fehler bei der Verbindung: '.mysqli_connect_error();
		exit();
		}
	if (!$mysqli->set_charset("utf8")) {
		echo 'Fehler beim Laden von UTF8 '. $mysqli->error;
	}
	// echo 'Alles gut. DB Verbindung steht';


	// hier muss eine Abfrage kommen: Pfad vorhanden - wenn Nein
	// FEHLERMELDUNG - Verbindung zur NAS fehlt!
	
  	while($file = readdir($dh)) {
		if($file != "." && $file != "..") {		// . und .. sind uninteressant
			if(is_dir("$dir/$file")) {
				getDir("$dir/$file");				// wenn Verzeichnis dann ruf dich selber auf
		} else {

			// $name="$dir/|$file"."\r\n"; // das zeichen | separiert pfad und file

			// hier kann man direkt in die db schreiben - nicht in ein file


				$dir = $mysqli->real_escape_string($dir);
				$filename = $mysqli->real_escape_string($file);
				$file = $dir.'/'. $filename;	// $file= pfad und filename
				
				// von welchem typ ist die datei 
				
				$finfo = finfo_open(FILEINFO_MIME_TYPE); 	// gib den MIME-Typ ala mimetype-Erweiterung zurück
				$filetyp=finfo_file($finfo, $file);
				//echo $file." ".finfo_file($finfo, $file) . "<br>";
				//echo $file." ".$filetyp."<br>";

				if ($filetyp == 'application/epub+zip') {	// ist das file in epub?
					$i++;
					echo $i;
					//echo " Das ist ein epub<br>";
					echo ' ';
					echo 'Pfad : '.$dir.', ';
					echo 'Datei: '.$filename.'<br>';
			}
		}
	}
  }
	//echo $i;
  closedir($dh);
 $mysqli->close();
}

// die Funktion getDir liest rekursiv das übergebenen Verzeichnis, schreibt alle (nur epub, .txt ...) in mssql db

// getDir('/media/matthias/NAS/Buecher/ebooks');	// realen Daten > 40.000 Einträge

getDir('.');	// realen Daten > 80.000 Einträge



// getDir('../test1');	// zum Testen - nur ein paar Einträge

/*
==================================================================================================
wie kommen neue Epubs in die DB?
==================================================================================================
Epub vorhanden?




==================================================================================================
*/

chdir('/var/www/html/meineWebseite/html');

?>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
