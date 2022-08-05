<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $clientId = $_POST['client_id'];
            $petId = $_POST['pet_id'];
            $weight = htmlspecialchars($_POST['weight']);
            $temp = htmlspecialchars($_POST['temp']);
            $hr = htmlspecialchars($_POST['hr']);
            $rr = htmlspecialchars($_POST['rr']);
            $tests = htmlspecialchars($_POST['tests']);
            $procedures = htmlspecialchars($_POST['procedures']);
            $medication = htmlspecialchars($_POST['medication']);
            $caseClosed = $_POST['case_closed'];
            $nexAppointment = $_POST['next_appointment'];
            $vetNurse = $_POST['vet_nurse'];

            $query = $con->prepare("INSERT INTO medical_records(user_id,pet_id,pet_weight,temp,hr,rr,tests,`procedure`,medication,case_closed,created_at,updated_at)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $query->bind_param("iissssssssss", $clientId, $petId, $weight, $temp, $hr, $rr, $temp, $procedures,$medication, $caseClosed, $today, $today);
            $query->execute();

            echo 'ok';
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>