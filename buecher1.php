<?php
$epubFile = '/var/www/html/ebooks/Giulia Enders - Darm mit Charme'; // Pfad zu Ihrer EPUB-Datei angeben

$dom = new DOMDocument();
$dom->load($epubFile);

$xpath = new DOMXPath($dom);

// Namespace-URI abrufen
$packageNode = $dom->getElementsByTagName('package')->item(0);
$namespace = $packageNode->lookupNamespaceURI(null);

$xpath->registerNamespace('opf', $namespace);
$xpath->registerNamespace('dc', 'http://purl.org/dc/elements/1.1/');

// Titel abrufen
$titleNode = $xpath->query('/opf:package/opf:metadata/dc:title/text()')->item(0);
$title = $titleNode->nodeValue;

// Autor abrufen
$authorNode = $xpath->query('/opf:package/opf:metadata/dc:creator/text()')->item(0);
$author = $authorNode->nodeValue;

// Beschreibung abrufen
$descriptionNode = $xpath->query('/opf:package/opf:metadata/dc:description/text()')->item(0);
$description = $descriptionNode->nodeValue;

// Weitere Metadaten abrufen...

// Ausgabe der Metadaten
echo "Titel: $title\n";
echo "Autor: $author\n";
echo "Beschreibung: $description\n";
