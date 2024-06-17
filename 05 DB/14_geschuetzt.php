<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

function pruefeAufNull(string $in):string {
	if(strlen($in)>0) {
		$out = "'" . $in . "'";
	}
	else {
		$out = "NULL";
	}
	
	return $out;
}

ta($_POST);
$msg = "";
$conn = dbConnect();
$autologout = false;

session_start();

if(count($_POST)>0 && isset($_POST["btnLoeschen"])) {
	//der User hat entschieden, sein Profil zu löschen: --> Datensatz löschen, ausloggen
	
	$sql = "
		DELETE FROM tbl_user
		WHERE(
			IDUser=" . $_SESSION["IDUser"] . "
		)
	";
	ta($sql);
	$ok = dbQuery($conn,$sql);
	$autologout = $ok;
}

// ---- eingeloggt-/ausloggen-Bereich ----
if($autologout || count($_POST)>0 && isset($_POST["btnLogout"])) {
	//naja, offensichtsich will sich der User ausloggen
	$_SESSION = [];
	if(ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 86400, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	}
	session_destroy();
}

if(!(isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"]==true)) {
	//nein, das ist kein korrekt eingeloggter User
	header("Location: 13_login.php");
}
// ----------------------------------------

if(count($_POST)>0 && isset($_POST["btnSpeichern"])) {
	$sql = "
		UPDATE tbl_user SET
			Vorname=" . pruefeAufNull($_POST["VN"]) . ",
			Nachname=" . pruefeAufNull($_POST["NN"]) . ",
			GebDatum=" . pruefeAufNull($_POST["GD"]) . "
		WHERE(
			IDUser=" . $_SESSION["IDUser"] . "
		)
	";
	ta($sql);
	$ok = dbQuery($conn,$sql);
	if(!$ok) {
		$msg = '<p class="error">Sorry, leider ist beim Speichern Ihres Profiles ein Fehler aufgetreten.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Profil bearbeiten</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post">
			<input type="submit" value="ausloggen" name="btnLogout">
		</form>
		<h1>Profil bearbeiten</h1>
		<?php
		$sql = "
			SELECT
				Vorname,
				Nachname,
				GebDatum
			FROM tbl_user
			WHERE(
				IDUser=" . $_SESSION["IDUser"] . "
			)
		";
		//ta($sql);
		$userliste = dbQuery($conn,$sql);
		$user = $userliste->fetch_object();
		//ta($user);
		?>
		<form method="post">
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
			<input type="submit" value="speichern" name="btnSpeichern">
			<input type="submit" value="Profil löschen" name="btnLoeschen">
		</form>
	</body>
</html>