<?php
error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php');
    
    session_start();
    $UserID="";
    if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
        
        $FirstName = mysql_real_escape_string($_POST['FirstName']);
        $LastName = mysql_real_escape_string($_POST['LastName']);
        $Username = mysql_real_escape_string($_POST['Username']);
        $Status = mysql_real_escape_string($_POST['Status']);
        
        $UserID = $_SESSION['UserID'];
        $FileName = $_FILES['ProfilePicture']['name'];
        $size = $_FILES['ProfilePicture']['size'];
        echo $type = $_FILES['ProfilePicture']['type'];
        $tmp_name = $_FILES['ProfilePicture']['tmp_name'];
        
        $DB = new DataBase();
        
        if(isset($FileName)){
            if(!empty($FileName)){
                $location = "UsersProfiles/";
                if(move_uploaded_file($tmp_name,$location.$UserID.".jpg")){
                    $ImageURL =$location.$UserID.".jpg";
                    echo "done uploaded";
                    $DB->EditProfileImg($UserID,$FirstName,$LastName,$Username,$Status,$ImageURL);
                    header('Location: Friends.php');  
                }
            }else{
                //nofile has been chosen
                $DB->EditProfileNoImg($UserID,$FirstName,$LastName,$Username,$Status);
                 header('Location: Friends.php');  
            }
        }
    }else{
        //redirect to login page
        header('Location: Login.html');  
    }
    
    
    
    
    
 ?>