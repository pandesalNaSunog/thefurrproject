<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_POST) && isset($_SESSION['client_id'])){
            $time = $_POST['time'];
            $date = $_POST['date'];

            $query = "SELECT * FROM appointments WHERE time = '$time' AND date = '$date'";
            $appointment = $con->query($query) or die($con->error);
            $doctors = array();
            if($appointmentRow = $appointment->fetch_assoc()){
                $doctorId = $appointmentRow['doctor_id'];
                $query = "SELECT * FROM users WHERE user_type = 'doctor' AND id != '$doctorId'";
            }else{
                $query = "SELECT * FROM users WHERE user_type = 'doctor'";
            }

            $doctor = $con->query($query) or die($con->error);

            while($doctorRow = $doctor->fetch_assoc()){
                $doctors[] = array(
                    'id' => $doctorRow['id'],
                    'doctor' => $doctorRow['name']
                );
            }

            echo json_encode($doctors);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>