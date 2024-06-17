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
		<style>
			.H {
				display:none;
			}
			ul a,
			ul span {
				text-decoration:underline;
				cursor:pointer;
			}
		</style>
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
				von:
				<input type="date" name="von">
			</label>
			<label>
				bis:
				<input type="date" name="bis">
			</label>
			<input type="submit" value="filtern">
		</form>
		<ul>
			<?php
			$arr = ["tbl_ausborgeliste.Ende IS NULL"];
			if(count($_POST)>0) {
				if(strlen($_POST["von"])>0) {
					$arr[] = "tbl_ausborgeliste.Beginn>='" . $_POST["von"] . "'";
				}
				if(strlen($_POST["bis"])>0) {
					$arr[] = "tbl_ausborgeliste.Beginn<='" . $_POST["bis"] . "'";
				}
			}
			
			$sql = "
				SELECT
					tbl_ausborgeliste.Beginn,
					tbl_buecher.Titel,
					tbl_personen.Vorname,
					tbl_personen.Nachname,
					tbl_user.IDUser,
					tbl_user.Adresse,
					tbl_user.PLZ,
					tbl_user.Ort,
					tbl_user.Emailadresse
				FROM tbl_ausborgeliste
				INNER JOIN tbl_buecher ON tbl_buecher.IDBuch=tbl_ausborgeliste.FIDBuch
				INNER JOIN tbl_user ON tbl_user.IDUser=tbl_ausborgeliste.FIDUser
				INNER JOIN tbl_personen ON tbl_personen.IDPerson=tbl_user.FIDPerson
				WHERE(
					" . implode(" AND ",$arr) . "
				)
				ORDER BY tbl_ausborgeliste.Beginn DESC
			";
			ta($sql);
			$buecher = dbQuery($conn,$sql);
			while($buch = $buecher->fetch_object()) {
				echo('
					<li>
						' . $buch->Beginn . ': ' . $buch->Titel . ', ausgeborgt von <span onclick="document.querySelector(\'#adresse_' . $buch->IDUser . '\').classList.toggle(\'H\');">' . $buch->Nachname . ' ' . $buch->Vorname . '</span>
						<address class="H" id="adresse_' . $buch->IDUser . '">
							' . $buch->Adresse . ', ' . $buch->PLZ . ' ' . $buch->Ort . '<br>
							' . $buch->Emailadresse . '
						</address>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>