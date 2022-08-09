<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $service = htmlspecialchars($_POST['service']);
            $category = htmlspecialchars($_POST['category']);

            $query = "INSERT INTO services(`service`,`category`,`created_at`,`updated_at`)VALUES('$service','$category','$today','$today')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM services WHERE id = LAST_INSERT_ID()";
            $service = $con->query($query) or die($con->error);
            $serviceRow = $service->fetch_assoc();

            echo json_encode($serviceRow);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>