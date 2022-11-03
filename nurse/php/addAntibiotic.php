<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayDate = currentDate();
        $antibioticInput = htmlspecialchars($_POST['antibiotic']);
        $confinementId = $_POST['confinement_id'];

        $query = "INSERT INTO antibiotics(`confinement_id`,`tick`,`antibiotic`,`price`,`created_at`,`updated_at`)VALUES('$confinementId',1,'$antibioticInput',100,'$todayDate','$todayDate')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM antibiotics WHERE id = LAST_INSERT_ID()";
        $antibiotic = $con->query($query) or die($con->error);
        $antibioticRow = $antibiotic->fetch_assoc();

        $response = array(
            'id' => $antibioticRow['id'],
            'antibiotic' => $antibioticRow['antibiotic'],
            'date' => date_format(date_create($antibioticRow['created_at']), "M d, Y h:i A")
        );

        echo json_encode($response);
    }else{
        error();
    }
?>