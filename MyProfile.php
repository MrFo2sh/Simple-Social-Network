<?php
error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('User.php');
	require_once('DataBase.php'); 
    session_start();
    $UserID="";
    if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
           $UserID=$_SESSION['UserID'];
           $DB = new DataBase();
           $user = $DB->getUserByID($UserID);
    }else{
         header('Location: Login.html');  
    }
    
?>
<head>
    <title><?php echo $user->getUserName(); ?></title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="bootstrap-theme.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="MyProfile.css">
</head>
<body style="background: url('UsersProfiles/BackgroundImage.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="full-width bg-transparent">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12">
            <div class="full-width">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="custom-form" style="border:solid;border-radius:15px;border-color:grey">
                        <form action="EditProfile.php" method="post" enctype="multipart/form-data">
                            <div class="text-center bg-form" style="background-image: url('<?php echo $user->getImageUrl(); ?>')">
                                <input type="file" id="ProfilePicture" onchange="readURL(this);" accept="image/*"  class="form-control form-input Profile-input-file" name="ProfilePicture">
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <input type="text" class="form-control form-input" value="<?php echo $user->getFirstName();?>" placeholder="First"  id="fname" name="FirstName">
                                <span class="glyphicon glyphicon-user input-place"></span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <input type="text" class="form-control form-input" value="<?php echo $user->getLastName();?>" placeholder="Last Name"  id="lname" name="LastName">
                                <span class="glyphicon glyphicon-user input-place"></span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <input type="text" class="form-control form-input" value="<?php echo $user->getUsername();?>" placeholder="Username"  id="uname" name="Username">
                                <span class="glyphicon glyphicon-user input-place"></span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <input type="text" class="form-control form-input" value="<?php echo $user->getStatus();?>" placeholder="Status"  id="status" name="Status">
                                <span class="glyphicon glyphicon-user input-place"></span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <input type="text" class="form-control form-input" value="<?php echo $user->getEmail();?>" placeholder="Email ID"  id="email" disabled>
                                <span class="glyphicon glyphicon-envelope input-place"></span>
                            </div>
                            <div class="col-lg-12 col-md-12 text-center">
                                <input type="submit" class="btn btn-info btn-lg glyphicon glyphicon-save custom-btn" id="submit" value="Save" name="submit">
                            </div>
                        </form>
                        <div class="col-lg-12 col-md-12 text-center">
                            <a href="DeleteAccount.php" class="btn btn-warning custom-btn"  name="submit">Delete Account</a>
                            </div>
                    </div>
                </div>
            </div>

        </div>
        </div>

        </div>
    </div>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imgCircle')
                            .attr('src', e.target.result)
                            .width(200)
                            .height(200);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>