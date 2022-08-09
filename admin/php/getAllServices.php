<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $query = "SELECT * FROM services";
        $service = $con->query($query) or die($con->error);
        $services = array();
        while($servicesRow = $service->fetch_assoc()){
            $services[] = $servicesRow;
        }
        echo json_encode($services);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>