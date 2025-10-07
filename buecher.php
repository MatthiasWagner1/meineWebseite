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


/*
==================================================================================================
wie kommen neue Epubs in die DB?
==================================================================================================
Epub vorhanden?




==================================================================================================
*/



// Verzeichnis, das durchsucht werden soll
$directory = '/var/www/html/ebooks/';

// Datenbankverbindung herstellen (ersetzen Sie die Datenbankverbindungsdetails)
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "deineDatenbank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Rekursive Funktion zum Durchsuchen des Verzeichnisses
function scanDirectory($dir) {
    global $conn;
    
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $path = $dir . '/' . $file;
            
            if (is_dir($path)) {
                // Wenn es ein Verzeichnis ist, rufe die Funktion erneut auf
                scanDirectory($path);
            } else {
                // Wenn es eine EPUB-Datei ist, lese die Metadaten aus
                if (pathinfo($path, PATHINFO_EXTENSION) == 'epub') {
                    $metadata = extractEpubMetadata($path);
                    saveToDatabase($metadata);
                }
            }
        }
    }
}

// Funktion zum Extrahieren der Metadaten aus einer EPUB-Datei
function extractEpubMetadata($filepath) {
    $metadata = array();
    
    // Erzeuge ein DOMDocument-Objekt und lade die EPUB-Datei
    $doc = new DOMDocument();
    $doc->load($filepath);
    
    // Hier können Sie die entsprechenden XML-Elemente und Attribute finden und auslesen
    $title = $doc->getElementsByTagName('dc:title')->item(0)->nodeValue;
    $author = $doc->getElementsByTagName('dc:creator')->item(0)->nodeValue;
    $description = $doc->getElementsByTagName('dc:description')->item(0)->nodeValue;
    
    // Fügen Sie die Metadaten dem Array hinzu
    $metadata['title'] = $title;
    $metadata['author'] = $author;
    $metadata['description'] = $description;
    
    return $metadata;
}

// Funktion zum Speichern der Metadaten in der Datenbank
function saveToDatabase($metadata) {
    global $conn;
    
    // SQL-Abfrage zum Einfügen der Metadaten in die Tabelle "books" (passen Sie die Tabelle und Spaltennamen an Ihre Datenbankstruktur an)
    $sql = "INSERT INTO books (title, author, description) VALUES ('".$metadata['title']."', '".$metadata['author']."', '".$metadata['description']."')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Metadaten erfolgreich in die Datenbank eingefügt.";
    } else {
        echo "Fehler beim Einfügen der Metadaten in die Datenbank: " . $conn->error;
    }
}

// Aufruf der Funktion zum Durchsuchen des Verzeichnisses
scanDirectory($directory);

?>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
