<?php

    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $name = $_POST['name'];
        $price = $_POST['price'];

        $query = "SELECT * FROM lab_services WHERE name = '$name' AND price = '$price'";
        $service = $con->query($query) or die($con->error);
        $data = array();
        while($row = $service->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) >= 1){
            echo 'exists';
        }else{
            $query = "INSERT INTO lab_services(`name`,`price`)VALUES('$name','$price')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM lab_services WHERE id = LAST_INSERT_ID()";
            $labService = $con->query($query) or die($con->error);
            $row = $labService->fetch_assoc();
            echo json_encode($row);
        }
    }
?>