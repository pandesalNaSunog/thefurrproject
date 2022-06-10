<?php

    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){

        $appointmentId = $_POST['appointment_id'];

        $query = "SELECT * FROM lab_requests WHERE appointment_id = '$appointmentId'";
        $labRequest = $con->query($query) or die($con->error);
        $data = array();
        while($row = $labRequest->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
    }
?>