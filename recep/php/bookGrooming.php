<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $con = connect();

        $today = getCurrentDate();

        if(isset($_POST)){

            $userId = $_POST['user_id'];
            $petIds = $_POST['pet_ids'];
            $weight = $_POST['weight'];
            $petIdString = "";

            $doctorIdString = "";
            
            foreach($petIds as $key => $petId){
                $thisWeight = $weight[$key];
                if($thisWeight == ""){
                    $thisWeight = "NOT INDICATED";
                }
                if($key == 0){
                    $petIdString .= $petId;
                    $doctorIdString .= "0";
                }else{
                    $petIdString .= "**".$petId;
                    $doctorIdString .= "**0";
                }
                $query = "INSERT INTO wellness_records(`pet_id`,`doctor_id`,`service`,`remarks`,`date`,`next_appointment`,`created_at`,`updated_at`,`pet_weight`)VALUES('$petId',0,'GROOMING','GROOMING','$date','$date','$today','$today','$thisWeight')";
                $con->query($query) or die($con->error);
            }

            $query = "INSERT INTO appointments(`user_id`,`doctor_id`,`concern`,`date`,`time`,`arrival_status`,`pet_ids`,`created_at`,`updated_at`)VALUES('$userId','$doctorIdString','grooming','$date','$time','Arrived','$petIdString','$today','$today')";
            $con->query($query) or die($con->error);

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>