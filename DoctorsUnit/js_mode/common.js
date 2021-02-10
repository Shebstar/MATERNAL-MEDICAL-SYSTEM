function startupload() {
    document.getElementById("wait").innerHTML = "<img src='images/wait.gif'>";
}
/////////////////////////////////////////////////////////////////////////////
function remove_arr(arr, value) {
    for (var i = arr.length; i--;) {
        if (arr[i] === value) {
            arr.splice(i, 1);
        }
    }
}
/////////////////////////////////////////////////////////////////////////////
function get_input_value_byid(id) {
    var value = "";
    try {
        value = document.getElementById(id).value;
    } catch (e) {}
    return value;
}
////////////////////////////////////////////////////////////////////////////
function stopUpload_dms(filename, reference, done, id) {
    if ((filename != "") & (done == 1)) {
        document.getElementById("wait").innerHTML = "File uploaded successful";
        document.getElementById("reference" + id).value = reference;
    } else {
        document.getElementById("wait").innerHTML = "Fail upload file";
    }
}
////////////////////////////////////////////////////////////////////////////
function stopUpload_dms_display(filename, reference, id, file_name, display_tag) {
    if (filename != "") {
        document.getElementById("wait").innerHTML = "File uploaded successful";
        document.getElementById("reference" + id).value = reference;
        document.getElementById("file_name" + id).value = file_name;
        document.getElementById("display_after_upload").innerHTML = display_tag;
    } else {
        document.getElementById("wait").innerHTML = "Fail upload file";
    }
}
////////////////////////////////////////////////////////////////////////////
function lock_my_account() {
    document.getElementById("wait").innerHTML = "Wait ... <img src='images/wait.gif' >";
    document.getElementById("legend").innerHTML = "&nbsp;&nbsp;<img src='images/create.png'  height='30' width='30'>&nbsp;&nbsp;Lock My Account";
    var url = "admin_mod/lock_my_account";
    process_request("crdb_canvas", url);
}
////////////////////////////////////////////////////////////////////////////////
function date_difference(date1, date2) {
    dt1 = new Date(date1);
    dt2 = new Date(date2);
    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24));
}
/////////////////////////////////////////////////////////////////////////////////////////
function is_complex(a) {
    if (a.match("^[a-zA-Z0-9]*$")) {
        return false;
    } else {
        //Not alphanumeric
        if (is_small_capital_number(a) == true) {
            return true;
        }
    }
}
/////////////////////////////////////////////////////////////////////////////////////////
function is_small_capital_number(a) {
    var rea1 = /[^a-z]/g;
    var reA = /[^A-Z]/g;
    var reN = /[^0-9]/g;
    var text = a.replace(reA, "");
    var text1 = a.replace(rea1, "");
    var num = a.replace(reN, "");
    if ((num != "") && (text != "") && (text1 != "")) {
        return true
    }
}
////////////////////////////////////////////////////////////////////
function ValidateEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,10})+$/;
    if (inputText.match(mailformat)) {
        return true;
    } else {
        return false;
    }
}
/////////////////////////////////////////////////////////////////////////////
function process_request_many_args(id, url, args_src) {
    var args = args_src.split(";");
    var ajaxRequest;
    ajaxRequest = obshii(ajaxRequest);
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            var ajaxDisplay = document.getElementById(id);
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            document.getElementById("wait").innerHTML = "&nbsp;";
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            for (var i = 0; i < args.length; i++) {
                eval(args[i]);
            }
            return 1;
        }
    }
    var res = url.split("?");
    ajaxRequest.open("POST", res[0], true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(res[1]);
}
//////////////////////////////////////
function initilize_dataTable_type2(id) {
    $(document).ready(function() {
        $('#' + id).DataTable({
            pageLength: 100,
            "oLanguage": {
                "sSearch": "_INPUT_",
                "sSearchPlaceholder": "Search...",
            },
            dom: 'Bfrtip',
            lengthMenu: [100, 200, 500],
        });
    });
}
///////////////////////////////////////////////////////////////
function initilize_dataTable(id) {
    $(document).ready(function() {
        $('#' + id).dataTable();
        document.getElementById("myTable_length").style.width = "20px";

    });
}
////////////////////////////////////////////////////////////////////////////
function process_request_text(id, url) {
    var ajaxRequest;
    ajaxRequest = obshii(ajaxRequest);
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            var ajaxDisplay = document.getElementById(id);
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            document.getElementById("wait").innerHTML = "&nbsp;";
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            return 1;
        }
    }
    var res = url.split("?");
    ajaxRequest.open("POST", res[0], true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(res[1]);
}
////////////////////////////////////////////////////////////////////////////////////////
function reset_password() {
    document.getElementById("wait").innerHTML = "Wait ... <img src='images/wait.gif' >";
    var old_password = document.getElementById("old_password").value;
    old_password = calcMD5(old_password);
    var ajaxRequest; // The variable that makes Ajax possible!	
    ajaxRequest = obshii(ajaxRequest);
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            var xx;
            xx = ajaxRequest.responseText;
            if (xx == "1") {
                document.getElementById("wait").innerHTML = "&nbsp;";
                reset_password_now();
            } else if (xx == -1) {
                document.getElementById("wait").innerHTML = "<i>Unexpected error try again!</i>";
            } else {
                document.getElementById("wait").innerHTML = "<i>Old password is incorrect !</i>";
            }
        }
    }
    ajaxRequest.open("POST", "password_mod/get_old_password.php?old_password=" + old_password, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(null);
}
///////////////////////////////////////////////////
function obshii(ajaxRequest) {
    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    return ajaxRequest;
}
/////////////////////////////////////////////////////////////////
function automatic_logout(location) {
    var url = "login_mod/automatic_logout";
    var ajaxRequest = obshii(ajaxRequest);
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            var result = ajaxRequest.responseText;
            if (result == 1) {
                window.location = location;
            }
        }
    }
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(null);
}
///////////////////////////////////////////////////////////
function replaceee(text, substr, newstring) {
    for (var i = 0; i < text.length; i++) {
        text = text.replace(substr, newstring);
    }
    return text;
}
///////////////////////////////////////////////////////////
function hide_show_reason(obj, reason_tag, Reject) {
    if (obj.value == Reject) {
        document.getElementById(reason_tag).style.visibility = "visible";
    } else {
        document.getElementById(reason_tag).style.visibility = "hidden";
    }
}
/////////////////////////////////////////////////////////////////////////////
function process_request_no_response(url) {
    var ajaxRequest;
    ajaxRequest = obshii(ajaxRequest);
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {}
    };
    var res = url.split("?");
    ajaxRequest.open("POST", res[0], true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(res[1]);
}
/////////////////////////////////////////////////////////////////////////////
function display_alert(text_, title_, icon_, button_) {
    swal({
        title: title_,
        text: text_,
        icon: icon_,
        button: button_
    });
}
////////////////////////////////////////////////////////////////////////////
function process_request_swal(id, url) {
    var ajaxRequest;
    ajaxRequest = obshii(ajaxRequest);
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            var ajaxDisplay = document.getElementById(id);
            var response_ = ajaxRequest.responseText;
            var json_obj = JSON.parse(response_);
            var code = json_obj.code;
            var html_response = json_obj.html_response;
            ajaxDisplay.innerHTML = html_response;
            document.getElementById("wait").innerHTML = "&nbsp;";
            ajaxDisplay.innerHTML = html_response;
            var text = "",
                title = "",
                icon = "",
                button = "";
            if (code == 200) {
                text = json_obj.text;
                title = "success";
                icon = "success";
                button = "Done";
            } else if (code == 400) {
                text = json_obj.error;
                title = "warning";
                icon = "warning";
                button = "Try Again";
            }
            display_alert(text, title, icon, button);
        }
    };
    var res = url.split("?");
    ajaxRequest.open("POST", res[0], true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(res[1]);
}

//////////////////////////////////////////////////////////////////