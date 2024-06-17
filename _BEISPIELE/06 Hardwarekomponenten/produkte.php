<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/db.inc.php");

$conn = dbConnect();
ta($_GET);
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
		<ul>
		<?php
		if(count($_GET)>0 && isset($_GET["idKategorie"]) && intval($_GET["idKategorie"])>0) {
			$idKat = intval($_GET["idKategorie"]);
			$sql = "
				SELECT
					tbl_produkte.Artikelnummer,
					tbl_produkte.Produkt,
					tbl_produkte.Beschreibung,
					tbl_produkte.Preis,
					tbl_produkte.Produktfoto,
					tbl_lieferbarkeiten.Lieferbarkeit
				FROM tbl_produkte
				INNER JOIN tbl_lieferbarkeiten ON tbl_lieferbarkeiten.IDLieferbarkeit=tbl_produkte.FIDLieferbarkeit
				WHERE(
					tbl_produkte.FIDKategorie=" . $idKat . "
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
						' . $pr->Produkt . ' (ANr ' . $pr->Artikelnummer . ') - ' . $pr->Preis . ': ' . $pr->Lieferbarkeit . '
						<div>' . $pr->Beschreibung . '</div>
						' . $foto . '
					</li>
				');
			}
		}
		?>
		</ul>
	</body>
</html>