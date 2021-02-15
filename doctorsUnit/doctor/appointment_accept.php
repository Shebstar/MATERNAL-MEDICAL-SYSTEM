<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
}
$AppointNo = $_REQUEST['AppointNo'];
$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
$sql = "UPDATE $table_appointments SET is_accepted='1' WHERE AppointNo='$AppointNo' AND doctor_uname='$username'";
$result = excute_command_inherite_con($con, $sql);
if ($result == 1) {
    $html_response = "Appointment Successfull Accepted
			&nbsp;&nbsp;<button class='btn btn-success' onclick='this.disabled=true;appointments_show()'>Show Appointments... </button>";
    $text = "Appintment successful Accepted";
    $response_ = array("code" => 200, "error" => "", "html_response" => "$html_response", "text" => "$text");
} else {
    $html_response = "<strong>Unexpected error, contact system admin</strong></div>
    &nbsp;&nbsp;<button class='btn-danger' onclick='this.disabled=true;ipd_patients()'>Try Again... </button>";
    $response_ = array("code" => 400, "error" => "Unexpected error occur, Please Try Again!", "html_response" => "$html_response");
}
close_connections($con);
$response = json_encode($response_);
echo $response;
