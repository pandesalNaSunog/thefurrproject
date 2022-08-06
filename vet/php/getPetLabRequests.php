<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
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
                    $query = "SELECT * users WHERE id = '$labTechId'";
                    $labTechquery = $con->query($query) or die($con->error);
                    $labTechRow = $labTech->fetch_assoc();
                    $labTech = $labTechRow['name'];
                }
                $requests[] = array(
                    'request' => $requestRow['request'],
                    'lab_tech' => $labTech
                );
            }

            echo json_encode($requests);
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>