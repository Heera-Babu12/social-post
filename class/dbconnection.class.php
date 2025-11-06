<?php

// class for DB Connection
class DBCONNECTION{

    public $conn;

    function __construct()
    {
        session_start();
        
        include_once("config/config.php");

        // DB Connection
        $this->conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);
   
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $this->conn;
    }
}

?>
