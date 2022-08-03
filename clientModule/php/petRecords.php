<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        if(isset($_POST) && isset($_SESSION['client_id'])){
            $petId = $_POST['pet_id'];
            $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId'";
            $wellness = $con->query($query) or die($con->error);
            $wellnessRecords = array();
            while($wellnessRow = $wellness->fetch_assoc()){
                $doctorId = $wellnessRow['doctor_id'];
                $query = "SELECT * FROM users WHERE id = $doctorId";
                $doctor = $con->query($query) or die($con->error);
                $doctorRow = $doctor->fetch_assoc();
                $doctor = $doctorRow['name'];
                $wellnessRecords[] = array(
                    'doctor' => $doctor,
                    'service' => $wellnessRow['service'],
                    'date' => date_format(date_create($wellnessRow['date']), "M d, Y")
                );
            }
            echo json_encode($wellnessRecords);
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>