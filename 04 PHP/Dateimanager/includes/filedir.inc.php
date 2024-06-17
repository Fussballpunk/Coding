<?php
function loescheVZ(string $root):bool {
	$r = true;
	
	if(file_exists($root)) {
		$inhalt = scandir($root);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($root.$d)) {
					$r = $r && loescheVZ($root.$d."/");
				}
				else {
					//ta('lösche Datei/Verknüpfung: ' . $root.$d);
					$r = $r && unlink($root.$d);
				}
			}
		}
		
		if($r) {
			//ta('lösche Verzeichnis: ' . $root);
			$r = $r && rmdir($root);
		}
	}
	else {
		ta("Das Verzeichnis " . $root . " existiert nicht");
	}
	
	return $r;
}
?>