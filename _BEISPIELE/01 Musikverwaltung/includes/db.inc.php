<?php
function dbConnect():mysqli {
	try {
		$conn = new MySQLi(DB["host"],DB["user"],DB["pwd"],DB["name"]);
		$conn->set_charset("utf8mb4");
	}
	catch(Exception $e) {
		if(TESTMODUS) {
			ta("Fehler im Verbindungsaufbau");
			ta($e);
			die("Abbruch");
		}
		else {
			header("Location: errors/dbconnect.html");
		}
	}
	
	return $conn;
}

function dbQuery(mysqli $conn, string $sql):mysqli_result|bool {
	try {
		$daten = $conn->query($sql);
		if($daten===false) {
			if(TESTMODUS) {
				ta("Fehler in der Query:");
				ta($sql);
				die("Abbruch");
			}
			else {
				header("Location: errors/dbquery.html");
			}
		}
	}
	catch(Exception $e) {
		if(TESTMODUS) {
			ta("Fehler in der Query:");
			ta($e);
			ta($sql);
			die("Abbruch");
		}
		else {
			header("Location: errors/dbquery.html");
		}
	}
	
	return $daten;
}
?>