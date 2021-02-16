<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
}
$day = $_REQUEST['day'];
$today_date = date("Y-m-d");
$week_no = get_weekNo($today_date);
$username = $_SESSION['username'];
$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
$sql = "SELECT * FROM $table_appointments WHERE is_accepted='1' AND doctor_uname='$username'";
$rows = get_from_table_sql($con, $sql);
$display = "";
$flag = 0;
foreach ($rows as $row) {
    $AppointNo = $row['AppointNo'];
    $AppointDescription = $row['AppointDescription'];
    $FirstNameAP = $row['FirstNameAP'];
    $LastNameAP = $row['LastNameAP'];
    $UsernameAP = $row['UsernameAP'];
    $CityAP = $row['CityAP'];
    $Gender = $row['Gender'];
    $ZIPCODE = $row['ZIPCODE'];
    $created_at = $row['created_at'];
    $xx = explode(" ", $created_at);
    $date_created = $xx[0];
    $updated_at = $row['updated_at'];
    $full_name = "$FirstNameAP $LastNameAP";
    $sql_ = "SELECT * FROM $table_client WHERE name='$UsernameAP' ORDER BY created_at DESC";
    $rowx = get_from_table_sql_one($con, $sql_);
    $Email = $rowx['email'];
    if (($week_no == get_weekNo($date_created)) && (get_weekDay($date_created) == $day)) {
        $flag = 1;
        $display .= "
        <tr>
        <td class='avatar'><img src='../images/avatr.png'></td>
        <td>
            <div class='table-data__info'>
            <h5>$full_name</h5>
            <span><a href='#'><i class='fa fa-envelope'></i> $Email</a></span><br>
            <span><a href='#'><i class='fa fa-map-marker-alt'></i> $CityAP</a></span><br>
            </div>
        </td>
        <td>$created_at</td>
    </tr>
        ";
    }
}
if ($flag == 1) {
    $table = "
<table class='table'>
    <thead>
        <tr>
            <td>Profile pic</td>
            <td>Details</td>
            <td>Time</td>
        </tr>
    </thead>
    <tbody>$display</tbody>
</table>";
} else {
    $table = "";
}

echo $table;
