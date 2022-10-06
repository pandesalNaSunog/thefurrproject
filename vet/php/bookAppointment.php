<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        date_default_timezone_set('Asia/Manila');

        if(isset($_POST)){
            $clientId = $_POST['user_id'];
            $concern = 'Walked In';
            $date = date('Y-m-d');
            $time = date_format(date_create(date('H:i:s')), 'h:i A');
            $petIds = $_POST['pet_ids'];
            $status = "Arrived";
            $isDone = "no";
            $petIdString = "";
            $doctorIdString = "";
            $doctorIds = array();
            foreach($petIds as $key => $petId){

                $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId'";
                $wellness = $con->query($query) or die($con->error);
                $doctorId = 0;
                if($wellnessRow = $wellness->fetch_assoc()){
                    $doctorId = $wellnessRow['doctor_id'];
                }else{
                    $query = "SELECT * FROM users WHERE user_type ='doctor'";
                    $doctor = $con->query($query) or die($con->error);
                    while($doctorRow = $doctor->fetch_assoc()){
                        $doctorIds[] = $doctorRow['id'];
                    }

                    $doctorIndex = rand(0,count($doctorIds) - 1);

                    $doctorId = $doctorIds[$doctorIndex];
                }
                if($key == 0){
                    $petIdString .= $petId;
                    $doctorIdString .= $doctorId;
                }else{
                    $petIdString .= "**".$petId;
                    $doctorIdString .= "**".$doctorId;
                }
            }

            $query = $con->prepare("INSERT INTO appointments(is_done,user_id,doctor_id,concern,date,time,arrival_status,pet_ids,created_at,updated_at)VALUES(?,?,?,?,?,?,?,?,?,?)");
            $query->bind_param("sissssssss", $isDone,$clientId, $doctorIdString, $concern, $date, $time, $status, $petIdString, $today, $today);
            $query->execute();

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>