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
			$query = "SELECT * FROM services WHERE Type = :Type ORDER BY Id DESC ;";
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

//function to select data from the table delegates
function table_select_delegates($Id) {
	$database = new Database();

	if (empty($Id) || $Id == "" || $Id == NULL) {
		$query = "SELECT * FROM delegates ORDER BY Id ;";
		$database->query($query);
	}
	else {
		$query = "SELECT * FROM delegates WHERE Id = :Id ;";
		$database->query($query);
		$database->bind(':Id', $Id);
	}
	return $r = $database->resultset();
}

//function to select data from the table bookings
function table_select_bookings($DelegateId) {
	$database = new Database();

	if (empty($DelegateId) || $DelegateId == "" || $DelegateId == NULL) {
		$query = "SELECT
			delegates.Title,
			delegates.Firstname,
			delegates.Lastname,
			delegates.Organization,
			delegates.City,
			deleagates.Telephone,
			delegates.Email,
			delegates.Arrival,
			delegates.Departure,
			delegates.Airport_Trf,
			services.Service,
			services.Supplier,
			services.ETD,
			services.ETA,
			services.Flight,
			bookings.ServiceId
			FROM bookings
			LEFT OUTER JOIN delegates
			ON delegates.Id = bookings.DelegateId
			LEFT OUTER JOIN services
			ON services.Id = bookings.ServiceId
		;";
		$database->query($query);
	}
	else {
		$query = "SELECT
			delegates.Title,
			delegates.Firstname,
			delegates.Lastname,
			delegates.Organization,
			delegates.City,
			delegates.Telephone,
			delegates.Email,
			delegates.Arrival,
			delegates.Departure,
			delegates.Airport_Trf,
			delegates.Payment,
			services.Service,
			services.Supplier,
			services.Type,
			services.ETD,
			services.ETA,
			services.Flight,
			bookings.ServiceId
			FROM bookings
			LEFT OUTER JOIN delegates
			ON delegates.Id = bookings.DelegateId
			LEFT OUTER JOIN services
			ON services.Id = bookings.ServiceId
			WHERE delegates.Id = :DelegateId
		;";
		$database->query($query);
		$database->bind(':DelegateId', $DelegateId);
	}
	return $r = $database->resultset();

}

?>
