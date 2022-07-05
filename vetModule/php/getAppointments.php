<?php
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d');
    if(!isset($_SESSION)){
        session_start();
    }
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_GET)){
        $doctorId = $_SESSION['doctor_id'];
        $query = "SELECT * FROM appointments WHERE doctor_id = '$doctorId'";
        $appointment = $con->query($query) or die($con->error);
        $data = array();

        while($row = $appointment->fetch_assoc()){
            $data[] = $row;
        }

        $response = array();
        foreach($data as $dataItem){

            $todayDateObject = date_create($today);
            $bookedDate = date_create($dataItem['date']);
            $dateDiff = date_diff($todayDateObject,$bookedDate);
            $dateDiffResult = $dateDiff->format('%R');

            if($dateDiffResult == "+"){
                $status = "Booked";
            }else{
                $status = "Did Not Arrive";
            }
            $appointmentId = $dataItem['id'];
            $query = "UPDATE appointments SET status = '$status' WHERE id = '$appointmentId'";
            $con->query($query) or die($con->error);
            $clientId = $dataItem['client_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $row = $user->fetch_assoc();
            $appointmentId = $dataItem['id'];
            $query = "SELECT * FROM patient_details WHERE appointment_id = '$appointmentId'";
            $patient = $con->query($query) or die($con->error);
            $showView = false;
            if($patientrow = $patient->fetch_assoc()){
                $showView = true;
            }else{
                $showView = false;
            }
            $response[] = array('show_view' => $showView, 'appointment' => $dataItem, 'client_name' => $row['name'], 'client_id' => $row['id']);
        }
        echo json_encode($response);
    }
?>