<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();

ta($_POST);

if(count($_POST)>0) {
	switch(true) {
		case isset($_POST["btnDel"]):
			$sql = "
				DELETE FROM tbl_mitglieder_gruppen
				WHERE(
					IDMitgliedGruppe=" . $_POST["btnDel"] . "
				)
			";
			$ok = dbQuery($conn,$sql);
			break;
		
		case isset($_POST["btnAdd"]):
			$idGruppe = $_POST["btnAdd"];
			$sql = "
				INSERT INTO tbl_mitglieder_gruppen
					(FIDGruppe, FIDMitglied)
				VALUES (
					" . $idGruppe . ",
					" . $_POST["MGListe_" . $idGruppe] . "
				)
			";
			//ta($sql);
			$ok = dbQuery($conn,$sql);
			break;
	}
}
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
		<ol>
			<?php
			$sql = "
				SELECT
					tbl_mitglieder.Vorname,
					tbl_mitglieder.Nachname,
					SUM(tbl_ausfluege.Distanz) AS km
				FROM tbl_mitglieder_ausfluege
				INNER JOIN tbl_mitglieder ON tbl_mitglieder.IDMitglied=tbl_mitglieder_ausfluege.FIDMitglied
				INNER JOIN tbl_ausfluege ON tbl_ausfluege.IDAusflug=tbl_mitglieder_ausfluege.FIDAusflug
				WHERE(
					tbl_ausfluege.Ende<NOW()
				)
				GROUP BY tbl_mitglieder.IDMitglied
				ORDER BY km DESC
			";
			$liste = dbQuery($conn,$sql);
			while($eintrag = $liste->fetch_object()) {
				echo('
					<li>' . $eintrag->km . ' km: ' . $eintrag->Nachname . ' ' . $eintrag->Vorname . '</li>
				');
			}
			?>
		</ol>
	</body>
</html>