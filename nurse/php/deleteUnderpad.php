<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $underpadId = $_POST['underpad_id'];
        $query = "DELETE FROM underpads WHERE id = '$underpadId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>