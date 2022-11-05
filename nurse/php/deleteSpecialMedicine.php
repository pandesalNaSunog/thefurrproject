<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $specialMedicineId = $_POST['special_medicine_id'];
        $query = "DELETE FROM special_medicines WHERE id = '$specialMedicineId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>