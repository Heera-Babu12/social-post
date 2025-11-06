<?php
class HOME{
    public $objFeed;
    public $arrMessages;

    function __construct(){

         // include class
         include_once("class/feeds.class.php");
         $this->objFeed = new FEEDS();
         
         // Error and Success Messages
        $this->arrMessages = array( 
            "NAD" => "Post not created successfully.",
            "AD" => "Post created successfully."
         );

         if(isset($_REQUEST['doAction'])){
             switch($_REQUEST['doAction']){
                 case "post" : 
  
                        if($this->objFeed->addPosts()){
                            header("location: home.php?flMsg=AD");
                            exit();
                        }
                        else{
                            header("location: home.php?flMsg=NAD&err=1");
                            exit();
                        }
  
                        break;
             }
         }
    }
}

?>