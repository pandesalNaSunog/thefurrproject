<?php
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d H:i:s');
    include('connection.php');
    $con = connect();


    if(isset($_POST)){
        $vetId  = $_POST['attending_vet_id']; 
        $userId = $_POST['user_id'];
        $petName = $_POST['pet_name'];
        $clientConcern = $_POST['client_concern'];
        $appointmentDate = $_POST['appointment_date'];
        $age = $_POST['pet_age'];
        $breed = $_POST['pet_breed'];
        $species = $_POST['pet_species'];
        $weight = $_POST['pet_weight'];
        $sex = $_POST['pet_sex'];

        //insert appointment history

        $query = "INSERT INTO appointments(`client_id`,`doctor_id`,`date`,`time`,`concern`,`created_at`,`updated_at`)VALUES('$userId','$vetId','$appointmentDate','null','$clientConcern','$today','$today')";
        $con->query($query) or die($con->error);

        //insert patient details
        $query = "SELECT * FROM appointments WHERE id = LAST_INSERT_ID()";
        $appointment = $con->query($query) or die($con->error);
        $appointmentRow = $appointment->fetch_assoc();
        $appointmentId = $appointmentRow['id'];

        $query = "INSERT INTO patient_details(`appointment_id`,`client_id`,`pet_name`,`age`,`breed`,`species`,`weight`,`sex`,`created_at`,`updated_at`)VALUES('$appointmentId','$userId','$petName','$age','$breed','$species','$weight','$sex','$today','$today')";
        $con->query($query) or die($con->error);
        echo 'ok';
    }
?>