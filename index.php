
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

            ?><h4 class="text-center fw-700 fs-1 mb-4">Login</h4>
            <form id="frmLevel0" method="post" action="<?php print($_SERVER['REQUEST_URI']); ?>">
                <div class="mb-4 position-relative">
                    <label for="txtEmail" class="form-label">Email or Phone</label>
                    <input type="text" class="form-control" id="txtEmail" aria-describedby="emailHelp" name="txtEmail">
                    <small class="error" id="errEmail" style="display: none;">Please enter Email address or Phone number</small>
                    <small class="error" id="errEmailValid" style="display: none;">Please enter a valid Email address or Phone number</small>
                </div>
                <div class="mb-4 position-relative">
                    <label for="txtPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                    <small class="error" id="errPwd" style="display: none;">Please enter a Password</small>
                </div>
                <button type="button" onclick="jsValidateUser(this.form);" class="btn btn-primary mt-4 w-100">Login</button>
                <p class="fz-5 fw-400 mt-3 mb-0 text-center">Create an account <a href="register.php">Register Now</a></p>

                <p class="fz-5 fw-400 mt-3 mb-0 text-center">Searching for a person or post? <a href="publicfeed.php">click here</a> to explore public feed</p>
                <input type="hidden" id="doAction" name="doAction" value="">
            </form>
        </div>

    </div>
</div>

<script>

    function jsValidateUser(objForm){

        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let phoneRegex = /^\+?[1-9]\d{1,14}$/;
        
        // Email Validation
        if(objForm.txtEmail.value == ""){
            document.getElementById("errEmail").style.display = "block";
            document.getElementById("errEmailValid").style.display = "none";
            objForm.txtEmail.focus();
            return false;
        }
        else{
            if (!emailRegex.test(objForm.txtEmail.value) && !phoneRegex.test(objForm.txtEmail.value)) {
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

        // Password
        if(objForm.txtPassword.value == ""){
            document.getElementById("errPwd").style.display = "block";
            objForm.txtPassword.focus();
            return false;
        }
        else{
            document.getElementById("errPwd").style.display = "none";
        }

        document.getElementById('doAction').value = "login";
        objForm.submit();
    }
</script><?php

// include footer
include_once("modules/footer.php");

?>