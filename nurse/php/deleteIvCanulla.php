<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $ivCanullaId = $_POST['iv_canulla_id'];
        $query = "DELETE FROM i_v_canullas WHERE id = '$ivCanullaId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>