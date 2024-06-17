<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();

ta($_POST);
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
		<form method="post">
			<label>
				gesuchter Songtitel (Anfangsbuchstaben sind ausreichen):
				<input type="text" name="Songtitel">
			</label>
			<label>
				gesuchtes Album (Anfangsbuchstaben sind ausreichen):
				<input type="text" name="Albumtitel">
			</label>
			<label>
				gesuchter Interpret (Anfangsbuchstaben sind ausreichen):
				<input type="text" name="Interpret">
			</label>
			<input type="submit" value="filtern">
		</form>
		<ul>
			<?php
			$where = "";
			
			if(count($_POST)>0) {
				$arr_w = []; //leeres Array
				
				if(strlen($_POST["Songtitel"])>0) {
					$arr_w[] = "tbl_songs.Songtitel LIKE '" . $_POST["Songtitel"] . "%'";
				}
				if(strlen($_POST["Albumtitel"])>0) {
					$arr_w[] = "tbl_alben.Albumtitel LIKE '" . $_POST["Albumtitel"] . "%'";
				}
				if(strlen($_POST["Interpret"])>0) {
					$arr_w[] = "tbl_interpreten.Interpret LIKE '" . $_POST["Interpret"] . "%'";
				}
				
				if(count($arr_w)>0) {
					$where = "
						WHERE(
							" . implode(" AND ",$arr_w) . "
						)
					";
				}
				ta($arr_w);
			}
			$sql = "
				SELECT
					tbl_songs.Songtitel,
					tbl_alben.Albumtitel,
					tbl_alben.Erscheinungsjahr,
					tbl_interpreten.Interpret
				FROM tbl_songs
				INNER JOIN tbl_alben ON tbl_alben.IDAlbum=tbl_songs.FIDAlbum
				INNER JOIN tbl_interpreten ON tbl_interpreten.IDInterpret=tbl_alben.FIDInterpret
				" . $where . "
				ORDER BY tbl_songs.Songtitel, tbl_alben.Albumtitel ASC, tbl_interpreten.Interpret ASC
			";
			ta($sql);
			
			$songs = dbQuery($conn,$sql);
			while($song = $songs->fetch_object()) {
				echo('
					<li>
						' . $song->Songtitel . ' aus dem Album ' . $song->Albumtitel . ' (' . $song->Erscheinungsjahr . ') von ' . $song->Interpret . '
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>