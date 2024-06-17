<?php
class behaeltnis {
	
	
	function __construct(int $volumen, string $farbe) {
		$this->vol = $volumen; //das übergebene Volumen wird im Objekt in der Variable (=Eigenschaft) vol des Objektes selbst gespeichert --> bis dato: implizite Deklaration und diese ist automatisch public
		$this->col = $farbe;
	}
}

$flasche1 = new behaeltnis(1400,"blau");
$flasche2 = new behaeltnis(500,"schwarz");

echo("<p>Die Farbe der ersten Flasche ist " . $flasche1->col . ", die Farbe von Flasche 2 ist " . $flasche2->col . "</p>");

$flasche1->col = "grün"; //das Objekt flasche1 möchte auf die Objekteigenschaft col zugreifen und diese verändern; die Eigenschaft col wurde (implizit) in der Klasse behaeltnis deklariert

echo("<p>Die Farbe der ersten Flasche ist " . $flasche1->col . ", die Farbe von Flasche 2 ist " . $flasche2->col . "</p>");
?>