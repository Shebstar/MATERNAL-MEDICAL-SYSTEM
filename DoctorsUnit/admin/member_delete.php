<?php
session_start();
include "../functions/function.php";
include "../config_settings.php";
if (!isset($_SESSION['username']) and !trim($_SESSION['id'])) {
	header($root_system_url);
	exit;
} else {
	$my_username = $_SESSION['username'];
	$user_id = $_SESSION['id'];
	$id = $_REQUEST['id'];
	$added_by = $user_id;
	if (trim($added_by) != "") {
		$sql = "SELECT * FROM $table_users where id='$id'";
		$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
		$row = get_from_table_sql_one($con, $sql);
		$full_name = $row['Full_name'];
		//==================================================================================================
		$sql = "DELETE FROM $table_users WHERE id='$id'";
		$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
		$results = excute_command_inherite_con($con, $sql);
		if ($results == 1) {
			$activity = "Worker $full_name succesfully deleted by $my_username";
			record_activity_inherite_con($con, $table_activity, $added_by, $activity);
			echo "Worker <b>$full_name</b>  deleted ... ";
		} else {
			echo "<strong>Unexpected error, contact system admin</strong></div>";
		}
		echo "&nbsp;&nbsp;<button onclick='this.disabled=true;worker_list()'>Back.. </button>";
		close_connections($con);
	} else {
		echo "Unexpected Error, Try Again!";
	}
}
