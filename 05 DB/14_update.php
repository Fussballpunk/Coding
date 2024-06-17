<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

function pruefeAufNull(string $in):string {
	return strlen($in)>0 ? "'" . $in . "'" : "NULL";
}

$conn = dbConnect();
$msg = "";
ta($_POST);

if(count($_GET)>0) {
	$id = $_GET["id"];
}
else {
	header("Location: 13_redaktionssystem02.php");
}

if(count($_POST)>0) {
	$sql = "
		UPDATE tbl_user SET
			Emailadresse='" . $_POST["E"] . "',
			Passwort='" . $_POST["P"] . "',
			Vorname=" . pruefeAufNull($_POST["VN"]) . ",
			Nachname=" . pruefeAufNull($_POST["NN"]) . ",
			GebDatum=" . pruefeAufNull($_POST["GD"]) . "
		WHERE(
			IDUser=" . $id . "
		)
	";
	ta($sql);
	$ok = dbQuery($conn,$sql);
	if($ok) {
		header("Location: 13_redaktionssystem02.php");
	}
	else {
		$msg = '<p class="error">Leider konnte der User nicht geändert werden.</p>';
	}
}

?>
<!doctype html>
<html lang="de">
	<head>
		<title>Datensatz aktualisieren</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php
		$sql = "
			SELECT
				*
			FROM tbl_user
			WHERE(
				IDUser=" . $id . "
			)
		";
		//ta($sql);
		$userliste = dbQuery($conn,$sql);
		$user = $userliste->fetch_object();
		//ta($user);
		?>
		<?php echo($msg); ?>
		<form method="post">
			<label>
				Emailadresse:
				<input type="email" name="E" value="<?php echo($user->Emailadresse); ?>">
			</label>
			<label>
				Passwort:
				<input type="text" name="P" value="<?php echo($user->Passwort); ?>">
			</label>
			<label>
				Vorname:
				<input type="text" name="VN" value="<?php echo($user->Vorname); ?>">
			</label>
			<label>
				Nachname:
				<input type="text" name="NN" value="<?php echo($user->Nachname); ?>">
			</label>
			<label>
				Geburtsdatum:
				<input type="date" name="GD" value="<?php echo($user->GebDatum); ?>">
			</label>
			<input type="submit" value="speichern">
		</form>
	</body>
</html>