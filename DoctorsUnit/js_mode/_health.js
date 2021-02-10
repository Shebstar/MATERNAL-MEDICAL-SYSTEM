/////////////////////////////////////////////////////////////////////////////
function users_show() {
    document.getElementById("wait").innerHTML = "<img src='../images/wait.png' >";
    var url = "bet_mod/reload_mkeka";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function check_login() {
    var email = get_input_value_byid("email");
    var password = get_input_value_byid("password");
    if (email == "") {
        document.getElementById("email").style.borderColor = "red";
        document.getElementById("email_err").innerHTML = "Please Type Email";
        document.getElementById("btn").disabled = true;
    } else {
        document.getElementById("email").style.borderColor = "#eeee";
        document.getElementById("email_err").innerHTML = "";
        document.getElementById("btn").disabled = false;
    }
    if (password == "") {
        document.getElementById("password").style.borderColor = "red";
        document.getElementById("password_err").innerHTML = "Please Type Password";
        document.getElementById("btn").disabled = true;
    } else {
        document.getElementById("password").style.borderColor = "#eeee";
        document.getElementById("password_err").innerHTML = "";
        document.getElementById("btn").disabled = false;
    }
    var name1 = calcMD5(email);
    alert(name1);
}
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
function search_role_table(obj) {
    var input = obj;
    var filter, table, tr, td, i, txtValue;
    filter = input.value.toUpperCase();
    table = document.getElementById('dtBasicExample');
    tr = table.getElementsByTagName('tr');
    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[3];
        var td1 = tr[i].getElementsByTagName('td')[3];
        if (td || td1) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}
/////////////////////////////////////////////////////////////////////////////
function expenses_search() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3>Expenses</h3>";
    var url = "../auditor_mod/expenses_search";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function stake_sales_list() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    var from_date = document.getElementById("from_date").value;
    var to_date = document.getElementById("to_date").value;
    var data = JSON.stringify({
        "from_date": from_date,
        "to_date": to_date
    });
    var url = "../auditor_mod/stake_sales_list?data=" + data;
    process_request_tag_many_args("result", url, "initilize_dataTable_type2('dtBasicExample');");
}
/////////////////////////////////////////////////////////////////////////////
function expenses_list() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    var from_date = document.getElementById("from_date").value;
    var to_date = document.getElementById("to_date").value;
    var data = JSON.stringify({
        "from_date": from_date,
        "to_date": to_date
    });
    var url = "../auditor_mod/expenses_list?data=" + data;
    process_request_tag_many_args("result", url, "initilize_dataTable_type2('dtBasicExample');");
}
/////////////////////////////////////////////////////////////////////////////
function appointments_show() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3><i class='zmdi zmdi-account-calendar'></i>  Appointments</h3>";
    var url = "../doctor/appointment_show";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function balance_sales_show() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    var from_date = document.getElementById("from_date").value;
    var to_date = document.getElementById("to_date").value;
    var data = JSON.stringify({
        "from_date": from_date,
        "to_date": to_date
    });
    var url = "../auditor_mod/balance_sales_show?data=" + data;
    process_request_tag_many_args("result", url, "initilize_dataTable_type2('dtBasicExample');");
}
/////////////////////////////////////////////////////////////////////////////
function statement_search() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    document.getElementById("heading").innerHTML = "<h3>Statement</h3>";
    var url = "../auditor_mod/statement_search";
    process_request_text("content", url);
}
/////////////////////////////////////////////////////////////////////////////
function statement_show() {
    document.getElementById("wait").innerHTML = "Wait... <img src='../images/wait.gif' >";
    var from_date = document.getElementById("from_date").value;
    var to_date = document.getElementById("to_date").value;
    var data = JSON.stringify({
        "from_date": from_date,
        "to_date": to_date
    });
    var url = "../auditor_mod/statement_show?data=" + data;
    process_request_tag_many_args("result", url, "initilize_dataTable_type2('dtBasicExample');");
}
/////////////////////////////////////////////////////////////////////////////