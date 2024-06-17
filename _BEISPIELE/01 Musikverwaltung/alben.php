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
					tbl_alben.IDAlbum,
					tbl_alben.Albumtitel,
					tbl_alben.Erscheinungsjahr,
					tbl_interpreten.Interpret
				FROM tbl_alben
				INNER JOIN tbl_interpreten ON tbl_interpreten.IDInterpret=tbl_alben.FIDInterpret
				ORDER BY tbl_alben.Erscheinungsjahr DESC
			";
			$alben = dbQuery($conn,$sql);
			while($album = $alben->fetch_object()) {
				//ta($album);
				echo('
					<li>
						&raquo;' . $album->Albumtitel . '&laquo; von ' . $album->Interpret . ' (' . $album->Erscheinungsjahr . '):
						<ul>
				');
				
				// ---- Songs je Album: ----
				$sql = "
					SELECT
						Songtitel
					FROM tbl_songs
					WHERE(
						FIDAlbum=" . $album->IDAlbum . "
					)
					ORDER BY Reihenfolge ASC
				";
				//ta($sql);
				$songs = dbQuery($conn,$sql);
				while($song = $songs->fetch_object()) {
					echo('<li>' . $song->Songtitel . '</li>');
				}
				// -------------------------
				
				echo('		
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>