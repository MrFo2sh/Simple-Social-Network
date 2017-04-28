<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php');
    
    $Email = mysql_real_escape_string($_POST['Email']);
    $Password = mysql_real_escape_string($_POST['Password']);
    
    $DB = new DataBase();
    $validation = $DB->Login($Email , $Password);
    
    if($validation == "error"){
        header('Location: InvalidLogin.html');
    }elseif($validation == "invalid"){
        header('Location: InvalidLogin.html');
    }else{
        session_start();
        $_SESSION["UserID"] = $validation;
        header('Location: Friends.php');
    }
?>