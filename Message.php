<?php
    class Message{
        private $Date;
        private $Text;
        private $UserID;
        private $ChatID;
        
        public function __construct($Date,$Text,$UserID,$ChatID) {
            $this->Date = $Date;
            $this->Text = $Text;
            $this->UserID = $UserID;
            $this->ChatID = $ChatID;
        }
        
        function getDate(){
            return $this->Date;
        }
        function getText(){
            return $this->Text;
        }
        function getUserID(){
            return $this->UserID;
        }
        function getChatID(){
            return $this->ChatID;
        }
        function getStringDate(){
            return strftime("%Y-%m-%d %H:%M:%S",$this->Date);
        }
    }
?>