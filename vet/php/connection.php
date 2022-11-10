<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        function connect(){
            //return new mysqli("localhost","root","","thrfurr_db");

            return new mysqli("localhost","u568496919_thefurr","Thefurrpassword11","u568496919_thefurr_db");
        }

        function getCurrentDate(){
            date_default_timezone_set('Asia/Manila');
            $today = date('Y-m-d H:i:s');
            return $today;
        }

        function humanReadableDate($date){
            return date_format(date_create($date), "M d, Y h:i A");
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

?>
