<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){
        $appointmentId = $_POST['appointment_id'];
        $petId = $_POST['pet_id'];
        $clientId = $_POST['client_id'];
        $labRequest = $_POST['lab_request'];
        $price = $_POST['price'];

        //insert lab request
        $query = "INSERT INTO lab_requests(`appointment_id`,`pet_id`,`client_id`,`lab_request`,`lab_request_price`) VALUES('$appointmentId','$petId','$clientId','$labRequest','$price')";
        $con->query($query) or die($con->error);
        
        //fetch inserted lab request

        $query = "SELECT * FROM lab_requests WHERE id = LAST_INSERT_ID()";
        $request = $con->query($query) or die($con->error);
        $row = $request->fetch_assoc();

        echo json_encode($row);
    }
?>