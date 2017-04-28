<?php
    require_once('User.php');
	require_once('DataBase.php');
    require_once('Message.php'); 
    session_start();
    $UserID="";
    $Message="";
    $FriendID="";
    $conversation=array();
    $Friend="";
    $Me="";
    if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
           $UserID=$_SESSION['UserID'];
           $DB = new DataBase();
           if((isset($_POST['Message']) && !empty($_POST['Message']))&& (isset($_REQUEST['FriendID']) && !empty($_REQUEST['FriendID']))){
                $Message = $_POST['Message'];
                $FriendID = $_REQUEST['FriendID'];
                $MSG = new Message(time(),$Message,$UserID,"");
                $DB->addMessageTo($UserID,$FriendID,$MSG);
                $conversation = $DB->getChatOf($UserID,$FriendID);
                $Me=$DB->getUserByID($UserID);
                $Friend=$DB->getUserByID($FriendID); 
           }elseif(isset($_REQUEST['FriendID']) && !empty($_REQUEST['FriendID'])){
            $FriendID = $_REQUEST['FriendID'];
            $conversation = $DB->getChatOf($UserID,$FriendID);
            $Me=$DB->getUserByID($UserID);
            $Friend=$DB->getUserByID($FriendID); 
           }else{
            header('Location: Friends.php');
           }
    }else{
         header('Location: Login.html');  
    }
    
    function WriteLeftMessage($Username , $ImageURL , $Time , $msg){
        echo"
                <li class='left clearfix'>
                            <span class='chat-img pull-left'>
                            <img style='width:14%;' src='$ImageURL' alt='User Avatar' class='img-circle' />
                        </span>
                            <div class='chat-body clearfix'>
                                <div class='header'>
                                    <strong class='primary-font'>$Username</strong> <small class='pull-right text-muted'>
                                        <span class='glyphicon glyphicon-time'></span>$Time</small>
                                </div>
                                <p>$msg</p>
                            </div>
                        </li>
        ";
    }
    function WriteRightMessage($Username , $ImageURL , $Time , $msg){
        echo"
                <li class='right clearfix'><span class='chat-img pull-right'>
                            <img style='width:10%;float:right' src='$ImageURL' alt='User Avatar' class='img-circle' />
                        </span>
                            <div class='chat-body clearfix'>
                                <div class='header'>
                                    <small class=' text-muted'><span class='glyphicon glyphicon-time'></span>$Time</small>
                                    <strong class='pull-right primary-font'>$Username</strong>
                                </div>
                                <p style='float:right'>$msg</p>
                            </div>
                        </li>
        ";
    }
    
?>
<html>
    <head>
        <title><?php echo $Friend->getUserName(); ?>'s Conversation</title>
        <link rel="nofollow" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
        <link rel="nofollow" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css" />
        <link rel="nofollow" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
                <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="bootstrap-theme.css">
        <link rel="stylesheet" href="bootstrap-theme.min.css">
        <link rel="stylesheet" href="bootstrap.min.css">
        <link rel="stylesheet" href="ChatRoom.css">
        <link rel="stylesheet" href="Friends.css">
    </head>
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
    <body onload="gotoBottom('ChatArea')" style="background: url('UsersProfiles/BackgroundImage.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
        <div class="row">
       <div class="container col-md-2 col-md-offset-3" style="margin-top:6%;padding-left:4%;width:100%">
    <div class="row" id="chatBox">
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading" id="accordion">
                    <a href="ChatRoom.php?FriendID=<?php echo $_REQUEST['FriendID']; ?>" style="color: white;">Refresh</a>
                </div>
                <div class="panel-body" id="ChatArea">
                    <ul class="chat">
                                        <?php
                                            if($conversation!="zero" && $conversation!="error" && !empty($conversation) ){ 
                                                foreach($conversation as $m){
                                                    if($m->getUserID()== $UserID){
                                                        WriteRightMessage($Me->getUsername(),$Me->getImageUrl(),$m->getStringDate(),$m->getText());
                                                    }else{
                                                        WriteLeftMessage($Friend->getUsername(),$Friend->getImageUrl(),$m->getStringDate(),$m->getText());
                                                    }
                                                }
                                            }
                                        ?>
                    </ul>
                </div>
                <form action="ChatRoom.php?FriendID=<?php echo $_REQUEST['FriendID']; ?>" method="post">
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" name="Message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                            <input type="hidden" name="FriendID" value="<?php echo $FriendID; ?>" />
                            <span class="input-group-btn">
                                <input style="" type="submit" value="Send" class="btn btn-warning btn-sm" id="btn-chat"/>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        </div>
        <script>
            function gotoBottom(id){
               var element = document.getElementById(id);
               element.scrollTop = element.scrollHeight - element.clientHeight;
            }
        </script>
    </body>
</html>