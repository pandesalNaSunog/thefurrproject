<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        session_start();
        $con = connect();
        $today = getCurrentDate();

        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $endorserId = $_SESSION['doctor_id'];
            $doctorId = $_POST['doctor_id'];
            $confinementId = $_POST['confinement_id'];

            $query = "SELECT * FROM confinement_endorsements WHERE confinement_id = '$confinementId'";
            $endorsementQuery = $con->query($query) or die($con->error);
            if($endorsementRow = $endorsementQuery->fetch_assoc()){
                $query = "DELETE FROM confinement_endorsements WHERE confinement_id = '$confinementId'";
                $con->query($query) or die($con->error); 
            }
            $query = "INSERT INTO confinement_endorsements(`endorser_id`,`confinement_id`,`doctor_id`,`created_at`,`updated_at`)VALUES('$endorserId','$confinementId','$doctorId','$today','$today')";
            $con->query($query) or die($con->error);
            echo 'ok';
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>