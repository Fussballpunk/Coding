<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

// Schritt 1: Verbindung zu einem DB-Server herstellen und dort eine Datenbank auswählen
$conn = dbConnect(); //ruft die Funktion dbConnect auf, die uns ein mysqli-Verbindungsobjekt zurückliefert
//ta($conn);

// Schritt 2: "Was wollen wir eigentlich nun mit der Datenbank tun?" --> ein SQL-Statement (als Text/String) formulieren
$sql = "
	SELECT
		*
	FROM tbl_user
";

// Schritt 3: Das als String formulierte SQL-Statement an den DB-Server übertragen und die Antwort des DB-Servers entgegennehmen
$antwort = dbQuery($conn,$sql);
ta($antwort);

// Schritt 4: Die Antwort des DB-Servers auswerten
/*
$datensatz = $antwort->fetch_array(); //liefert den nächsten noch nicht gelesenen Datensatz aus der Datensatzmenge zurück
ta($datensatz);

$datensatz = $antwort->fetch_assoc();
ta($datensatz);

$datensatz = $antwort->fetch_object();
ta($datensatz);
*/

/*
$datensaetze = $antwort->fetch_all(MYSQLI_ASSOC); //holt sämtliche Daten aus dem Ergebnisobjekt ($antwort) in Form eines assoziativen Arrays
ta($datensaetze);
*/

while($datensatz = $antwort->fetch_object()) {
	ta($datensatz);
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Datenbanken</title>
	<link rel="stylesheet" href="css/common.css">
</head>

<body>
	<p>Hallo Welt!</p>
</body>
</html>