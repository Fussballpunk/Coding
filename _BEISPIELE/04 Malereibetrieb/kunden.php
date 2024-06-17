<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Malereibetrieb</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Malereibetrieb</h1>
		<nav>
			<ul>
				<li><a href="mitarbeiter.php">Mitarbeiter</a></li>
				<li><a href="kunden.php">Einsätze beim Kunden</a></li>
			</ul>
		</nav>
		<ul>
			<?php
			$sql = "
				SELECT
					*
				FROM tbl_kunden
				ORDER BY Nachname ASC, Vorname ASC
			";
			$kunden = dbQuery($conn,$sql);
			while($kunde = $kunden->fetch_object()) {
				$sql = "
					SELECT
						Startzeitpunkt,
						Endzeitpunkt
					FROM tbl_einsatz
					WHERE(
						FIDKunde=" . $kunde->IDKunde . "
					)
				";
				$einsaetze = dbQuery($conn,$sql);
				$summe = 0; //Summe an Stunden, die beim Kunden gearbeitet wurden
				$start = null; //frühester Startzeitpunkt
				$ende = null; //letzter Endzeitpunkt
				
				while($einsatz = $einsaetze->fetch_object()) {
					$ts_start = strtotime($einsatz->Startzeitpunkt);
					$ts_ende = strtotime($einsatz->Endzeitpunkt);
					$diff_sek = $ts_ende - $ts_start; //Differenz in Sekunden
					$diff_h = ceil($diff_sek/1800)/2; //Differenz in Stunden (auf angefangene halbe Stunden hochgerechnet)
					$summe = $summe + $diff_h;
					
					if(is_null($start) || $start>$ts_start) {
						$start = $ts_start;
					}
					if(is_null($ende) || $ende<$ts_ende) {
						$ende = $ts_ende;
					}
				}
				
				
				echo('
					<li>
						' . $kunde->Nachname . ' ' . $kunde->Vorname . ' (' . $kunde->Adresse . ', ' . $kunde->PLZ . ' ' . $kunde->Ort . ' | ' . $kunde->Telno . ' &bull; ' . $kunde->Email . '):
						<ul>
							<li>Anzahl der gearbeiteten Stunden: ' . $summe . '</li>
							<li>Kosten: EUR ' . ($summe*60) . '</li>
							<li>von ' . date("j.n.Y H:i",$start) . ' bis ' . date("j.n.Y H:i",$ende) . ' Uhr</li>
						</ul>
					</li>
				');
			}
			?>
		</ul>
	</body>
</html>