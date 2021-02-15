<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
}
$username = $_SESSION['username'];
$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
$sql = "SELECT * FROM $table_appointments WHERE is_accepted='0' AND doctor_uname='$username'";
$rows = get_from_table_sql($con, $sql);
$tbody = "";
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
    $updated_at = $row['updated_at'];
    $full_name = "$FirstNameAP $LastNameAP";
    $sql_ = "SELECT * FROM $table_client WHERE name='$UsernameAP'";
    $rowx = get_from_table_sql_one($con, $sql_);
    $Email = $rowx['email'];
    $tbody .= "
    <tr>
        <td class='avatar'><img src='../images/avatr.png'></td>
        <td>
            <div class='table-data__info'>
            <h5>$full_name</h5>
            <span><a href='#'><i class='fa fa-envelope'></i> $Email</a></span><br>
            <span><a href='#'><i class='fa fa-map-marker-alt'></i> $CityAP</a></span><br>
            </div>
        </td>
        <td><span>
            <button class='btn bg-success' onclick='accept_appointment($AppointNo)'>Accept</button>
            <button class='btn bg-danger' onclick='deny_appointment()'>Deny</button>
            </span>
        </td>
    </tr>";
}
?>
<section class="statistic">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class='user-data m-b-40' id="display">
                                    <div class='table-responsive table-data'>
                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                    <td>Profile pic</td>
                                                    <td>Details</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo $tbody; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>