<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $otherMedicineInput = htmlspecialchars($_POST['other_medicine']);
        $confinementId = $_POST['confinement_id'];

        $query = "INSERT INTO other_medicines(`confinement_id`,`tick`,`other_medicine`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,'$otherMedicineInput',0,'$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM other_medicines WHERE id = LAST_INSERT_ID()";
        $otherMedicine = $con->query($query) or die($con->error);
        $otherMedicineRow = $otherMedicine->fetch_assoc();

        $response = array(
            'id' => $otherMedicineRow['id'],
            'other_medicine' => $otherMedicineRow['other_medicine'],
            'date' => date_format(date_create($otherMedicineRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
    }else{
        error();
    }
?>