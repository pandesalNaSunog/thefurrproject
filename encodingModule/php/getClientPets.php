<?php
    include('connection.php');
    $con = connect();


    if(isset($_GET)){
        $appointmentId = $_GET['appointment_id'];
    }
?>