<?php
    if(!isset($_SESSION)){
        session_start();

        if(isset($_SESSION['client_id'])){
            echo $_SESSION['client_id'];
        }else{
            echo 'index.html';
        }
        
    }
?>