<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $petId = $_POST['pet_id'];
        $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId'";

        $wellness = $con->query($query) or die($con->error);

        $data = array();

        while($row = $wellness->fetch_assoc()){
            $doctorId = $row['doctor_id'];
            if($doctorId != 0){
                $query = "SELECT * FROM users WHERE id = '$doctorId'";
                $doctor = $con->query($query) or die($con->error);
                $doctorRow = $doctor->fetch_assoc();
                $doctorName = $doctorRow['name'];
            }else{
                $doctorName = "NONE";
            }
            
            $remarks = $row['remarks'];
            $date = $row['date'];
            $date = date_create($date);
            $date = date_format($date,"M d, Y");

            $nextAppointment = $row['next_appointment'];
            $nextAppointment = date_create($nextAppointment);
            $nextAppointment = date_format($nextAppointment, "M d, Y");

            $data[] = array(
                'id' => $row['id'],
                'service' => $row['service'],
                'doctor' => $doctorName,
                'doctor_id' => $doctorRow['id'],
                'remarks' => $remarks,
                'date' => $date,
                'next_appointment' => $nextAppointment,
                'pet_weight' => $row['pet_weight']
            );
        }
        echo json_encode($data);
    }else{
        echo header('HTTP/1.0 403 Forbidden');
    }
?>