<?php
    include('server.php');
    if(isSecure()){
        function connect(){
            //return new mysqli("localhost","u568496919_thefurr","Thefurrpassword11","u568496919_thefurr_db");
            return new mysqli("localhost","root","","thrfurr_db");
        }
    }else{
        error();
    }
    
?>