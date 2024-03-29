<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        date_default_timezone_set('Asia/Manila');
        $todaysDate = date('Y-m-d');
        if(isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            $query = "SELECT * FROM appointments WHERE doctor_id LIKE '%$doctorId%' ORDER BY date, time ASC";
            $appointment = $con->query($query) or die($con->error);
            
            $response = array();
            while($appointmentRow = $appointment->fetch_assoc()){

                $date = $appointmentRow['date'];


                $todaysDateObject = date_create($todaysDate);
                $appointmentDateObject = date_create($date);

                $dateDiff = date_diff($appointmentDateObject, $todaysDateObject);

                $dateDifference = $dateDiff->format("%R");
                $dateDays = $dateDiff->format("%a");
                if($todaysDate == $date){
                    $day = "today";
                }else if($dateDifference == '+') {
                    $day = "yesterday";
                }else{
                    $day = "tomorrow";
                }
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
                    'day' => $day,
                    'appointment_id' => $appointmentRow['id'],
                    'client_name' => $clientName,
                    'concern' => $appointmentRow['concern'],
                    'date' => date_format(date_create($appointmentRow['date']), "M d, Y"),
                    'time' => $appointmentRow['time'],
                    'arrival_status' => $appointmentRow['arrival_status'],
                    'pets' => $pets,
                    'is_done' => $appointmentRow['is_done']
                );


            }
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>