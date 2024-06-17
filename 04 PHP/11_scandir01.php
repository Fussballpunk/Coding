<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
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
		$inhalt = scandir("./"); //liest den Inhalt des unter dem Pfad angegebenen Verzeichnisses ein und schreibt die NAMEN der Dateien, Verzeichnisse und Verknüpfungen in ein Array (nicht: schreibt die PFADE der Dateien, ...)
		//ta($inhalt);
		
		echo('<ul>');
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir("./" . $d)) {
					echo('<li class="dir">' . $d . '</li>');
				}
				else {
					if(is_file("./" . $d)) {
						echo('<li class="file">' . $d . '</li>');
					}
					else {
						echo('<li class="link">' . $d . '</li>');
					}
				}
			}
		}
		echo('</ul>');
		?>
	</body>
</html>