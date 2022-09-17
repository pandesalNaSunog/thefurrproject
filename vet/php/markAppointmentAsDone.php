<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $appointmentId = $_POST['appointment_id'];
            $isDone = $_POST['is_done'];

            $query = "UPDATE appointments SET is_done = '$isDone' WHERE id = '$appointmentId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>