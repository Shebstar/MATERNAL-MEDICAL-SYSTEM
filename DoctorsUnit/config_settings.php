<?php

error_reporting(0);
@ini_set('display_errors', 0);
session_start();

$ip_address = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?:
    getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
$server_name = $_SERVER['SERVER_NAME'];
$server_port = $_SERVER['SERVER_PORT'];
$root_system_url = 'location: http://localhost:80/healthcare/';
$system_url = 'http://localhost:80/healthcare/';
$system_name = 'Maternal Medical system';
$system_name_short_name = 'Maternal Medical';
$phone_no = "+255 718 327 770";
$email = "hosptialname@example.com";

$_SESSION['database_inuse'] = 'MYSQL';
$myServer = 'localhost';
$myUser = 'root';
$myPass = '';
$myDB = 'healthcare';

//constant
$code_mkulima = 'MKULIMA';
$code_doctor = 'DOCTOR';
$code_admin = 'ADMIN';

//all tables
$table_users = 'tb_users';
$table_activity = 'activity_logs';
$table_contacts = "tb_contacts";
$table_farmers = 'tb_farmers';
$table_businessman = 'tb_businessman';
$table_region = 'tb_regions';
$table_district = 'tb_districts';
$table_crops = "tb_crops";
$table_inputs = "tb_inputs";
$table_farmer_crop_history = "tb_farmer_crop_history";
