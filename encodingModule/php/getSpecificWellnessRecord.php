<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $wellnessId = $_POST['wellness_id'];

        $query = "SELECT * FROM wellness_records WHERE id = '$wellnessId'";
        $wellness = $con->query($query) or die($con->error);

        $row = $wellness->fetch_assoc();
        $service = $row['service'];
        $petWeight = $row['pet_weight'];
        $doctorId = $row['doctor_id'];
        $remarks = $row['remarks'];
        $query = "SELECT * FROM users WHERE id = '$doctorId'";
        $doctor = $con->query($query) or die($con->error);

        $doctorRow = $doctor->fetch_assoc();
        $doctorName = $doctorRow['name'];
        $date = $row['date'];
        $nextAppointment = $row['next_appointment'];
        
        $response = array(
            'service' => $service,
            'pet_weight' => $petWeight,
            'doctor' => $doctorName,
            'doctor_id' => $doctorId,
            'remarks' => $remarks,
            'date' => $date,
            'next_appointment' => $nextAppointment
        );

        echo json_encode($response);
    }
?>