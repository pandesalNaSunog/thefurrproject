<?php
    session_start();
    if(!isset($_SESSION['lab_tech_id'])){
        echo 'index.html';
    }else{
        echo 'ok';
    }
?>