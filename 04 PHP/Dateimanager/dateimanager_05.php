<?php
/* Veränderungen zur vorangegangenen Version:
   - Darstellung der letzten Änderung eines Elements (Verzeichnis, Datei, Verknüpfung)
   - Brotkrümel-Navigation (beachte: Erweiterung der Auswahl der Elemente in JS)
*/

require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/filedir.inc.php");

define("ROOTVZ","./Ablage/"); //Root-Verzeichnis für die Ablage der Inhalte (Dateien, Verzeichnisse, Verknüpfungen) des Users

$aktuellesVZ = ROOTVZ;

ta($_POST);
//ta($_FILES);

$msg = "";

if(count($_POST)>0) {
	$aktuellesVZ = $_POST["VZUser"];
	
	if(isset($_POST["btnVZNeu"]) && isset($_POST["VZNeu"])) {
		$vzneu = trim($_POST["VZNeu"]); //entfernt führende und abschließende Whitespaces (Leerzeichen, Tabulatorschritte, Zeilenumbrüche, etc.)

		if(strlen($vzneu)>0) {
			if(!file_exists($aktuellesVZ.$vzneu)) {
				$ok = mkdir($aktuellesVZ.$_POST["VZNeu"],0755,false);
				if(!$ok) {
					$msg.= '<p class="error">Leider konnte das Verzeichnis nicht angelegt werden.</p>';
				}
			}
			else {
				$msg.= '<p class="error">Dieses Verzeichnis existiert bereits.</p>';
			}
		}
		else {
			$msg.= '<p class="error">Das ist kein gültiger Verzeichnisname.</p>';
		}
	}
	
	if(isset($_POST["btnVZDel"])) {
		if($aktuellesVZ!=ROOTVZ) {
			ta("lösche " . $aktuellesVZ);
			$ok = loescheVZ($aktuellesVZ);
			if($ok) {
				$aktuellesVZ = ROOTVZ;
			}
			else {
				$msg = '<p class="error">Leider konnte das gewünschte Verzeichnis nicht gelöscht werden.</p>';
			}
		}
		else {
			$msg = '<p class="error">Dieses Verzeichnis kann nicht gelöscht werden.</p>';
		}
	}
	
	if(isset($_POST["btnVZRename"])) {
		$vzneu = trim($_POST["VZRename"]);
		if(strlen($vzneu)>0) {
			$tmp = explode("/",$aktuellesVZ);
			//ta($tmp);
			$tmp[count($tmp)-2] = $_POST["VZRename"];
			//ta($tmp);
			$pfad_neu = implode("/",$tmp);
			//ta($pfad_neu);
			$ok = rename($aktuellesVZ,$pfad_neu);
			if($ok) {
				$aktuellesVZ = $pfad_neu;
			}
			else {
				$msg = '<p class="error">Leider konnte das Verzeichnis nicht umbenannt werden.</p>';
			}
		}
	}
	
	if(isset($_POST["btnVZMove"])) {
		if($aktuellesVZ!=ROOTVZ) {
			$tmp = explode("/",$aktuellesVZ);
			//ta($tmp);
			$_POST["VZMove"].= $tmp[count($tmp)-2];
			//ta($_POST["VZMove"]);
			//ta($aktuellesVZ);
			$ok = rename($aktuellesVZ,$_POST["VZMove"]);
			if($ok) {
				$aktuellesVZ = $_POST["VZMove"]."/";
			}
			else {
				$msg = '<p class="error">Leider konnte das Verzeichnis nicht verschoben werden.</p>';
			}
		}
		else {
			$msg = '<p class="error">Dieses Verzeichnis kann nicht verschoben werden.</p>';
		}
	}
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
								<td><span class="material-symbols-outlined">folder</span></td>
								<td class="dir">' . $d . '</td>
								<td>' . date("d.m.Y, H:i:s",filectime($root.$d)) . '</td>
								<td>Verzeichnis</td>
								<td></td>
							</tr>
						';
						break;
					case is_file($root.$d):
						$r.= '
							<tr>
								<td><span class="material-symbols-outlined">description</span></td>
								<td class="file">' . $d . '</td>
								<td>' . date("d.m.Y, H:i:s",filectime($root.$d)) . '</td>
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
								<td>' . date("d.m.Y, H:i:s",filectime($root.$d)) . '</td>
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

function zeigeStrukturAlsSelect(string $root, int $tiefe=1):string {
	$r = "";
	
	if(file_exists($root)) {
		if($root==ROOTVZ) {
			$r.= '
				<select name="VZMove">
					<option value="' . ROOTVZ . '">Ablage</option>
			';
		}
		$inhalt = scandir($root);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($root.$d)) {
					$einrueckung = "";
					for($j=0; $j<4*$tiefe; $j++) {
						$einrueckung.= "&nbsp;";
					}
					$r.= '<option value="' . $root.$d. '/">' . $einrueckung.$d . '</option>';
					$r.= zeigeStrukturAlsSelect($root.$d."/",$tiefe+1);
				}
			}
		}
		if($root==ROOTVZ) { $r.= '</select>'; }
	}
	
	return $r;
}

function zeigeBrotkruemel(string $root):string {
	$tmp = explode("/",$root);
	//ta($tmp);
	$tmp = array_slice($tmp,1); //entfernt den ersten Punkt
	//ta($tmp);
	$tmp = array_slice($tmp,0,count($tmp)-1); //entfernt den letzten (leeren) Eintrag
	//ta($tmp);
	
	$pre = "./";
	for($i=0; $i<count($tmp); $i++) {
		$new = '<span data-pfad="' . $pre.$tmp[$i] . '/">' . $tmp[$i] . '</span>';
		$pre.= $tmp[$i]."/";
		$tmp[$i] = $new;
		//htmlspecialchars(print_r($tmp));
	}
	return implode(" &rsaquo; ",$tmp);
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Dateimanager</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<link rel="stylesheet" href="css/dateimanager.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<style>
		.material-symbols-outlined {
			font-variation-settings:
			'FILL' 0,
			'wght' 400,
			'GRAD' 0,
			'opsz' 24;
			color:grey;
		}
	</style>
		<script>
		document.addEventListener("DOMContentLoaded",() => {
			const spans = document.querySelectorAll("#Struktur span, #BC span"); //Array mit den Verweisen auf die jeweiligen span-Elemente, denen wir einen Event Listener für click zuweisen möchten
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
		<div id="BC">
			<?php
			$bc = zeigeBrotkruemel($aktuellesVZ);
			echo($bc);
			?>
		</div>
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
			<fieldset id="VZNeu">
				<legend>Neues Verzeichnis anlegen</legend>
				<label>
					Verzeichnisname:
					<input type="text" name="VZNeu">
				</label>
				<input type="submit" value="anlegen" name="btnVZNeu">
			</fieldset>
			<fieldset id="VZRename">
				<legend>Verzeichnis umbenennen</legend>
				<label>
					Umbenennen in:
					<input type="text" name="VZRename">
				</label>
				<input type="submit" value="umbenennen" name="btnVZRename">
			</fieldset>
			<fieldset id="VZMove">
				<legend>Verzeichnis verschieben</legend>
				<label>
					verschieben in:
					<?php
					$box = zeigeStrukturAlsSelect(ROOTVZ);
					echo($box);
					?>
				</label>
				<input type="submit" value="verschieben" name="btnVZMove">
			</fieldset>
			<fieldset id="VZDel">
				<legend>aktuelles Verzeichnis löschen</legend>
				<input type="submit" value="löschen" name="btnVZDel">
			</fieldset>
		</form>
	</body>
</html>