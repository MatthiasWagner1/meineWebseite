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






 
<?php

require_once('./BookGluttonEpub.php');
require_once('./BookGluttonZipEpub.php');

/*

Example and test script using the libraries to rename files
according to metadata found in the epub file.


*/

//$dir = realpath(dirname(__FILE__)).'/epubs/';
//$dir = $argv[1];
$dir = '/var/www/html/meineWebseite/html/ebooks/';
$dh = opendir($dir);

echo $dir;
echo '<br>';
$ite=new RecursiveDirectoryIterator($dir);

$bytestotal=0;
$nbfiles=0;

foreach (new RecursiveIteratorIterator($ite) as $file=>$cur) {
	
		if(!preg_match('/\.epub$/i',$file)) continue;
	
    $filesize=$cur->getSize();
    $bytestotal+=$filesize;
    $nbfiles++;
    //echo "$file => $filesize\n";

		try {

			$epub = new BookGluttonZipEpub();
			$epub->enableLogging();
			$epub->loadZip($file);
			$title = $epub->getTitle();
			$author = $epub->getAuthor();
			//$epub->close();

			// how you do the actual rename is up to you -- our example
			// just echoes what the operation will do:
			$newtitle = preg_replace('/[\$\'\\\!\`\~\/\>\<\}\{\@\^\*]/',"","$author - $title".".epub");
			echo "rename to ".$newtitle."\n";
				
			if(!is_dir("$dir/$author")) {
				mkdir("$dir/$author");
			}
		
			rename($file,"$dir/$author/$newtitle");

		} catch (Exception $e) {
		
			// BAD FILES go to bad file GHETTO
		
			echo "Exception caught:".$e->getMessage()."\n----------\n";
			
			rename($file,$dir.'/_GHETTO.'.$newtitle);
			
			echo "Moved to ghetto.\n------------\n=============\n";
			
		
		}
		
}

$bytestotal=number_format($bytestotal);
echo "Total: $nbfiles files, $bytestotal bytes\n";









?>

</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>