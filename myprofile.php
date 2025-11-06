<?php

// include and create object for class
include_once("index.class.php");
$objScr = new INDEX();

if(!isset($_SESSION['USERID'])){
    header("Location: index.php"); 
    exit();
}

// Include header 
include_once("modules/header.php");

// Navigation 
include_once("modules/navigation.php");

$arrUserDetail = $objScr->objUser->getUserDetails();
?><div class="pt-3 pb-3">
        <div class="container">
            <div class="form-wrapper w-100 m-auto" style=" max-width: 75%;"><?php
                if(isset($_REQUEST['flMsg'])){
                    if(isset($_REQUEST['err']) && $_REQUEST['err'] = 1){
                        ?><div class="alert alert-danger fade show" role="alert">
                            <strong><?php print($objScr->arrMessages[$_REQUEST['flMsg']]); ?></strong> 
                        </div><?php
                    }
                    else{
                        ?><div class="alert alert-success fade show" role="alert">
                            <strong><?php print($objScr->arrMessages[$_REQUEST['flMsg']]); ?></strong> 
                        </div><?php
                    }               
                } 

                ?><div class="row">
                    <div class="col-md-5">
                        <form name="frmEmail" id="frmEmail" method="post" action="myprofile.php"> 
                            <h3>Change Email :</h3>
                            <div class="mb-4 position-relative">
                                <label for="txtEmail" class="form-label">Email</label>
                                <input type="text" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="Email" value="<?php print($arrUserDetail['email']); ?>">
                                <small class="error" id="errEmail" style="display: none;">Please enter Email address</small>
                                <small class="error" id="errEmailValid" style="display: none;">Please enter a valid Email address</small>
                            </div>
                            <input type="hidden" id="doAction" name="doAction" value="">
                            <button type="button" onclick="jsSubmitEmailForm(this.form);" class="btn btn-primary mt-4 w-100 fw-600">Update</button>
                        </form>
                    </div>
                    <div class="col-md-1 separator-line"></div>
                    <div class="col-md-5">
                        <form name="frmPassword" id="frmPassword" method="post" action="myprofile.php">
                            <h3>Change Password :</h3>
                            <div class="mb-4 position-relative">
                                <label for="txtOldPwd" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="txtOldPwd" name="txtOldPwd" aria-describedby="Old Password">
                                <small class="error" id="errOldPwd" style="display:none;">Please enter current password</small>
                            </div>
                            <div class="mb-4 position-relative">
                                <label for="txtPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="txtPassword" name="txtPassword" aria-describedby="Password">
                                <small class="error" id="errPwd" style="display:none;">Please enter a new Password</small>
                            </div>
                            <div class="mb-4 position-relative">
                                <label for="txtConfirmPwd" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="txtConfirmPwd" name="txtConfirmPwd" aria-describedby="Confirm Password">
                                <small class="error" id="errConfirmPwd" style="display:none;">Please re-enter Password</small>
                                <small class="error" id="errFailedPwd" style="display:none; bottom:-40px">Password and Confirm Password are not same. Please re-enter the password again. </small>
                            </div>
                            <input type="hidden" id="doActionPwd" name="doAction" value="">
                            <button type="button" onclick="jsSubmitPwdForm(this.form);" class="btn btn-primary mt-4 w-100 fw-600">Update</button>
                        </form>
                    </div>  
                </div>
            </div>

        </div>
    </div>
    <script>

function jsSubmitEmailForm(objForm){

    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
   
    // Email Validation
    if(objForm.txtEmail.value == ""){
        document.getElementById("errEmail").style.display = "block";
        document.getElementById("errEmailValid").style.display = "none";
        objForm.txtEmail.focus();
        return false;
    }
    else{
        if (!emailRegex.test(objForm.txtEmail.value)) {
            document.getElementById("errEmail").style.display = "none";
            document.getElementById("errEmailValid").style.display = "block";
            objForm.txtEmail.focus();
            return false;
        }
        else{
            document.getElementById("errEmail").style.display = "none";
            document.getElementById("errEmailValid").style.display = "none";
        }
    }

    document.getElementById('doAction').value = "updateEmail";
    objForm.submit();
}

function jsSubmitPwdForm(objForm){

    // Password
    if(objForm.txtOldPwd.value == ""){
        document.getElementById("errOldPwd").style.display = "block";
        objForm.txtOldPwd.focus();
        return false;
    }
    else{
        document.getElementById("errOldPwd").style.display = "none";
    }

    if(objForm.txtPassword.value == ""){
        document.getElementById("errPwd").style.display = "block";
        objForm.txtPassword.focus();
        return false;
    }
    else{
        document.getElementById("errPwd").style.display = "none";
    }

    if(objForm.txtConfirmPwd.value == ""){
        document.getElementById("errConfirmPwd").style.display = "block";
        document.getElementById("errFailedPwd").style.display = "none";
        objForm.txtConfirmPwd.focus();
        return false;
    }
    else if(objForm.txtPassword.value != objForm.txtConfirmPwd.value){
        document.getElementById("errConfirmPwd").style.display = "none";
        document.getElementById("errFailedPwd").style.display = "block";
        objForm.txtConfirmPwd.focus();
        return false;
    }
    else{
        document.getElementById("errConfirmPwd").style.display = "none";
        document.getElementById("errFailedPwd").style.display = "none";
    }

    
    document.getElementById('doActionPwd').value = "updatePassword";
    objForm.submit();
}
</script><?php

// include footer
include_once("modules/footer.php");

?>