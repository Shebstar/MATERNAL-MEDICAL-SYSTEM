<?php
session_start();
include "function.php";
include "config_settings.php";
$id = $_SESSION['id'];
$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
$sql = "SELECT * FROM $table_users WHERE id='$id'";
$row = get_from_table_sql_one($con, $sql);
if ($row == true) {
	$full_name = $row['username'];
	$activity = "User $full_name succesfully Logged out";
	record_activity_inherite_con($con, $table_activity, $id, $activity);
}
session_destroy();
header($root_system_url);
exit();
