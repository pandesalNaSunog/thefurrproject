<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $petWeight = htmlspecialchars($_POST['pet_weight']);
            $petId = htmlspecialchars($_POST['pet_id']);
            $doctorId = htmlspecialchars($_POST['doctor_id']);
            $service = htmlspecialchars($_POST['service']);
            $remarks = htmlspecialchars($_POST['remarks']);
            $date = htmlspecialchars($_POST['date']);
            $nextAppointment = htmlspecialchars($_POST['next_appointment']);
            $response = array();
            $query = "INSERT INTO wellness_records(`pet_weight`,`pet_id`,`doctor_id`,`service`,`remarks`,`date`,`next_appointment`,`created_at`,`updated_at`)VALUES('$petWeight','$petId','$doctorId','$service','$remarks','$date','$nextAppointment','$today','$today')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM wellness_records WHERE id = LAST_INSERT_ID()";
            $wellness = $con->query($query) or die($con->error);
            $wellnessRow = $wellness->fetch_assoc();
            $doctorId = $wellnessRow['doctor_id'];
            $query = "SELECT * FROM users WHERE id = '$doctorId'";
            $doctor = $con->query($query) or die($con->error);
            $doctorRow = $doctor->fetch_assoc();
            $doctorName = $doctorRow['name'];

            $date = date_create($date);
            $date = date_format($date,"M d, Y");

            $nextAppointment = date_create($nextAppointment);
            $nextAppointment = date_format($nextAppointment, "M d, Y");

            $response = array(
                'id' => $wellnessRow['id'],
                'service' => $wellnessRow['service'],
                'doctor' => $doctorName,
                'remarks' => $remarks,
                'date' => $date,
                'next_appointment' => $nextAppointment,
                'pet_weight' => $wellnessRow['pet_weight']
            );

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>