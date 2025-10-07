<?php
// Verzeichnis, das durchsucht werden soll
$directory = '/var/www/html/ebooks/';

// Datenbankverbindung herstellen (ersetzen Sie die Datenbankverbindungsdetails)
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "deineDatenbank";


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
                    echo 'Titel: '.$metadata['title'];
                    echo $metadata['author'];
                    echo $metadata['description'];



                    exit;
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
    //$metadata['title'] = $title;
    $metadata['author'] = $author;
    $metadata['description'] = $description;



    echo $filepath;
    echo 'Titel: '.$metadata['title'];
    echo 'Titel: '.$title;

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

