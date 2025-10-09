<!doctype html>
<html lang=de>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
  <link rel="stylesheet" href="../diba_formate.css" type="text/css">
  <title>ING</title>
</head>

<body>
  <header>
    <?php
    include "header.php"; // die Menüs einbinden
    ?>
  </header>

  <main>

    <br>

    <!--  -->
    <form method='post'>
      <input formaction="heimnetz_ip.php" type="Submit" name="" value="IP Adressen">
      <input formaction="heimnetz.php" type="Submit" name="" value="Temperaturen">
      <input formaction="diba.php" type="Submit" name="" value="ING">
    </form>


    <h1><a href="heimnetz.php"> Heimnetz - Konten</a></h1>
    <?php

    include "heimnetz_verbinden.php"; // db wird geöffnet

    // hier wird der erste Datensatz geholt für Konto Matthias, Name und Saldo
    $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = 1 ORDER BY datum DESC LIMIT 1");
    $result = $erg->execute();
    while ($data = $erg->fetch()) {
      $id = $data['id'];
      $konto = $data['konto'];
      $saldo = $data['saldo'];

      // Datum in dd.mm.yyyy umwandeln
      $originalDate = $data['datum'];
      //original date is in format YYYY-mm-dd
      $timestamp = strtotime($originalDate);
      $datum = date("d.m.Y", $timestamp);

      $name = "Matthias";
      $iban = "DE87 5001 0517 5429 1557 53";
    }
    ?>

    <!-- Darstellung der Konten in der grauen Box  -->
    <!-- Matthias -->
    <div class="flex-container">
      <div>
        <h5><a href="diba.php"> DiBa <?php echo $name ?></a></h5>
        <br>
        <?php
        echo "Saldo: <saldo>€ " . $saldo . "</saldo>";
        ?>
        <br>
        <?php
        echo "am " . $datum;
        echo "<br><iban>" . $iban . "</iban>";
        ?>
      </div>

      <?php
      // hier wird der erste Datensatz geholt für Konto Claudia, Name und Saldo
      $erg = $pdo->prepare("SELECT * FROM konten WHERE konto = 2 ORDER BY datum DESC LIMIT 1");
      $result = $erg->execute();
      while ($data = $erg->fetch()) {
        $id = $data['id'];
        $konto = $data['konto'];
        $saldo = $data['saldo'];
        // Datum in dd.mm.yyyy umwandeln
        $originalDate = $data['datum'];
        //original date is in format YYYY-mm-dd
        $timestamp = strtotime($originalDate);
        $datum = date("d.m.Y", $timestamp);
        $name = "Claudia";
        $iban = "DE33 5001 0517 5430 0111 01";
      }

      ?>
      <!-- Darstellung der Konten in der grauen Box  -->
      <!-- Claudia -->
      <div>
        <h5><a href="diba.php"> DiBa <?php echo $name ?></a></h5>
        <br>
        <?php
        echo "Saldo: <saldo>€ " . $saldo . "</saldo>";
        ?>
        <br>
        <?php
        echo "am " . $datum;
        echo "<br><iban>" . $iban . "</iban>";
        ?>

      </div>
    </div>
    <br>

    <div class="privat">
      <table>
        <tr>
          <td><a href="diba_csv_lesen.php" title=""> csv einlesen</a></td>
          <td><a href="diba_buchungen_pruefen.php" title=""> Buchungen prüfen</a></td>
          
        </tr>
      </table>
      <br>


      <?php
      
      // hier holen wir die Filter aus der Datenbank

      $erg = $pdo->prepare("SELECT * FROM konten_filter");
      $result = $erg->execute();
      $data = $erg->fetch();
      $konto = $data['konto'];
      $jahr = $data['jahr'];
      $monat = $data['monat'];
      $kategorie = $data['kategorie'];
      $sortierung = $data['sortierung'];
      $betrag1 = $data['betrag1'];
      $betrag2 = $data['betrag2'];

   
      //$konto = "alle";
      //$jahr = date("Y"); //aktuelles Jahr
      //$monat = date('m', strtotime('-1 month')); // hier wird der letzte Monat gewählt 06 = juni
      //$kategorie = "alle";
      //$sortierung = "datum";

      // falls die Daten vom Formular kommen:
      if (isset(
        $_POST["konto"],
        $_POST["jahr"],
        $_POST["monat"],
        $_POST["kategorie"],
        $_POST["sortierung"],
        $_POST["betrag1"],
        $_POST["betrag2"]
      )) {

        $konto = $_POST['konto'];
        $jahr = $_POST['jahr'];
        $monat = $_POST['monat'];
        $kategorie = $_POST['kategorie'];
        $sortierung = $_POST['sortierung'];
        $betrag1 = intval($_POST['betrag1']);
        $betrag2 = intval($_POST['betrag2']);

        // hier schreiben wir die Filter in die Datenbank

        $qu = "UPDATE heimnetz.konten_filter set konto='$konto', ";
        $qu.="jahr='$jahr', ";
        $qu.="monat='$monat', ";
        $qu.="kategorie='$kategorie', ";
        $qu.="betrag1=$betrag1, ";
        $qu.="betrag2=$betrag2, ";
        // Achtung beim letzten Teil KEIN Komma!!!
        $qu.="sortierung='$sortierung' ";
       
        //echo $qu;
        //exit;
       
        $qu = $pdo->prepare($qu);
        $result = $qu->execute();

      }
      ?>

      <!-- =========================== suche und Filter =========================================================== -->
      <table>
        <div id="filter">
          <form method='post'>
            <!--<label for='suche'></label>-->
            Suchbegriff:<input id='suche' name='suche' value='<?php echo $_POST['suche']; ?>'></td>
            Betrag von:<input id='betrag1' name='betrag1' value='<?php echo $_POST['betrag1']; ?>'></td>
            Betrag bis:<input id='betrag2' name='betrag2' value='<?php echo $_POST['betrag2']; ?>'> (Input leer => alle)</td>
            </tr>
      </table>

      <table>
        <tr>
          <td>Konto: <select name="konto">
              <option <?php if ($konto == "alle") {
                        echo "selected='selected'";
                      }
                      ?> value="alle">Alle</option>
              <option <?php if ($konto == "matthias") {
                        echo "selected='selected'";
                      }
                      ?> value="matthias">Matthias</option>
              <option <?php if ($konto == "claudia") {
                        echo "selected='selected'";
                      }
                      ?> value="claudia">Claudia</option>
            </select></td>

          <td>Jahr: <select name="jahr">
              <option <?php if ($konto == "alle") {
                        echo "selected='selected'";
                      }
                      ?> value="alle">Alle</option>
                            <option <?php if ($jahr == "2025") {
                        echo "selected='selected'";
                      }
                      ?> value="2025">2025</option>
                            <option <?php if ($jahr == "2024") {
                        echo "selected='selected'";
                              }
                              ?> value="2024">2024</option>
                      <option <?php if ($jahr == "2023") {
                                echo "selected='selected'";
                              }
                              ?> value="2023">2023</option>
                      
                      <option <?php if ($jahr == "2022") {
                                echo "selected='selected'";
                              }
                              ?> value="2022">2022</option>
            </select></td>

          <td>Monat: <select name="monat">
              <option <?php if ($monat == "alle") {
                        echo "selected='selected'";
                      }
                      ?> value="alle">Alle</option>
              <option <?php if ($monat == "01") {
                        echo "selected='selected'";
                      }
                      ?> value="01">Januar</option>
              <option <?php if ($monat == "02") {
                        echo "selected='selected'";
                      }
                      ?> value="02">Februar</option>
              <option <?php if ($monat == "03") {
                        echo "selected='selected'";
                      }
                      ?> value="03">März</option>
              <option <?php if ($monat == "04") {
                        echo "selected='selected'";
                      }
                      ?> value="04">April</option>
              <option <?php if ($monat == "05") {
                        echo "selected='selected'";
                      }
                      ?> value="05">Mai</option>
              <option <?php if ($monat == "06") {
                        echo "selected='selected'";
                      }
                      ?> value="06">Juni</option>
              <option <?php if ($monat == "07") {
                        echo "selected='selected'";
                      }
                      ?> value="07">Juli</option>
              <option <?php if ($monat == "08") {
                        echo "selected='selected'";
                      }
                      ?> value="08">August</option>
              <option <?php if ($monat == "09") {
                        echo "selected='selected'";
                      }
                      ?> value="09">September</option>
              <option <?php if ($monat == "10") {
                        echo "selected='selected'";
                      }
                      ?> value="10">Oktober</option>
              <option <?php if ($monat == "11") {
                        echo "selected='selected'";
                      }
                      ?> value="11">November</option>
              <option <?php if ($monat == "12") {
                        echo "selected='selected'";
                      }
                      ?> value="12">Dezember</option>

            </select></td>

          <td>Kategorie: <select name="kategorie" id="kategorie">
              <option value="alle">Alle</option>
              <?php
              include "heimnetz_verbinden.php"; // db wird geöffnet

              $erg = $pdo->prepare("SELECT * FROM konten_kategorie");
              $result = $erg->execute();
              while ($kat = $erg->fetch()) {
                $id = $kat['id_kat'];

                // wenn eine kategorie übergeben wird dann soll es hier selektiert werden
                if ($kategorie == $kat['name_kategorie']) {
                  echo '<option value = ' . $kat['name_kategorie'] . ' selected="selected">' . $kat['name_kategorie'] . '</option>';
                } else {
                  echo '<option value = ' . $kat['name_kategorie'] . '>' . $kat['name_kategorie'] . '</option>';
                }
              }
              ?>
            </select></td>

          <td>Sortierung: <select name="sortierung">
              <option <?php if ($sortierung == "datum") {
                        echo "selected='selected'";
                      }
                      ?> value="datum">Datum</option>
              <option <?php if ($sortierung == "empfang") {
                        echo "selected='selected'";
                      }
                      ?> value="empfang">Empfänger</option>
              <option <?php if ($sortierung == "betrag_ab") {
                        echo "selected='selected'";
                      }
                      ?> value="betrag_ab">Betrag ab</option>
              <option <?php if ($sortierung == "betrag_auf") {
                        echo "selected='selected'";
                      }
                      ?> value="betrag_auf">Betrag auf</option>
              <option <?php if ($sortierung == "kategorie") {
                        echo "selected='selected'";
                      }
                      ?> value="kategorie">Kategorie</option>

            </select></td>

        </tr>

      </table>
    </div>
  
    <input formaction="diba.php" type="Submit" name="" style="height: 30px; width: 150px; margin: 15px 0px" value="anzeigen">
    <input formaction="diba_kategorien.php" type="Submit" name="" style="height: 30px; width: 150px; margin: 15px 0px" value="nach Kategorien">

  </form>

    <!-- ===================== hier wird die variable $erg erstellt ===================================== -->

        <?php

        // echo "Konto: ".$konto."<br>";
        // echo "Jahr: ".$jahr."<br>";
        //echo "monat: ".$monat."<br>";
        //echo "Kategorie: ".$kategorie."<br>";
        //echo "Sortierung: ".$sortierung."<br>";

        //exit;

        $erg = "SELECT * FROM konten";

        if ($konto != "alle") {
          if ($konto == "matthias") {
            $konto_nr = "1";
          }
          if ($konto == "claudia") {
            $konto_nr = "2";
          }
          $abfrage = " WHERE konto = " . $konto_nr;
          $z++;
          $erg .= $abfrage;
        }

        if (!isset($betrag1)or $betrag1 == 0){
          $betrag1 = -1000000; 
        }
        
        if (!isset($betrag2)or $betrag2 == 0){
          $betrag2 = 1000000; 
        }
        //echo $betrag1;
        //exit;

          if ($z == 0) {
            $abfrage = " WHERE betrag BETWEEN $betrag1 AND $betrag2";
          }

          if ($z != 0) {
            $abfrage = " AND betrag BETWEEN $betrag1 AND $betrag2";
          }

          $z++;
          $erg .= $abfrage;
        
        if ($jahr != "alle") {
          if ($z == 0) {
            $abfrage = " WHERE DATE_FORMAT(datum, '%Y')  = " . $jahr;
          }

          if ($z != 0) {
            $abfrage = " AND DATE_FORMAT(datum, '%Y')  = " . $jahr;
          }

          $z++;
          $erg .= $abfrage;
        }

        if ($monat != "alle") {
          if ($z == 0) {
            $abfrage = " WHERE DATE_FORMAT(datum, '%c')  = " . $monat;
          }

          if ($z != 0) {
            $abfrage = " And DATE_FORMAT(datum, '%c')  = " . $monat;
          }

          $z++;
          $erg .= $abfrage;
        }

        if ($kategorie != "alle") {
          if ($z == 0) {
            $abfrage = " WHERE kategorie = '" . $kategorie . "'";
          }

          if ($z != 0) {
            $abfrage = " AND kategorie = '" . $kategorie . "'";
          }

          $z++;
          $erg .= $abfrage;
        }

        if ($sortierung == "empfang") {
          $erg .= " ORDER BY $sortierung ASC"; //oder ASC
        }
        if ($sortierung == "datum") {
          $erg .= " ORDER BY $sortierung DESC"; //oder ASC
        }
        if ($sortierung == "betrag_ab") {
          $erg .= " ORDER BY betrag DESC"; //oder ASC
        }
        if ($sortierung == "betrag_auf") {
          $erg .= " ORDER BY betrag ASC"; //oder DESC
        }
        if ($sortierung == "kategorie") {
          $erg .= " ORDER BY kategorie ASC"; //oder DESC
        }
        
        //echo $erg;
        //echo " Betrag1 ".$betrag1;      
        //echo " Betrag2 ".$betrag2;

        //exit;

        // ==== hier wird der suche string in suche[0] und [1] geschrieben =================================================
        
        if (isset($_POST["suche"])) {
          $eingabe = $_POST['suche'];
          //echo $eingabe;
          //exit;
        } else {
          $eingabe = "";
        }

        $eingabe = $_POST['suche'];

        $suche = explode(" ", $eingabe); // falls 2 Suchbegriff dann zerlegen
        if (empty($suche[1])) { // falls 2. nicht - dann erstellen und wert übergeben
          $suche[1] = substr($suche[0], 0, 1);
        }
        $suche0 = $suche[0]; // damit die variable an die funktion ausgabe übergeben werden kann
        $suche1 = $suche[1];

        //echo "Suche0: ".$suche[0];
        //echo "Suche1: ".$suche[1];
        //echo $erg;

        //exit;






        // =============================== Funktion Ausgabe ==========================================================
        //function ausgabe($erg, $jahr, $monat, $suche0, $suche1)
        function ausgabe($erg, $suche0, $suche1)
        {
          //echo $monat, $jahr;
          $summe = 0;
          $az = 0;
          while ($data = $erg->fetch()) {
            $suche_in = $data['empfang'] . $data['verwendung'] . $data['notiz'];
            $pos = stripos($suche_in, $suche0); // wenn der suchbegriff in datei dann $pos=true
            $pos1 = stripos($suche_in, $suche1); // stripos() Klein- Großschreibung egal

            if ($pos !== false and $pos1 !== false or $suche0 == "") { //wenn es den string gibt ($pos=true) oder suche leer
              $id = $data['id'];
              $konto = $data['konto'];
              if ($konto == 1) {
                $name = "Matthias";
              }
              if ($konto == 2) {
                $name = "Claudia";
              }
              $kategorie = $data['kategorie'];
              $betrag = $data['betrag'];
              $summe = $summe + $betrag;
              $az = $az + 1;

              // Datum in dd.mm.yyyy umwandeln
              $originalDate = $data['datum'];
              //original date is in format YYYY-mm-dd2023.German.AC3.MD.TS.x264-ATOMiCBOMB
              $timestamp = strtotime($originalDate);
              $datum = date("d.m.Y", $timestamp);

              // hier wird der String VISA aus der Darstellung entfernt. Soll der Übersichtlichkeit dienen
              $empfang = $data['empfang'];
              //$empfang = trim($empfang, "VISA"); // funktioniert ungenau
              $empfang = str_replace("VISA", "", $empfang);

              echo '<tr>';
              echo '<td><a href=diba_formular.php?ID=' . $id . '>' . $name . '</a></td>';
              echo '<td><a href=diba_formular.php?ID=' . $id . '>' . $datum . '</a></td>';
              echo '<td><a href=diba_formular.php?ID=' . $id . '>' . $empfang . '</a></td>';

              if ($betrag > 0) {
                echo '<span style="color: red;">';
                echo '<td align=right><font color="green">' . $betrag . '</td>';
                echo '</span>';
              } else {
                echo '<td align=right><a href=diba_formular.php?ID=' . $id . '>' . $betrag . '</a></td>';
              }
              echo '<td align=right><a href=diba_formular.php?ID=' . $id . '>' . $kategorie . '</a></td>';
              echo '</tr>';
            } // End if $pos ....
          } // Ende while schleife
          
          echo '<br>';
          $summe = number_format($summe, 2, ",", ".");

          echo 'Saldo: ' . $summe . ' Anzahl: ' . $az;

        } // Ende Funktion Ausgabe


