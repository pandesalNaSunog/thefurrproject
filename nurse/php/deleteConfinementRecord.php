<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        $confinementRecordId = $_POST['confinement_record_id'];
        $query = "DELETE FROM confinement_records WHERE id = '$confinementRecordId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>