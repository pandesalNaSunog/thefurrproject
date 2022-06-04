<?php

    if(!isset($_SESSION)){
        session_start();
    }
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $id = $_SESSION['client_id'];

        $query = "SELECT users.*, appointments.* FROM appointments JOIN users ON appointments.client_id = users.id WHERE appointments.client_id = '$id'";
        $appointments = $con->query($query) or die($con->error);
        $data = array();
        while($row = $appointments->fetch_assoc()){
            $data[] = $row;
        }
        $response = array();
        foreach($data as $dataItem){
            $doctorId = $dataItem['doctor_id'];
            $query = "SELECT * FROM doctors WHERE id = '$doctorId'";
            $doctor = $con->query($query) or die($con->error);
            $row = $doctor->fetch_assoc();
            $response[] = array('name' => $dataItem['name'], 'concern' => $dataItem['concern'], 'vet' => $row['name'], 'date' => $dataItem['date'], 'time' => $dataItem['time']);
        }
        echo json_encode($response);
    }
?>