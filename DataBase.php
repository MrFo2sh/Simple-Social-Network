<?php 
    require_once('Message.php'); 
	class DataBase{
		//Declaring DB_User etc..
		private $db_host;
		private $db_user;
		private $db_pass;
		private $db_name;
		
		function __construct(){
			//init
			$this->db_host = 'localhost'; 
			$this->db_user = 'root'; 
			$this->db_pass = 'GetOut'; 
			$this->db_name = 'cya';
		}
		
		function Register(User $user){
			
			$conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
			// die(mysqli_error($db)); 
				return "error" ;     // connection error
			  }
		  
		    $FirstName = $user->getFirstName();
			$LastName = $user->getLastName();
			$ImageUrl = "UsersProfiles/Default.jpg";
			$Email = $user->getEmail();
			$Username = "";
			$Password = $user->getPassword();
			$Status = "Newbie";
		  
			 //ask if the email already exist
			$sql = "SELECT * FROM `user` WHERE Mail='$Email'";
            $result = $conn->query($sql);
                
            //if there are one or more results then user exists
            if ($result->num_rows > 0) {
                $conn->close();
				return "exist";
            } else {
                //user dosen't exist and its valid register
                 $sql = "INSERT INTO user (FirstName,LastName,ImageUrl,Mail,Username,Password,Status)
				 VALUES ('$FirstName','$LastName','$ImageUrl','$Email','$Username','$Password','$Status')";
                 //validate insertion
                 if($conn->query($sql)){
                    $conn->close();
                    return "valid";
                 }else{
                    $conn->close();
                    return "error";
                 }
            }
            $conn->close();
		}
        
        function DeleteAccount($UserID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
              $sql = "DELETE FROM friends WHERE UserID='$UserID' OR FriendID='$UserID'";
              if($conn->query($sql)){
                $sql= "DELETE FROM user WHERE UserID='$UserID'";
                if($conn->query($sql)){
                    $sql="DELETE FROM messages WHERE UserID='$UserID'";
                    if($conn->query($sql)){
                        $conn->close();
                        return "valid";
                    }else{
                        $conn->close();
                        return "error";
                    }
                }else{
                $conn->close();
                return "error";
             }
                $conn->close();
                return "valid";
             }else{
                $conn->close();
                return "error";
             }
        }
        
        function Login($Email , $Password){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
              
            $sql = "SELECT * FROM `user` WHERE Mail='$Email' AND Password='$Password'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $ID = $row["UserID"];
                    $conn->close();
                    return $ID;
                }
               }else{
                $conn->close();
                return "invalid";
               }
            $conn->close();
        }
        
        function EditProfileImg($UserID , $FirstName , $LastName, $Username , $Status ,$ImageURL){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
		      }
             $sql = "UPDATE user SET FirstName='$FirstName',LastName='$LastName',Username='$Username',Status='$Status',ImageURL='$ImageURL' WHERE UserID=$UserID";
             if($conn->query($sql)){
                $conn->close();
                return "valid";
             }else{
                $conn->close();
                return "error";
             }
        }
        
        
        function EditProfileNoImg($UserID , $FirstName , $LastName, $Username , $Status){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
             $sql = "UPDATE user SET FirstName='$FirstName',LastName='$LastName',Username='$Username',Status='$Status' WHERE UserID=$UserID";
             if($conn->query($sql)){
                $conn->close();
                return "valid";
             }else{
                $conn->close();
                return "error";
             }
        }
        
        function getUserByID($UserID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
            $sql = "SELECT * FROM `user` WHERE UserID=$UserID";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $ID = $row["UserID"];
                    $FirstName = $row["FirstName"];
                    $LastName = $row["LastName"];
                    $ImageURL = $row["ImageURL"];
                    $Email = $row["Mail"];
                    $Username = $row["Username"];
                    $Password = $row["Password"];
                    $Status = $row["Status"];
                    
                    $user = new User($ID,$FirstName,$LastName,$ImageURL,$Email,$Username,$Password,$Status);
                    
                    $conn->close();
                    return $user;
                }
            }
        }
        function SearchForFriend($UserID,$Query){
            $Friends = $this->getFriendsList($UserID);
            $Result = array();
            if($Friends!="zero"&&$Friends!="error"&& $Query!=""){
                foreach($Friends as $f){
                    if($f->getUsername() == $Query || $f->getEMail() == $Query){
                        array_push($Result,$f);
                    }
                }
                return $Result;
            }else{
                return $Friends;
            }
        }
        function SearchForUser($UserID,$Query){
            $Users = $this->getRecommendedUsers($UserID);
            $Result = array();
            if($Users!="zero"&&$Users!="error"&& $Query!=""){
                foreach($Users as $f){
                    if($f->getUsername() == $Query || $f->getEMail() == $Query){
                        array_push($Result,$f);
                    }
                }
                return $Result;
            }else{
                return $Users;
            }
        }
        function getRecommendedUsers($UserID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
              $List = array();
              $sql ="SELECT * FROM user";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $ID = $row["UserID"];
                        $FirstName = $row["FirstName"];
                        $LastName = $row["LastName"];
                        $ImageURL = $row["ImageURL"];
                        $Email = $row["Mail"];
                        $Username = $row["Username"];
                        $Password = $row["Password"];
                        $Status = $row["Status"];
                        $user = new User($ID,$FirstName,$LastName,$ImageURL,$Email,$Username,$Password,$Status);
                        if($ID!=$UserID){
                            array_push($List,$user);
                        }
                    }
                        $Friends = $this->getFriendsList($UserID);
                        $recommended=array();
                        foreach($List as $i){
                            $flag=true;
                            if($Friends !="zero"&& $Friends !="error"){
                                foreach($Friends as $f){
                                    if($i==$f){
                                        $flag = false;
                                    }
                                }
                                if($flag==true){
                                    array_push($recommended,$i);
                                }
                            }else{
                                return $List;
                            }
                        }
                    
                        return $recommended;
                }
                $conn->close();
                return "zero";
        }
        function SearchFor($UserID,$Search){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
              $list = array();
              $sql = "SELECT * FROM user WHERE Username='$Search' OR Mail='$Search'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $ID = $row["UserID"];
                        $FirstName = $row["FirstName"];
                        $LastName = $row["LastName"];
                        $ImageURL = $row["ImageURL"];
                        $Email = $row["Mail"];
                        $Username = $row["Username"];
                        $Password = $row["Password"];
                        $Status = $row["Status"];
                        $user = new User($ID,$FirstName,$LastName,$ImageURL,$Email,$Username,$Password,$Status);
                        if($ID!=$UserID){
                            array_push($list,$user);
                        }
                    }
                        $conn->close();
                        return $list;
                }
                $conn->close();
                return "zero";
        }
        function getFriendsCount($UserID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
              $list = array();
              $sql = "SELECT * FROM friends WHERE UserID='$UserID'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    
                        $conn->close();
                        return $result->num_rows;
                }
                $conn->close();
                return 0;
        }
        /*
        function setFriends($UserID,$FriendID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			 }
             $index="";
             $sql = "INSERT INTO 'friends' (UserID,FriendID,ChatID)
				 VALUES ('$UserID','$FriendID','-1')";
                 if($conn->query($sql)){
                    $sql = "SELECT * FROM 'friends' WHERE UserID='$UserID' AND FriendID='$FriendID'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $index = $row["Index"];
                            break;
                        }
                        $sql = "UPDATE friends SET ChatID='$index' WHERE Index=$index'";
                        if($conn->query($sql)){
                             $sql = "INSERT INTO 'friends' (UserID,FriendID,ChatID)
				             VALUES ('$FriendID','$UserID','$index')";
                             if($conn->query($sql)){
                                $conn->close();
                                return "valid";
                             }else{
                                $conn->close();
                                return "error";
                             }
                            $conn->close();
                            return "valid";
                         }else{
                            $conn->close();
                            return "error";
                         }
                        
                            $conn->close();
                    }
                 }else{
                    $conn->close();
                    return "error";
                 }
        }*/
        
        function setFriends($UserID,$FriendID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			 }
             $Index="";
             $sql="INSERT INTO friends (UserID,FriendID,ChatID) VALUES ('$UserID','$FriendID','0')";
             if($conn->query($sql)){
                $sql = "select * FROM friends WHERE UserID='$UserID' AND FriendID='$FriendID'";
                $result = $conn->query($sql);
                 if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $Index = $row["Index"];
                            break;
                        }
                        $sql = "UPDATE friends SET ChatID='$Index' WHERE UserID='$UserID' AND FriendID='$FriendID'";
                        if($conn->query($sql)){
                            $sql = "INSERT INTO friends (UserID,FriendID,ChatID)
				            VALUES ('$FriendID','$UserID','$Index')";
                            if(!$conn->query($sql)){
                                return $conn->error;
                            }
                        }else{
                            $conn->close();
                            return $conn->error;
                        }
                    }else{
                        $conn->close();
                        return "zero";
                    }
             }else{
                    $conn->close();
                    return "error";
                }
        }
        
        function getFriendsList($UserID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
			  }
              $FriendList = array();
              $list = array();
              $sql = "SELECT * FROM `friends` where UserID='$UserID'";
              $result = $conn->query($sql);
              if($result->num_rows > 0){
                 while($row = $result->fetch_assoc()){
                    $FriendID = $row["FriendID"];
                    array_push($list,$FriendID);
                }
                    $conn->close();
                foreach($list as $f){
                    array_push($FriendList,$this->getUserByID($f));
                }
                    return $FriendList;
            }else{
                $conn->close();
                return "zero";
            }
        }
        
        /*
        function getChatOf($UserID,$FriendID){
           $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
            } 
              $ChatID="";
              $conversation = array();
              $sql = "SELECT * FROM `friends` where UserID='$UserID' and FriendID='$FriendID'";
              $result = $conn->query($sql);
              if($result->num_rows > 0){
                 while($row = $result->fetch_assoc()){
                    $ChatID = $row["ChatID"];
                    break;
                }
                $sql = "SELECT * FROM `messages` where UserID='$UserID' and ChatID='$ChatID'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                     while($row = $result->fetch_assoc()){
                        $Content = $row["Content"];
                        $Date = strtotime($row["Date"]) ;
                        $UserID2 = $row["UserID"];
                        $MSG = new Message($Date , $Content , $UserID2 , $ChatID);
                        array_push($conversation,$MSG);
                     }
                    $sql = "SELECT * FROM `messages` where UserID='$FriendID' and ChatID='$ChatID'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                     while($row = $result->fetch_assoc()){
                        $Content = $row["Content"];
                        $Date = strtotime($row["Date"]) ;
                        $UserID2 = $row["UserID"];
                        $MSG = new Message($Date , $Content , $UserID2 , $ChatID);
                        array_push($conversation,$MSG);
                    }
                    //sort the conversation according to date and time then return the conversation
                    usort($conversation,"compare");
                    return $conversation;
                }
                usort($conversation,"compare");
                return $conversation;
            }else{
                $sql = "SELECT * FROM `messages` where UserID='$FriendID' and ChatID='$ChatID'";
                $result = $conn->query($sql);
                    if($result->num_rows > 0){
                     while($row = $result->fetch_assoc()){
                        $Content = $row["Content"];
                        $Date = $row["Date"] ;
                        $UserID2 = $row["UserID"];
                        $MSG = new Message($Date , $Content , $UserID2 , $ChatID);
                        array_push($conversation,$MSG);
                    }
                    //sort the conversation according to date and time then return the conversation
                    usort($conversation,"compare");
                    return $conversation;
                }else{
                    return "zero";
                }
            }
            }else{
                return "zero";
            }
        }
        */
        
        function getChatOf($UserID,$FriendID){
            $ChatID = $this->getChatID($UserID,$FriendID);
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
            } 
            $conversation = array();
            $sql = "SELECT * FROM `messages` WHERE ChatID=$ChatID AND (UserID=$UserID OR UserID=$FriendID) order by Date";
              $result = $conn->query($sql);
              if(isset($result) && !empty($result)){
                  if($result->num_rows > 0){
                      while($row = $result->fetch_assoc()){
                        $Content = $row["Content"];
                        $Date = strtotime($row["Date"]) ;
                        $UserID2 = $row["UserID"];
                        $MSG = new Message($Date , $Content , $UserID2 , $ChatID);
                        array_push($conversation,$MSG);
                     }
                     $conn->close();
                     return $conversation;
                }else{
                    return "zero";
                }
            }
        }
        
        function getChatID($UserID,$FriendID){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
            } 
            $sql = "SELECT * FROM `friends` where UserID='$UserID' and FriendID='$FriendID'";
              $result = $conn->query($sql);
                  if($result->num_rows > 0){
                     while($row = $result->fetch_assoc()){
                        $ChatID = $row["ChatID"];
                        $conn->close();
                        return $ChatID;
                        }
                    }
            }
        
        function addMessageTo($UserID,$FriendID,$Message){
            $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
			if (mysqli_connect_errno()){
				return "error" ;     // connection error
            } 
            $ChatID="";
              $conversation = array();
              $sql = "SELECT * FROM `friends` where UserID='$UserID' and FriendID='$FriendID'";
              $result = $conn->query($sql);
              if($result->num_rows > 0){
                 while($row = $result->fetch_assoc()){
                    $ChatID = $row["ChatID"];
                    break;
                }
                $text = $Message->getText();
                $strDate =$Message->getStringDate();
             $sql = "INSERT INTO messages (ChatID,Content,Date,UserID)
				 VALUES ('$ChatID','$text','$strDate','$UserID')";
                 if($conn->query($sql)){
                    return "valid";
                 }else{
                    return "error";
                 }
            }
        }
	}
    function compare($a,$b){
            if($a->getDate()== $b->getDate()){
                return 0;
            }
            return (($a->getDate()) < ($b->getDate()))?-1:1;
        }
?>