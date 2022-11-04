<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $confinementId = $_POST['confinement_id'];

        $query = "INSERT INTO oxygens(`confinement_id`,`tick`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,0,'$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM oxygens WHERE id = LAST_INSERT_ID()";
        $otherMedicine = $con->query($query) or die($con->error);
        $otherMedicineRow = $otherMedicine->fetch_assoc();

        $response = array(
            'id' => $otherMedicineRow['id'],
            'stopped_at' => date_format(date_create($otherMedicineRow['stopped_at']), "M d, Y h:i A"),
            'date' => date_format(date_create($otherMedicineRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
    }else{
        error();
    }
?>