//echo $erg;
//exit;

?>

<!-- hier wird die Tabelle Kategorien erstellt -->
<div class="privat">
              <table>
                <tr>
                  <th>Kategorie</th>
                  <th>Anzahl</th>
                  <th>Summe</th>
                </tr>
             
              <?php
                $erg1 = $erg;
                $erg1 = $pdo->prepare($erg1);
                $result1 = $erg1->execute();

                $az = 0;
                while ($data = $erg1->fetch()) {
                  $suche_in = $data['empfang'] . $data['verwendung'] . $data['notiz'];
                  $pos = stripos($suche_in, $suche0); // wenn der suchbegriff in datei dann $pos=true
                  $pos1 = stripos($suche_in, $suche1); // stripos() Klein- Großschreibung egal
                  if ($pos !== false and $pos1 !== false or $suche0 == "") { //wenn es den string gibt ($pos=true) oder suche leer
                    $az = $az + 1;

                    $kategorie = $data['kategorie'];
                    $betrag = $data['betrag'];
                    
                    // Datum in dd.mm.yyyy umwandeln
                    $originalDate = $data['datum'];
                    //original date is in format YYYY-mm-dd2023.German.AC3.MD.TS.x264-ATOMiCBOMB
                    $timestamp = strtotime($originalDate);
                    $datum = date("d.m.Y", $timestamp);

                    // hier werden die daten in ein array geschrieben
                    
                    //$buchung[$az]['name'] = $name;
                    //$buchung[$az]['datum'] = $datum;
                    //$buchung[$az]['empfang'] = $empfang;
                    $buchung[$az]['kategorie'] = $kategorie;
                    $buchung[$az]['betrag'] = $betrag;
                    //$buchung['betrag'] = $betrag;
                    //$buchung['kategorie'] = $kategorie;
                    // ===========================================

                  } // End if $pos ....
                } // Ende while schleife
                
                $z1 = 0;
                include "heimnetz_verbinden.php"; // db wird geöffnet
                $erg2 = $pdo->prepare("SELECT * FROM konten_kategorie");
                $result = $erg2->execute();
                while ($kat = $erg2->fetch()) {
                  $kat_betrag[$z1]['kategorie'] = $kat['name_kategorie'];
                  $kat_betrag[$z1]['betrag'] = 0;
                  $z1 = $z1 + 1;
                }
                $z1 = 0;
                foreach ($buchung as  &$value) {
                  for ($z1=0; $z1<count($kat_betrag);$z1++) {
                    if ($value['kategorie'] == $kat_betrag[$z1]['kategorie']) {
                      $kat_betrag[$z1]['betrag'] = $value['betrag'] + $kat_betrag[$z1]['betrag'];
                    }
                  }
                }

                // Ausgabe der Tabelle Kategorien mit Betrag
                $z1 = 0;
                foreach ($kat_betrag as &$value) {
                  $kategorie = $kat_betrag[$z1]['kategorie'];
                  $betrag = $kat_betrag[$z1]['betrag'];
                  echo '<tr>';
                  // im array $buchungen werden kategorien gezählt
                  echo '<td>' . $kategorie . '</td>' . '<td>' . array_count_values(array_column($buchung, 'kategorie'))[$kategorie] . '</td>';
                  $betrag = number_format($betrag, 2, '.', '');
                  echo '<td align=right>' . $betrag . '</td>';
                  echo '</tr>';
                  $z1 = $z1 + 1;
              }
              
              ?>
</table>
</div>

        <!-- hier wird der Tabllenkopf für die Ausgabe erstellt -->
        <div class="privat">
              <table>
                <tr>
                  <th>Konto</th>
                  <th>Datum</th>
                  <th>Empfänger / Gutschrift von</th>
                  <th>Betrag</th>
                  <th>Kategorie</th>
                </tr>
        <?php
        
        $erg = $pdo->prepare($erg);
        $result = $erg->execute();
        
        //ausgabe($erg, $jahr, $monat, $suche0, $suche1);
        ausgabe($erg, $suche0, $suche1);

        ?>
      </table>
    </div>
    <br>
  </main>
</body>

</html>
<?php
include "footer.php"; // die Fusszeile einbinden
?>