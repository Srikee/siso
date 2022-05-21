<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');
	date_default_timezone_set("Asia/Bangkok");
	
	ini_set('short_open_tag', 0);
	ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    include_once("class.database.php");
    include_once("vendor/autoload.php");
    include_once("function.php");
    include_once("config.php");
    include_once("cryption/class.cryption.php");
    
    $DB = new Database(HOST, USER, PASS, DBNAME);
    $USER = GetUser();

    function GetUser() {
        global $DB;
        $username = @$_SESSION["username"];
        $password = @$_SESSION["password"];
        $sql = "SELECT * FROM user WHERE status='Y' AND username='".$username."' AND password='".$password."'";
        $obj = $DB->QueryObj($sql);
        if( sizeof($obj)==1 ) return $obj[0];
        return null;
    }
    