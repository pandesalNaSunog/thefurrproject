<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $query = "SELECT * FROM services ORDER BY category ASC";
        $service = $con->query($query) or die($con->error);
        $services = array();
        while($serviceRow = $service->fetch_assoc()){
            $services[] = $serviceRow;
        }
        echo json_encode($services);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>