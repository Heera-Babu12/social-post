<?php

// Class for Post based details
class FEEDS {

    public $conn;
    public $encKey;
    
    function __construct(){
         // DB connection class
         include_once("dbconnection.class.php");
         $dbConn = new DBCONNECTION();
         $this->conn = $dbConn->conn;
        
         include_once("config/config.php");
         $this->encKey = ENCKEY;
    }

    // add a post/feed 
    function addPosts(){

        $qryIns = "INSERT INTO posts(userid, message, datetimex)
                    VALUES( '" . $_SESSION['USERID'] . "',
                    '" . addslashes($_REQUEST['taMessage']) . "',
                    NOW())";

        $objResult = mysqli_query($this->conn, $qryIns);

        $postId = mysqli_insert_id($this->conn);

        if($postId > 0){

            // insert image if present
            if(isset($_FILES['flImage']) && $_FILES['flImage']['name'] != ""){
                if(!$this->addImage($postId)){
                    return false;
                }
            }

            return true;
        }
        else{
            return false;
        }
    }

    // display posts 
    function getPosts(){
        $qrySel = "SELECT p.message message, p.filename fileName, DATE_FORMAT(p.datetimex, '%d %b %Y %h:%i %p') dateCreated
                    FROM posts p 
                    WHERE p.userid = '" . $_SESSION['USERID'] . "'
                    ORDER BY p.datetimex DESC";

        $objResult = mysqli_query($this->conn, $qrySel);

        return $objResult;
    }

    // insert image and update post record 
    function addImage($postId){

        $imageName = $_FILES['flImage']['name'];     
        $imageTmpName = $_FILES['flImage']['tmp_name'];

        $arrImageDetails = pathinfo($imageName);
        $imageNameWithoutExtension = $arrImageDetails['filename'];
        $imgExtension = $arrImageDetails['extension'];

        $newImage = $imageNameWithoutExtension . "_fd" . $postId . "." . $imgExtension;

        $filePath = 'upload/' . $newImage;

        if (move_uploaded_file($imageTmpName, $filePath)) {

            $qryUpd = "UPDATE posts p 
                        SET p.filename = '" . $newImage . "'
                        WHERE p.recid = '" . $postId . "' ";
            
            $objResult = mysqli_query($this->conn, $qryUpd);
            
            if(!$objResult){
                return false;
            }
            else{
                return true;
            }
        } 
    }

    // get username
    function getUserName(){

        $qrySel = "SELECT AES_DECRYPT(u.name, '" . $this->encKey . "') userName
                    FROM users u 
                    WHERE u.recid = '" . $_SESSION['USERID'] . "'";
        
        $objResult = mysqli_query($this->conn, $qrySel);

        $arrUserDetails = mysqli_fetch_assoc($objResult);

        return $arrUserDetails;

    }
}

?>