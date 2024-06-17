<?php
/* Veränderungen zur vorangegangenen Version:
   - das aktuelle Verzeichnis, in dem sich der User befindet, wird als value in das versteckte Formularfeld namens VZUser geschrieben
   - es können beliebig viele Dateien in das aktuelle Verzeichnis hochgeladen werden
*/

require("includes/config.inc.php");
require("includes/common.inc.php");

define("ROOTVZ","./Ablage/"); //Root-Verzeichnis für die Ablage der Inhalte (Dateien, Verzeichnisse, Verknüpfungen) des Users

$aktuellesVZ = ROOTVZ;

ta($_POST);
//ta($_FILES);

$msg = "";

if(count($_POST)>0) {
	$aktuellesVZ = $_POST["VZUser"];
}

if(count($_FILES)>0) {
	$f = $_FILES["myUpload"];
	for($i=0; $i<count($f["name"]); $i++) {
		if($f["error"][$i]==0) {
			$ok = move_uploaded_file($f["tmp_name"][$i],$aktuellesVZ.$f["name"][$i]);
			if(!$ok) {
				$msg.= '<p class="error">Die Datei ' . $f["name"][$i] . ' konnte leider nicht gespeichert werden.</p>';
			}
		}
	}
}

function zeigeStruktur(string $root):string {
	$r = "";
	
	if(file_exists($root)) {
		$r.= '<ul>';
		$inhalt = scandir($root);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($root.$d)) {
					$r.= '<li><span data-pfad="' . $root.$d . '/">' . $d . '</span>';
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
		<script>
		document.addEventListener("DOMContentLoaded",() => {
			const spans = document.querySelectorAll("#Struktur span"); //Array mit den Verweisen auf die jeweiligen span-Elemente, denen wir einen Event Listener für click zuweisen möchten
			for(let i=0; i<spans.length; i++) {
				spans[i].addEventListener("click",(ev) => {
					//console.log("geklickt");
					let pfad = ev.srcElement.attributes["data-pfad"].value; //ermittelt aus dem angeklickten span-Element den Inhalt des Attributes mit dem Namen data-pfad
					document.querySelector("[name=VZUser]").value = pfad; //schreibt den Inhalt der Variable pfad in das Formularfeld mit dem Namen VZUser
					document.querySelector("#DM").submit(); //schickt das Formular mit der ID="DM" ab
				});
			}
		});
		</script>
	</head>
	<body>
		<?php echo($msg); ?>
		<form id="DM" method="post" enctype="multipart/form-data">
			<input type="hidden" name="VZUser" value="<?php echo($aktuellesVZ); ?>">
			<div id="Struktur">
				<span data-pfad="<?php echo(ROOTVZ); ?>">Ablage</span>
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
			<fieldset id="Upload">
				<legend>Datei(en) hochladen</legend>
				<label>
					Bitte wählen Sie eine oder mehrere Dateien aus:
					<input type="file" name="myUpload[]" multiple>
				</label>
				<input type="submit" value="hochladen">
			</fieldset>
		</form>
	</body>
</html>