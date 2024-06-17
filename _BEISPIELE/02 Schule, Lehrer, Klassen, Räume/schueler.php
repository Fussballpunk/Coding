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
		<form method="post">
			<label>
				Vorname:
				<input type="text" name="VN">
			</label>
			<label>
				Nachname:
				<input type="text" name="NN">
			</label>
			<input type="submit" value="filtern">
		</form>
		<ul>
			<?php
			$where = "";
			
			if(count($_POST)>0) {
				$arr = [];
				if(strlen($_POST["VN"])>0) {
					$arr[] = "Vorname LIKE '%" . $_POST["VN"] . "%'";
				}
				if(strlen($_POST["NN"])>0) {
					$arr[] = "Nachname LIKE '%" . $_POST["NN"] . "%'";
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
					Vorname,
					Nachname,
					GebDatum
				FROM tbl_schueler
				" . $where . "
				ORDER BY Nachname ASC, Vorname ASC
			";
			//ta($sql);
			$schuelerliste = dbQuery($conn,$sql);
			while($s = $schuelerliste->fetch_object()) {
				echo('
					<li>' . $s->Nachname . ' ' . $s->Vorname . ', geb. ' . $s->GebDatum . '</li>
				');
			}
			?>
		</ul>
	</body>
</html>