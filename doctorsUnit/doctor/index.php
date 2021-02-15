<?php
session_start();
include '../config_settings.php';
include '../function.php';
$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
if (empty($_SESSION['username']) and empty($_SESSION['id'])) {
    $_SESSION['username'] = $_REQUEST['myusername'];
    $_SESSION['id'] = $_REQUEST['myuserid'];
}
$my_username = $_SESSION['username'];
$id = $_SESSION['id'];
if (!isset($my_username) and !isset($id)) {
    $link = "../logout.php";
    header("Location: $link");
    exit;
}
$today_year = date('Y');
$today_month = date('Y-m');
$today_date = date('Y-m-d');
$today_time = date('Y-m-d H:i:s');

$sql = "SELECT * FROM $table_users WHERE id=$id";
$row = get_from_table_sql_one($con, $sql);
$full_name = $row['full_name'];


$sql = "SELECT count(AppointNo) as 'appointments' FROM $table_appointments WHERE doctor_uname='$my_username'";
$row = get_from_table_sql_one($con, $sql);
$appointments = $row['appointments'];

$sql = "SELECT count(id) as 'total_mikeka_sold', sum(amount) as 'total_amount' FROM $table_mikeka 
    WHERE date_time LIKE '$today_date%' AND is_payed='1' AND is_printed='1' AND is_cancelled='0'";
$row = get_from_table_sql_one($con, $sql);
$total_mikeka_sold = $row['total_mikeka_sold'];
$total_amount_per_day = $row['total_amount'];
$total_amount_per_day = formatMoney($total_amount_per_day, 0);

