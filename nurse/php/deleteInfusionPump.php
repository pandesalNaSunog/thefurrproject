<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        $infusionPumpId = $_POST['infusion_pump_id'];
        $query = "DELETE FROM infusion_pumps WHERE id = '$infusionPumpId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>