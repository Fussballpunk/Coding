<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

ta($_POST);
$msg = ""; //Hilfsvariable
if(count($_POST)>0) {
	ta("Es wurden Formulardaten übermittelt");
	
	$email_korrekt = "test@test.at";
	$pwd_korrekt = "test123";
	
	if($_POST["E"]==$email_korrekt && $_POST["P"]==$pwd_korrekt) {
		//ok, die eingegebenen Daten waren korrekt --> Weiterleitung auf eine geschützte Seite
		//$msg = '<p class="success">Vielen Dank. Sie werden in Kürze weitergeleitet.</p>';
		
		session_start(); //erzeugt eine Session-ID (sofern noch nicht vorhanden) und startet den Zugriff auf die Session-Verwaltung
		$_SESSION["eingeloggt"] = true;
		header("Location: 10_geschuetzt.php");
	}
	else {
		//nein, die eingegebenen Daten waren nicht korrekt --> Meldung an den User
		$msg = '<p class="error">Leider waren die eingegebenen Zugangsdaten nicht korrekt. Bitte versuchen Sie es erneut.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>PHP: Formulare</title>
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