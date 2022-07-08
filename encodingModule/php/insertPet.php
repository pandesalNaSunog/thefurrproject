<?php
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d H:i:s');
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $clientId = $_POST['client_id'];
        $appointmentId = $_POST['appointment_id'];
        $name = $_POST['pet_name'];
        $age = $_POST['age'];
        $breed = $_POST['breed'];
        $species = $_POST['species'];
        $weight = $_POST['weight'];
        $sex = $_POST['sex'];

        $query = "SELECT * FROM patient_details WHERE client_id = '$clientId' AND pet_name = '$name'";
        $patient = $con->query($query) or die($con->error);
        if(!($row = $patient->fetch_assoc())){
            $query = "INSERT INTO patient_details(`client_id`,`pet_name`,`breed`,`species`,`sex`,`created_at`,`updated_at`)VALUES('$clientId','$name','$breed','$species','$sex','$today','$today')";
            $con->query($query) or die($con->error);
        }

        $query = "INSERT INTO pet_age_and_sexes(`weight`,`age`,`created_at`,`updated_at`,`appointment_id`)VALUES('$weight','$age','$today','$today','$appointmentId')";
        $con->query($query) or die($con->error);
        echo 'ok';
    }
?>