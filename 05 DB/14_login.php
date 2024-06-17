<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$msg = "";

ta($_POST);
if(count($_POST)>0) {
	/* E: test@test.at, PW: test123
	   SELECT
		  *
	   FROM tbl_user
	   WHERE(
	      Emailadresse='test@test.at' AND
		  Passwort='test123'
	   )
	*/
	
	$conn = dbConnect();
	
	$sql = "
		SELECT
			IDUser
		FROM tbl_user
		WHERE(
			Emailadresse='" . $_POST["E"] . "' AND
			Passwort='" . $_POST["P"] . "'
		)
	";
	ta($sql);
	$userliste = dbQuery($conn,$sql);
	ta($userliste);
	if($userliste->num_rows==1) {
		//die Zugangsdaten des Users waren korrekt
		$user = $userliste->fetch_object();
		session_start();
		$_SESSION["eingeloggt"] = true;
		$_SESSION["IDUser"] = $user->IDUser;
		header("Location: 13_geschuetzt.php");
	}
	else {
		//Login falsch --> Katastrophe!
		$msg = '<p class="error">Leider waren die eingegebenen Daten nicht korrekt.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post">
			<label>
				Emailadresse:
				<input type="email" name="E" required>
			</label>
			<label>
				Passwort:
				<input type="password" name="P" required>
			</label>
			<input type="submit" value="einloggen">
		</form>
	</body>
</html>