<?php
// Include header 
include_once("modules/header.php");


// include and create object for class
include_once("index.class.php");
$objScr = new INDEX();

?><div class="pt-3 pb-3">
        <div class="container">
            <div class="form-wrapper w-100 m-auto"><?php
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

                 ?><h4 class="text-center fw-700 fs-1 mb-4">Signup</h4>
                <form>
                    <div class="mb-4 position-relative">
                        <label for="txtName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="txtName" name="txtName" aria-describedby="name">
                        <small class="error" id="errName" style="display:none;">Please enter Name</small>
                    </div>
                    <div class="mb-4 position-relative">
                        <label for="txtEmail" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="txtEmail" name="txtEmail"  aria-describedby="emailHelp">
                        <small class="error" id="errEmail" style="display:none;">Please enter Email Address</small>
                        <small class="error" id="errEmailValid" style="display:none;">Please enter a valid Email Address</small>
                    </div>
                    <div class="mb-4 position-relative">
                        <label for="txtPhone" class="form-label">Phone number</label>
                        <input type="text" class="form-control" id="txtPhone" name="txtPhone" aria-describedby="phone">
                        <small class="error" id="errPhone" style="display:none;">Please enter a Phone number</small>
                        <small class="error" id="errPhoneValid" style="display:none;">Please enter a valid Phone number</small>
                    </div>
                    <div class="mb-4 position-relative">
                        <label for="txtPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                        <small class="error" id="errPwd" style="display:none;">Please enter a password</small>
                    </div>
                    
                    <button type="button" onclick="jsSubmitForm(this.form);" class="btn btn-primary mt-4 w-100 fw-600">Register</button>
                    <input type="hidden" id="doAction" name="doAction" value="">
                    <p class="fz-5 fw-400 mt-3 mb-0 text-center">Already have an account? <a href="index.php">Login</a></p>
                </form>
            </div>

        </div>
    </div>
    <script>

function jsSubmitForm(objForm){

    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let phoneRegex = /^\+?[1-9]\d{1,14}$/;
    
    // Name validation
    if(objForm.txtName.value == ""){
        document.getElementById("errName").style.display = "block";
        objForm.txtName.focus();
        return false;
    }
    else{
        document.getElementById("errName").style.display = "none";
    }

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

    // Phone Validation
    if(objForm.txtPhone.value == ""){
        document.getElementById("errPhone").style.display = "block";
        document.getElementById("errPhoneValid").style.display = "none";
        objForm.txtPhone.focus();
        return false;
    }
    else{
        if (!phoneRegex.test(objForm.txtPhone.value)) {
            document.getElementById("errPhone").style.display = "none";
            document.getElementById("errPhoneValid").style.display = "block";
            objForm.txtPhone.focus();
            return false;
        }
        else{
            document.getElementById("errPhone").style.display = "none";
            document.getElementById("errPhoneValid").style.display = "none";
        }
    }

    // Password
    if(objForm.txtPassword.value == ""){
        document.getElementById("errPwd").style.display = "block";
        objForm.txtPassword.focus();
        return false;
    }
    else{
        document.getElementById("errPwd").style.display = "none";
    }

    document.getElementById('doAction').value = "register";
    objForm.submit();
}
</script><?php

// include footer
include_once("modules/footer.php");

?>