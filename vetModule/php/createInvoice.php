<?php

    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_POST)){
        $services = $_POST['services'];
        $prices = $_POST['prices'];
        $total = $_POST['total'];
        $clientId = $_POST['client_id'];
        $doctorId = $_SESSION['doctor_id'];
        $appointmentId = $_POST['appointment_id'];

        $index = 0;

        $breakdown = "";
        while($index < count($services)){
            $thisService = $services[$index];
            $thisPrice = $prices[$index];
            $breakdown .= $thisService."**".$thisPrice."\n";
            $index++;
        }


        $query = "INSERT INTO invoices(`client_id`,`doctor_id`,`service_breakdown`,`total_price`) VALUES('$clientId','$doctorId','$breakdown','$total')";
        $con->query($query) or die($con->error);
        $query = "DELETE FROM appointments WHERE id = '$appointmentId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }

?>