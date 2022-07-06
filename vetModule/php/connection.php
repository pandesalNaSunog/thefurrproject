<?php
     function connect(){
        $hostname = "localhost";
        $username = "u568496919_thefurr";
        $password = "Thefurrpassword";
        $database = "u568496919_thefurr_db";
        $con = new mysqli($hostname,$username,$password,$database);
        return $con;
    }
    function getCurrentDate(){
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d H:i:s');
        return $date;
    }
?>