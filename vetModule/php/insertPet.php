<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){
        $petName = $_POST['pet_name'];
        $age = $_POST['age'];
        $breed = $_POST['breed'];
        $species = $_POST['species'];
        $weight = $_POST['weight'];
        $sex = $_POST['sex'];
        $appointmentId = $_POST['appointment_id'];

        //get Client Id

        $query = "SELECT * FROM appointments WHERE id = '$appointmentId'";
        $appointment = $con->query($query) or die($con->error);
        $row = $appointment->fetch_assoc();
        $clientId = $row['client_id'];

        //get Client Code
        $query = "SELECT * FROM users WHERE id = '$clientId'";
        $user = $con->query($query) or die($con->error);
        $row = $user->fetch_assoc();
        $clientCode = $row['client_code'];


        //insert pet
        $query = "INSERT INTO patient_details(`appointment_id`,`pet_name`,`age`,`breed`,`species`,`weight`,`sex`) VALUES('$appointmentId','$petName','$age','$breed','$species','$weight','$sex')";
        $con->query($query) or die($con->error);

        //return last inserted record
        $query = "SELECT * FROM patient_details WHERE id = LAST_INSERT_ID()";
        $patient = $con->query($query) or die($con->error);
        $row = $patient->fetch_assoc();

        echo json_encode($row);
    }
?>