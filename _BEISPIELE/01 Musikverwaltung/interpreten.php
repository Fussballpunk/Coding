<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Musikverwaltung</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<h1>Musikverwaltung</h1>
		<ul>
			<?php
			$sql = "
				SELECT
					*
				FROM tbl_interpreten
				ORDER BY Interpret ASC
			";
			$interpreten = dbQuery($conn,$sql);
			while($interpret = $interpreten->fetch_object()) {
				echo('
					<li>
						' . $interpret->Interpret . ':
						<ul>
				');
				
				// ---- Alben je Interpret: ----
				$sql = "
					SELECT
						Albumtitel,
						Erscheinungsjahr
					FROM tbl_alben
					WHERE(
						FIDInterpret=" . $interpret->IDInterpret . "
					)
				";
				//ta($sql);
				$alben = dbQuery($conn,$sql);
				while($album = $alben->fetch_object()) {
					echo('
						<li>' . $album->Albumtitel . ' (' . $album->Erscheinungsjahr . ')</li>
					');
				}
				// -----------------------------
				
				echo('		
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>