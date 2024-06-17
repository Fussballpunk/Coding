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
		<form method="post">
		<?php
		$sql = "
			SELECT
				*
			FROM tbl_gruppen
			ORDER BY Gruppenname ASC
		";
		$gruppen = dbQuery($conn,$sql);
		while($gruppe = $gruppen->fetch_object()) {
			echo('
				<article>
					<h2>' . $gruppe->Gruppenname . '</h2>
					<div>' . $gruppe->Beschreibung . '</div>
					<ul>
			');
			
			// ---- Mitglieder der jeweiligen Gruppe: ----
			$arr_mg = [];
			$sql = "
				SELECT
					tbl_mitglieder.*,
					tbl_mitglieder_gruppen.IDMitgliedGruppe
				FROM tbl_mitglieder_gruppen
				INNER JOIN tbl_mitglieder ON tbl_mitglieder.IDMitglied=tbl_mitglieder_gruppen.FIDMitglied
				WHERE(
					tbl_mitglieder_gruppen.FIDGruppe=" . $gruppe->IDGruppe . "
				)
			";
			$mgliste = dbQuery($conn,$sql);
			while($mg = $mgliste->fetch_object()) {
				echo('
					<li>' . $mg->Nachname . ' ' . $mg->Vorname . ' (' . $mg->Emailadresse . ') <button type="submit" name="btnDel" value="' . $mg->IDMitgliedGruppe . '">x</button></li>
				');
				$arr_mg[] = "IDMitglied<>" . $mg->IDMitglied;
			}
			// -------------------------------------------
			echo('
					</ul>
					<select name="MGListe_' . $gruppe->IDGruppe . '">
			');
			
			// ---- neue Mitglieder hinzufügen: ----
			// Schritt 1: bestehende Mitglieder Gruppe ermitteln: erledigt
			// Schritt 2: alle bereits vorhandenen Mitglieder der Gruppe aussschließen
			// Variante 1:
			$where = "";
			if(count($arr_mg)>0) {
				$where = "
					WHERE(
						" . implode(" AND ",$arr_mg) . "
					)
				";				
			}
			
			$sql = "
				SELECT
					Vorname,
					Nachname,
					IDMitglied
				FROM tbl_mitglieder
				WHERE(
					IDMitglied NOT IN (
						SELECT
							FIDMitglied
						FROM tbl_mitglieder_gruppen
						WHERE(
							FIDGruppe=" . $gruppe->IDGruppe . "
						)
					)
				)
				ORDER BY Nachname ASC, Vorname ASC
			";
			// Ende Variante 1
			
			// Variante 2:
			$sql = "
				SELECT
					Vorname,
					Nachname,
					IDMitglied
				FROM tbl_mitglieder
				" . $where . "
				ORDER BY Nachname ASC, Vorname ASC
			";
			// Ende Variante 2
			
			$mgliste = dbQuery($conn,$sql);
			while($mg = $mgliste->fetch_object()) {
				echo('
					<option value="' . $mg->IDMitglied . '">' . $mg->Nachname . ' ' . $mg->Vorname . '</option>
				');
			}
			
			echo('
					</select>
					<button type="submit" name="btnAdd" value="' . $gruppe->IDGruppe . '">+</button>
				</article>
			');
			//ta($sql);
		}
		?>
		</form>
	</body>
</html>