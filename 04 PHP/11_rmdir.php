<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/filedir.inc.php");
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Löschen von Verzeichnissen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php
		$ok = loescheVZ("./bilder2/");
		ta("ok: ".$ok);
		?>
	</body>
</html>