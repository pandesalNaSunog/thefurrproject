<?php
    session_start();
    if(isset($_SESSION['cashier_id'])){
        echo 'ok';
    }else{
        echo 'index.html';
    }
?>