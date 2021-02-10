<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
} else {
?>
    <section>
        <div class='section__content section__content--p30'>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-xl-12'>
                        <div class='recent-report2'>
                            <div id="result">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="full_name" class="form-control-label">Full Name:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="full_name" placeholder="Full Name" class="form-control">
                                        <small class="form-text text-danger" id="name_err"></small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="username" class="form-control-label">Username:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="username" placeholder="Username" class="form-control">
                                        <small class="form-text text-danger" id="username_err"></small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email" class=" form-control-label">Email:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="email" id="email" placeholder="Enter Email" class="form-control">
                                        <small class="form-text text-danger" id="email_err"></small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="role" class=" form-control-label">Role</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select id="role" class="form-control">
                                            <option value="">-- select role--</option>
                                            <option value="ADMIN">Admin</option>
                                            <option value="DOCTOR">Doctor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="phone_no" class=" form-control-label">Phone no:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="email" id="phone_no" placeholder="Phone No:" class="form-control">
                                        <small class="form-text text-danger" id="phone_err"></small>
                                    </div>
                                </div>
                                <!-- <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="password-input" class=" form-control-label">Password</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password-input" name="password-input" placeholder="Password" class="form-control">
                                    <small class="help-block form-text">Please enter a complex password</small>
                                </div>
                            </div> -->
                                <div class="row form-group">
                                    <div class="col col-md-3"></div>
                                    <div class="col-12 col-md-9">
                                        <button class="btn btn-primary btn-sm" id="click" onclick="this.disabled=true;register_member_next()">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>