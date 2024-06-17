<?php
require("includes/common.inc.php");

define("ROOTVZ","./Ablage/"); //Root-Verzeichnis für die Ablage der Inhalte (Dateien, Verzeichnisse, Verknüpfungen) des Users

$aktuellesVZ = ROOTVZ;

function zeigeStruktur(string $root):string {
	$r = "";
	
	if(file_exists($root)) {
		$r.= '<ul>';
		$inhalt = scandir($root);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($root.$d)) {
					$r.= '<li>' . $d;
					$r.= zeigeStruktur($root.$d."/");
					$r.= '</li>';
				}
			}
		}
		$r.= '</ul>';
	}	
	
	return $r;
}

function zeigeInhalt(string $root):string {
	$r = "";
	
	if(file_exists($root)) {
		$r.= '
			<table>
				<thead>
					<tr>
						<td></td>
						<th scope="col">Name</th>
						<th scope="col">Änderung</th>
						<th scope="col">Typ</th>
						<th scope="col">Größe</th>
					</tr>
				</thead>
				<tbody>
		';
		$inhalt = scandir($root);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				switch(true) {
					case is_dir($root.$d):
						$r.= '
							<tr>
								<td></td>
								<td class="dir">' . $d . '</td>
								<td></td>
								<td>Verzeichnis</td>
								<td></td>
							</tr>
						';
						break;
					case is_file($root.$d):
						$r.= '
							<tr>
								<td></td>
								<td class="file">' . $d . '</td>
								<td></td>
								<td>' . mime_content_type($root.$d) . '</td>
								<td>' . filesize($root.$d) . ' B</td>
							</tr>
						';
						break;
					case is_link($root.$d):
						$r.= '
							<tr>
								<td></td>
								<td class="link">' . $d . '</td>
								<td></td>
								<td>Verknüpfung</td>
								<td></td>
							</tr>
						';
						break;
				}
			}
		}
		$r.= '
				</tbody>
			</table>
		';
	}
	
	return $r;
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Dateimanager</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<link rel="stylesheet" href="css/dateimanager.css">
	</head>
	<body>
		<div id="DM">
			<div id="Struktur">
				<span>Ablage</span>
				<?php
				$struktur = zeigeStruktur(ROOTVZ);
				echo($struktur);
				?>
			</div>
			<div id="Inhalt">
				<?php
				$inhalt = zeigeInhalt($aktuellesVZ);
				echo($inhalt);
				?>
			</div>
		</div>
	</body>
</html>