<?php

// include and create object for class
include_once("home.class.php");
$objScr = new HOME();

if(!isset($_SESSION['USERID'])){
    header("Location: index.php"); 
    exit();
}

// Include header 
include_once("modules/header.php");

// Navigation 
include_once("modules/navigation.php");

?><div class="feed-container"><?php
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

    $arrUser = $objScr->objFeed->getUserName();
    ?><form action="home.php" method="post" enctype="multipart/form-data">
        <div class="post-form">
            <h3>Hi <?php print($arrUser['userName']); ?>, Create a Post</h3>
            <textarea name="taMessage" placeholder="What's on your mind?"></textarea>
            <input type="file" name="flImage" id="flImage" accept="image/*">
            <input type="hidden" id="doAction" name="doAction" value="">
            <button type="button" onclick="jsUploadPost(this.form);">Post</button>
        </div>
    </form>

    <h3>Your Posts</h3><?php
    $objResultPost = $objScr->objFeed->getPosts();
    while($arrPost = mysqli_fetch_assoc($objResultPost)){
       ?><div class="post">
            <p> Created Date : <?php print($arrPost['dateCreated']); ?></p><?php
            if(!empty($arrPost['message'])){
                ?><p> <?php print($arrPost['message']); ?></p><?php
            } 

            if(!empty($arrPost['fileName'])){
                $imagePath = "upload/" . $arrPost['fileName'];
                ?><img src="<?php print($imagePath); ?>" alt="post image" width="250px" height="200px"><?php
            }
       ?></div><?php
    }
?></div>
<script>
    function jsUploadPost(objForm){
        if(objForm.taMessage.value == "" && objForm.flImage.files.length == 0){
            document.getElementById("errMsg").style.display = "block";
            return false;
        }

        document.getElementById("doAction").value = "post";
        objForm.submit()
    }

</script><?php

// include footer
include_once("modules/footer.php");

?>