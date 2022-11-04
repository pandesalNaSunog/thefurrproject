<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $petId = $_POST['pet_id'];
            $query = "SELECT * FROM medical_records WHERE pet_id = '$petId'";
            $record = $con->query($query) or die($con->error);
            $records = array();
            while($recordRow = $record->fetch_assoc()){

                $doctorId = $recordRow['doctor_id'];
                $query = "SELECT * FROM users WHERE id = '$doctorId'";
                $doctor = $con->query($query) or die($con->error);
                $doctorRow = $doctor->fetch_assoc();
                $doctorName = $doctorRow['name'];
                $records[] = array(
                    'pet_weight' => $recordRow['pet_weight'],
                    'temp' => $recordRow['temp'],
                    'hr' => $recordRow['hr'],
                    'rr' => $recordRow['rr'],
                    'tests' => $recordRow['tests'],
                    'procedure' => $recordRow['procedure'],
                    'medication' => $recordRow['medication'],
                    'case_closed' => $recordRow['case_closed'],
                    'doctor_id' => $doctorName,
                    'vet_nurse' => $recordRow['vet_nurse'],
                    'created_at' => date_format(date_create($recordRow['created_at']), "M d, Y h:i A")
                );
            }
            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();

            $petName = $petRow['name'];
            $clientId = $petRow['user_id'];

            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $client = $con->query($query) or die($con->error);
            $clientROw = $client->fetch_assoc();
            $clientName = $clientROw['name'];
            $clientCode = $clientROw['client_code'];

            $response = array(
                'client_name' => $clientName,
                'client_code' => $clientCode,
                'pet_name' => $petName,
                'records' => $records
            );

            echo json_encode($response);
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>