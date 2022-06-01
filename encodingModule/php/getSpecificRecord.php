<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $id = $_POST['record_id'];

        $query = "SELECT users.*, medical_records.* FROM medical_records JOIN users WHERE medical_records.id = '$id'";
        $record = $con->query($query) or die($con->error);
        $row = $record->fetch_assoc();

        echo json_encode($row);
    }
?>