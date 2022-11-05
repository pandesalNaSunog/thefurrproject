<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $syringePumpId = $_POST['syringe_pump_id'];
        $query = "DELETE FROM syringe_pumps WHERE id = '$syringePumpId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>