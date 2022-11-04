<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $today = currentDate();
        $oxygenId = $_POST['oxygen_id'];

        $query = "UPDATE oxygens SET stopped_at = '$today'";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM oxygens WHERE id = '$oxygenId'";
        $oxygen = $con->query($query) or die($con->error);
        $oxygenRow = $oxygen->fetch_assoc();

        echo json_encode($oxygenRow);
    }else{
        error();
    }
?>