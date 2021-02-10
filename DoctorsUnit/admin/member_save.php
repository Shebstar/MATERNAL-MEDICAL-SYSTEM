<?php
session_start();
include '../function.php';
include '../config_settings.php';
$my_username = $_SESSION['username'];
$id = $_SESSION['id'];
if (!isset($my_username) and !isset($id)) {
    header($root_system_url);
    exit;
} else {
    $added_by = $_SESSION['id'];
    if (trim($added_by) != '') {
        $json_array = json_decode($_REQUEST['data'], true);
        $full_name = _real_escape_string($json_array['full_name']);
        $username = _real_escape_string($json_array['user_name']);
        $hash_username = md5($username);
        $role = _real_escape_string($json_array['role']);
        $_phone_no = _real_escape_string($json_array['phone_no']);
        $phone_no = resolve_phone_number($_phone_no);
        $email_address = _real_escape_string($json_array['email_address']);
        $gender = _real_escape_string($json_array['gender']);
        $sql = "INSERT INTO $table_users (full_name, username, hash_username, role, phone_no, email, ip_author) 
	        VALUES ('$full_name', '$username', '$hash_username','$role','$phone_no','$email_address', '$ip_address')";
        //==================================================================================================
        $con = connect_to_database($myServer, $myUser, $myPass, $myDB);
        $results = excute_command_inherite_con($con, $sql);
        if ($results == 1) {
            $activity = "Worker $full_name succesfully added by $my_username";
            record_activity_inherite_con($con, $table_activity, $added_by, $activity);
            $html_response = "Worker <b>$full_name</b>  successfull added ... 
			&nbsp;&nbsp;<button class='btn btn-success' onclick='this.disabled=true;register_member()'>New Worker... </button>";
            $text = "$role $full_name successful Added";
            $response_ = array("code" => 200, "error" => "", "html_response" => "$html_response", "text" => "$text");
        } else {
            $html_response = "<strong>Unexpected error, contact system admin</strong></div>
            &nbsp;&nbsp;<button class='btn-danger' onclick='this.disabled=true;ipd_patients()'>Try Again... </button>";
            $response_ = array("code" => 400, "error" => "Unexpected error occur, Please Try Again!", "html_response" => "$html_response");
        }
        close_connections($con);
        $response = json_encode($response_);
        echo $response;
    } else {
        echo "Unexpected Error, <a href='../profil_mod/404'>Try Again!</a>";
    }
}
