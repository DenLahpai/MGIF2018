<?php
require "functions.php";

//getting the delegates Id
$DelegateId = trim($_REQUEST['DelegateId']);

$rows_delegates = table_select_delegates($DelegateId);
foreach ($rows_delegates as $row_delegates) {
    $DelegateId = $row_delegates->Id;
}

$rows_data = table_select_bookings($DelegateId);
foreach ($rows_data as $row_data) {

}
$Email = $row_data->Email;

//Emailing the summary
$mailto = "info@linkinmyanmar.com,
    den@linkinmyanmar.com,
    $Email,
";
$subject = "Reservations for Myanmar Global Investment Forum 2018";

$message = "
    <ul style=\"list-style: none;\">
        <li>Title: $row_data->Title</li>
        <li>First Name: $row_data->Firstname</li>
        <li>Last Name: $row_data->Lastname</li>
        <li>Organization: $row_data->Organization</li>
        <li>City: $row_data->City</li>
        <li>Telephone: $row_data->Telephone</li>
        <li>Email: $row_data->Email</li>
        <br>
        <h4>Services:</h4>
";

foreach ($rows_data as $row_data) {
    if ($row_data->Type == 'FL') {
        switch ($row_data->Service) {
            case 'Yangon - Nay Pyi Taw':
            $message .= "<li>".date('d-M-Y', strtotime($row_data->Arrival)).": ".$row_data->Supplier.", ".$row_data->Service.": "
            .date('H:i', strtotime($row_data->ETD))." - ".date('H:i', strtotime($row_data->ETA))."</li>";
                break;

            default:
            $message .= "<li>".date('d-M-Y', strtotime($row_data->Departure)).": ".$row_data->Supplier.", ".$row_data->Service.": "
            .date('H:i', strtotime($row_data->ETD))." - ".date('H:i', strtotime($row_data->ETA))."</li>";
                break;
        }
    }
    else {
        $message .= "<li><span style='font-weight: bold';>".$row_data->Supplier."</span> - ".$row_data->Service." Room, ";
        $message .= "Check-in: ".date('d-M-Y', strtotime($row_data->Arrival)).", ";
        $message .= "Check-out: ".date('d-M-Y', strtotime($row_data->Departure))."</li>";
    }
}

$message .= "<li>";
switch ($row_data->Airport_Trf) {
    case '0':
        $message .= "Airport Pick-up & Drop-off: Own Arrangement";
        break;

    case '1':
        $message .= "Airport Pick-up & Drop-off: On arrival and on departure";
        break;

    case '2':
        $message .= "Airport Pick-up & Drop-off: On arrival only";
        break;

    case '3':
        $message .= "Airport Pick-up & Drop-off: On departure only";
        break;

    default:
        // code...
        break;
}
$message .= "</li>";

$header = "FROM: $row_data->Firstname $row_data->Lastname <$row_data->Email>\r\n";
$header .= "Content-type: text/html\r\n";

mail($mailto, $subject, $message, $header);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

    </body>
</html>
