<?php
    include('connection.php');
    $con = connect();
    session_start();
    $today = getCurrentDate();
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        if(isset($_SESSION['doctor_id']) && isset($_POST)){
            $confinementId = $_POST['confinement_id'];
            $doctorId = $_SESSION['doctor_id'];
            $soaNumber = generateSoaNumber($doctorId);
            $query = "INSERT INTO confinement_soas(`confinement_id`,`soa_number`,`created_at`,`updated_at`)VALUES('$confinementId','$soaNumber','$today','$today')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM confinement_soas WHERE id = LAST_INSERT_ID()";
            $confinementSoa = $con->query($query) or die($con->error);
            $confinementSoaRow = $confinementSoa->fetch_assoc();
            $confinementSoaId = $confinementSoaRow['id'];

            $soaNumber .= $confinementId;

            $query = "UPDATE confinement_soas SET soa_number = '$soaNumber' WHERE id = '$confinementSoaId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function generateSoaNumber($doctorId){
        $initial = "";
        if($doctorId == 1){
            $initial = "Z-00";
        }else if($doctorId == 2){
            $initial = "H-00";
        }else if($doctorId == 3){
            $initial = "ZX-00";
        }else if($doctorId == 4){
            $initial = "ZH-00";
        }
        return $initial;
    }
?>