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
			<input type="submit" value="filtern">
		</form>
		<ul>
			<?php
			if(count($_POST)>0 && strlen($_POST["Songtitel"])>0) {
				$sql = "
					SELECT
						tbl_songs.Songtitel,
						tbl_alben.Albumtitel,
						tbl_alben.Erscheinungsjahr,
						tbl_interpreten.Interpret
					FROM tbl_songs
					INNER JOIN tbl_alben ON tbl_alben.IDAlbum=tbl_songs.FIDAlbum
					INNER JOIN tbl_interpreten ON tbl_interpreten.IDInterpret=tbl_alben.FIDInterpret
					WHERE(
						tbl_songs.Songtitel LIKE '" . $_POST["Songtitel"] . "%'
					)
					ORDER BY tbl_songs.Songtitel, tbl_alben.Albumtitel ASC, tbl_interpreten.Interpret ASC
				";
			}
			else {
				$sql = "
					SELECT
						tbl_songs.Songtitel,
						tbl_alben.Albumtitel,
						tbl_alben.Erscheinungsjahr,
						tbl_interpreten.Interpret
					FROM tbl_songs
					INNER JOIN tbl_alben ON tbl_alben.IDAlbum=tbl_songs.FIDAlbum
					INNER JOIN tbl_interpreten ON tbl_interpreten.IDInterpret=tbl_alben.FIDInterpret
					ORDER BY tbl_songs.Songtitel, tbl_alben.Albumtitel ASC, tbl_interpreten.Interpret ASC
				";
			}
			
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