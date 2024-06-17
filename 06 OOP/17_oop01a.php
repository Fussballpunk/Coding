<?php
class behaeltnis {
	private int $vol; //explizite Deklaration der Variable vol als private Integer-Variable
	private string $col;
	
	function __construct(int $volumen, string $farbe) {
		$this->vol = $volumen; //das übergebene Volumen wird im Objekt in der Variable (=Eigenschaft) vol des Objektes selbst gespeichert
		$this->col = $farbe;
	}
	
	public function color_get():string {
		//Getter-Methode für die Eigenschaft col des Objektes
		return $this->col;
	}
	
	public function color_set(string $farbe):void {
		//Setter-Methode für die Eigenschaft col des Objektes
		$this->col = $farbe;
	}
}

$flasche1 = new behaeltnis(1400,"blau");
$flasche2 = new behaeltnis(500,"schwarz");

echo("<p>Die Farbe der ersten Flasche ist " . $flasche1->color_get() . ", die Farbe von Flasche 2 ist " . $flasche2->color_get() . "</p>");

$flasche1->color_set("grün"); //das Objekt flasche1 möchte auf die Objekteigenschaft col zugreifen und diese verändern; die Eigenschaft col wurde (implizit) in der Klasse behaeltnis deklariert

echo("<p>Die Farbe der ersten Flasche ist " . $flasche1->color_get() . ", die Farbe von Flasche 2 ist " . $flasche2->color_get() . "</p>");
?>