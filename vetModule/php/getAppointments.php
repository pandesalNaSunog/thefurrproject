<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();

        if(isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            $query = "SELECT * FROM appointments WHERE doctor_id LIKE '%$doctorId%' ORDER BY date ASC";
            $appointment = $con->query($query) or die($con->error);
            
            $response = array();
            while($appointmentRow = $appointment->fetch_assoc()){
                $doctorIdArray = explode("**", $appointmentRow['doctor_id']);
                $pets = array();
                foreach($doctorIdArray as $key => $doctorIdItem){
                    if($doctorIdItem == $doctorId){
                        $petIdArray = $appointmentRow['pet_ids'];
                        $petId = explode("**",$petIdArray);
                        
                        $petIdInt = $petId[$key];
                        $query = "SELECT * FROM pets WHERE id = '$petIdInt'";
                        $pet = $con->query($query) or die($con->error);
                        $petRow = $pet->fetch_assoc();
                        $pets[] = $petRow;
                    }
                }
                $clientId = $appointmentRow['user_id'];
                $query = "SELECT * FROM users WHERE id = '$clientId'";
                $user = $con->query($query) or die($con->error);
                $userRow = $user->fetch_assoc();
                $clientName = $userRow['name'];

                $response[] = array(
                    'client_name' => $clientName,
                    'concern' => $appointmentRow['concern'],
                    'date' => date_format(date_create($appointmentRow['date']), "M d, Y"),
                    'time' => $appointmentRow['time'],
                    'arrival_status' => $appointmentRow['arrival_status'],
                    'pets' => $pets
                );


            }
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>