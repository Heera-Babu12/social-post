<?php
class INDEX {
    public $objUser;
    public $arrMessages;

    function __construct(){
        
        // include class
        include_once("class/users.class.php");
        $this->objUser = new USERS();

        // Error and Success Messages
        $this->arrMessages = array( 
                        "NPD" => "You have entered a wrong password.",
                        "NUE" => "Entered email or phone number does not exist.",
                        "NEU" => "Please enter a valid email address.",
                        "NRE" => "Your registration failed. Please try again.",
                        "LOU" => "You are logged out successfully.",
                        "UP" => "Your email address updated successfully.",
                        "NUP" => "Email updation failed. Please try again.",
                        "PU" => "Your password updated successfully",
                        "NPU" => "Your password not updated. Please try again.",
                        "NPW" => "Your current password is wrong."
                     );

        if(isset($_REQUEST['doAction'])){
            switch($_REQUEST['doAction']){
                case "login" : 
                        if(!empty($_REQUEST['txtEmail'])){
                            $userId = $this->objUser->validateEmail();
                            
                            if($userId > 0){
                                if($this->objUser->validatePassword($userId)){
                                    header("location: home.php");
                                    exit();
                                }
                                else{
                                    header("location: index.php?flMsg=NPD&err=1");
                                    exit();
                                }
                            }
                            else{
                                header("location: index.php?flMsg=NUE&err=1");
                                exit();
                            }
                        }
                        else{
                            header("location: index.php?flMsg=NEU&err=1");
                            exit();
                        }

                        break;

                case "register" :
                        $arrData = $_REQUEST;

                        if($this->objUser->addUser($arrData)){
                            header("location: home.php");
                            exit;
                        }
                        else{
                            header("location: register.php?flMsg=NRE&err=1");
                            exit();
                        }
                        
                        break;

                case "logout" :
                    session_unset();
                    header("location: index.php?flMsg=LOU");
                    exit();
                    
                    break;
                
                case "updateEmail" : 
                    $arrData = $_REQUEST;
                    $arrData['userId'] = $_SESSION['USERID'];
                    if($this->objUser->updateEmail($arrData)){
                        header("Location: myprofile.php?flMsg=UP");
                        exit;
                    }
                    else{
                        header("Location: myprofile.php?flMsg=NUP&err=1");
                        exit;
                    }
                    break;

                case "updatePassword" :
                    $arrData = $_REQUEST;
                    $arrData['userId'] = $_SESSION['USERID'];
                    
                    $_REQUEST['txtPassword'] = $_REQUEST['txtOldPwd'];
                    if($this->objUser->validatePassword($_SESSION['USERID'])){
                        if($this->objUser->updateUser($arrData)){
                            header("Location: myprofile.php?flMsg=PU");
                            exit;
                        }
                        else{
                            header("Location: myprofile.php?flMsg=NPU&err=1");
                            exit;
                        }
                    }
                    else{
                        header("Location: myprofile.php?flMsg=NPW&err=1");
                        exit;
                    }

                    break;
                
            }
        }
    }
}

?>