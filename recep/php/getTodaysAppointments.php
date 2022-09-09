<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');

        include('connection.php');
        $con = connect();

        $query = "SELECT * FROM appointments WHERE date = '$today'";

        $appointment = $con->query($query) or die($con->error);
        $appointments = array();


        while($appointmentRow = $appointment->fetch_assoc()){
            $date = date_format(date_create($appointmentRow['date']), "M d, Y");
            $doctorIds = $appointmentRow['doctor_id'];
            $petIds = $appointmentRow['pet_ids'];

            $doctorIdArray = explode("**", $doctorIds);
            $petIdArray = explode("**", $petIds);
            $doctorNameString = "";
            $petNameString = "";
            foreach($doctorIdArray as $key => $doctorId){

                if($doctorId != 0){
                    $query = "SELECT * FROM users WHERE id = '$doctorId'";
                    $doctor = $con->query($query) or die($con->error);
                    $doctorRow = $doctor->fetch_assoc();
                    $doctorName = $doctorRow['name'];
                }else{
                    $doctorName = "GROOMING ONLY";
                }
                

                $petId = $petIdArray[$key];
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
                $petName = $petRow['name'];

                if($key == 0){
                    $doctorNameString .= $doctorName;
                    $petNameString .= $petName;
                }else{
                    $doctorNameString .= " / ".$doctorName;
                    $petNameString .= " / ".$petName;
                }
            }

            $appointments[] = array(
                'date' => $date,
                'doctor' => $doctorNameString,
                'pet' => $petNameString
            );
        }

        echo json_encode($appointments);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>