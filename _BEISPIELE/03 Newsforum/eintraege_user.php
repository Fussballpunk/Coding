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
		<title>Newsforum</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Newsforum</h1>
		<nav>
			<ul>
				<li><a href="eintraege.php">Einträge im Newsforum</a></li>
				<li><a href="eintraege_user.php">Einträge von Usern</a></li>
				<li><a href="eintragssuche.php">Suche nach Text</a></li>
			</ul>
		</nav>
		<form method="post">
			<label>
				Emailadresse:
				<input type="email" name="E">
			</label>
			<input type="submit" value="filtern">
		</form>
		
		<?php
		$where = "";
		if(count($_POST)>0 && strlen($_POST["E"])>0) {
			$where = "
				WHERE(
					Emailadresse='" . $_POST["E"] . "'
				)
			";
		}
		
		$sql = "
			SELECT
				tbl_eintraege.Eintrag,
				tbl_eintraege.Eintragezeitpunkt,
				tbl_user.Vorname,
				tbl_user.Nachname,
				tbl_user.Emailadresse
			FROM tbl_eintraege
			LEFT JOIN tbl_user ON tbl_user.IDUser=tbl_eintraege.FIDUser
		" . $where . "
			ORDER BY tbl_user.Nachname, tbl_user.Vorname, tbl_eintraege.Eintragezeitpunkt DESC
		";
		ta($sql);
		$eintraege = dbQuery($conn,$sql);
		echo('<ul>');
		while($eintrag = $eintraege->fetch_object()) {
			if(is_null($eintrag->Vorname) && is_null($eintrag->Nachname)) {
				$name = "(Anonymous)";
			}
			else {
				$name = $eintrag->Nachname . ' ' . $eintrag->Vorname;
			}
			echo('
				<li>
					' . $name . ' (' . $eintrag->Emailadresse . ') schrieb am ' . date("d.m.Y",strtotime($eintrag->Eintragezeitpunkt)) . ' um ' . date("H:i",strtotime($eintrag->Eintragezeitpunkt)) . ' Uhr:
					<div>' . $eintrag->Eintrag . '</div>
				</li>
			');
		}
		echo('</ul>');
		?>
	</body>
</html>