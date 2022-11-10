<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        session_start();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $prognosis = htmlspecialchars($_POST['prognosis']);
            $confinementId = htmlspecialchars($_POST['confinement_id']);
            $query = "INSERT INTO prognoses(`prognosis`,`confinement_id`,`created_at`,`updated_at`)VALUES('$prognosis','$confinementId','$today','$today')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM prognoses WHERE id = LAST_INSERT_ID()";
            $prognosisQuery = $con->query($query) or die($con->error);
            $prognosisRow = $prognosisQuery->fetch_assoc();

            $response = array(
                'id' => $prognosisRow['id'],
                'prognosis' => $prognosisRow['prognosis'],
                'date' => date_format(date_create($prognosisRow['created_at']), "M d, Y h:i A")
            );

            echo json_encode($response);
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>