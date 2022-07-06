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

        $transactionId = transactioIdGenerator();


        $query = "INSERT INTO invoices(`transaction_id`,`amount_renderred`,`change`,`balance`,`created_at`, `updated_at`, `client_id`,`doctor_id`,`service_breakdown`,`total_price`,`pet_id`) VALUES('$transactionId',0.0,0.0,'$total','$createdAt', '$createdAt', '$clientId','$doctorId','$breakdown','$total','$petId')";
        $con->query($query) or die($con->error);
        echo 'ok';
    }

    function transactioIdGenerator(){
        $characters = "1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
        $generated = "";
        for($i = 0;$i < 10;$i++){
            $index = rand(0, strlen($characters) - 1);
            $generated .= $characters[$index];
        }

        return $generated;
    }

?>