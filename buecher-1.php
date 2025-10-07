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
	    <input id = "buttons_film" type="Submit" name="" value="Bücher umbenennen">
      </form>

<br><br>

<?php

$eingabe = $_POST['suche'];

$suche = explode(" ", $eingabe); 			// falls 2 Suchbegriff dann zerlegen
if (empty($suche[1])) {						// falls 2. nicht - dann erstellen und wert übergeben
	$suche[1] = substr ($suche[0], 0, 1);
}
/*
echo getcwd() . "\n";
echo '<br>';
chdir('/var/www/html/buecher');
echo getcwd() . "\n";
echo '<br>';

foreach (scandir(".") as $file) {
	if ($file === ".." or $file === ".") continue;
  
	  echo "$file".'<br>';
  }
*/




/*
==================================================================================================
Hier kommen verschiedene Bereiche des Programmes
==================================================================================================
*/



/*

==================================================================================================

==================================================================================================
content.opf auslesen
==================================================================================================




==================================================================================================
*/
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
    	//echo 'bis hier geht es ';
		
	/* 

	*/




    if($file != "." && $file != "..") {
      if(is_dir("$dir/$file")) {
        getDir("$dir/$file");		// wenn Verzeichnis dann ruf dich selber auf
      } else {

        // $name="$dir/|$file"."\r\n"; // das zeichen | separiert pfad und file

        // hier kann man direkt in die db schreiben - nicht in ein file

		$endungen= array(".pdf", "epub", "mobi", "azw3", ".rtf"); // nur diese endungen werden benötigt

        $endung = substr($name,strlen($name)-5,4); // von den letzten 6 zeichen nimm 4, die beiden letzten zeichen sind /n für Zeilenumbruch
        $endung = rtrim($endung);
        $endung = substr($file,-4); // die letzten 4 zeichen sind die Endung

		//echo $dir.' ---  '.$file.'! ---!'.$endung.'!'.'<br>';





		if (in_array($endung, $endungen)) {  // nur die gewünschten Endungen

			// echo $dir.' ---  '.$file.' ---  '.$endung.'<br>';

			// $endung = $mysqli->real_escape_string($endung); // hier werden Sonderzeichen maskiert z.B. in O'Reilley
			$dir = $mysqli->real_escape_string($dir);
			$file = $mysqli->real_escape_string($file);
			$pfad = $dir.'/'. $filename;

			// von welchem typ ist die datei 
			$finfo = finfo_open(FILEINFO_MIME_TYPE); 	// gib den MIME-Typ ala mimetype-Erweiterung zurück
			$filetyp=finfo_file($finfo, $pfad);
			//echo $file." ".finfo_file($finfo, $file) . "<br>";
			//echo $file." ".$filetyp."<br>";

			if ($filetyp == 'application/epub+zip') {	// ist das file ein epub?

			}
	

			//echo $endung.' '.$i.": ".$ebooks[$i].'<br>';

			$i++;
			
			echo $i;
			//echo '<br>';
			echo ' Pfad : '.$dir;
			echo ' Datei: '.$file.'<br>';
			//echo '<br><br>'
		
			

			
			;
			//exit;






			//$sql = "INSERT INTO tab_ebooks (titel, pfad, typ) VALUES ('$file', '$dir', '$endung')";
/*
			if ($mysqli->query($sql) === TRUE) {
				// echo "New record created successfully".'<br>';
			} else {
				echo "Error: " . $sql . "<br>" . $mysqli->error;
			}
			*/
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

//getDir('/mnt/pve/daten/Buecher/ebooks');	// realen Daten > 40.000 Einträge

//echo 'bis hier geht es ';

getDir('../test1');	// zum Testen - nur 2000 Einträge





/*
==================================================================================================
wie kommen neue Epubs in die DB?
==================================================================================================
Epub vorhanden?




==================================================================================================
*/



?>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
