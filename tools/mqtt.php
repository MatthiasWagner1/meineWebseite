<?php
include('phpMQTT.php');

$server = '192.168.59.67';        // change if necessary
$port = 1883;                     // change if necessary
$username = '';                   // set your username
$password = '';                   // set your password
$client_id = 'phpMQTT-subscribe-msg'; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);
if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

echo $mqtt->subscribeAndWaitForMessage('home/temp/azi', 0);

$mqtt->close();


?>