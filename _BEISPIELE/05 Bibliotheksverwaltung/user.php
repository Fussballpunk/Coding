<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
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
		<ul>
			<?php
			$sql = "
				SELECT
					tbl_user.IDUser,
					tbl_user.Emailadresse,
					tbl_user.Adresse,
					tbl_user.PLZ,
					tbl_user.Ort,
					tbl_personen.Vorname,
					tbl_personen.Nachname				
				FROM tbl_user
				INNER JOIN tbl_personen ON tbl_personen.IDPerson=tbl_user.FIDPerson
			";
			$userliste = dbQuery($conn,$sql);
			while($user = $userliste->fetch_object()) {
				echo('
					<li>
						<span onclick="document.querySelector(\'#adresse_' . $user->IDUser . '\').classList.toggle(\'H\');">' . $user->Nachname . ' ' . $user->Vorname . '</span>
						<a onclick="document.querySelector(\'#buecher_' . $user->IDUser . '\').classList.toggle(\'H\');">Ausborgeliste</a>
						<ul class="H buecher" id="buecher_' . $user->IDUser . '">
				');
				
				// ---- Bücher je User: ----
				$sql = "
					SELECT
						tbl_ausborgeliste.Beginn,
						tbl_ausborgeliste.Ende,
						tbl_buecher.Titel
					FROM tbl_ausborgeliste
					INNER JOIN tbl_buecher ON tbl_buecher.IDBuch=tbl_ausborgeliste.FIDBuch
					WHERE(
						tbl_ausborgeliste.FIDUser=" . $user->IDUser . "
					)
					ORDER BY tbl_ausborgeliste.Ende ASC, tbl_ausborgeliste.Beginn DESC
				";
				$buecher = dbQuery($conn,$sql);
				while($buch = $buecher->fetch_object()) {
					echo('
						<li>' . $buch->Beginn . ' bis ' . $buch->Ende . ': ' . $buch->Titel . '</li>
					');
				}
				// -------------------------
				
				echo('		
						</ul>
						<address class="H" id="adresse_' . $user->IDUser . '">
							' . $user->Adresse . ', ' . $user->PLZ . ' ' . $user->Ort . '<br>
							' . $user->Emailadresse . '
						</address>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>