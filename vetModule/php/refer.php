<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){
        $appointmentId = $_POST['appointment_id'];
        $doctor_id = $_POST['doctor_id'];

        $query = "UPDATE appointments SET doctor_id = '$doctor_id' WHERE id = '$appointmentId'";
        $con->query($query) or die($con->error);

        echo 'ok';
    }
?>