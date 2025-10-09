
<?php
$filename = '/var/www/html/ebooks/Benedict Wells - Vom Ende der Einsamkeit.epub';

$zip = new ZipArchive();
if ($zip->open($filename) === true) {
    $metadataFile = $zip->getFromName('META-INF/container.xml');
    $container = new DOMDocument();
    $container->loadXML($metadataFile);
    $rootfiles = $container->getElementsByTagName('rootfile');
    if ($rootfiles->length > 0) {
        $rootfile = $rootfiles->item(0);
        $rootfilePath = $rootfile->getAttribute('full-path');
        $opfFile = $zip->getFromName($rootfilePath);
        $opf = new DOMDocument();
        $opf->loadXML($opfFile);

        $title = $opf->getElementsByTagName('title')->item(0)->nodeValue;
        $author = $opf->getElementsByTagName('creator')->item(0)->nodeValue;

        echo "Titel: $title\n";
        echo "Autor: $author\n";

    } else {
        echo "Keine rootfile-Elemente gefunden.";
    }
    $zip->close();
} else {
    echo "Fehler beim Öffnen der EPUB-Datei.";
}
?>


