<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();

        $price = htmlspecialchars($_POST['price']);
        $specialMedicineId = $_POST['special_medicine_id'];
        $specialMedicine = htmlspecialchars($_POST['special_medicine']);
        $query = "UPDATE special_medicines SET price = '$price', special_medicine = '$specialMedicine' WHERE id = '$specialMedicineId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>