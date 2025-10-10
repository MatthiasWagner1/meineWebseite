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

require_once './BookGluttonEpub.php';
require_once './BookGluttonZipEpub.php';
$file = './H. G. Wells - The War of the Worlds.epub';
echo "Opening {$file} as OPS in temp dir:\n";
$epub = new BookGluttonEpub();
$epub->setLogVerbose(true);
$epub->setLogLevel(2);
$epub->open($file);
print_r($epub->getMetaPairs());
echo "Now opening {$file} as virtual zip (no filesystem on disk):\n";
$epub = new BookGluttonZipEpub();
$epub->enableLogging();
$epub->loadZip($file);
print_r($epub->getMetaPairs());
echo "There are " . $epub->getFlatNav()->length . " navPoints here.\n";
echo "NCX:\n";
foreach ($epub->getFlatNav() as $np) {
    echo $np->nodeValue . "\n";
}
?>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
