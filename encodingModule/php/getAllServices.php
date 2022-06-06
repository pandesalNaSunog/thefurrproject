<?php
    include('connection.php');
    $con = connect();


    if(isset($_GET)){
        $query = "SELECT * FROM services";
        $service = $con->query($query) or die($con->error);
        $data = array();
        while($row = $service->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    }
?>