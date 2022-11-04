<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayTimeStamp = currentDate();
        $confinementId = $_POST['confinement_id'];
        $query = "SELECT * FROM syringe_pumps WHERE created_at LIKE '$today%' AND confinement_id = '$confinementId'";
        $infusionPump = $con->query($query) or die($con->error);

        


        
        if($infusionPumpRow = $infusionPump->fetch_assoc()){
            echo 'invalid';
        }else{

            $price = 250;
            
            $query = "INSERT INTO syringe_pumps(`confinement_id`,`tick`,`price`,`created_at`,`updated_at`)VALUES('$confinementId','1','$price','$todayTimeStamp','$todayTimeStamp')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM syringe_pumps WHERE id = LAST_INSERT_ID()";
            $infusionPump = $con->query($query) or die($con_>error);
            $infusionPumpRow = $infusionPump->fetch_assoc();



            echo json_encode(array(
                'date' => date_format(date_create($infusionPumpRow['created_at']), 'M d, Y h:i A'),
                'id' => $infusionPumpRow['id']
            ));
        }
    }else{
        error();
    }
?>