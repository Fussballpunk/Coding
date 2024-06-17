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
				// ---- INNER JOIN: ----
				$sql = "
					SELECT
						tbl_user.IDUser,
						tbl_user.Emailadresse,
						tbl_user.Vorname,
						tbl_user.Nachname,
						tbl_user.FIDGeschlecht,
						tbl_geschlechter.Geschlecht
					FROM tbl_user
					INNER JOIN tbl_geschlechter ON tbl_geschlechter.IDGeschlecht=tbl_user.FIDGeschlecht
				";
				$userliste = dbQuery($conn,$sql);
				while($user = $userliste->fetch_object()) {
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->FIDGeschlecht . ' | ' . $user->Geschlecht . '</td>
						</tr>
					');
				}
				echo('<tr><td colspan="5">-----</td></tr>');
				
				// ---- LEFT JOIN: ----
				$sql = "
					SELECT
						tbl_user.IDUser,
						tbl_user.Emailadresse,
						tbl_user.Vorname,
						tbl_user.Nachname,
						tbl_user.FIDGeschlecht,
						tbl_geschlechter.Geschlecht
					FROM tbl_user
					LEFT JOIN tbl_geschlechter ON tbl_geschlechter.IDGeschlecht=tbl_user.FIDGeschlecht
				";
				$userliste = dbQuery($conn,$sql);
				while($user = $userliste->fetch_object()) {
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->FIDGeschlecht . ' | ' . $user->Geschlecht . '</td>
						</tr>
					');
				}
				echo('<tr><td colspan="5">-----</td></tr>');
				
				// ---- RIGHT JOIN: ----
				$sql = "
					SELECT
						tbl_user.IDUser,
						tbl_user.Emailadresse,
						tbl_user.Vorname,
						tbl_user.Nachname,
						tbl_user.FIDGeschlecht,
						tbl_geschlechter.Geschlecht
					FROM tbl_user
					RIGHT JOIN tbl_geschlechter ON tbl_geschlechter.IDGeschlecht=tbl_user.FIDGeschlecht
				";
				$userliste = dbQuery($conn,$sql);
				while($user = $userliste->fetch_object()) {
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->FIDGeschlecht . ' | ' . $user->Geschlecht . '</td>
						</tr>
					');
				}
				?>
			</tbody>
		</table>
	</body>
</html>