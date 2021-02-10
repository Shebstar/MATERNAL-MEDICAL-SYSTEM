<?php
error_reporting(0);
@ini_set('display_errors', 0);
session_start();
include "../config_settings.php";
include "../function.php";
$_SESSION['timeout'] = time() + 10;
$myusername = mssql_real_escape_string($_REQUEST['email']);
$mypassword = mssql_real_escape_string($_REQUEST['password']);
if (isset($_REQUEST['submit'])) {
	$myusername = md5($myusername);
	$hash_new_password = md5(sha1(md5($mypassword)));
	$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
	$sql = "SELECT * FROM $table_users WHERE hash_username='$myusername' AND password='$hash_new_password'";
	$array1 = get_from_table_sql_one($con, $sql);
	$id = $array1['id'];
	if ($id > 0) {
		$_SESSION['id'] = $id;
		$attempts = $array1['attempts'];
		$my_role = $array1['role'];
		$full_name = $array1['username'];
		$_SESSION['role'] = $my_role;
		$_SESSION['username'] = $array1['username'];
		$password_exp_date = trim($array1['password_exp_date']);
		if ($password_exp_date == "0") {
			$header = "Location: ../change_pwd";
			header($header);
		} else {
			if ($attempts > 3) {
				$sql = "UPDATE $table_users SET locked='locked' where id='$id'  ";
				excute_command_inherite_con($con, $sql);
				echo "User arleady locked";
			} else {
				$activity = "User $full_name succesfully Logged in";
				record_activity_inherite_con($con, $table_activity, $id, $activity);
				if ($my_role == $code_admin) {
					$header = "Location: ../admin/";
				} elseif ($my_role == $code_doctor) {
					$header = "Location: ../doctor/";
				} elseif ($my_role == $code_bussinesmann) {
					$header = "Location: ../busman_mod/busman_index";
				}
				header($header);
			}
		}
	}
}
