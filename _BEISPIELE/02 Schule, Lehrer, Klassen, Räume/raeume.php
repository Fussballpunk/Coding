<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();

ta($_POST);
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
			// ---- ausgehend von den Räumen: beachte: 1:1-Beziehung, weshalb ein LEFT JOIN von tbl_raeume auf tbl_klassen erlaubt ist: ----
			$sql = "
				SELECT
					tbl_raeume.Bezeichnung AS Raum,
					tbl_klassen.Bezeichnung AS Klasse
				FROM tbl_raeume
				LEFT JOIN tbl_klassen ON tbl_klassen.FIDRaum=tbl_raeume.IDRaum
			";
			// ----
			
			// ---- ausgehend von der Klasse: 1:1-Beziehung --> RIGHT JOIN passt hervorragend: ----
			$sql = "
				SELECT
					tbl_raeume.Bezeichnung AS Raum,
					tbl_klassen.Bezeichnung AS Klasse
				FROM tbl_klassen
				RIGHT JOIN tbl_raeume ON tbl_klassen.FIDRaum=tbl_raeume.IDRaum
			";
			// ----
			
			$raeume = dbQuery($conn,$sql);
			while($raum = $raeume->fetch_object()) {
				echo('
					<li>' . $raum->Raum . ': Klasse ' . $raum->Klasse . '</li>
				');
			}
			?>
		</ul>
	</body>
</html>