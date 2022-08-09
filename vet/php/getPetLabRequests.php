<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $today = getCurrentDate();
        $con = connect();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            $petId = $_POST['pet_id'];
            $query = "SELECT * FROM lab_requests WHERE pet_id = '$petId' AND doctor_id = '$doctorId'";
            $request = $con->query($query) or die($con->error);
            $requests = array();

            while($requestRow = $request->fetch_assoc()){
                if($requestRow['lab_tech_id'] == 0){
                    $labTech = 'Pending';
                }else{
                    $labTechId = $requestRow['lab_tech_id'];
                    $query = "SELECT * FROM users WHERE id = '$labTechId'";
                    $labTechquery = $con->query($query) or die($con->error);
                    $labTechRow = $labTechquery->fetch_assoc();
                    $labTech = $labTechRow['name'];
                }
                $query = "SELECT * FROM users WHERE id = '$doctorId'";
                $doctorQuery = $con->query($query) or die($con->error);
                $doctorRow = $doctorQuery->fetch_assoc();
                $doctor = $doctorRow['name'];

                $labRequestId = $requestRow['id'];
                $query = "SELECT * FROM lab_results WHERE lab_request_id = '$labRequestId'";
                $labResultQuery = $con->query($query) or die($con->error);
                $labResults = array();
                while($labResultRow = $labResultQuery->fetch_assoc()){
                    $labResults[] = $labResultRow;
                }

                if(count($labResults) == 0){
                    $result = "Pending";
                }else{
                    $result = $labResults;
                }

                $timeLeft = calculateTimeLeft($today, $requestRow['created_at'], $requestRow['time_limit'], $con, $labRequestId);

                $requests[] = array(
                    'id' => $requestRow['id'],
                    'time_limit' => $timeLeft."min",
                    'request' => $requestRow['request'],
                    'lab_tech' => $labTech,
                    'doctor' => $doctor,
                    'result' => $result,
                    'date' => date_format(date_create($requestRow['created_at']),"M d, Y h:i A"),
                );
            }
            echo json_encode($requests);
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }



    function calculateTimeLeft($today, $timeRequested, $timeLimit, $con ,$labRequestId){
        $expectedTime = strtotime($timeRequested . " + " . $timeLimit . " minute");
        $dateDiff = date_diff(date_create($today), date_create(date('Y-m-d H:i:s', $expectedTime)));
        $timeLeft = $dateDiff->format("%i");
        return $timeLeft;
    }
?>