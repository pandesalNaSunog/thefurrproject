<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_GET) && isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];

            $query = "SELECT * FROM users WHERE id = '$doctorId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();

            echo json_encode(array(
                'profile_name' => $userRow['name']
            ));
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>