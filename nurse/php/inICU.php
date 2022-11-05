<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $todayTimeStamp = currentDate();

        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $confinementId = $_POST['confinement_id'];
        
        $query = "INSERT INTO icus(`confinement_id`,`tick`,`price`,`created_at`,`updated_at`)VALUES('$confinementId','Yes','1000','$todayTimeStamp','$todayTimeStamp')";
        $con->query($query) or die($con->error);
        $query = "SELECT * FROM icus WHERE id = LAST_INSERT_ID()";
        $icu = $con->query($query) or die($con_>error);
        $icuRow = $icu->fetch_assoc();



        echo json_encode(array(
            'date' => date_format(date_create($icuRow['created_at']), 'M d, Y h:i A'),
            'id' => $icuRow['id']
        ));
        
    }else{
        error();
    }
?>