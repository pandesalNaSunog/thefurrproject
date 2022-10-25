<?php
    include('server.php');

    if(secured()){
        echo 'done';
    }else{
        error();
    }
?>