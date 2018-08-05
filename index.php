<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//data for the table delegates
	$Title = $_REQUEST['Title'];
	$Firstname = trim($_REQUEST['Firstname']);
	$Lastname = trim($_REQUEST['Lastname']);
	$Organization = trim($_REQUEST['Organization']);
	$City = trim($_REQUEST['City']);
	$Telephone = trim($_REQUEST['Telephone']);
	$Email = trim($_REQUEST['Email']);
	$Arrival = $_REQUEST['Arrival'];
	$Departure = $_REQUEST['Departure'];
	$Airport_Trf = $_REQUEST['Airport_Trf'];
	$Special = trim($_REQUEST['Special']);
	$Payment =$_REQUEST['Payment'];

	//data for the table bookings
	$RGNNYT = $_REQUEST['RGNNYT'];
	$NYTRGN = $_REQUEST['NYTRGN'];
	$Hotel = $_REQUEST['Hotel'];

	$database = new Database();

	//inserting data to the table delegates
	$query_insert_delegates = "INSERT INTO delegates (
		Title,
		Firstname,
		Lastname,
		Organization,
		City,
		Telephone,
		Email,
		Arrival,
		Departure,
		Airport_Trf,
		Special,
		Payment
		) VALUES (
		:Title,
		:Firstname,
		:Lastname,
		:Organization,
		:City,
		:Telephone,
		:Email,
		:Arrival,
		:Departure,
		:Airport_Trf,
		:Special,
		:Payment
		)
	;";
	$database->query($query_insert_delegates);
	$database->bind(':Title', $Title);
	$database->bind(':Firstname', $Firstname);
	$database->bind(':Lastname', $Lastname);
	$database->bind(':Organization', $Organization);
	$database->bind(':City', $City);
	$database->bind(':Telephone', $Telephone);
	$database->bind(':Email', $Email);
	$database->bind(':Arrival', $Arrival);
	$database->bind(':Departure', $Departure);
	$database->bind(':Airport_Trf', $Airport_Trf);
	$database->bind(':Special', $Special);
	$database->bind(':Payment', $Payment);
	if ($database->execute()) {
		//getting the Id from the table delegates
		$query_delegates_Id = "SELECT Id from delegates WHERE
			Firstname = :Firstname AND
			Lastname = :Lastname AND
			Organization = :Organization
		;";
		$database->query($query_delegates_Id);
		$database->bind(':Firstname', $Firstname);
		$database->bind(':Lastname', $Lastname);
		$database->bind(':Organization', $Organization);
		$rows = $database->resultset();
		foreach ($rows as $row) {
			$DelegateId = $row->Id;
		}

		$insert_flight_RGNNYT = "INSERT INTO bookings (
			DelegateId,
			ServiceId
			) VALUES (
			:DelegateId,
			:ServiceId
			)
		;";
		$database->query($insert_flight_RGNNYT);
		$database->bind(':DelegateId', $DelegateId);
		$database->bind(':ServiceId', $RGNNYT);
		$database->execute();

		$insert_flight_NYTRGN = "INSERT INTO bookings (
			DelegateId,
			ServiceId
			) VALUES (
			:DelegateId,
			:ServiceId
			)
		;";
		$database->query($insert_flight_NYTRGN);
		$database->bind(':DelegateId', $DelegateId);
		$database->bind(':ServiceId', $NYTRGN);
		$database->execute();

		$insert_hotel = "INSERT INTO bookings (
			DelegateId,
			ServiceId
			) VALUES (
			:DelegateId,
			:ServiceId
			)
		;";
		$database->query($insert_hotel);
		$database->bind(':DelegateId', $DelegateId);
		$database->bind(':ServiceId', $Hotel);
		$database->execute();
		
		header("location:thankyou.php?DelegateId=$DelegateId");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="Shortcut icon" href="images/Logo_small.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reservations for MGIF 2018</title>
