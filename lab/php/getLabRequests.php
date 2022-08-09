<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_SESSION['lab_tech_id'])){
            $labTechId = $_SESSION['lab_tech_id'];
            $query = "SELECT * FROM lab_requests WHERE lab_tech_id = $labTechId";
            $labRequest = $con->query($query) or die($con->error);
            $response = array();
            while($labRequestRow = $labRequest->fetch_assoc()){
                $petId = $labRequestRow['pet_id'];
                $doctorId = $labRequestRow['doctor_id'];
                $query = "SELECT * FROM users WHERE id = '$doctorId'";
                $doctorquery = $con->query($query) or die($con->error);

                $doctorRow = $doctorquery->fetch_assoc();
                $doctor = $doctorRow['name'];
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
                $petName = $petRow['name'];
                if($labRequestRow['has_result'] == 'No'){
                    $result = "pending";
                }else{
                    $labRequestId = $labRequestRow['id'];
                    $query = "SELECT * FROM lab_results WHERE lab_request_id = '$labRequestId'";
                    $resultQuery = $con->query($query) or die($con->error);
                    $resultRow = $resultQuery->fetch_assoc();
                    $result = $resultRow['result'];
                }

                $timeLimit = calculateTimeLeft($today, $labRequestRow['created_at'], $labRequestRow['time_limit'], $con, $labRequestRow['id']);
                $response[] = array(
                    'id' => $labRequestRow['id'],
                    'patient_name' => $petName,
                    'request' => $labRequestRow['request'],
                    'result' => $result,
                    'doctor' => $doctor,
                    'requested_at' => date_format(date_create($labRequestRow['created_at']),"M d, Y h:i A"),
                    'time_limit' => $timeLimit . "min"
                );
                
            }
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function calculateTimeLeft($today, $timeRequested, $timeLimit, $con ,$labRequestId){
        $expectedTime = strtotime($timeRequested . " + " . $timeLimit . " minute");
        $dateDiff = date_diff(date_create($today), date_create(date('Y-m-d H:i:s', $expectedTime)));
        $timeLeft = $dateDiff->format("%i");

        $percentR = $timeLeft->format("%R");

        if($percentR == "-"){
            $timeLeft = 0;
        }
        return $timeLeft;
    }
?>