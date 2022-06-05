<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){
        $id = $_POST['appointment_id'];
        $query = "SELECT * FROM appointments WHERE id = '$id'";
        $appointment = $con->query($query) or die($con->error);
        $row = $appointment->fetch_assoc();

        $clientId = $row['client_id'];

        $query = "SELECT * FROM users WHERE id = '$clientId'";
        $user = $con->query($query) or die($con->error);
        $row = $user->fetch_assoc();

        echo json_encode($row);
    }
?>