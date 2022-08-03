<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];
            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pet = $con->query($query) or die($con->error);
            $nextAppointments = array();
            while($petRow = $pet->fetch_assoc()){
                $petId = $petRow['id'];
                $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId' ORDER BY id DESC";
                $wellness = $con->query($query) or die($con->error);
                
                $wellnessRow = $wellness->fetch_assoc();
                $doctorId = $wellnessRow['doctor_id'];

                $query = "SELECT * FROM users WHERE id = '$doctorId'";
                $doctor = $con->query($query) or die($con->error);
                $doctorRow = $doctor->fetch_assoc();
                $doctorName = $doctorRow['name'];
                $nextAppointments[] = array(
                    'pet_name' => $petRow['name'],
                    'date' => date_format(date_create($wellnessRow['next_appointment']),"M d, Y"),
                    'doctor' => $doctorName
                );
            }

            echo json_encode($nextAppointments);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>