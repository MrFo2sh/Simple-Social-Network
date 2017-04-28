<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
	require_once('User.php');
	require_once('DataBase.php');
	
	$FirstName = mysql_real_escape_string($_POST['FirstName']);
	$LastName = mysql_real_escape_string($_POST['LastName']);
	$Email = mysql_real_escape_string($_POST['Email']);
	$Password = mysql_real_escape_string($_POST["Password"]);
	$Confirm = mysql_real_escape_string($_POST["Confirm"]);
    //invalid
	if(strlen($FirstName)<5 || strlen($LastName)<5 || strlen($Email)<5 || strlen($Password)<8|| strlen($Confirm)<8){
                header('Location: InvalidRegister.html');
    }else{//valid
        if($Password == $Confirm){
            $user = new User( 0 ,$FirstName , $LastName , "" , $Email , "" , $Password,"");
            $DB = new DataBase();
            $State = $DB->Register($user);
            switch($State){
                case "valid":
                echo "Valid Register";
                $validation = $DB->Login($Email , $Password);
                $_SESSION["UserID"] = $validation;
                header('Location: Friends.php');
                break;

                case "exist":
                echo "Email already exist";
                header('Location: InvalidRegister.html');
                break;

                case "error";
                echo "Eroor occured";
                header('Location: InvalidRegister.html');
                break;
            }
        }else{
            //Password not equal to confirm
    }
    }
	

?>