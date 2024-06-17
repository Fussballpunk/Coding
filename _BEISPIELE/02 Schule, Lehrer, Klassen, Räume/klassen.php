<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Schule</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Schule</h1>
		<nav>
			<ul>
				<li><a href="klassen.php">Klassen</a></li>
				<li><a href="schueler.php">Schüler</a></li>
				<li><a href="raeume.php">Räume</a></li>
			</ul>
		</nav>
		<ul>
			<?php
			$sql = "
				SELECT
					tbl_klassen.IDKlasse,
					tbl_klassen.Bezeichnung AS Klasse,
					tbl_raeume.Bezeichnung AS Raum,
					tbl_lehrer.Vorname,
					tbl_lehrer.Nachname
				FROM tbl_klassen
				LEFT JOIN tbl_raeume ON tbl_raeume.IDRaum=tbl_klassen.FIDRaum
				LEFT JOIN tbl_lehrer ON tbl_lehrer.IDLehrer=tbl_klassen.FIDKV
			";
			$klassen = dbQuery($conn,$sql);
			while($klasse = $klassen->fetch_object()) {
				echo('
					<li>
						' . $klasse->Klasse . ': Raum ' . $klasse->Raum . ', KV ' . $klasse->Vorname . ' ' . $klasse->Nachname . '
						<ul>
				');
				
				// ---- Schüler je Klasse: ----
				$sql = "
					SELECT
						Vorname,
						Nachname,
						GebDatum
					FROM tbl_schueler
					WHERE(
						FIDKlasse=" . $klasse->IDKlasse . "
					)
				";
				$schuelerliste = dbQuery($conn,$sql);
				while($s = $schuelerliste->fetch_object()) {
					echo('<li>' . $s->Vorname . ' ' . $s->Nachname . ', geb. ' . $s->GebDatum . '</li>');
				}
				// ----------------------------
				
				echo('
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>