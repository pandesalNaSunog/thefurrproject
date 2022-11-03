<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $todayTimeStamp = currentDate();
        $confinementId = $_POST['confinement_id'];
        $query = "SELECT * FROM confinement_records WHERE created_at LIKE '$today%' AND confinement_id = '$confinementId'";
        $confinementRecord = $con->query($query) or die($con->error);

        


        
        if($confinementRecordRow = $confinementRecord->fetch_assoc()){
            echo 'invalid';
        }else{

            $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
            $confinement = $con->query($query) or die($con->error);
            $confinementRow = $confinement->fetch_assoc();
            $petWeight = $confinementRow['pet_weight'];

            $price = calculatePrice($petWeight);
            
            $query = "INSERT INTO confinement_records(`confinement_id`,`tick`,`price`,`created_at`,`updated_at`)VALUES('$confinementId','1','$price','$todayTimeStamp','$todayTimeStamp')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM confinement_records WHERE id = LAST_INSERT_ID()";
            $confinementRecord = $con->query($query) or die($con_>error);
            $confinementRecordRow = $confinementRecord->fetch_assoc();



            echo json_encode(array(
                'date' => date_format(date_create($confinementRecordRow['created_at']), 'M d, Y h:i A'),
                'id' => $confinementRecordRow['id']
            ));
        }
    }else{
        error();
    }

    function calculatePrice($petWeight){
        if($petWeight < 5){
            return 800;
        }else if($petWeight > 5 && $petWeight <= 10){
            return 1000;
        }else if($petWeight > 10 && $petWeight <= 20){
            return 2000;
        }else if($petWeight > 20){
            return 2500;
        }
    }
?>