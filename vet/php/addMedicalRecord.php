<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        $date = date('Y-m-d');
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
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


            $remarks = htmlspecialchars($_POST['remarks']);
            $service = htmlspecialchars($_POST['service']);


            $query = $con->prepare("INSERT INTO medical_records(user_id,doctor_id,pet_id,pet_weight,temp,hr,rr,tests,`procedure`,medication,case_closed,created_at,updated_at,vet_nurse)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $query->bind_param("iiisssssssssss", $clientId, $doctorId, $petId, $weight, $temp, $hr, $rr, $temp, $procedures,$medication, $caseClosed, $today, $today,$vetNurse);
            $query->execute();

            $newquery = $con->prepare("INSERT INTO wellness_records(pet_id,doctor_id,`service`,remarks,`date`,next_appointment,created_at,updated_at,pet_weight)VALUES(?,?,?,?,?,?,?,?,?)");
            $newquery->bind_param("iisssssss", $petId, $doctorId, $service, $remarks, $date, $nexAppointment,$today, $today, $weight);
            $newquery->execute();

            echo 'ok';
            
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>