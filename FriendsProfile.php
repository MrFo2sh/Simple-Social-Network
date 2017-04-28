<?php
error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php'); 
    session_start();
    $UserID="";
    $friend="";
    $count="";
    if((isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) && (isset($_SESSION['FriendID']) && !empty($_SESSION['FriendID']))){
        $FriendID = $_SESSION['FriendID'];
        $DB = new DataBase();
        $friend = $DB->getUserByID($FriendID);
        $count = $DB->getFriendsCount($FriendID);
        unset($_SESSION['FriendID']);
    }
    elseif(isset($_SESSION['UserID']) && !empty($_SESSION['UserID']) && isset($_POST['FriendID']) && !empty($_POST['FriendID'])) {
        $FriendID = mysql_real_escape_string($_POST['FriendID']);
        $DB = new DataBase();
        $friend = $DB->getUserByID($FriendID);
        $count = $DB->getFriendsCount($FriendID);
    }elseif(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])){
        header('Location: Friends.php');
    }
    else{
        //redirect to login page
        header('Location: Login.html');  
    }
?>
<head>
    <title><?php echo $friend->getUserName(); ?>'s Profile</title>
    <script src="OthersProfile.js"></script>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="bootstrap-theme.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="OthersProfile.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body style="background: url('UsersProfiles/BackgroundImage.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
    <div class="container">
        <div class="row">
        <!-- Contenedor -->
        <ul id="accordion" class="accordion" style="border:solid;border-width:1.5px;border-color:grey;margin-top:5%">
        <li>
    <div class="col col_4 iamgurdeep-pic">
    <img class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" src="<?php echo $friend->getImageUrl(); ?>">
        
    <div class="username">
        
        <form action="ChatRoom.php" method="get">
            
            <h2><?php echo $friend->getUsername(); ?></h2>
            <input type='hidden' value='<?php echo $friend->getID(); ?>' name='FriendID'>
            <input type="submit" value="Send Message" target="_blank" class="btn-o fa fa-user-plus">
            <a class= "btn-o fa fa-users" href="Friends.php"> Back To Friends</a>
        </form>
    </div>

    </div>

        </li>
            <li>
                <div class="link"><i class="fa fa-globe"></i><?php echo $friend->getStatus(); ?></i></div>
            </li>
            <li>
                <div class="link"><i class="fa fa-user"></i><?php echo $friend->getFirstName()." ".$friend->getLastName(); ?></div>
            </li>
            <li>
                <div class="link"><i class="fa fa-envelope"></i><?php echo $friend->getEMail(); ?></div>
            </li>
            <li>
                <div class="link"><i class="fa fa-users"></i>Friends <small>:<?php echo " ".$count; ?></small></div>
            </li>
        </ul>
        </div>
    </div>
</body>