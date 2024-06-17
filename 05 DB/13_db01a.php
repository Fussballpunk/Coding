<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();

$sql = "
	SELECT
		*
	FROM tbl_user
";

$antwort = dbQuery($conn,$sql);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Datenbanken</title>
	<link rel="stylesheet" href="css/common.css">
</head>

<body>
	<table>
		<thead>
			<tr>
				<th scope="col">IDUser</th>
				<th scope="col">Emailadresse</th>
				<th scope="col">Passwort</th>
				<th scope="col">Vorname</th>
				<th scope="col">Nachname</th>
				<th scope="col">Geb-Datum</th>
				<th scope="col">Reg-Zeitpunkt</th>
			</tr>
		</thead>
		<tbody>
			<?php
			/* assoziatives Array:
			while($datensatz = $antwort->fetch_assoc()) {
				echo('
					<li>IDUser: ' . $datensatz["IDUser"] . '</li>
				');
			}
			*/

			while($datensatz = $antwort->fetch_object()) {
				echo('
					<tr>
						<td>' . $datensatz->IDUser . '</td>
						<td>' . $datensatz->Emailadresse . '</td>
						<td>' . $datensatz->Passwort . '</td>
						<td>' . $datensatz->Vorname . '</td>
						<td>' . $datensatz->Nachname . '</td>
						<td>' . $datensatz->GebDatum . '</td>
						<td>' . $datensatz->RegZeitpunkt . '</td>
					</tr>
				');
			}
			?>
		</tbody>
	</table>
</body>
</html>