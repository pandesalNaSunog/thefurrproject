<?php
    include('secure.php');
    if(secured()){
        session_start();
        session_unset();
        echo 'ok';
    }else{
        showError();
    }
?>