<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $petIdArray = explode("*",$_POST['pet_id']);
            $petId = $petIdArray[0];
            $appointmentId = $petIdArray[1];

            $hasMedicalRecord = false;
            $query = "SELECT * FROM medical_records WHERE pet_id = '$petId' AND appointment_id = '$appointmentId'";
            $medicalRecord = $con->query($query) or die($con->error);
            if($medicalRecordRow = $medicalRecord->fetch_assoc()){
                $hasMedicalRecord = true;
            }else{
                $hasMedicalRecord = false;
            }
            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $petName = $petRow['name'];
            $clientId = $petRow['user_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);

            $userRow = $user->fetch_assoc();
            $name = $userRow['name'];
            $code = $userRow['client_code'];
            $response = array(
                'appointment_id' => $appointmentId,
                'client_id' => $clientId,
                'name' => $name,
                'pet_name' => $petName,
                'client_code' => $code,
                'has_medical_record' => $hasMedicalRecord
            );

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>