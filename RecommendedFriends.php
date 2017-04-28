<?php
error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php'); 
    session_start();
    $UserID="";
    $Search="";
    $list=array();
    if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
           $UserID=$_SESSION['UserID'];
           $DB = new DataBase();
           if(isset($_POST['Search']) && !empty($_POST['Search'])){
                $SearchUsername = mysql_real_escape_string($_POST['Search']);
                $list = $DB->SearchForUser($UserID,$SearchUsername);
           }else{
                $list = $DB->getRecommendedUsers($UserID);
           }
    }else{
         header('Location: Login.html');  
    }
    
    
?>
<html>
    <head>
       
        <title>Recommended Friends</title>
         <link rel="nofollow" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
        <link rel="nofollow" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css" />
        <link rel="nofollow" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
                <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="bootstrap-theme.css">
        <link rel="stylesheet" href="bootstrap.min.css">
        <link rel="stylesheet" href="Friends.css">
    </head>
    <body style="background: url('UsersProfiles/BackgroundImage.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
        <nav class="navbar navbar-webmaster">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="active"><a href="Friends.php">Friends<span class="sr-only">(current)</span></a></li>
                            <li>
                            <li class="active"><a href="RecommendedFriends.php">Recommended Friends<span class="sr-only">(current)</span></a></li>
                            <li>
                                <form action="RecommendedFriends.php" method="post" class="navbar-form navbar-right search-form" role="search">
                                    <input type="text" class="form-control" placeholder="Search" name="Search"/>
                                    <input type="submit" class="form-control" value="Search">
                                </form>
                            </li>
                        </ul>
                        <!-- DropDown -->
                        <ul class=" nav navbar-nav navbar-right">
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Profile <span class="caret"></span></a>
                        <ul class="dropdown-menu">


                        <!-- DropDown Items -->
                        <li><a href="MyProfile.php">Edit Profile</a></li>
                        <li><a href="Logout.php">Logout</a></li>
                        </ul>
                            
                    </div>
                </div>
            </nav>

        <div class="container" style="width:90%;margin-top:5%">
            <div class="row">
               <?php 
                    if($list !="zero"){
                        foreach($list as $u){
                            echo " <div class='col-sm-4 col-md-4 container'>
                    <form height='6%' action='OthersProfile.php' method='post'  style=' border: 1px dashed #ddd;border-radius:5px;
                box-shadow: 0 0 0 3px #fff, 0 0 0 5px #ddd, 0 0 0 10px #fff, 0 0 2px 10px #eee;
                                    '>
                            <div class='post'>
                                <div class='post-img-content'>
                                    <img  src='".$u->getImageUrl()."' class='img-responsive' style='border-radius:5px;width:auto' />
                                    <span class='post-title container ' style='float:left'>
                                        <b class='align-center' >".$u->getUsername()."</b><br />
                                        <b class='align-center'>".$u->getStatus()."</b>
                                        <br/>
                                        <input type='hidden' value='".$u->getID()."' name='FriendID'>
                                    </span>
                                </div>
                            </div>
                             <input type='submit' style='width:100%' value='View Profile' class='btn btn-primary btn-md center-block'>
                        </form>
                    </div>
                ";
                        }
                    }
               ?>
            </div>
        </div>
        </div>
    </body>
</html>