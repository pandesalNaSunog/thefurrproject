<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){
        $id = $_POST['appointment_id'];
        $query = "SELECT * FROM appointments WHERE id = '$id'";
        $appointment = $con->query($query) or die($con->error);
        $row = $appointment->fetch_assoc();

        $clientId = $row['client_id'];
        $appointmentId = $row['id'];

        //get pet details using appointment id

        $query = "SELECT * FROM patient_details WHERE appointment_id = '$appointmentId'";
        $pet = $con->query($query) or die($con->error);
        $petRow = $pet->fetch_assoc();


        $query = "SELECT * FROM users WHERE id = '$clientId'";
        $user = $con->query($query) or die($con->error);
        $row = $user->fetch_assoc();

        echo json_encode(array(
            'name' => $row['name'],
            'client_code' => $row['client_code'],
            'pet_name' => $petRow['pet_name'],
            'pet_id' => $petRow['id'],
            'client_id' => $row['id']
        ));
    }
?>