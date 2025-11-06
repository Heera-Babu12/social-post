<?php

// include and create object for class
include_once("index.class.php");
$objScr = new INDEX();

// Include header 
include_once("modules/header.php");

?><div class="navbar">
    <span>Public Feed</span>   
    <div class="nav-links">
        <a href="index.php">Back to Login</a>
    </div> 
</div><?php

if(!isset($_REQUEST['txtSearch'])) $_REQUEST['txtSearch'] = "";

?><form action="publicfeed.php" method="post">
    <div class="search-container">
        <input type="text" class="search-box" id="txtSearch" name="txtSearch" placeholder="Search with Phone number" value="<?php print($_REQUEST['txtSearch']); ?>">
        <small class="error" id="errSearch" style="display:none;">Please enter a phone number to search</small>
        <button type="button" class="btn btn-primary" onclick="jsSearch(this.form);">Search</button>
        <button type="button" class="btn btn-light" onclick="jsClearSearch(this.form);">Clear Search</button>
        <input type="hidden" name="doAction" id="doAction" value="">
    </div>
</form>

<div class="feed-container"><?php
    if((isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == "search" && !empty($_REQUEST['txtSearch'])) || (isset($_REQUEST['mob']))){
        $objResult = $objScr->objUser->getUserPostDetails();

        // display user's name only once
        $userName = "";
        $totalRecords = mysqli_num_rows($objResult);

        if($totalRecords > 0){
            while($arrDetails = mysqli_fetch_assoc($objResult)){
                if($userName != $arrDetails['userName']){
                    ?><div class="profile">
                        <img src="upload/profile_img.jpg" alt="Profile Picture">
                         <span><strong><?php print($arrDetails['userName']); ?></strong></span>
                    </div><?php
    
                    $userName = $arrDetails['userName'];
                }
    
                if(!empty($arrDetails['message'])){
                    ?><div class="post">
                        <p> Created Date : <?php print($arrDetails['dateCreated']); ?></p>
                        <p> Created By : <?php print($arrDetails['userName']); ?></p>
                        <p><?php print($arrDetails['message']); ?></p><?php
                        if(!empty($arrDetails['fileName'])){
                            $imagePath = "upload/" . $arrDetails['fileName'];
                            ?><img src="<?php print($imagePath); ?>" alt="post image" width="250px" height="200px"><?php
                        }
                    ?></div><?php
                }
                else if(!empty($arrDetails['fileName'])){
                    ?><div class="post">
                        <p> Created Date : <?php print($arrDetails['dateCreated']); ?></p>
                        <p> Created By : <?php print($arrDetails['userName']); ?></p><?php
                        $imagePath = "upload/" . $arrDetails['fileName'];
                        ?><img src="<?php print($imagePath); ?>" alt="post image" width="250px" height="200px">
                    </div><?php
                } 
            }
        }
        else{
            ?><div class="post">
                <p>No details to show</p>
            </div><?php
        }
        
    }
    else{
        ?><div class="post">
            <p>No details to show</p>
          </div><?php
    }
    ?>
    
</div>

<script>
    function jsSearch(objForm){
        if(objForm.txtSearch.value == ""){
            document.getElementById("errSearch").style.display = "block";
            objForm.txtSearch.focus();
            return false;
        }
        else{
            document.getElementById("errSearch").style.display = "none";
        }
        
        document.getElementById("doAction").value = "search";
        objForm.submit();
    }

    function jsClearSearch(objForm){
        document.getElementById("txtSearch").value = "";
        document.getElementById("doAction").value = "";
        objForm.submit();

    }
</script><?php

// include footer
include_once("modules/footer.php");

?>