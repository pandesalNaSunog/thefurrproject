<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $nebulizationId = $_POST['nebulization_id'];
        $query = "DELETE FROM nebulizations WHERE id = '$nebulizationId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>