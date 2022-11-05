<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $ivFluidId = $_POST['iv_fluid_id'];
        $query = "DELETE FROM i_v_fluids WHERE id = '$ivFluidId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>