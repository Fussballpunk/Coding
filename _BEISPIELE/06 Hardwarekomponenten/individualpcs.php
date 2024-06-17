<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Hardwarekomponenten</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Hardwarekomponenten</h1>
		<nav>
			<ul>
				<li><a href="produktkategorien.php">Produktkategorien</a></li>
				<li><a href="individualpcs.php">Individual-PCs</a></li>
			</ul>
		</nav>
		<form method="post">
			<label>
				Produktbezeichnung:
				<input type="text" name="PrBez">
			</label>
			<label>
				Artikelnummer:
				<input type="text" name="ANr">
			</label>
			<input type="submit" value="filtern">
		</form>
		<ul>
		<?php
		$where = "";
		if(count($_POST)>0) {
			$arr = [];
			if(strlen($_POST["PrBez"])>0) {
				$arr[] = "tbl_produkte.Produkt LIKE '%" . $_POST["PrBez"] . "%'";
			}
			if(strlen($_POST["ANr"])>0) {
				$arr[] = "tbl_produkte.Artikelnummer LIKE '%" . $_POST["ANr"] . "%'";
			}
			if(count($arr)>0) {
				$where = "
					WHERE(
						" . implode(" OR ",$arr) . "
					)
				";
			}
		}
		
		$erlaubtePCs = [];
		$sql = "
			SELECT
				FIDPC
			FROM tbl_konfigurator
			INNER JOIN tbl_produkte ON tbl_produkte.IDProdukt=tbl_konfigurator.FIDKomponente
			" . $where . "
			GROUP BY tbl_konfigurator.FIDPC
		";
		$pcs2 = dbQuery($conn,$sql);
		while($pc2 = $pcs2->fetch_object()) {
			$erlaubtePCs[] = "tbl_produkte.IDProdukt=" . $pc2->FIDPC;
		}
		//ta($erlaubtePCs);
		
		if(count($erlaubtePCs)>0) {
			$arr2 = ["tbl_produkte.FIDKategorie=2"];
			$arr2[] = "(" . implode(" OR ",$erlaubtePCs) . ")";
			$sql = "
				SELECT
					tbl_produkte.IDProdukt,
					tbl_produkte.Artikelnummer,
					tbl_produkte.Produkt,
					tbl_produkte.Beschreibung,
					tbl_produkte.Preis,
					tbl_produkte.Produktfoto,
					tbl_lieferbarkeiten.Lieferbarkeit
				FROM tbl_produkte
				INNER JOIN tbl_lieferbarkeiten ON tbl_lieferbarkeiten.IDLieferbarkeit=tbl_produkte.FIDLieferbarkeit
				WHERE(
					" . implode(" AND ",$arr2) . "
				)
			";
			ta($sql);
			$pcs = dbQuery($conn,$sql);
			while($pc = $pcs->fetch_object()) {
				if(!is_null($pc->Produktfoto)) {
					$foto_pc = '<img src="' . $pc->Produktfoto . '" alt="Foto des Produktes ' . $pc->Produkt . '">';
				}
				else {
					$foto_pc = "";
				}
				echo('
					<li>
						' . $pc->Produkt . ' (ANr ' . $pc->Artikelnummer . ') - ' . $pc->Preis . ': ' . $pc->Lieferbarkeit . '
						<div>' . $pc->Beschreibung . '</div>
						' . $foto_pc . '
						<ul>
				');
				
				// ---- Komponenten je PC: ----
				$preis = 0;
				$sql = "
					SELECT
						tbl_konfigurator.Anzahl,
						tbl_produkte.Artikelnummer,
						tbl_produkte.Produkt,
						tbl_produkte.Beschreibung,
						tbl_produkte.Preis,
						tbl_produkte.Produktfoto,
						tbl_lieferbarkeiten.Lieferbarkeit
					FROM tbl_konfigurator
					INNER JOIN tbl_produkte ON tbl_produkte.IDProdukt=tbl_konfigurator.FIDKomponente
					INNER JOIN tbl_lieferbarkeiten ON tbl_lieferbarkeiten.IDLieferbarkeit=tbl_produkte.FIDLieferbarkeit
					WHERE(
						tbl_konfigurator.FIDPC=" . $pc->IDProdukt . "
					)
				";
				$prs = dbQuery($conn,$sql);
				while($pr = $prs->fetch_object()) {
					if(!is_null($pr->Produktfoto)) {
						$foto = '<img src="' . $pr->Produktfoto . '" alt="Foto des Produktes ' . $pr->Produkt . '">';
					}
					else {
						$foto = "";
					}
					echo('
						<li>
							' . $pr->Anzahl . 'x ' . $pr->Produkt . ' (ANr ' . $pr->Artikelnummer . ') - ' . $pr->Preis . ': ' . $pr->Lieferbarkeit . '
							<div>' . $pr->Beschreibung . '</div>
							' . $foto . '
						</li>
					');
					
					$preis+= $pr->Anzahl*$pr->Preis;
				}
				// ENDE Komponenten je PC: ----
				
				echo('
						</ul>
						<strong>Gesamt: ' . $preis . '</strong>
					</li>
				');
			}
		}
		?>
		</ul>
	</body>
</html>