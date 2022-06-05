<?php
    if(!isset($_SESSION)){
        session_start();
    }
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_GET)){
        $doctorId = $_SESSION['doctor_id'];
        $query = "SELECT * FROM appointments WHERE doctor_id = '$doctorId'";
        $appointment = $con->query($query) or die($con->error);
        $data = array();

        while($row = $appointment->fetch_assoc()){
            $data[] = $row;
        }

        $response = array();
        foreach($data as $dataItem){
            $clientId = $dataItem['client_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $row = $user->fetch_assoc();

            $response[] = array('appointment' => $dataItem, 'client_name' => $row['name'], 'client_id' => $row['id']);
        }
        echo json_encode($response);
    }
?>