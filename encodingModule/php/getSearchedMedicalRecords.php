<?php

    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $keyword = $_GET['keyword'];
        $query = "SELECT users.*, medical_records.* FROM medical_records JOIN users WHERE medical_records.patient_name LIKE '%$keyword%' OR users.client_code LIKE '%$keyword%'";
        $record = $con->query($query) or die($con->error);
        $data = array();
        while($row = $record->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
    }
?>