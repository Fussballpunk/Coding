<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Fahrradclub</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Fahrradclub</h1>
		<nav>
			<ul>
				<li><a href="mitglieder.php">Mitglieder</a></li>
				<li><a href="gruppen.php">Gruppen</a></li>
				<li><a href="ausfluege.php">Ausflüge</a></li>
				<li><a href="highscore.php">Highscore</a></li>
			</ul>
		</nav>
		<ul>
			<?php
			$sql = "
				SELECT
					*
				FROM tbl_mitglieder
				ORDER BY Nachname ASC, Vorname ASC
			";
			$mgliste = dbQuery($conn,$sql);
			while($mg = $mgliste->fetch_object()) {
				echo('
					<li>' . $mg->Nachname . ' ' . $mg->Vorname . ' (' . $mg->Emailadresse . '):
						<ul>
				');
				
				// ---- Fahrräder je Mitglied: ----
				$sql = "
					SELECT
						tbl_fahrraeder.Modell,
						tbl_fahrradmarken.Markenname,
						tbl_fahrradtypen.Typ
					FROM tbl_fahrraeder
					INNER JOIN tbl_fahrradmarken ON tbl_fahrradmarken.IDFahrradmarke=tbl_fahrraeder.FIDMarke
					INNER JOIN tbl_fahrradtypen ON tbl_fahrradtypen.IDFahrradtyp=tbl_fahrraeder.FIDFahrradtyp
					WHERE(
						tbl_fahrraeder.FIDMitglied=" . $mg->IDMitglied . "
					)
				";
				$bikes = dbQuery($conn,$sql);
				while($bike = $bikes->fetch_object()) {
					echo('<li>' . $bike->Markenname . ' ' . $bike->Modell . ' (' . $bike->Typ . ')</li>');
				}
				// --------------------------------
					
				echo('
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>