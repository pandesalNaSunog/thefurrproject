<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $confinementId = $_POST['confinement_id'];


        $query = "SELECT * FROM laser_therapies";
        $laser = $con->query($query) or die($con->error);
        if($laserRow = $laser->fetch_assoc()){
            $price = 1200;
        }else{
            $price = 1700;
        }

        $query = "INSERT INTO laser_therapies(`confinement_id`,`tick`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,'$price','$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM laser_therapies WHERE id = LAST_INSERT_ID()";
        $otherMedicine = $con->query($query) or die($con->error);
        $otherMedicineRow = $otherMedicine->fetch_assoc();

        $response = array(
            'id' => $otherMedicineRow['id'],
            'date' => date_format(date_create($otherMedicineRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
    }else{
        error();
    }
?>