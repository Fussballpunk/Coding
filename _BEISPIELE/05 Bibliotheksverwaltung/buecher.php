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
		<title>Bibliotheksverwaltung</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Bibliotheksverwaltung</h1>
		<nav>
			<ul>
				<li><a href="user.php">User</a></li>
				<li><a href="ausgeborgt.php">Ausgeborgte Bücher</a></li>
				<li><a href="buecher.php">Bücher</a></li>
			</ul>
		</nav>
		<form method="post">
			<label>
				Buchtitel:
				<input type="text" name="Titel">
			</label>
			<label>
				Erscheinungsjahr:
				<input type="number" name="Jahr" max="<?php echo(date("Y")); ?>">
			</label>
			<input type="submit" value="filtern">
		</form>
		<ul>
			<?php
			$where = "";
			if(count($_POST)>0) {
				$arr = [];
				if(strlen($_POST["Titel"])>0) {
					$arr[] = "tbl_buecher.Titel='" . $_POST["Titel"] . "'";
				}
				if(strlen($_POST["Jahr"])>0) {
					$arr[] = "YEAR(tbl_buecher.Erscheinungsdatum)=" . $_POST["Jahr"];
				}
				
				if(count($arr)>0) {
					$where = "
						WHERE(
							" . implode(" AND ",$arr) . "
						)
					";
				}
			}
			
			$sql = "
				SELECT
					tbl_buecher.IDBuch,
					tbl_buecher.Titel,
					tbl_buecher.ISBN,
					tbl_buecher.Erscheinungsdatum,
					tbl_verlage.Verlag,
					tbl_verlage.Ort,
					tbl_staaten.Staat
				FROM tbl_buecher
				INNER JOIN tbl_verlage ON tbl_verlage.IDVerlag=tbl_buecher.FIDVerlag
				INNER JOIN tbl_staaten ON tbl_staaten.IDStaat=tbl_verlage.FIDStaat
				" . $where . "
				ORDER BY tbl_buecher.Titel ASC
			";
			ta($sql);
			$buecher = dbQuery($conn,$sql);
			while($buch = $buecher->fetch_object()) {
				echo('
					<li>
						' . $buch->Titel . ', erschienen am ' . $buch->Erscheinungsdatum . ' im Verlag ' . $buch->Verlag . ' (' . $buch->Ort . ', ' . $buch->Staat . '), ISBN ' . $buch->ISBN . '
						<ul>
				');
				
				// ---- Autoren je Buch: ----
				$sql = "
					SELECT
						tbl_autoren.Titel,
						tbl_personen.Vorname,
						tbl_personen.Nachname
					FROM tbl_buecher_autoren
					INNER JOIN tbl_autoren ON tbl_autoren.IDAutor=tbl_buecher_autoren.FIDAutor
					INNER JOIN tbl_personen ON tbl_personen.IDPerson=tbl_autoren.FIDPerson
					WHERE(
						tbl_buecher_autoren.FIDBuch=" . $buch->IDBuch . "
					)
				";
				$autoren = dbQuery($conn,$sql);
				while($autor = $autoren->fetch_object()) {
					echo('
						<li>' . $autor->Nachname . ' ' . $autor->Vorname . ', ' . $autor->Titel . '</li>
					');
				}
				// --------------------------
				
				echo('
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>