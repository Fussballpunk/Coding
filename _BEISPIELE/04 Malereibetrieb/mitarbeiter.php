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
		<title>Malereibetrieb</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Malereibetrieb</h1>
		<nav>
			<ul>
				<li><a href="mitarbeiter.php">Mitarbeiter</a></li>
				<li><a href="kunden.php">Einsätze beim Kunden</a></li>
			</ul>
		</nav>
		<form method="post">
			<fieldset>
				<legend>Mitarbeiter</legend>
				<label>
					Nachname:
					<input type="text" name="MaNN">
				</label>
				<label>
					Vorname:
					<input type="text" name="MaVN">
				</label>
			</fieldset>
			<fieldset>
				<legend>Kunde</legend>
				<label>
					Nachname:
					<input type="text" name="KdNN">
				</label>
				<label>
					Vorname:
					<input type="text" name="KdVN">
				</label>
			</fieldset>
			<input type="submit" value="filtern">
		</form>
		
		<ul>
			<?php
			$where_ma = "";

			if(count($_POST)>0) {
				// ---- Mitarbeiter: ----
				$arr_ma = [];
				
				if(strlen($_POST["MaNN"])>0) {
					$arr_ma[] = "Nachname='" . $_POST["MaNN"] . "'";
				}
				if(strlen($_POST["MaVN"])>0) {
					$arr_ma[] = "Vorname='" . $_POST["MaVN"] . "'";
				}
				
				if(count($arr_ma)>0) {
					$where_ma = "
						WHERE(
							" . implode(" AND ",$arr_ma) . "
						)
					";
				}
				// ----
			}
			
			$sql = "
				SELECT
					Vorname,
					Nachname,
					IDMitarbeiter
				FROM tbl_mitarbeiter
			" . $where_ma . "
				ORDER BY Nachname ASC, Vorname ASC
			";
			//ta($sql);
			$maliste = dbQuery($conn,$sql);
			while($ma = $maliste->fetch_object()) {
				echo('
					<li>
						' . $ma->Nachname . ' ' . $ma->Vorname . ':
						<ul>
				');
				
				// ---- Einsätze je Mitarbeiter: ----
				$arr_kd = [];
				$arr_kd = ["tbl_einsatz.FIDMitarbeiter=" . $ma->IDMitarbeiter];
				
				if(count($_POST)>0) {
					if(strlen($_POST["KdNN"])>0) {
						$arr_kd[] = "Nachname='" . $_POST["KdNN"] . "'";
					}
					if(strlen($_POST["KdVN"])>0) {
						$arr_kd[] = "Vorname='" . $_POST["KdVN"] . "'";
					}
				}
				// ----

				$sql = "
					SELECT
						tbl_einsatz.Startzeitpunkt,
						tbl_einsatz.Endzeitpunkt,
						tbl_kunden.Vorname,
						tbl_kunden.Nachname
					FROM tbl_einsatz
					LEFT JOIN tbl_kunden ON tbl_kunden.IDKunde=tbl_einsatz.FIDKunde
					WHERE(
						" . implode(" AND ",$arr_kd) . "
					)
					ORDER BY tbl_einsatz.Startzeitpunkt ASC
				";
				//ta($sql);
				$einsaetze = dbQuery($conn,$sql);
				while($einsatz = $einsaetze->fetch_object()) {
					echo('
						<li>
							' . $einsatz->Startzeitpunkt . ' bis ' . $einsatz->Endzeitpunkt . ' bei ' . $einsatz->Nachname . ' ' . $einsatz->Vorname . '
						</li>
					');
				}
				// ----------------------------------
				
				echo('
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>