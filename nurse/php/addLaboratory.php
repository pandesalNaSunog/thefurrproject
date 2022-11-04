<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $labInput = htmlspecialchars($_POST['lab']);
        $confinementId = $_POST['confinement_id'];

        $query = "INSERT INTO confinement_lab_requests(`confinement_id`,`tick`,`laboratory`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,'$labInput',0,'$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM confinement_lab_requests WHERE id = LAST_INSERT_ID()";
        $otherMedicine = $con->query($query) or die($con->error);
        $otherMedicineRow = $otherMedicine->fetch_assoc();

        $response = array(
            'id' => $otherMedicineRow['id'],
            'laboratory' => $otherMedicineRow['laboratory'],
            'date' => date_format(date_create($otherMedicineRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
    }else{
        error();
    }
?>