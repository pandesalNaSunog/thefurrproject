<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        if(!isset($_SESSION['lab_tech_id'])){
            echo 0;
        }else{
            echo 1;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>