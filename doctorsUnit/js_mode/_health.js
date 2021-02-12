/////////////////////////////////////////////////////////////////////////////
function users_list() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3>Users</h3>";
    var url = "../admin/users_list";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function register_user() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3>Register User</h3>";
    var url = "../admin/member_add";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function register_member_next() {
    document.getElementById("wait").innerHTML = "<img src='../images/wait.png' >";
    var full_name = document.getElementById("full_name").value;
    if (full_name == "") {
        document.getElementById("click").disabled = false;
        document.getElementById("name_err").innerHTML = "Please Enter Full Name";
        return;
    }
    var user_name = document.getElementById("username").value;
    if (user_name == "") {
        document.getElementById("click").disabled = false;
        document.getElementById("username_err").innerHTML = "Please Enter Username";
        return;
    }
    var role = document.getElementById("role").value;
    if (role == "") {
        document.getElementById("click").disabled = false;
        document.getElementById("role").innerHTML = "Please Select role ";
        return;
    }
    var email_address = document.getElementById("email").value;
    if (email_address == "") {
        document.getElementById("click").disabled = false;
        document.getElementById("email_err").innerHTML = "Please Enter email";
        return;
    }

    var phone_no = document.getElementById("phone_no").value;
    if (phone_no == "") {
        document.getElementById("click").disabled = false;
        document.getElementById("phone_err").innerHTML = "Please Type Phone no";
        return;
    }
    var data = JSON.stringify({
        "full_name": full_name,
        "user_name": user_name,
        "role": role,
        "phone_no": phone_no,
        "email_address": email_address,
    });
    var url = "../admin/member_save?data=" + data;
    process_request_swal("result", url);
}
/////////////////////////////////////////////////////////////////////////////
function appointments_show() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3><i class='zmdi zmdi-account-calendar'></i>  Appointments</h3>";
    var url = "../doctor/appointment";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function schedule_show() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3><i class='zmdi zmdi-account-calendar'></i>  Appointments</h3>";
    var url = "../doctor/schedule";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function show_appointment(obj) {
    var day = obj.value;
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    var url = "../doctor/appointment_show?day=" + day;
    process_request_text("_display", url);
}

/////////////////////////////////////////////////////////////////////////////