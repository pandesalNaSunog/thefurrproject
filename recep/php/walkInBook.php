<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        date_default_timezone_set('Asia/Manila');

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $timeString = $time." (walk-in)";
        if(isset($_POST)){

            $userId = $_POST['user_id'];
            $concern = htmlspecialchars($_POST['concern']);
            $petIds = $_POST['pet_ids'];
            $petIdString = "";
            $doctorIdString = "";
            $doctorIds = array();
            foreach($petIds as $key => $petId){
                $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId'";
                $wellness = $con->query($query) or die($con->error);
                if($wellnessRow = $wellness->fetch_assoc()){
                    $doctorId = $wellnessRow['doctor_id'];
                }else{
                    $query = "SELECT * FROM users WHERE user_type ='doctor'";
                    $doctor = $con->query($query) or die($con->error);
                    while($doctorRow = $doctor->fetch_assoc()){
                        $doctorIds[] = $doctorRow['id'];
                    }
    
                    $doctorIndex = rand(0,3);
    
                    $doctorId = $doctorIds[$doctorIndex];
                }
                
                
                if($key == 0){
                    $petIdString .= $petId;
                    $doctorIdString .= $doctorId;
                }else{
                    $petIdString .= "**".$petId;
                    $doctorIdString .= "**".$doctrIdString;
                }
            }

            $query = "INSERT INTO appointments(`user_id`,`doctor_id`,`concern`,`date`,`time`,`arrival_status`,`pet_ids`,`created_at`,`updated_at`)VALUES('$userId','$doctorIdString','$concern','$date','$timeString','Pending','$petIdString','$today','$today')";
            $con->query($query) or die($con->error);

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>