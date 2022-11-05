<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $laboratoryId = $_POST['laboratory_id'];
        $query = "DELETE FROM confinement_lab_requests WHERE id = '$laboratoryId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>