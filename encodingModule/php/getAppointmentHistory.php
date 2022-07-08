<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $userId = $_POST['user_id'];
        $query = "SELECT * FROM appointments WHERE client_id = '$userId'";
        $appointment = $con->query($query) or die($con->error);

        $appointments = array();

        while($row = $appointment->fetch_assoc()){
            $appointments[] = $row;
        }
        $response = array();
        foreach($appointments as $appointmentItem){
            $appointmentDate = $appointmentItem['date'];
            $appointmentId = $appointmentItem['id'];
            $clientId = $appointmentItem['client_id'];
            $vetId = $appointmentItem['doctor_id'];

            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();

            $query = "SELECT * FROM doctors WHERE id = '$vetId'";
            $doctor = $con->query($query) or die($con->error);
            $doctorRow = $doctor->fetch_assoc();
            $clientName = $userRow['name'];
            $attendingVet = $doctorRow['name'];
            $clientConcern = $appointmentItem['concern'];

            $response[] = array(
                'client_name' => $clientName,
                'attending_vet' => $attendingVet,
                'client_concern' => $clientConcern,
                'appointment_date' => $appointmentDate
            );
        }

        echo json_encode($response);
    }
?>