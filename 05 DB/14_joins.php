<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Joins</title>
		<meta charset="utf-8">
	</head>
	<body>
		<table>
			<thead>
				<tr>
					<th scope="col">IDUser</th>
					<th scope="col">Emailadresse</th>
					<th scope="col">Vorname</th>
					<th scope="col">Nachname</th>
					<th scope="col">Geschlecht</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "
					SELECT
						IDUser,
						Emailadresse,
						Vorname,
						Nachname,
						FIDGeschlecht
					FROM tbl_user
				";
				$userliste = dbQuery($conn,$sql);
				while($user = $userliste->fetch_object()) {
					// ---- Geschlecht ermitteln: ----
					// SO SICHER NICHT!
					if(!is_null($user->FIDGeschlecht)) {
						$sql = "
							SELECT
								Geschlecht
							FROM tbl_geschlechter
							WHERE(
								IDGeschlecht=" . $user->FIDGeschlecht . "
							)
						";
						$geschlechter = dbQuery($conn,$sql);
						$geschlecht = $geschlechter->fetch_object();
						$g = $geschlecht->Geschlecht;
					}
					else {
						$g = "?";
					}
					// -------------------------------
					
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->FIDGeschlecht . ' | ' . $g . '</td>
						</tr>
					');
				}
				?>
			</tbody>
		</table>
	</body>
</html>