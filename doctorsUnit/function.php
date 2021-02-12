<?php
if (!isset($_SESSION)) {
  session_start();
}
error_reporting(0);
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
date_default_timezone_set("Africa/Dar_es_salaam");

define("cipher_method", "AES-128-CBC");
//**********************************************************************************************************************************
function add_time($date_, $str_interval)
{
  $date = date_create($date_);
  date_add($date, date_interval_create_from_date_string($str_interval));
  return date_format($date, 'Y-m-d');
}
//****************************************************************************
function get_reference()
{
  return md5(date('Y-m-d H:i:s') . uniqid());
}
//********************************************************************************************** */
function dateDifference($date_1, $date_2, $differenceFormat = '%a')
{
  $datetime1 = date_create($date_1);
  $datetime2 = date_create($date_2);
  $interval = date_diff($datetime1, $datetime2);
  return $interval->format($differenceFormat);
}
//************************************************************************************************************
function resolve_phone_number($phone_number)
{
  if (trim($phone_number) == "") {
    return "";
  }
  $phone_number = trim($phone_number);
  $phone_number = remove_space_phone_number($phone_number);
  $phone_number = str_ireplace("-", "", $phone_number);
  $phone_number = str_ireplace(".", "", $phone_number);
  $phone_number = str_ireplace("(", "", $phone_number);
  $phone_number = str_ireplace(")", "", $phone_number);
  $zero = substr($phone_number, 0, 1);
  if ($zero == "+")
    $phone_number = substr($phone_number, 1);
  else {
    if ($zero == "0") {
      $phone_number = "255" . substr($phone_number, 1);
    }
  }
  $phone_number = str_ireplace(" ", "", $phone_number);
  $pattern1 = '/[0-9]*/';
  $character = preg_replace($pattern1, '', $phone_number);
  if (strlen($character) > 1) {
    $delimeter = $character[1];
    $x = explode($delimeter, $phone_number);
    $pattern = '/[^0-9]/';
    $phone = preg_replace($pattern, '', $x[0]);
  } else {
    $pattern = '/[^0-9]/';
    $phone = preg_replace($pattern, '', $phone_number);
  }
  return choosenumber($phone);
}
//*********************************************************************************************
function remove_space_phone_number($string)
{
  $string = strip_tags($string);
  $string = str_ireplace("+", "", $string);
  $string = str_ireplace("-", "", $string);
  $string = str_ireplace(" ", "", $string);
  return $string;
}
//**********************************************************************************************************************************
function choosenumber($phone)
{
  $phone = trim($phone);
  $country_code = substr($phone, 0, 3);
  $size = strlen($phone);
  if ((trim($country_code) == "255") and ($size > 12)) {
    return  substr($phone, 0, 12);
  } else {
    return $phone;
  }
}

