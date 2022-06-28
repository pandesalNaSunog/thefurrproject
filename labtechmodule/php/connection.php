<?php
    function connect(){
        $con = new mysqli('localhost','root','','thrfurr_db');
        return $con;
    }
    function getCurrentDate(){
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d H:i:s');
        return $date;
    }
?>