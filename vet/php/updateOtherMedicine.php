<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();

        $price = htmlspecialchars($_POST['price']);
        $specialMedicineId = $_POST['other_medicine_id'];
        $specialMedicine = htmlspecialchars($_POST['other_medicine']);
        $query = "UPDATE other_medicines SET price = '$price', other_medicine = '$specialMedicine' WHERE id = '$specialMedicineId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>