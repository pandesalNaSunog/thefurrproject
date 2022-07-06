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
            $appointmentId = $appointmentItem['id'];
            $clientId = $appointmentItem['client_id'];
            $vetId = $appointmentItem['doctor_id'];

            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();

            $query = "SELECT * FROM doctors WHERE id = '$vetId'";
            $doctor = $con->query($query) or die($con->error);
            $doctorRow = $doctor->fetch_assoc();


            $query = "SELECT * FROM patient_details WHERE appointment_id = '$appointmentId'";
            $patient = $con->query($query) or die($con->error);
            $patientRow = $patient->fetch_assoc();
            $petName = $patientRow['pet_name'];
            $age = $patientRow['age'];
            $breed = $patientRow['breed'];
            $species = $patientRow['species'];
            $weight = $patientRow['weight'];
            $sex = $patientRow['sex'];
            $clientName = $userRow['name'];
            $attendingVet = $doctorRow['name'];
            $clientConcern = $appointmentItem['concern'];

            $response[] = array(
                'client_name' => $clientName,
                'attending_vet' => $attendingVet,
                'client_concern' => $clientConcern,
                'pet_name' => $petName,
                'pet_age' => $age,
                'pet_breed' => $breed,
                'pet_species' => $species,
                'pet_weight' => $weight,
                'pet_sex' => $sex,
            );
        }

        echo json_encode($response);
    }
?>