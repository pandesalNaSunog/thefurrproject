<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $otherMedicineId = $_POST['other_medicine_id'];
        $query = "DELETE FROM other_medicines WHERE id = '$otherMedicineId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>