<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];
            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pet = $con->query($query) or die($con->error);
            $pets = array();
            while($petRow = $pet->fetch_assoc()){
                $pets[] = $petRow;
            }
            echo json_encode($pets);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>