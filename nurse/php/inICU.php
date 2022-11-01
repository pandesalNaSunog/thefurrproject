<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $today = currentDate();

        $confinementId = $_POST['confinement_id'];
        $query = "SELECT * FROM icus WHERE created_at LIKE '$today%'";
        $icu = $con->query($query) or die($con->error);

        if($icuRow = $icu->fetch_assoc()){
            echo 'invalid';
        }else{
            $query = "INSERT INTO icus(`confinement_id`,`tick`,`price`,`created_at`,`updated_at`)VALUES('$confinementId','Yes','1000','$today','$today')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM icus WHERE id = LAST_INSERT_ID()";
            $icu = $con->query($query) or die($con_>error);
            $icuRow = $icu->fetch_assoc();



            echo json_encode(array(
                'date' => date_format(date_create($icuRow['created_at']), 'M d, Y h:i A')
            ));
        }
    }else{
        error();
    }
?>