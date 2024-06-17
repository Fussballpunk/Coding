<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Beziehungen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<h1>User &amp; Telefonnummern</h1>
		<h2>Alle User mitsamt der Telefonnummern</h2>
		<ul>
			<?php
			/* Fremdschlüssel zeigt in die falsche Richtung:
			$sql = "
				SELECT
					tbl_user.*,
					tbl_telnos.Telno
				FROM tbl_user
				LEFT JOIN tbl_telnos ON tbl_user.IDUser=tbl_telnos.FIDUser
			";
			*/
			$sql = "
				SELECT
					*
				FROM tbl_user
			";
			$userliste = dbQuery($conn,$sql);
			while($user = $userliste->fetch_object()) {
				echo('
					<li>
						IDUser: ' . $user->IDUser . ' | ' . $user->Emailadresse . '
						<ul>
				');
				
				// ---- Telnos je User: ----
				$sql = "
					SELECT
						Telno
					FROM tbl_telnos
					WHERE(
						FIDUser=" . $user->IDUser . "
					)
				";
				//ta($sql);
				$telnos = dbQuery($conn,$sql);
				while($telno = $telnos->fetch_object()) {
					echo('<li>' . $telno->Telno . '</li>');
				}
				// --------------------------
				
				echo('
						</ul>
					</li>
				');
			}
			?>
		</ul>
		<h2>Alle Telefonnummern samt User</h2>
		<ul>
			<?php
			$sql = "
				SELECT
					tbl_telnos.Telno,
					tbl_user.IDUser,
					tbl_user.Emailadresse
				FROM tbl_telnos
				INNER JOIN tbl_user ON tbl_user.IDUser=tbl_telnos.FIDUser
			";
			$telnos = dbQuery($conn,$sql);
			while($telno = $telnos->fetch_object()) {
				echo('
					<li>' . $telno->Telno . ': ' . $telno->IDUser . ' | ' . $telno->Emailadresse . '</li>
				');
			}
			?>
		</ul>
	</body>
</html>