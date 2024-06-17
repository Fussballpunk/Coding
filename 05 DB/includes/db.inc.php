<?php
function dbConnect():mysqli {
	try {
		$conn = new MySQLi(DB["host"],DB["user"],DB["pwd"],DB["name"]);

		// diese Überprüfung findet nur statt, wenn im Fehlerfall keine Exception geworfen wird (das hängt davon ab, ob der Modus MYSQLI_REPORT_STRICT aktiviert ist oder nicht)
		if($conn->connect_errno>0) {
			if(TESTMODUS) {
				die("Fehler im Verbindungsaufbau: " . $conn->connect_error);
			}
			else {
				header("Location: errors/db_connect.html");
			}
		}

		$conn->set_charset("utf8mb4"); //Zeichensatz für die Kommunikation zw. DB-Server und Webserver
	}
	catch(Exception $e) {
		//es ist während des Versuchs eines Verbindungsaufbaus irgendein Fehler aufgetreten --> Abbruch!
		if(TESTMODUS) {
			ta($e);
			die("Fehler im Verbindungsaufbau");
		}
		else {
			header("Location: errors/db_connect.html");
		}
	}
	
	return $conn;
}

function dbQuery(mysqli $conn, string $sql):mysqli_result {
	try {
		$antwort = $conn->query($sql);
		if($antwort===false) {
			if(TESTMODUS) {
				die("Fehler in der Query: " . $conn->error);
			}
			else {
				header("Location: errors/db_query.html");
			}
		}
	}
	catch(Exception $e) {
		if(TESTMODUS) {
			ta($e);
			die("Fehler in der Query");
		}
		else {
			header("Location: errors/db_query.html");
		}
	}
	
	return $antwort;
}
?>