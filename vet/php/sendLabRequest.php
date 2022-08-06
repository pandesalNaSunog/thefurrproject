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

            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $hasResult = "No";
            $clientId = $petRow['user_id'];
            $labTechId = 0;
            $query = $con->prepare("INSERT INTO lab_requests(has_result,client_id,pet_id,doctor_id,lab_tech_id,request,created_at,updated_at)VALUES(?,?,?,?,?,?,?)");
            $query->bind_param("siiiisss",$hasResult, $clientId, $petId, $doctorId, $labTechId, $request, $today, $today);
            $query->execute();

            $query = "SELECT * FROM lab_requests WHERE id = LAST_INSERT_ID()";
            $labRequest = $con->query($query) or die($con->error);
            $labRequestRow = $labRequest->fetch_assoc();

            if($labRequestRow['lab_tech_id'] == 0){
                $attendingLabTech = "Pending";
            }else{
                $attendingLabTechId = $labRequestRow['lab_tech_id'];
                $query = "SELECT * FROM users WHERE id = '$attendingLabTechId'";
                $labTech = $con->query($query) or die($con->error);
                $labTechRow = $labTech->fetch_assoc();
                $attendingLabTech = $labTechRow['name'];
            }
            
            $response = array(
                'request' => $labRequestRow['request'],
                'lab_tech' => $attendingLabTech
            );
            echo json_encode($response);
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>