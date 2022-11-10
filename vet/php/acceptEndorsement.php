<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            $endorsementId = $_POST['id'];
            $query = "SELECT * FROM confinement_endorsements WHERE id = '$endorsementId'";
            $endorsement = $con->query($query) or die($con->error);
            $endorsementRow = $endorsement->fetch_assoc();

            $confinementId = $endorsementRow['confinement_id'];

            $query = "UPDATE confinements SET doctor_id = '$doctorId' WHERE id = '$confinementId'";
            $con->query($query) or die($con->error);

            $query = "DELETE FROM confinement_endorsements WHERE id = '$endorsementId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>