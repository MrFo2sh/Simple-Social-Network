<?php 

	class User{
		
		protected $ID;
		protected $FirstName;
		protected $LastName;
		protected $ImageURL;
		protected $EMail;
		protected $Username;
		protected $Password;
		protected $Status;
		
		public function __construct($_id ,$_firstName , $_lastName , $_imageUrl , $_mail , $_username , $_password , $_status ){
			$this->ID = $_id;
			$this->FirstName = $_firstName;
			$this->LastName = $_lastName;
			$this->ImageURL = $_imageUrl;
			$this->EMail = $_mail;
			$this->Username = $_username;
			$this->Password = $_password;
			$this->Status = $_status;
			$this->ListOfFriends = array();
		}
		
		public function getID() {
		return $this->ID;
		}
		
		public function getFirstName(){
			return $this->FirstName;
		}
		
		public function getLastName(){
			return $this->LastName;
		}
		
		public function getImageUrl(){
			return $this->ImageURL;
		}
		
		public function getEMail(){
			return $this->EMail;
		}
		
		public function getUsername(){
			return $this->Username;
		}
		
		public function getPassword(){
			return $this->Password;
		}
		
		public function getStatus(){
			return $this->Status;
		}
	}

?>