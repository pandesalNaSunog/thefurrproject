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
            $dose = htmlspecialchars($_POST['dose']);

            $query = "INSERT INTO treatment_plans(`dose`,`drug`,`route`,`frequency`,`time`,`confinement_id`,`created_at`,`updated_at`)VALUES('$dose','$drug','$route','$frequency','$time','$confinementId','$today','$today')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM treatment_plans WHERE id = LAST_INSERT_ID()";
            $treatment = $con->query($query) or die($con->error);
            $treatmentRow = $treatment->fetch_assoc();
            $response = array(
                'id' => $treatmentRow['id'],
                'drug' => $treatmentRow['drug'],
                'route' => $treatmentRow['route'],
                'frequency' => $treatmentRow['frequency'],
                'time' => $treatmentRow['time'],
                'dose' => $treatmentRow['dose'],
                'date' => humanReadableDate($treatmentRow['created_at'])
            );

            echo json_encode($response);
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>