<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
}
$days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
?>
<section class="statistic">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="recent-report2">
                                    <div style="display:flex;border-bottom: 1px solid #f0f0f0;border-radius: 4px 4px 0 0;padding: 10px 20px;">
                                        <?php
                                        for ($i = 0; $i < count($days); $i++) {
                                            echo "<input type='button' onclick='show_appointment(this)' class='btn btn-outline-primary' value='$days[$i]'>";
                                        }
                                        ?>
                                    </div>
                                    <div id="_display">
                                        jghjgfhgfgf
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