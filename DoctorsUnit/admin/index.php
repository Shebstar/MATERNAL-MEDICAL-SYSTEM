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
$avatar_path = $row['avatar'];


$sql = "SELECT count(id) as 'total_online' FROM $table_users WHERE is_online='1'";
$row = get_from_table_sql_one($con, $sql);
$total_online = $row['total_online'];

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
                        <img src="<?php echo $avatar_path; ?>" alt="<?php echo $my_username; ?>" />
                    </div>
                    <h4 class="name"><?php echo $full_name; ?></h4>
                    <a href="../logout.php">Sign out</a>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="#" onclick="users_list()">
                                <i class="fas fa-users"></i>Users</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Fixtures
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="#" onclick="create_today_fixture_GSB()">
                                        <i class="fas fa-file-alt"></i>Today Fixture GSB
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="create_today_fixture()">
                                        <i class="fas fa-file-alt"></i>Today Fixture
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="create_mega_fixture()">
                                        <i class="fas fa-file"></i>Mega Fixture
                                    </a>
                                </li>
                            </ul>
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
                                <div class="header-button-item js-item-menu">
                                    <h5>Download Fixture</h5>
                                    <div class="search-dropdown js-dropdown">
                                        <div class="notifi__item">
                                            <div class="content" onclick="daily_fixture_display()">
                                                <p>Daily Fixture</p>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="content" onclick="mega_fixture_display()">
                                                <p onclick="">Mega Fixture</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <a href="index">
                                    <i class="fas fa-home"></i>Home</a>
                                <!-- <span class="inbox-num">3</span> -->
                            </li>
                            <li>
                                <a href="#" onclick="member_list()">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                            <li>
                                <a href="#" onclick="stake_sales()">
                                    <i class="fas fa-list"></i>Stake Sales</a>
                            </li>
                            <li>
                                <a href="#" onclick="balance_sales_search()">
                                    <i class="fas fa-list-alt"></i>Balance Sales</a>
                            </li>
                            <li>
                                <a href="#" onclick="statement_search()">
                                    <i class="zmdi zmdi-money"></i>Statement</a>
                            </li>
                            <li>
                                <a href="#" onclick="expenses_search()">
                                    <i class="fa fa-money"></i>Expenses</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-copy"></i>Fixtures
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" onclick="create_today_fixture()">
                                            <i class="fas fa-file-alt"></i>Today Fixture
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="create_today_fixture_GSB()">
                                            <i class="fas fa-file-alt"></i>Today Fixture GSB
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="create_mega_fixture()">
                                            <i class="fas fa-file"></i>Mega Fixture
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="../logout">
                                    <i class="fas fa-sign-out"></i>Sign Out</a>
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
                                <div class="col-md-6 col-lg-3">
                                    <div class="statistic__item">
                                        <h2 class="number"><?php echo $total_online; ?></h2>
                                        <span class="desc">Agents Online</span>
                                        <div class="icon">
                                            <i class="zmdi zmdi-account-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="statistic__item">
                                        <h2 class="number"><?php echo $total_mikeka_sold; ?></h2>
                                        <span class="desc">BetSlip Sold</span>
                                        <div class="icon">
                                            <i class="zmdi zmdi-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="statistic__item">
                                        <h2 class="number"><?php echo "TZS.$total_amount_per_day"; ?></h2>
                                        <span class="desc">Today</span>
                                        <div class="icon">
                                            <i class="zmdi zmdi-money"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="statistic__item">
                                        <h2 class="number"><?php echo "TZS.$total_amount"; ?></h2>
                                        <span class="desc">total earnings</span>
                                        <div class="icon">
                                            <i class="zmdi zmdi-money"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="recent-report2">
                                        <h3 class="title-3">Today Expenses</h3>
                                        <div class="recent-report__chart">
                                            <?php echo $table; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END STATISTIC-->
                <!-- <section>
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="recent-report2">
                                        <h3 class="title-3">recent reports</h3>
                                        <div class="chart-info">
                                            <div class="chart-info__left">
                                                <div class="chart-note">
                                                    <span class="dot dot--blue"></span>
                                                    <span>products</span>
                                                </div>
                                                <div class="chart-note">
                                                    <span class="dot dot--green"></span>
                                                    <span>Services</span>
                                                </div>
                                            </div>
                                            <div class="chart-info-right">
                                                <div class="rs-select2--dark rs-select2--md m-r-10">
                                                    <select class="js-select2" name="property">
                                                        <option selected="selected">All Properties</option>
                                                        <option value="">Products</option>
                                                        <option value="">Services</option>
                                                    </select>
                                                    <div class="dropDownSelect2"></div>
                                                </div>
                                                <div class="rs-select2--dark rs-select2--sm">
                                                    <select class="js-select2 au-select-dark" name="time">
                                                        <option selected="selected">All Time</option>
                                                        <option value="">By Month</option>
                                                        <option value="">By Day</option>
                                                    </select>
                                                    <div class="dropDownSelect2"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="recent-report__chart">
                                            <canvas id="recent-rep2-chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            </div>
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

    <script src="../vendor/sweetalert/sweetalert.min.js"></script>
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

</body>

</html>
<!-- end document-->