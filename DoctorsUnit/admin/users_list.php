<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id'])) {
    header("location: $root_system_url");
    exit;
} else {
    $my_username = $_SESSION['username'];
    $found = 0;
    $k = 1;
    $sql = "SELECT * FROM $table_users";
    $con = connect_to_database($myServer, $myUser, $myPass, $myDB);
    $rows = get_from_table_sql($con, $sql);
    $tbody = "";
    $class == "";
    "";
    foreach ($rows as $row) {
        $id = $row['id'];
        $full_name = $row['full_name'];
        $username = $row['username'];
        $role = $row['role'];
        $low_role = strtolower($role);
        $Email = $row['email'];
        $Gender = $row['gender'];
        $Phone_no = $row['phone_no'];
        if ($low_role == "admin") {
            $class = "role admin";
        } else if ($low_role == "doctor") {
            $class = "role member";
        }
        $tbody .= "
            <tr style=\"cursor:pointer\" onclick=display_worker_details($id)>
            <td>$k</td>
            <td>
                <div class='table-data__info'>
                <h6>$full_name</h6>
                <span><a href='#'>$Email</a></span>
                </div>
            </td>
            <td><span class=\"$class\">$role</span></td>
            </tr>";
        $found = 1;
        $k++;
    }
    $table_display = "
                        <div class='table-responsive table-data'>
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <td>S/N</td>
                                        <td>Details</td>
                                        <td>role</td>
                                    </tr>
                                </thead>
                                <tbody>$tbody</tbody>
                            </table>
                        </div>
                        <div class='user-data__footer'>
                            <button class='au-btn au-btn-load'>load more</button>
                        </div>";
    if ($found == 1) {
        $xx = $table_display;
        $_SESSION['tag'] = $xx;
    } else {
        $xx = "NO DATA FOUND";
    }
}
?>

<section>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7">
                    <div class='user-data m-b-40'>
                        <h3 class='title-3 m-b-30'>
                            <i class='zmdi zmdi-account-calendar'></i>user data
                        </h3>
                        <div class="filters m-b-45">
                            <button class="btn btn-outline-primary" onclick="register_user()">Add New User</button>
                        </div>
                        <?php echo $xx; ?>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class='user-data m-b-40'>
                        <div class='recent-report2'>
                            <h4>Click at AnyRow to View User data</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>