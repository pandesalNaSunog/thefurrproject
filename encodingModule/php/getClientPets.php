<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST['client_id'])){
            $clientId = htmlspecialchars($_POST['client_id']);
            $pets = array();
            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pet = $con->query($query) or die($con->error);
            while($row = $pet->fetch_assoc()){
                $pets[] = $row;
            }
            echo json_encode($pets);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>