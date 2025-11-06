<?php

// class for user detail functions 
class USERS {
    public $encKey;
    public $conn;
    
    function __construct(){

        // DB connection class
        include_once("dbconnection.class.php");
        $dbConn = new DBCONNECTION();
        $this->conn = $dbConn->conn;
     
        include_once("config/config.php");
        $this->encKey = ENCKEY;
    }

    // for User email or phone validation
    function validateEmail(){
        
        $qrySel = "SELECT u.recid userId
                    FROM users u 
                    WHERE ( AES_DECRYPT(u.email, '" . $this->encKey . "') = '" . strtolower($_REQUEST['txtEmail']) . "' OR AES_DECRYPT(u.phone, '" . $this->encKey . "') = '" . $_REQUEST['txtEmail'] . "')";

        $obResult =  mysqli_query($this->conn, $qrySel);

        $arrUser = mysqli_fetch_assoc($obResult);

        if(isset($arrUser) && $arrUser['userId'] > 0){
            return $arrUser['userId'];
        }
        else{
            return false;
        }
    }

    // for password validation of user 
    function validatePassword($userId){
        
        $qrySel = "SELECT u.recid userId
                    FROM users u 
                    WHERE u.password = SHA1('" . $_REQUEST['txtPassword'] . "') AND u.recid = '" . $userId . "' ";

        $obResult =  mysqli_query($this->conn, $qrySel);

        $arrUser = mysqli_fetch_assoc($obResult);

        if($arrUser['userId'] > 0){
            $_SESSION['USERID'] = $arrUser['userId'];
            return true; 
        }
        else{
            return false;
        }
    }

    // inserting user details 
    function addUser($arrUser = array() ){
        $qryIns = "INSERT INTO users(name, email, password, phone, datetimex)
                    VALUES( AES_ENCRYPT('" . addslashes($arrUser['txtName']) . "', '" . $this->encKey . "'),
                    AES_ENCRYPT('" . strtolower(addslashes($arrUser['txtEmail'])) . "', '" . $this->encKey . "'),
                    SHA1('" . $arrUser['txtPassword'] . "'),
                    AES_ENCRYPT('" . addslashes($arrUser['txtPhone']) . "', '" . $this->encKey . "'),
                    NOW() )";
        
        $objResult = mysqli_query($this->conn, $qryIns);

        $userId = mysqli_insert_id($this->conn);

        if($userId){
            session_start();
            $_SESSION['USERID'] = $userId;
            return true;
        }
        else{
            return false;
        }
    }

    // change user details 
    function updateUser($arrData = array()){

        $qryUpd = "UPDATE users u 
                    SET u.password = SHA1('" . $arrData['txtPassword'] . "')
                    WHERE u.recid = '" . $arrData['userId'] . "'";

        $objResult = mysqli_query($this->conn, $qryUpd);

        if(!$objResult){
            return false;
        }
        else {
            return true;
        }
    }

    // change user details 
    function updateEmail($arrData = array()){

        $qryUpd = "UPDATE users u 
                    SET u.email = AES_ENCRYPT('" . strtolower($arrData['txtEmail']) . "', '" . $this->encKey . "')
                    WHERE u.recid = '" . $arrData['userId'] . "'";
   
        $objResult = mysqli_query($this->conn, $qryUpd);

        if(!$objResult){
            return false;
        }
        else {
            return true;
        }
    }

    // to get user details
    function getUserDetails(){

        $qrySel = "SELECT AES_DECRYPT(u.name, '" . $this->encKey . "') userName, AES_DECRYPT(u.email, '" . $this->encKey . "') email, AES_DECRYPT(u.phone, '" . $this->encKey . "') phone
                    FROM users u 
                    WHERE u.recid = '" . $_SESSION['USERID'] . "'";
        
        $objResult = mysqli_query($this->conn, $qrySel);

        $arrUserDetails = mysqli_fetch_assoc($objResult);

        return $arrUserDetails;

    }

    // get user and post details based on phone number
    function getUserPostDetails(){

        if(isset($_REQUEST['mob']))  $_REQUEST['txtSearch'] = $_REQUEST['mob'];

        $qrySel = "SELECT AES_DECRYPT(u.name, '" . $this->encKey . "') userName, AES_DECRYPT(u.email, '" . $this->encKey . "') email, AES_DECRYPT(u.phone, '" . $this->encKey . "') phone, p.message message, p.filename fileName, DATE_FORMAT(p.datetimex, '%d %b %Y %h:%i %p') dateCreated
                    FROM users u LEFT JOIN posts p ON u.recid = p.userid
                    WHERE AES_DECRYPT(u.phone, '" . $this->encKey . "') = '" . $_REQUEST['txtSearch'] . "' ";
        
        $objResult = mysqli_query($this->conn, $qrySel);

        if(!$objResult){
            return false;
        }
        else {
            return $objResult;
        }
    }
}

?>