<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $wellnessId = $_POST['wellness_id'];
        $petId = $_POST['pet_id'];
        $doctorId = $_POST['doctor_id'];
        $service = $_POST['service'];
        $remarks = $_POST['remarks'];
        $date = $_POST['date'];
        $nextAppointment = $_POST['next_appointment'];
        $petWeight = $_POST['pet_weight'];

        $query = "UPDATE wellness_records SET pet_id = '$petId', doctor_id = '$doctorId', service = '$service', remarks = '$remarks', date = '$date', next_appointment = '$nextAppointment', pet_weight = '$petWeight' WHERE id = '$wellnessId'";

        $con->query($query) or die($con->error);

        echo 'ok';
    }
?>