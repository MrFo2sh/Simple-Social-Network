<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php');
    
     session_start();
    if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
         $UserID=$_SESSION['UserID'];
         $FriendID = mysql_real_escape_string($_POST['FriendID']);
         $DB = new DataBase();
         $result=$DB->setFriends($UserID,$FriendID);
         $_SESSION['FriendID'] = $FriendID;
         sleep(0.5);
         header('Location: FriendsProfile.php'); 
    }else{
         header('Location: Login.html'); 
    }
?>