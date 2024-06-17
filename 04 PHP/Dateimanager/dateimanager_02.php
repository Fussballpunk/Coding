<?php
/* Veränderungen zur vorangegangenen Version:
   - bei Klick auf einen Verzeichnisnamen wird über das zugehörige data-pfad Attribut der Pfad zum Verzeichnis ausgelesen
   - dieser Verzeichnispfad wird über ein verstecktes Formularfeld und darauffolgendes Abschicken des Formulares an den Server übermittelt
   - der Server nimmt die POST-Daten entgegen und wertet diese aus, indem der Inhalt des POST-Eintrages namens VZUser in die Variable $aktuellesVZ geschrieben wird
*/

require("includes/common.inc.php");

define("ROOTVZ","./Ablage/"); //Root-Verzeichnis für die Ablage der Inhalte (Dateien, Verzeichnisse, Verknüpfungen) des Users

$aktuellesVZ = ROOTVZ;

if(count($_POST)>0) {
	$aktuellesVZ = $_POST["VZUser"];
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
		<form id="DM" method="post">
			<input type="hidden" name="VZUser">
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
		</form>
	</body>
</html>