//***************************************************************************
function encrypt($plaintext, $key)
{
  $cipher_method = constant("cipher_method");
  $ivlen = openssl_cipher_iv_length($cipher = $cipher_method);
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
  $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
  return base64_encode($iv . $hmac . $ciphertext_raw);
}
//**************************************************************************
function decrypt($ciphertext, $key)
{
  $cipher_method = constant("cipher_method");
  $c = base64_decode($ciphertext);
  $ivlen = openssl_cipher_iv_length($cipher = $cipher_method);
  $iv = substr($c, 0, $ivlen);
  $hmac = substr($c, $ivlen, $sha2len = 32);
  $ciphertext_raw = substr($c, $ivlen + $sha2len);
  $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
  $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
  if ($hmac == $calcmac) {
    return $original_plaintext;
  }
  return "";
}
//**********************************************************************************************************************************
function connect_to_database($myServer, $myUser, $myPass, $myDB)
{
  session_start();
  if ($_SESSION['db_cred_saved'] == 0) {
    $_SESSION['myServer'] = $myServer;
    $_SESSION['myUser'] = $myUser;
    $_SESSION['myPass'] = encrypt($myPass, $_SESSION['myDB']);
    $_SESSION['myDB'] = $myDB;
    $_SESSION['db_cred_saved'] = 1;
  }
  // Figure out which connections are open, automatically opening any connections
  // which are failed or not yet opened but can be (re)established.
  $con = "";
  for ($i = 0, $n = 5; $i < $n; $i++) {
    $con = connect_to($myServer, $myUser, $myPass, $myDB);
    if (!($con === false)) {
      return $con;
    }
    sleep(1);
  }
  logs(" Unable to Connect to  $myServer    \n");
  return $con;
}
//**********************************************************************************************************************************
function connect_to($myServer, $myUser, $myPass, $myDB)
{
  session_start();
  $database_inuse = $_SESSION['database_inuse'];
  if ($database_inuse == "MYSQL") {
    $conn = mysqli_connect($myServer, $myUser, $myPass, $myDB);
    if ($conn) {
      $_SESSION['connection'] = $conn;
    }
  }
  return $conn;
}
//**********************************************************************************************************************************
function close_connections($conn)
{
  session_start();
  $database_inuse = $_SESSION['database_inuse'];
  if ($database_inuse == "MYSQL") {
    mysqli_close($conn);
  } else {
  }
}
//**********************************************************************************************************************************
function excute_command_inherite_con($conn, $command)
{
  $database_inuse = $_SESSION['database_inuse'];
  if ($database_inuse == "MYSQL") {
    if (mysqli_query($conn, $command)) {
      return 1;
    } else {
      logs(" Unable to excute sql $command command on excute_command_inherite_con() " . mysqli_error($conn) . " \n");
      return 0;
    }
  }
}
//**********************************************************************************************************************************
function get_from_table_sql_one($con, $sql)
{
  $row = array();
  $database_inuse = $_SESSION['database_inuse'];
  if ($database_inuse == "MYSQL") {
    if ($result = mysqli_query($con, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
      }
      // Free result set
      mysqli_free_result($result);
      return  $row;
    }
  }
}
/////////////////////////////////////
function mssql_real_escape_string($datax)
{
  return _real_escape_string($datax);
}
/////////////////////////////////////
function _real_escape_string($datax)
{
  if (!isset($datax) or empty($datax)) return "";
  $data = trim($datax);
  $non_displayables = array(
    '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
    '/%1[0-9a-f]/',             // url encoded 16-31
    '/[\x00-\x08]/',            // 00-08
    '/\x0b/',                   // 11
    '/\x0c/',                   // 12
    '/[\x0e-\x1f]/'             // 14-31
  );
  foreach ($non_displayables as $regex)
    $data = preg_replace($regex, '', $data);
  $data = str_replace("'", "''", $data);
  return $data;
}
//**********************************************************************************************************************************
function reconnect_db()
{
  if (isset($_SESSION['db_cred_saved'])) {
    if ($_SESSION['db_cred_saved'] == 1) {
      $myDB = $_SESSION['myDB'];
      $myPass = decrypt($_SESSION['myPass'], $myDB);
      $conn = connect_to_database($_SESSION['myServer'], $_SESSION['myUser'], $myPass, $myDB);
      return $conn;
    }
  }
}
//////////////////////////////////////////////////////
function get_from_table_sql($con, $sql)
{
  $rows = array();
  $database_inuse = $_SESSION['database_inuse'];
  if ($database_inuse == "MYSQL") {
    if ($result = mysqli_query($con, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
          $rows[] = $row;
        }
      }
      // Free result set
      mysqli_free_result($result);
    }
  }
  return $rows;
}
//******************************************************************************************************************
function record_activity_inherite_con($con, $table_activity, $user_id, $activity)
{
  $database_inuse = $_SESSION['database_inuse'];
  if ($user_id == "")
    return;
  $date = date('Y-m-d H:i:s');
  $ip = $_SERVER['REMOTE_ADDR'];
  $i = strlen($activity);
  for ($j = 0; $j < $i; $j++) {
    if (($j % $i) == 130) {
      $activity[$j] = $activity[$j] . "<br>";
    }
  }
  $activity = modify_string($activity);
  if ($database_inuse == "MYSQL") {
    $username = $_SESSION['username'];
    $command = "INSERT INTO $table_activity (user_id,activity,date_time,username,ip) VALUES ('$user_id','$activity','$date','$username','$ip')";
    excute_command_inherite_con($con, $command);
  }
}
//**********************************************************************************************************************************
function send_mail($to_address, $subject, $body)
{
  $headers   = array();
  $headers[] = "MIME-Version: 1.0";
  $headers[] = "Content-type: text/html; charset=iso-8859-1";
  $headers[] = "From: Mdausoft Technology <info@mdausoft.co.tz>";
  $headers[] = "Subject: {$subject}";
  $headers[] = "X-Mailer: PHP/" . phpversion();

  if (!@mail($to_address, $subject, $body, implode("\r\n", $headers))) {
    logs(" Error in send email to $to_address may be not exists");
  }
}
//**********************************************************************************************************************************
function logs($data)
{
  $date = date('Y;m;d');
  //$log= "C:/xampp/htdocs/csm/en/logs/$date.txt";
  $log = "C:/xampp/htdocs/csm/logs_mod/$date.txt";
  file_put_contents($log, "   " . $data, FILE_APPEND);
}
//**********************************************************************
function formatMoney($number, $cents = 1)
{ // cents: 0=never, 1=if needed, 2=always
  if (is_numeric($number)) { // a number
    if (!$number) { // zero
      $money = ($cents == 2 ? '0.00' : '0'); // output zero
    } else { // value
      if (floor($number) == $number) { // whole number
        $money = number_format($number, $cents); // format
      } else { // cents
        $money = number_format(round($number, $cents), $cents); // format
      } // integer or decimal
    } // value
    return $money;
  } // numeric
} // formatMoney
//*********************************************************************************************
function modify_string($string)
{
  $string = strip_tags($string);
  $string = str_ireplace("'", "''", $string);
  $string = str_ireplace('"', '', $string);
  return $string;
}
//**********************************************************************
function formatMoney_float($number)
{
  return formatMoney($number, numberOfDecimals($number));
}
//**********************************************************************
function remove_comma_from_number($number)
{
  return str_replace(",", "", $number);
}
//**********************************************************************
function get_datetime_next_n_month()
{
  $date = new DateTime('now');
  $date->modify('+2 month');
  return $date->format('Y-m-d');
}
//**********************************************************************
function numberOfDecimals($value)
{
  if ((int) $value == $value) {
    return 0;
  } else if (!is_numeric($value)) {
    return false;
  }
  return strlen($value) - strrpos($value, '.') - 1;
}
//************************************************
function is_file_path_exists($filename)
{
  $result = file_exists($filename);
  if ($result == 1) {
    return true;
  } else {
    return false;
  }
}
////////////////////////////////////////////