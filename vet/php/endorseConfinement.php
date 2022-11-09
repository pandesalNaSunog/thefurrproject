<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        session_start();
        $con = connect();


        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $doctorId = $_POST['doctor_id'];
            $confinementId = $_POST['confinement_id'];
            $query = "UPDATE confinements SET doctor_id = '$doctorId' WHERE id = '$confinementId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>