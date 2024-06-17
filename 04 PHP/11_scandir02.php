<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

function leseVZ(string $root):string {
	$r = "";
	
	$inhalt = scandir($root);
	$r.= '<ul>'; // $r.= "abc"; --> $r = $r . "abc";
	foreach($inhalt as $d) {
		if($d!="." && $d!="..") {
			if(is_dir($root.$d)) {
				/*
				$r.= '<li class="dir">' . $d;
				$r.= leseVZ($root.$d."/");
				$r.= '</li>';
				*/
				
				$r.= '<li class="dir">' . $d . leseVZ($root.$d."/") . '</li>';
			}
			else {
				if(is_file($root.$d)) {
					$r.= '<li class="file">' . $d . '</li>';
				}
				else {
					$r.= '<li class="link">' . $d . '</li>';
				}
			}
		}
	}
	
	$r.= '</ul>';
	
	return $r;
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Scandir</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php
		//$erg = leseVZ("./");
		//echo($erg);
		
		echo(leseVZ("./"));
		?>
	</body>
</html>