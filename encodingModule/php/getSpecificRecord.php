<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $id = $_POST['record_id'];

        $query = "SELECT * FROM medical_records WHERE id = '$id'";
        $record = $con->query($query) or die($con->error);
        $row = $record->fetch_assoc();

        echo json_encode($row);
    }
?>