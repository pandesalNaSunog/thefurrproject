<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        $icuId = $_POST['icu_id'];
        $query = "DELETE FROM icus WHERE id = '$icuId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>