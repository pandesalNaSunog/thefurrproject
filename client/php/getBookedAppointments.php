<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];

            $query = "SELECT * FROM appointments WHERE user_id = '$clientId'";
            $appointmentQuery = $con->query($query) or die($con->error);
            $response = array();
            while($appointmentRow = $appointmentQuery->fetch_assoc()){
                $doctorId = $appointmentRow['doctor_id'];
                $doctorIdArray = explode("**", $doctorId);
                $petIdArray = explode("**",$appointmentRow['pet_ids']);

                $petAndAttendingVet = array();
                foreach($doctorIdArray as $key => $doctorId){
                    $petId = $petIdArray[$key];
                    $query = "SELECT * FROM users WHERE id = '$doctorId'";
                    $doctorQuery = $con->query($query) or die($con->error);
                    $doctorRow = $doctorQuery->fetch_assoc();
                    $doctorName = $doctorRow['name'];

                    $query = "SELECT * FROM pets WHERE id = '$petId'";
                    $petQuery = $con->query($query) or die($con->error);
                    $petRow = $petQuery->fetch_assoc();
                    $petName = $petRow['name'];
                    $petAndAttendingVet[] = array(
                        'doctor' => $doctorName,
                        'pet' => $petName
                    );
                }
                
                $concern = $appointmentRow['concern'];
                $date = date_format(date_create($appointmentRow['date']), "M d, Y");
                $time = $appointmentRow['time'];

                $response[] = array(
                    'concern' => $concern,
                    'date' => $date,
                    'time' => $time,
                    'pets_with_attending_vet' => $petAndAttendingVet
                );
            }

            echo json_encode($response);

            
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>