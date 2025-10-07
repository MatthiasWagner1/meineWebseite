<?php
// $pdo = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');

include "heimnetz_verbinden.php"; // db wird geöffnet

echo "DB geöffnet"."<br />";


$sql = "SELECT temperatur, topic, zeit, id FROM sensor_daten ORDER BY ID DESC LIMIT 2";
foreach ($pdo->query($sql) as $row) {
   echo "ID: ".$row['id']."<br /><br />";
   echo $row['temperatur']." ".$row['topic']."<br />";
   echo "Zeit: ".$row['zeit']."<br /><br />";
}
?>


