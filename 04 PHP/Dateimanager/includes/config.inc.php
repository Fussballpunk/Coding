<?php
define("TESTMODUS",true); //der Konstanten TESTMODUS wird der Wert true zugewiesen

if(TESTMODUS) {
	error_reporting(E_ALL);
	ini_set("display_errors",1);
}
else {
	error_reporting(0);
	ini_set("display_errors",0);
}
?>