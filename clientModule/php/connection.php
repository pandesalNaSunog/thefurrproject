<?php
    function connect(){
        $hostname = "localhost";
        $username = "u568496919_thefurr";
        $password = "Thefurrpassword";
        $database = "u568496919_thefurr_db";

        $con = new mysqli($hostname, $username, $password, $database);
        if($con->connect_error){
            $error = $con->connect_error;
            return $error;
        }
        return $con;
    }
?>