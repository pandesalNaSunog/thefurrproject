<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $id = $_POST['record_id'];

        $query = "SELECT users.client_code, medical_records.* FROM users JOIN medical_records ON users.id = medical_records.client_id WHERE medical_records.id = '$id'";
        $record = $con->query($query) or die($con->error);
        $row = $record->fetch_assoc();
        echo json_encode($row);
    }
?>