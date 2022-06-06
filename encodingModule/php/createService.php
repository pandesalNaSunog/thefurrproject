<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $inputService = $_POST['service'];
        $price = $_POST['price'];


        $query = "SELECT * FROM services WHERE service = '$inputService'";
        $service = $con->query($query) or die($con->error);
        $data = array();
        while($row = $service->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) == 1){
            echo 'service exists';
        }else{
            $query = "INSERT INTO services(`service`,`price`)VALUES('$inputService','$price')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM services WHERE id = LAST_INSERT_ID()";
            $service = $con->query($query) or die($con->error);
            $data = $service->fetch_assoc();

            echo json_encode($data);
        }
    }
?>