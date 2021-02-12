<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
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
                                <div class='user-data m-b-40'>
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
                                                <tr>
                                                    <td class="avatar"><img src="../images/avatr.png"></td>
                                                    <td>
                                                        <div class='table-data__info'>
                                                            <h6>$full_name</h6>
                                                            <span><a href='#'>$Email</a></span>
                                                        </div>
                                                    </td>
                                                    <td><span>
                                                            <button class="btn bg-success">Accept</button>
                                                            <button class="btn bg-danger">Deny</button>
                                                        </span>
                                                    </td>
                                                </tr>
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