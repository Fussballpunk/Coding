<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

function leseVZ(string $root):void {
	$inhalt = scandir($root); //liest den Inhalt des unter dem Pfad angegebenen Verzeichnisses ein und schreibt die NAMEN der Dateien, Verzeichnisse und Verknüpfungen in ein Array (nicht: schreibt die PFADE der Dateien, ...)
	//ta($inhalt);
	
	echo('<ul>');
	foreach($inhalt as $d) {
		if($d!="." && $d!="..") {
			if(is_dir($root . $d)) {
				echo('<li class="dir">' . $d);
				
				// ---- Rekursion: ----
				leseVZ($root.$d."/");
				// --------------------

				echo('</li>');
			}
			else {
				if(is_file($root . $d)) {
					echo('<li class="file">' . $d . '</li>');
				}
				else {
					echo('<li class="link">' . $d . '</li>');
				}
			}
		}
	}
	echo('</ul>');
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Scandir</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php
		leseVZ("../../");
		?>
	</body>
</html>