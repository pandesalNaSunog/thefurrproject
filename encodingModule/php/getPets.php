<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $clientId = $_GET['client_id'];
        $query = "SELECT * FROM patient_details WHERE client_id = '$clientId'";
        $client = $con->query($query) or die($con->error);
        $data = array();
        while($row = $client->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    }
?>