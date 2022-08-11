<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();

        if(isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            $query = "SELECT * FROM rendered_services WHERE doctor_id = '$doctorId'";
            $service = $con->query($query) or die($con->error);
            $services = array();
            while($serviceRow = $service->fetch_assoc()){
                $services[] = $serviceRow;
            }
            echo json_encode($services);
        }

    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>