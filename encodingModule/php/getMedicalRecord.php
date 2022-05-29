<?php
    include('connection.php');
    $con = connect();

    $query = "SELECT * FROM medical_records";
    $record = $con->query($query) or die($con->error);
    $data = array();
    while($row = $record->fetch_assoc()){
        $data[] = $row;
    }

    echo json_encode($data);
?>