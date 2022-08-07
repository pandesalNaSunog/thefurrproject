<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();

        include('connection.php');
        $con = connect();
        if(isset($_POST) && isset($_SESSION['lab_tech_id'])){
            $labRequestId = $_POST['lab_request_id'];
            $query = "SELECT * FROM lab_results WHERE lab_request_id = '$labRequestId'";
            $labRequestQuery = $con->query($query) or die($con->error);
            $labResults = array();
            while($labRequestRow = $labRequestQuery->fetch_assoc()){
                $labResults[] = $labRequestRow;
                $petId = $labRequestRow['pet_id'];
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
                $patientName = $petRow['name'];

                $doctorId = $labRequestRow['doctor_id'];
                $query = "SELECT * FROM users WHERE id = '$doctorId'";
                $doctor = $con->query($query) or die($con->error);
                $doctorRow = $doctor->fetch_assoc();
                $attendingVet = $doctorRow['name'];

                $request = $labRequestRow['request'];
            }


            echo json_encode(
                array(
                    'results' => $labResults,
                    'patient_name' => $patientName,
                    'request' => $request
                )
            );
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>