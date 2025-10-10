<?php
//Tragen Sie hier Ihre Datenbankinformationen ein und den Namen der Backup-Datei
$mysqlDatabaseName ='musiksammlung';
$mysqlUserName ='matthias';
$mysqlPassword ='seppel';
$mysqlHostName ='localhost';
$mysqlImportFilename ='sicherung_musik2018-01-10.sql';

//Bei den folgenden Punkten bitte keine Änderung durchführen
//Import der Datenbank und Ausgabe des Status
$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
exec($command,$output=array(),$worked);
switch($worked){
case 0:
echo 'Die DAten aus der Datei <b>' .$mysqlImportFilename .'</b> wurden erfolgreich eingespielt in der Datenbank <b>' .$mysqlDatabaseName .'</b>';
break;
case 1:
echo 'Beim Import ist ein Fehler aufgetreten. Bitte prüfe, ob die Datei im gleichen Ordner wie dieses Skript abgelegt ist. Prüfe auch die folgenden Daten noch einmal:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Dateiname:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
break;
}
?>
