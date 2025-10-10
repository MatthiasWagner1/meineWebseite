

// hier öffnen wir die Verbindung zur Datenbank
$mysqli = new mysqli('localhost', 'matthias', 'seppel', 'buecher');
if ($mysqli->connect_error) {
	echo 'Fehler bei der Verbindung: '.mysqli_connect_error();
	exit();
	}
if (!$mysqli->set_charset("utf8")) {
	echo 'Fehler beim Laden von UTF8 '. $mysqli->error;
}

$erg = $mysqli->query("SELECT titel, pfad FROM ebooks order by titel")
	or die($mysqli->error);

// hier wird die Tabelle erstellt
echo 	'<table class="privat" border="1">';
echo 	'<br>';
echo 	'<thead><tr><td>Name</td><td>Pfad</td></tr></thead>';
echo 	'<br>';
echo	'<tbody>';

// hier wird die Datenbank durchlaufen und nach dem Suchbegriff gefiltert
while ($zeile = $erg->fetch_object()) {
	$pos = stripos($zeile->titel, $suche[0]); 	// stripos() Klein- Großschreibung egal
	$pos1 = stripos($zeile->titel, $suche[1]);

	// if ($pos!== false) {
	if ($pos!== false and $pos1!==false) {					//wenn es den string gibt ($pos=true)
		echo '<tr>';
		echo '<td>' . $zeile->titel . '</td>';				// Name und Pfad werde in die Tabelle geschrieben
		echo '<td>' . $zeile->pfad . '</td>';
		echo '</tr>';
		$treffer++;
	}
}

echo'</tbody>';
echo'</table>';

//hier wird die Anzahl der Treffer ggezeigt. id=treffer: an welche position - aus css
echo '<div id = "treffer" >';

if ($erg->num_rows) {
	echo "Datensätze vorhanden: ".$erg->num_rows;
	echo ", Treffer: ".$treffer;
}
echo '</div>';

/*
echo '<div class = "formular" >';
	echo 'Name: '. $eingabe . '<br>';
	echo 'Pfad: ';


echo '</div>';
*/





$erg->free();
$mysqli->close();

