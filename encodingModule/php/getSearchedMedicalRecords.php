<?php

    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $keyword = $_GET['keyword'];
        $query = "SELECT * FROM medical_records WHERE patient_name LIKE '%$keyword%' OR client_code LIKE '%$keyword%'";
        $record = $con->query($query) or die($con->error);
        $data = array();
        while($row = $record->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
    }
?>