</head>
<body>
	<!-- content -->
	<div class="content">
		<header>
			<h1>
				Reservations for Myanmar Global Investment Forum 2018
			</h1>
			<p>
				For group bookings, please contact us at
				<a href="mailto:den@linkinmyanmar.com">den@linkinmyanmar.com</a>
			</p>
		</header>
		<main>
			<form action="#" method="post">
				<ul>
					<li>
						Title: &nbsp;
						<select name="Title" id="Title">
							<option value="Mr.">Mr.</option>
							<option value="Ms.">Ms.</option>
							<option value="Mrs.">Mrs.</option>
						</select>
					</li>
					<li>
						First Name: &nbsp;
						<input type="text" name="Firstname" id="Firstname" required>
					</li>
					<li>
						Last Name: &nbsp;
						<input type="text" name="Lastname" id="Lastname" required>
					</li>
					<li>
						Organization: &nbsp;
						<input type="text" name="Organization" id="Organization" required>
					</li>
					<li>
						City: &nbsp;
						<input type="text" name="City" id="City" required>
					</li>
					<li>
						Telephone: &nbsp;
						<input type="text" name="Telephone" id="Telephone">
					</li>
					<li>
						Email: &nbsp;
						<input type="email" name="Email" id="Email" required>
					</li>
					<li>
						Arrival Date to Nay Pyi Taw: &nbsp;
						<input type="date" name="Arrival" required>
					</li>
					<li>
						Departure Date from Nay Pyi Taw: &nbsp;
						<input type="date" name="Departure" required>
					</li>
					<li class="sub-titles">Flights between Yangon & Nay Pyi Taw</li>
					<li>
						Flight Yangon - Nay Pyi Taw: &nbsp;
						<select name="RGNNYT">
							<option value="0">Own Arrangment</option>
							<?php
							$rows_RGNNYT = table_select_services('FL', 'Yangon - Nay Pyi Taw');
							foreach ($rows_RGNNYT as $row_RGNNYT) {
								echo "<option value=\"$row_RGNNYT->Id\">".date("H:i", strtotime($row_RGNNYT->ETD)).
								" - ".date("H:i", strtotime($row_RGNNYT->ETA)).", ".$row_RGNNYT->Supplier;
							}
							?>
						</select>
					</li>
					<li>
						Flight Nay Pyi Taw - Yangon: &nbsp;
						<select name="NYTRGN">
							<option value="0">Own Arrangment</option>
							<?php
							$rows_NYTRGN = table_select_services('FL', 'Nay Pyi Taw - Yangon');
							foreach ($rows_NYTRGN as $row_NYTRGN) {
								echo "<option value=\"$row_NYTRGN->Id\">".date("H:i", strtotime($row_NYTRGN->ETD)).
								" - ".date("H:i", strtotime($row_NYTRGN->ETA)).", ".$row_NYTRGN->Supplier;
							}
							?>
						</select>
					</li>
					<li>
						Hotel in Nay Pyi Taw: &nbsp;
						<select name="Hotel">
							<option value="0">Own Arrangment</option>
							<?php
							$rows_hotel = table_select_services('AC', NULL);
							foreach ($rows_hotel as $row_hotel) {
								echo "<option value=\"$row_hotel->Id\">".$row_hotel->Supplier." - ".$row_hotel->Service." : ".$row_hotel->Price." USD / night</option>";
							}
							?>
						</select>
					</li>
					<li>
						Airport pick-up & drop-off: &nbsp;
						<select name="Airport_Trf">
							<option value="0">Own Arrangement</option>
							<option value="1">On arrival and on departure: 40 USD</option>
							<option value="2">On arrival only: 20 USD</option>
							<option value="3">On departure only: 20 USD</option>
						</select>
					</li>
					<li>
						Special Request: &nbsp;
						<textarea name="Special" rows="3" cols="60"></textarea>
					</li>
					<li>
						Payment Methods: &nbsp;
						<select name="Payment">
							<option value="1">Bank Transfer (Our account in Singapore)</option>
							<option value="2">Visa / Master</option>
						</select>
					</li>
					<li>
						<button type="submit" name="buttonSubmit">Submit</button>
					</li>
				</ul>
			</form>
		</main>
	</div>
	<!-- end of content -->
</body>
</html>
