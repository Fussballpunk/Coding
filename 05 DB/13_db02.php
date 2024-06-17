<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();

//sämtliche Datensätze, pro Datensatz sämtliche Spalten
$sql = "
	SELECT
		*
	FROM tbl_user
";

//sämtliche Datensätze, jedoch nur die Spalten Emailadresse, Passwort und RegZeitpunkt
$sql = "
	SELECT
		Emailadresse,
		Passwort,
		RegZeitpunkt
	FROM tbl_user
";

//diejenigen Datensätze, die ein leeres Geburtsdatum aufweisen und wo der Nachname mit "Müller" endet; pro Datensatz erhalten wir die Spalten Emailadresse, GebDatum und Nachname
$sql = "
	SELECT
		Emailadresse,
		GebDatum,
		Nachname
	FROM tbl_user
	WHERE(
		GebDatum IS NULL AND
		Nachname LIKE '%Müller'
	)
";

//diejenigen Datensätze, die ein leeres Geburtsdatum aufweisen; pro Datensatz erhalten wir die Spalten Vorname, Nachname und GebDatum; die Datensätze sind zunächst aufsteigend nach dem Nachname und innerhalb der sortierten Nachnamen nach dem Vornamen sortiert
$sql = "
	SELECT
		Vorname,
		Nachname,
		GebDatum
	FROM tbl_user
	WHERE(
		GebDatum IS NULL
	)
	ORDER BY Nachname ASC, Vorname ASC
";

//diejenigen Datensätze, die ein leeres Geburtsdatum aufweisen; pro Datensatz erhalten wir die Spalten Vorname, Nachname und GebDatum; die Datensätze sind zunächst aufsteigend nach dem Nachname und innerhalb der sortierten Nachnamen nach dem Vornamen sortiert; davon erhalten wir ab dem fünften Datensatz drei Datensätze (die Datenssätze 0 bis 4 werden nicht dargestellt)
$sql = "
	SELECT
		Vorname,
		Nachname,
		GebDatum
	FROM tbl_user
	WHERE(
		GebDatum IS NULL
	)
	ORDER BY Nachname ASC, Vorname ASC
	LIMIT 15,3
";

$antwort = dbQuery($conn,$sql);
ta($antwort);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Datenbanken</title>
	<link rel="stylesheet" href="css/common.css">
</head>

<body>
	<?php
	while($datensatz = $antwort->fetch_object()) {
		ta($datensatz);
	}
	?>
</body>
</html>