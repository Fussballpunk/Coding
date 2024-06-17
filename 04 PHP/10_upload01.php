<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

ta($_POST);
ta($_FILES);
$msg = "";
if(count($_FILES)>0) {
	//es wurde ein Formular abgeschickt, wo zumindest die Möglichkeit bestanden hat, eine Datei hochzuladen
	if($_FILES["myUpload"]["error"]==0) {
		//der Upload war erfolgreich
		$ok = move_uploaded_file($_FILES["myUpload"]["tmp_name"],"uploads/" . $_FILES["myUpload"]["name"]);
		if($ok) {
			$msg = '<p class="success">Die Datei ' . $_FILES["myUpload"]["name"] . ' wurde erfolgreich hochgeladen.</p>';
		}
		else {
			$msg = '<p class="error">Leider ist beim Speichern der Datei ein Fehler aufgetreten.</p>';
		}
	}
	else {
		//der Upload war (aus irgendeinem Grund) nicht erfolgreich
		$msg = '<p class="error">Leider war der Upload nicht erfolgreich.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>PHP: Dateiupload</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post" enctype="multipart/form-data">
			<label>
				Bitte wählen Sie eine Datei aus:
				<input type="file" name="myUpload">
			</label>
			<input type="submit" value="hochladen">
		</form>
	</body>
</html>