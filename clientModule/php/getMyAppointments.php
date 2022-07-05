<?php
    date_default_timezone_set('Asia/Manila');
    $date = date('Y-m-d');
    if(!isset($_SESSION)){
        session_start();
    }
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $id = $_SESSION['client_id'];

        $query = "SELECT users.*, appointments.* FROM appointments JOIN users ON appointments.client_id = users.id WHERE appointments.client_id = '$id'";
        $appointments = $con->query($query) or die($con->error);
        $data = array();
        while($row = $appointments->fetch_assoc()){
            $data[] = $row;
        }
        $response = array();
        foreach($data as $dataItem){
            $today = date_create($date);
            $bookedDate = date_create($dataItem['date']);
            if($dataItem['date'] == $date){
                $isToday = true;
            }else{
                $isToday = false;
            }
            $dateDifference = date_diff($today,$bookedDate);
            $dateDiffResult = $dateDifference->format("%R");

            if($dateDiffResult == "+"){
                $status = "Booked";
            }else{
                $status = "Did Not Arrive";
            }
            $appointmentId = $dataItem['id'];
            $query = "UPDATE appointments SET status = '$status' WHERE id = '$appointmentId'";
            $con->query($query) or die($con->error);

            $formattedDate = date_format(date_create($dataItem['date']), 'M d, Y');

            $doctorId = $dataItem['doctor_id'];
            $query = "SELECT * FROM doctors WHERE id = '$doctorId'";
            $doctor = $con->query($query) or die($con->error);
            $row = $doctor->fetch_assoc();
            $response[] = array('is_today' => $isToday, 'id' => $dataItem['id'], 'status' => $status, 'name' => $dataItem['name'], 'concern' => $dataItem['concern'], 'vet' => $row['name'], 'date' => $formattedDate, 'time' => $dataItem['time']);
        }
        echo json_encode($response);
    }
?>