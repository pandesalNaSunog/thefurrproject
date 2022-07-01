<?php
    date_default_timezone_set('Asia/Manila');
    $createdAt = date('Y-m-d H:i:s');
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
        $petId = $_POST['pet_id'];

        $index = 0;

        $breakdown = "";
        while($index < count($services)){
            $thisService = $services[$index];
            $thisPrice = $prices[$index];
            $breakdown .= $thisService."**".$thisPrice."\n";
            $index++;
        }


        $query = "INSERT INTO invoices(`amount_renderred`,`change`,`balance`,`created_at`, `updated_at`, `client_id`,`doctor_id`,`service_breakdown`,`total_price`,`pet_id`) VALUES(0.0,0.0,'$total','$createdAt', '$createdAt', '$clientId','$doctorId','$breakdown','$total','$petId')";
        $con->query($query) or die($con->error);
        $query = "DELETE FROM appointments WHERE id = '$appointmentId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }

?>