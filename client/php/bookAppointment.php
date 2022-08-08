<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();

        if(isset($_POST) && isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];
            $concern = htmlspecialchars($_POST['concern']);
            $date = $_POST['date'];
            $time = $_POST['time'];
            $petIds = $_POST['pet_ids'];
            $status = "Pending";
            $petIdString = "";
            $doctorIdString = "";
            $doctorIds = array();
            foreach($petIds as $key => $petId){

                $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId'";
                $wellness = $con->query($query) or die($con->error);
                $doctorId = 0;
                if($wellnessRow = $wellness->fetch_assoc() && $wellnessRow['doctor_d'] != 0){
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
                    $doctorIdString .= "**".$doctorId;
                }
            }

            $query = $con->prepare("INSERT INTO appointments(user_id,doctor_id,concern,date,time,arrival_status,pet_ids,created_at,updated_at)VALUES(?,?,?,?,?,?,?,?,?)");
            $query->bind_param("issssssss", $clientId, $doctorIdString, $concern, $date, $time, $status, $petIdString, $today, $today);
            $query->execute();

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>