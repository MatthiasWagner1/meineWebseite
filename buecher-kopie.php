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
      <form method='post' action="buecher_rename-1.php">
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
==================================================================================================
Hier kommen verschiedene Bereiche des Programmes
==================================================================================================
*/

/*
==================================================================================================
das epub Archiv entpacken
==================================================================================================
*/




require_once('./BookGluttonEpub.php');
//require_once('./BookGluttonZipEpub.php');

//$file = '../Das Joshua-Profil - Sebastian Fitzek.epub';


//echo "Opening $file as OPS in temp dir:\n";

/*

$epub = new BookGluttonEpub();
$epub->setLogVerbose(true);
$epub->setLogLevel(2);
$epub->open($file);
print_r($epub->getMetaPairs());

echo '<br><br>';
echo 'Titel: '.$epub->getTitle().'<br>';
echo 'Author: '.$epub->getAuthor().'<br>';
echo 'ISBN: '.$epub->getIsbn(2).'<br>';
//echo 'Beschreibung: '.$epub->getDescription().'<br>';
echo 'Rechte: '.$epub->getRights().'<br>';
echo 'Sprache: '.$epub->getLanguage().'<br>';
echo 'PackagePath: '.$epub->getPackagePath().'<br>';
echo 'Sprache: '.$epub->getLanguage().'<br>';



echo $path_to_ops;




echo '<br><br>';

//echo "Now opening $file as virtual zip (no filesystem on disk):\n";

$epub = new BookGluttonZipEpub();
$epub->enableLogging();
$epub->loadZip($file);
print_r($epub->getMetaPairs());

echo "There are ".$epub->getFlatNav()->length." navPoints here.\n";
echo "NCX:\n";
foreach($epub->getFlatNav() as $np) {
	echo $np->nodeValue."\n";
}

/*

==================================================================================================

==================================================================================================
content.opf auslesen
==================================================================================================

content.opf ist ein Teil des Archives aus dem epub Dateien bestehen
Inhalts dieses xml Doumentes ist unter anderem: Titel, Autor, ISBN, Kategorie?? ....

https://www.php.net/manual/de/simplexml.examples-basic.php

==================================================================================================
*/
/*
$package = simplexml_load_file('../content.opf');
echo '<br><br>';
echo 'Titel: '.$package->metadata->children('dc', true)->title.'<br>';
echo 'Autor: '.$package->metadata->children('dc', true)->creator.'<br>';
echo 'Kat.: '.$package->metadata->children('dc', true)->subject.'<br>';
echo 'ISBN: '.$package->metadata->children('dc', true)->identifier.'<br>';
echo 'ISBN: '.$package->metadata->children('dc', true)->identifier->ISBN.'<br>';
//echo $package->metadata->children('dc', true)->description;

// echo $package->asXML();




==================================================================================================
was machen mit der Epub Datei
==================================================================================================
umbenennen und verschieben? (wie in Calibre)



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

		//if (in_array($endung, $endungen)) {  // nur die gewünschten Endungen

			// echo $dir.' ---  '.$file.' ---  '.$endung.'<br>';

			// $endung = $mysqli->real_escape_string($endung); // hier werden Sonderzeichen maskiert z.B. in O'Reilley
			$dir = $mysqli->real_escape_string($dir);
			$file = $mysqli->real_escape_string($file);

			


			//echo "Opening $file as OPS in temp dir:\n";

			//echo $endung.' '.$i.": ".$ebooks[$i].'<br>';

			$i++;
			
			echo $i;
			echo '<br>';
			echo 'Pfad : '.$dir.'<br>';
			echo 'Datei: '.$file.'<br>';
			$file = $dir.'/'. $file;
		
			// von welchem typ ist die datei 
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // gib den MIME-Typ ala mimetype-Erweiterung zurück
			echo $file." ".finfo_file($finfo, $file) . "<br>";


			$epub = new BookGluttonEpub();
			//$epub->setLogVerbose(true);
			//$epub->setLogLevel(2);
			$epub->setPretty(true);
			
						
			$epub->open($file);
			
			echo $file.'<br>';
			echo 'Titel: '.$epub->getTitle().'<br>';
			echo 'Author: '.$epub->getAuthor().'<br>';
			echo 'ISBN: '.$epub->getIsbn().'<br>';
			echo 'Beschreibung: '.$epub->getDescription().'<br>';
			echo 'Rechte: '.$epub->getRights().'<br>';
			echo 'Sprache: '.$epub->getLanguage().'<br>';
			echo 'PackagePath: '.$epub->getPackagePath().'<br>';
			//echo 'Sprache: '.$epub->getIdentifier().'<br>';
			
			echo '<br><br>';
			//exit;






			//$sql = "INSERT INTO tab_ebooks (titel, pfad, typ) VALUES ('$file', '$dir', '$endung')";
/*
			if ($mysqli->query($sql) === TRUE) {
				// echo "New record created successfully".'<br>';
			} else {
				echo "Error: " . $sql . "<br>" . $mysqli->error;
			}
			*/
		//}

      }
    }
  }
 	echo $i;
  closedir($dh);
 $mysqli->close();
}

// die Funktion getDir liest rekursiv das übergebenen Verzeichnis, schreibt alle (nur epub, .txt ...) in mssql db

// getDir('/media/matthias/NAS/Buecher/ebooks');	// realen Daten > 40.000 Einträge

//getDir('/mnt/pve/daten/Buecher/ebooks');	// realen Daten > 40.000 Einträge

//echo 'bis hier geht es ';

getDir('../test');	// zum Testen - nur 2000 Einträge

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
