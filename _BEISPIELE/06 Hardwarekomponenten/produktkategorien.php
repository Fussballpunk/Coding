<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();

function zeigeKategorien(?int $fid=null):string {
	global $conn;
	$r = "<ul>";
	
	$sql = "
		SELECT
			IDKategorie,
			Kategorie
		FROM tbl_kategorien
	";
	if(is_null($fid)) {
		$sql .= "
			WHERE(
				FIDKategorie IS NULL
			)
		";
	}
	else {
		$sql .= "
			WHERE(
				FIDKategorie=" . $fid . "
			)
		";
	}
	
	$kats = dbQuery($conn,$sql);
	while($kat = $kats->fetch_object()) {
		$r.= '
			<li>
				<a href="produkte.php?idKategorie=' . $kat->IDKategorie . '">' . $kat->Kategorie . '</a>' . zeigeKategorien($kat->IDKategorie) . '</li>
		';
	}
	
	$r.= "</ul>";
	
	return $r;
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Hardwarekomponenten</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Hardwarekomponenten</h1>
		<nav>
			<ul>
				<li><a href="produktkategorien.php">Produktkategorien</a></li>
				<li><a href="individualpcs.php">Individual-PCs</a></li>
			</ul>
		</nav>
		<?php
		echo(zeigeKategorien());
		?>
	</body>
</html>