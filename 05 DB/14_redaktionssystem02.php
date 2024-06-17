<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

function pruefeAufNull(string $in):string {
	return strlen($in)>0 ? "'" . $in . "'" : "NULL";
}

//ta($_POST);
$msg = "";
$conn = dbConnect();

if(count($_POST)>0) {
	switch(true) {
		case isset($_POST["btnNeu"]):
			//neuen User einfügen
			$sql = "
				INSERT INTO tbl_user
					(Emailadresse, Passwort, Vorname, Nachname, GebDatum)
				VALUES (
					'" . $_POST["E_0"] . "',
					'" . $_POST["P_0"] . "',
					" . pruefeAufNull($_POST["VN_0"]) . ",
					" . pruefeAufNull($_POST["NN_0"]) . ",
					" . pruefeAufNull($_POST["GD_0"]) . "
				)
			";
			//ta($sql);
			$ok = dbQuery($conn,$sql);
			if(!$ok) {
				$msg = '<p class="error">Leider konnte der neue User nicht gespeichert werden.</p>';
			}
			break;
			
		case isset($_POST["btnLoeschen"]):
			//bestehenden Datensatz löschen
			$sql = "
				DELETE FROM tbl_user
				WHERE(
					IDUser=" . $_POST["btnLoeschen"] . "
				)
			";
			//ta($sql);
			$ok = dbQuery($conn,$sql);
			if(!$ok) {
				$msg = '<p class="error">Leider konnte der User nicht gelöscht werden.</p>';
			}
			break;
			
		case isset($_POST["btnAktualisieren"]):
			//bestehenden Datensatz aktualisieren
			$id = $_POST["btnAktualisieren"];
			
			$sql = "
				UPDATE tbl_user SET
					Emailadresse='" . $_POST["E_".$id] . "',
					Passwort='" . $_POST["P_".$id] . "',
					Vorname=" . pruefeAufNull($_POST["VN_".$id]) . ",
					Nachname=" . pruefeAufNull($_POST["NN_".$id]) . ",
					GebDatum=" . pruefeAufNull($_POST["GD_".$id]) . "
				WHERE(
					IDUser=" . $id . "
				)
			";
			//ta($sql);
			$ok = dbQuery($conn,$sql);
			if(!$ok) {
				$msg = '<p class="error">Leider konnte der User nicht geändert werden.</p>';
			}
			break;
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Redaktionssystem</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<form method="post" action="">
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
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="text" name="E_0"></td>
					<td><input type="text" name="P_0"></td>
					<td><input type="text" name="VN_0"></td>
					<td><input type="text" name="NN_0"></td>
					<td><input type="date" name="GD_0"></td>
					<td></td>
					<td><input type="submit" name="btnNeu" value="einfügen"></td>
				</tr>
			</thead>
			<tbody>
			<?php
			$sql = "
				SELECT * FROM tbl_user
			";
			$userliste = dbQuery($conn,$sql);
			while($user = $userliste->fetch_object()) {
				$id = $user->IDUser;
				echo('
					<tr>
						<td>' . $id . '</td>
						<td>' . $user->Emailadresse . '</td>
						<td>' . $user->Passwort . '</td>
						<td>' . $user->Vorname . '</td>
						<td>' . $user->Nachname . '</td>
						<td>' . $user->GebDatum . '</td>
						<td>' . $user->RegZeitpunkt . '</td>
						<td>
							<!--<input type="submit" value="' . $user->IDUser . '" name="btnLoeschen">-->
							<a href="13_delete.php?id=' . $id . '">DEL</a>
							<a href="13_update.php?id=' . $id . '">UPD</a>
						</td>
					</tr>
				');
			}
			?>
			</tbody>
		</table>
		</form>
	</body>
</html>