<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $vitaminsInput = htmlspecialchars($_POST['vitamins']);
        $confinementId = $_POST['confinement_id'];

        
        $query = "INSERT INTO vitamins(`confinement_id`,`tick`,`vitamin`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,'$vitaminsInput',100,'$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM vitamins WHERE id = LAST_INSERT_ID()";
        $antibiotic = $con->query($query) or die($con->error);
        $antibioticRow = $antibiotic->fetch_assoc();

        $response = array(
            'id' => $antibioticRow['id'],
            'vitamins' => $antibioticRow['vitamin'],
            'date' => date_format(date_create($antibioticRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
        
    }else{
        error();
    }
?>