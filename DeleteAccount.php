<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php'); 
    session_start();
     if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];
        $DB = new DataBase();
        $DB->DeleteAccount($UserID);
        header('Location: Login.html'); 
    }else{
        //redirect to login page
        header('Location: Login.html');  
    }
?>