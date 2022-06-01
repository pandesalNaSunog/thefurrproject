<?php

    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT users.*, medical_records.* FROM medical_records JOIN users ON medical_records.client_id = users.id";
        $record = $con->query($query) or die($con->error);
        $data = array();
        while($row = $record->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    }
?>