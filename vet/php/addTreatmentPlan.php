<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        session_start();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $drug = htmlspecialchars($_POST['drug']);
            $route = htmlspecialchars($_POST['route']);
            $frequency = htmlspecialchars($_POST['frequency']);
            $time = htmlspecialchars($_POST['time']);
            $confinementId = htmlspecialchars($_POST['confinement_id']);

            $query = "INSERT INTO treatment_plans(`drug`,`route`,`frequency`,`time`,`confinement_id`,`created_at`,`updated_at`)VALUES('$drug','$route','$frequency','$time','$confinementId','$today','$today')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM treatment_plans WHERE id = LAST_INSERT_ID()";
            $treatment = $con->query($query) or die($con->error);
            $treatmentRow = $treatment->fetch_assoc();
            echo json_encode($treatmentRow);
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>