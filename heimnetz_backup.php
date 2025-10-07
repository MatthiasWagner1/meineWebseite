<!doctype html>
<html lang=de>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../heimnetz_formate.css" type="text/css">
  <title>Heimnetz</title>
</head>
<body>

  <header>
    <?php
    include "header.php"; // die Menüs einbinden
    ?>
  </header>

<!-- ab hier kommt nur noch Text -->
<main>

<?php
 include "heimnetz_verbinden.php"; // db wird geöffnet
?>


<?php

// Sensor1 Daten aus der DB lesen
$sensor1 = "home/temp/D1_Mini_2";
$sensor1_text = "Terrasse";
$sensor1_zeit = "";
$sensor1_temperatur = "";

$sql = "SELECT temperatur, topic, zeit, id FROM sensor_daten WHERE topic = '$sensor1' ORDER BY ID DESC LIMIT 1";
foreach ($pdo->query($sql) as $row) {
   $id = $row['id'];
   $topic = $row['topic'];
   $sensor1_temperatur = $row['temperatur'];
   $sensor1_zeit = $row['zeit'];
   $sensor1_zeit = substr($sensor1_zeit, -8, 5);
}

// Sensor2 Daten aus der DB lesen
$sensor2 = "home/temp/D1_Mini_1";
$sensor2_text = "Arbeitszimmer";
$sensor2_zeit = "";
$sensor2_temperatur = "";

$sql = "SELECT temperatur, topic, zeit, id FROM sensor_daten WHERE topic = '$sensor2' ORDER BY ID DESC LIMIT 1";
foreach ($pdo->query($sql) as $row) {
   $id = $row['id'];
   $topic = $row['topic'];
   $sensor2_temperatur = $row['temperatur'];
   $sensor2_zeit = $row['zeit'];
   $sensor2_zeit = substr($sensor2_zeit, -8, 5);
}

$sensor = $sensor1;
$sensor_text = $sensor1_text;

$i=$_REQUEST['i']; // der übergebene Sensor
if ($i == 0) {
  
} elseif ($i == 1) {
    $sensor = $sensor1;
    $sensor_text = $sensor1_text;
} elseif ($i == 2) {
    $sensor = $sensor2;
    $sensor_text = $sensor2_text;
}
?>

<h1>Heimnetz - Temperaturen </h1>
<br>

<form method='post' >
      <input type="text" value="<?php echo date("Y-m-d"); ?>" name="selectedDate"/>

      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">
  </form>
<br>

<!-- Darstellung der aktuellen Sensor Daten in der grauen Box  -->

<!-- Sensor 1 -->
<div class="flex-container">
  <div>
  <h5><a href="heimnetz.php?i=1"> <?php echo $sensor1_text?></a></h5>
    <br>
    <?php
      echo "aktuell: <grad>".$sensor1_temperatur."°</grad>";
    ?>
    <br>
    <?php
      echo $sensor1_zeit;
    ?>
  </div>

  <!-- Sensor 2 -->
  <div>
  <h5><a href="heimnetz.php?i=2"> <?php echo $sensor2_text?></a></h5>
    <br>
    <?php
      echo "aktuell: <grad>".$sensor2_temperatur."°</grad>";
    ?>
    <br>
    <?php
      echo $sensor2_zeit;
    ?>
  </div>
</div>
 
<!-- hier werden die Daten der Datenbank verarbeitet -->

<?php

$datum = date("Y-m-d"); 

//$daten = array($datum);
// es werden alle Datensätze geladen
$sql = "SELECT temperatur, topic, zeit, id FROM sensor_daten WHERE topic = '$sensor' ORDER BY ID DESC";
foreach ($pdo->query($sql) as $row) {
   $id = $row['id'];
   $topic = $row['topic'];
   $sensor_temperatur = $row['temperatur'];
   $sensor_zeit = $row['zeit'];
   $aktueller_tag = substr($sensor_zeit, 0, 10);  // das Datum des gerade gelesenen Datensatzes
   $jahr = substr($sensor_zeit, 0, 4);
   $monat = substr($sensor_zeit, 5, 2);
   $tag = substr($sensor_zeit, 8, 2);
   $stunde = substr($sensor_zeit, 11, 2);
   //$minute = substr($sensor_zeit, 14, 2);
   
   
   // hier werden die Daten vom gewählten Tag bearbeitet
   if ($aktueller_tag == $datum) {
      //echo $sensor_zeit." = ".$sensor_temperatur."<br>";
      //echo "Stunde= ".$stunde."<br>";
      //echo $stunde.": ".$sensor_temperatur.", ";
      // hier wird der String $stunde erstellt. 00 bis 23
      for($i=0; $i < 24; $i++) {
        //echo $i;
        if ($i < 10) {
          $z="0";
        }
        else {
          $z="";
        };
        $si = $z.$i;
            //echo $si."<br>";

        if ($stunde == "$si") {              // hier wird die Temp der Stunde ins array geschrieben, 
          if (empty($daten[$i])) {           // nur 1 wert
          $daten[$i] = substr($sensor_temperatur, 0, 4);
          //echo $daten[$i].", ";
        };
      }
     }
  }
}

?>

 <!-- hier werden die Daten für den gewählten Sensor ausgegeben -->

 <br>
<?php
  echo $sensor_text; // 
?>
 <br>
 <table>
 <thead>
 <tr> 
        <th>Tag</th><th>00</th><th>01</th><th>02</th><th>03</th><th>04</th><th>05</th><th>06</th><th>07</th><th>08</th>
        <th>09</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th>
        <th>19</th><th>20</th><th>21</th><th>22</th><th>23</th>
    </tr>
</thead> 
  <tr>
    <th><?php echo substr($datum, -2, 2).".".substr($datum, -5, 2);?> </th> <!-- hier wird das Datum geschrieben -->
     <?php
       for($i=0; $i < 24; $i++) {           //hier werden die Daten aus dem array geholt und geschrieben
         echo "<td>".$daten[$i]."</td>";
        }
      ?>  
  </tr>
</table>
<br>
</main>
</body>
</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>
