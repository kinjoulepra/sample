<?php
    session_start();

    require_once "db_connect.php";
    require_once "common.php";
    require_once "const.php";
    
    

    //未ログイン時
    if(!isset($_SESSION['loggin_id']) && $_SERVER['SCRIPT_NAME'] != '/schedule/login.php'){
        header("location: login.php");
        exit;
    }

?>