$sql = "SELECT sum(amount) as 'total_amount' FROM $table_mikeka WHERE is_payed='1' AND is_printed='1' AND is_cancelled='0'";
$row = get_from_table_sql_one($con, $sql);
$total_amount = $row['total_amount'];
$total_amount = formatMoney($total_amount, 0);
//-------------------------------
$sql_cancelled = "SELECT count(id) as 'cancelled', sum(amount) as 'cancelled_sales' FROM $table_mikeka WHERE date_time LIKE '$today_date%' AND is_cancelled='1' AND is_payed='1' AND is_printed='1'";
$row_cancelled = get_from_table_sql_one($con, $sql_cancelled);
$cancelled_sales = $row_cancelled['cancelled_sales'];
if ($cancelled_sales == "") {
    $cancelled_sales = 0;
}
$cancelled = $row_cancelled['cancelled'];
$sql = "SELECT * FROM $table_expenses WHERE date_time LIKE '$today_date%' LIMIT 10";
$con = connect_to_database($myServer, $myUser, $myPass, $myDB);
$rows = get_from_table_sql($con, $sql);
$tbody = "";
$k = 1;
foreach ($rows as $row) {
    $id = $row['id'];
    $maelezo = $row['maelezo'];
    $approved_by = $row['approved_by'];
    $date_time = $row['date_time'];
    $amount = $row['amount'];
    $tbody .= "<tr>
                <td>$k</td>
                <td>$maelezo</td>
                <td>$approved_by</td>
                <td>$amount</td>
                <td>$date_time</td>
              </tr>";
    $found = 1;
    $k++;
}
$table = "";
if ($found == 1) {
    $table = "<table id='dtBasicExample' class='dataTable table table-borderless table-striped table-sm'>
<thead>
    <th>S/N</th>
    <th>Maelezo</th>
    <th>Approved by</th>
    <th>Amount</th>
    <th>Date & Time</th>
</thead>
<tbody> $tbody</tbody>
</table>";
} else {
    $table = "<div align='center'>No data Available</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $system_name_short_name; ?></title>
    <!-- Fontfaces CSS-->
    <link href="../css/font-face.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <!-- Bootstrap CSS-->
    <link href="../vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <!-- Vendor CSS-->
    <link href='../vendor/fullcalendar-3.10.0/fullcalendar.css' rel='stylesheet' media="all" />
    <link href="../vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="../vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="../vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">
    <link href="../css/theme.css" rel="stylesheet" media="all">
    <link href="../css/health.css" rel="stylesheet" media="all">
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <h1><?php echo $system_name_short_name; ?></h1>
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="../images/team-image1.jpg" alt="<?php echo $my_username; ?>" />
                    </div>
                    <h4 class="name"><?php echo $full_name; ?></h4>
                    <a href="../logout.php">Sign out</a>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="./">
                                <i class="fas fa-envelope"></i>Inbox</a>
                            <span class="inbox-num">3</span>
                        </li>
                        <li>
                            <a href="#" onclick="appointments_show()">
                                <i class="fas fa-list-alt"></i>Appointments</a>
                            <span class="inbox-num"><?php echo $appointments; ?></span>
                        </li>
                        <li>
                            <a href="#" onclick="schedule_show()">
                                <i class="fas fa-calendar-alt"></i>Schedule</a>
                            <span class="inbox-num">3</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <h2><?php echo $system_name_short_name; ?></h2>
                                </a>
                            </div>
                            <div class="header-button2">
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-settings"></i>Setting</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="../logout"><i class="fa fa-sign-out"></i>Sign out</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <h1><?php echo $system_name_short_name; ?></h1>
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar1">
                    <nav class="navbar-sidebar2">
                        <ul class="list-unstyled navbar__list">
                            <li>
                                <a href="inbox">
                                    <i class="fas fa-envelope"></i>Inbox</a>
                                <span class="inbox-num">3</span>
                            </li>
                            <li>
                                <a href="#" onclick="appointments_show()">
                                    <i class="fas fa-list-alt"></i>Appointments</a>
                                <span class="inbox-num"><?php echo $appointments; ?></span>
                            </li>
                            <li>
                                <a href="#" onclick="schedule_show()">
                                    <i class="fas fa-calendar-alt"></i>Schedule</a>
                                <span class="inbox-num">3</span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <section class="au-breadcrumb m-t-75">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left" id="heading">
                                        <h3 id="heading">Home</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="wait" align='center'></div>
            <div id="content">
                <!-- STATISTIC-->
                <section class="statistic">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                                        <div class="au-card-title">
                                            <div class="bg-overlay bg-overlay--blue"></div>
                                            <h3>
                                                <i class="zmdi zmdi-account-calendar"></i>Notification
                                            </h3>
                                        </div>
                                        <div class="au-inbox-wrap js-inbox-wrap">
                                            <div class="au-message js-list-load">
                                                <div class="au-message-list">
                                                    <div class="au-message__item unread">
                                                        <div class="au-message__item-inner">
                                                            <div class="au-message__item-text">
                                                                <div class="avatar-wrap">
                                                                    <div class="avatar">
                                                                        <img src="../images/avatr.png" alt="John Smith">
                                                                    </div>
                                                                </div>
                                                                <div class="text">
                                                                    <h5 class="name">Catherine Fungo</h5>
                                                                    <p>Book an appointment</p>
                                                                </div>
                                                            </div>
                                                            <div class="au-message__item-time">
                                                                <span>12 Min ago</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="au-message__item unread">
                                                        <div class="au-message__item-inner">
                                                            <div class="au-message__item-text">
                                                                <div class="avatar-wrap online">
                                                                    <div class="avatar">
                                                                        <img src="../images/avatr.png" alt="Nicholas Martinez">
                                                                    </div>
                                                                </div>
                                                                <div class="text">
                                                                    <h5 class="name">Joyce Ally</h5>
                                                                    <p>Poor services received</p>
                                                                </div>
                                                            </div>
                                                            <div class="au-message__item-time">
                                                                <span>11:00 PM</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="au-message__item">
                                                        <div class="au-message__item-inner">
                                                            <div class="au-message__item-text">
                                                                <div class="avatar-wrap online">
                                                                    <div class="avatar">
                                                                        <img src="../images/doc_ava.jpg" alt="Michelle Sims">
                                                                    </div>
                                                                </div>
                                                                <div class="text">
                                                                    <h5 class="name">Clinical Guidelines</h5>
                                                                    <p>

                                                                    <h5>Management of inevitable abortion in Dispensary & Health Centre</h5>
                                                                    <ul>
                                                                        <li>Apply Airway, Breathing, Circulation and Dehydration (ABCD) principles of resuscitation </li>
                                                                        <li>Check Hb level. </li>
                                                                        <li>Give IV Ringers Lactate (RL)/Normal Saline (NS) 2litres</li>
                                                                        <li>Perform Manual Vacuum Aspiration (MVA) in health centre if gestation age is below 12 weeks </li>
                                                                        <li>Augment the process by administering oxytocin 20 IU in 500mls RL/NS at 40–60 drops/minute if gestation age is above 12 weeks </li>
                                                                        <li>Manage as incomplete abortion if after augmentation some products of conception remain in the uterus </li>
                                                                        <li>Manage as complete abortion if all product of conception are expelled</li>
                                                                    </ul>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="au-message__item-time">
                                                                <span>Yesterday</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="au-message__item">
                                                        <div class="au-message__item-inner">
                                                            <div class="au-message__item-text">
                                                                <div class="avatar-wrap">
                                                                    <div class="avatar">
                                                                        <img src="../images/avatr.png" alt="Michelle Sims">
                                                                    </div>
                                                                </div>
                                                                <div class="text">
                                                                    <h5 class="name">Michelle Sims</h5>
                                                                    <p>Rescheduled an Appointment</p>
                                                                </div>
                                                            </div>
                                                            <div class="au-message__item-time">
                                                                <span>Sunday</span>
                                                            </div>
                                                        </div>
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
                <section>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p><?php echo $system_name_short_name; ?> &copy; <?php echo date("Y"); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END PAGE CONTAINER-->
            </div>
        </div>


        <script type="text/javascript" src="../js_mode/base64.js"></script>
        <script type="text/javascript" src="../js_mode/common.js"></script>
        <!-- Jquery JS-->
        <script src="../js/jquery.js"></script>
        <!-- Bootstrap JS-->
        <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS -->
        <script src="../vendor/slick/slick.min.js"></script>
        <script src="../vendor/wow/wow.min.js"></script>
        <script src="../vendor/animsition/animsition.min.js"></script>
        <script src="../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <script src="../vendor/counter-up/jquery.waypoints.min.js"></script>
        <script src="../vendor/counter-up/jquery.counterup.min.js"></script>
        <script src="../vendor/circle-progress/circle-progress.min.js"></script>
        <script src="../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../vendor/chartjs/Chart.bundle.min.js"></script>
        <script src="../vendor/select2/select2.min.js"></script>
        <script src="../vendor/fullcalendar-3.10.0/lib/moment.min.js"></script>
        <script src="../vendor/fullcalendar-3.10.0/fullcalendar.js"></script>
        <!-- Main JS-->
        <script src="../js/main.js"></script>
        <script src="../js_mode/_health.js"></script>
        <script src="../js/daypilot-all.min.js"></script>

</body>

</html>
<!-- end document-->