<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST) && $_SESSION['doctor_id']){
            $doctorId = $_SESSION['doctor_id'];
            $petId = $_POST['pet_id'];
            $request = htmlspecialchars($_POST['request']);
            $labTechId = $_POST['vet_tech_id'];
            $timeLimit = $_POST['time_limit'];

            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $hasResult = "No";
            $clientId = $petRow['user_id'];
            $query = $con->prepare("INSERT INTO lab_requests(has_result,client_id,pet_id,doctor_id,lab_tech_id,request,created_at,updated_at,time_limit)VALUES(?,?,?,?,?,?,?,?,?)");
            $query->bind_param("siiiisssi",$hasResult, $clientId, $petId, $doctorId, $labTechId, $request, $today, $today, $timeLimit);
            $query->execute();

            $query = "SELECT * FROM lab_requests WHERE id = LAST_INSERT_ID()";
            $labRequest = $con->query($query) or die($con->error);
            $labRequestRow = $labRequest->fetch_assoc();

            $query = "SELECT * FROM users WHERE id = '$doctorId'";
            $doctorQuery = $con->query($query) or die($con->error);
            $doctorRow = $doctorQuery->fetch_assoc();
            $doctor = $doctorRow['name'];

            $attendingLabTechId = $labRequestRow['lab_tech_id'];
            $query = "SELECT * FROM users WHERE id = '$attendingLabTechId'";
            $labTech = $con->query($query) or die($con->error);
            $labTechRow = $labTech->fetch_assoc();
            $attendingLabTech = $labTechRow['name'];
            
            
            $response = array(
                'request' => $labRequestRow['request'],
                'lab_tech' => $attendingLabTech,
                'doctor' => $doctor,
                'date' => date_format(date_create($labRequestRow['created_at']),"M d, Y h:i A"),
                'time_limit' => $labRequestRow['time_limit']
            );
            echo json_encode($response);
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>