<?php
require "../conn/conn.php";

//function to use the table dates
function table_dates($task, $addition) {
	$database = new Database();
	switch ($task) {
		case 'select':
			if (empty($addition) || $addition == NULL || $additon == "") {
				$query = "SELECT * FROM dates ORDER BY Id ;";
				$database->query($query);
			}
			else {
				$query = "SELECT * FROM dates
					WHERE Id = :Id

				;";
				$database->query($query);
				$database->bind(':Id', $addition);
			}

			return $r = $database->resultset();
			break;

		default:
			# code...
			break;
	}
}

//function to use table services
function table_select_services($Type, $sector) {
	$database = new Database();
	switch ($Type) {
		case 'AC':
			$query = "SELECT * FROM services WHERE Type = :Type ;";
			$database->query($query);
			$database->bind(':Type', $Type);
			return $r = $database->resultset();
			break;

		case 'FL':
			$query = "SELECT * FROM services WHERE Service = :Service ;";
			$database->query($query);
			$database->bind(':Service', $sector);
			return $r = $database->resultset();
			break;

		default:
			# code...
			break;
	}
}

?>
