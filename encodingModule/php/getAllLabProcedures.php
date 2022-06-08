<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT * FROM lab_services";
        $labService = $con->query($query) or die($con->error);
        $data = array();
        while($row = $labService->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
    }
?>