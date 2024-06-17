<?php
class behaeltnis {
	private int $vol; //explizite Deklaration der Variable vol als private Integer-Variable
	private string $col;
	private int $content = 0;
	
	function __construct(int $volumen, string $farbe) {
		$this->vol = $volumen; //das übergebene Volumen wird im Objekt in der Variable (=Eigenschaft) vol des Objektes selbst gespeichert
		$this->col = $farbe;
	}
	
	public function color_get():string {
		//Getter-Methode für die Eigenschaft col des Objektes
		return $this->col;
	}
	
	public function content_change(int $change):void {
		//Setter-Methode für den Inhalt der content-Eigenschaft des Objektes
		if($this->content+$change<0) {
			$this->content = 0;
		}
		else {
			if($this->content+$change>$this->vol) {
				$this->content = $this->vol;
			}
			else {
				$this->content+= $change; //Veränderung des Inhalts (positiv wie negativ)
			}
		}
	}
	
	public function content_get():int {
		//Getter-Methode...
		return $this->content;
	}
}

$flasche1 = new behaeltnis(1400,"blau");
$flasche2 = new behaeltnis(500,"schwarz");

echo("<p>Die Farbe der ersten Flasche ist " . $flasche1->color_get() . ", die Farbe von Flasche 2 ist " . $flasche2->color_get() . "</p>");

//$flasche1->color_set("grün"); //das Objekt flasche1 möchte auf die Objekteigenschaft col zugreifen und diese verändern; die Eigenschaft col wurde (implizit) in der Klasse behaeltnis deklariert

echo("<p>Die Farbe der ersten Flasche ist " . $flasche1->color_get() . ", die Farbe von Flasche 2 ist " . $flasche2->color_get() . "</p>");
echo("<p>Der Inhalt der ersten Flasche ist " . $flasche1->content_get() . ", die Farbe von Flasche 2 ist " . $flasche2->content_get() . "</p>");

$flasche1->content_change(11350);
echo("<p>Der Inhalt der ersten Flasche ist " . $flasche1->content_get() . ", die Farbe von Flasche 2 ist " . $flasche2->content_get() . "</p>");
$flasche1->content_change(-500);
echo("<p>Der Inhalt der ersten Flasche ist " . $flasche1->content_get() . ", die Farbe von Flasche 2 ist " . $flasche2->content_get() . "</p>");
$flasche1->content_change(-1500);
echo("<p>Der Inhalt der ersten Flasche ist " . $flasche1->content_get() . ", die Farbe von Flasche 2 ist " . $flasche2->content_get() . "</p>");
?>