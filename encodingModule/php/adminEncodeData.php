<?php
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d H:i:s');
    include('connection.php');
    $con = connect();


    if(isset($_POST)){
        $vetId  = $_POST['attending_vet_id']; 
        $userId = $_POST['user_id'];
        $clientConcern = $_POST['client_concern'];
        $appointmentDate = $_POST['appointment_date'];

        //insert appointment history

        $query = "INSERT INTO appointments(`client_id`,`doctor_id`,`date`,`time`,`concern`,`created_at`,`updated_at`)VALUES('$userId','$vetId','$appointmentDate','null','$clientConcern','$today','$today')";
        $con->query($query) or die($con->error);
        echo 'ok';
    }
?>