<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $vitaminsId = $_POST['vitamins_id'];
        $query = "DELETE FROM vitamins WHERE id = '$vitaminsId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>