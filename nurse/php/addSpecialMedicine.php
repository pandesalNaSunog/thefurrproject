<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $specialMedicineInput = htmlspecialchars($_POST['special_medicine']);
        $confinementId = $_POST['confinement_id'];

        
        $query = "INSERT INTO special_medicines(`confinement_id`,`tick`,`special_medicine`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,'$specialMedicineInput',0,'$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM special_medicines WHERE id = LAST_INSERT_ID()";
        $antibiotic = $con->query($query) or die($con->error);
        $antibioticRow = $antibiotic->fetch_assoc();

        $response = array(
            'id' => $antibioticRow['id'],
            'special_medicine' => $antibioticRow['special_medicine'],
            'date' => date_format(date_create($antibioticRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
        
    }else{
        error();
    }
?>