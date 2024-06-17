<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$msg = "";

ta($_POST);
if(count($_POST)>0) {
	$conn = dbConnect();
	
	// Schritt 1: prüfen, ob diese Emailadresse nicht bereits verwendet wird
	$sql = "
		SELECT
			COUNT(*) AS Anzahl
		FROM tbl_user
		WHERE(
			Emailadresse='" . $_POST["E"] . "'
		)
	";
	//ta($sql);
	$liste = dbQuery($conn,$sql);
	//ta($liste);
	$eintrag = $liste->fetch_object();
	//ta($eintrag);
	if($eintrag->Anzahl==0) {
		//diese Emailadresse existiert noch nicht
		$pw = trim($_POST["P"]);
		if(strlen($pw)>=8) {
			//Länge des Passwortes ist ok
			if($pw==$_POST["P2"]) {
				$sql = "
					INSERT INTO tbl_user
						(Emailadresse,Passwort)
					VALUES (
						'" . $_POST["E"] . "',
						'" . $pw . "'
					)
				";
				ta($sql);
				$ok = dbQuery($conn,$sql);
				ta($ok);
				if($ok) {
					$msg = '<p class="success">Vielen Dank. Sie wurden erfolgreich registriert.</p>';
				}
				else {
					$msg = '<p class="error">Leider nicht...</p>';
				}
			}
			else {
				$msg = '<p class="error">Sorry, die Passwörter stimmen nicht überein.</p>';
			}
		}
		else {
			$msg = '<p class="error">Sorry, das Passwort ist zu kurz. Mind. 8 Zeichen für alle diejenigen, die lesen können.</p>';
		}
	}
	else {
		$msg = '<p class="error">Sorry, diese Emailadresse existiert bereits. Bitte loggen Sie sich ein.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Registrierung</title>
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
				Passwort (mind. acht Zeichen):
				<input type="password" name="P" required>
				<input type="password" name="P2" required placeholder="Passwort wiederholen">
			</label>
			<input type="submit" value="registrieren">
		</form>
	</body>
</html>