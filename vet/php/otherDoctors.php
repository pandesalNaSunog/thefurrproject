<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();

        if(isset($_SESSION['doctor_id'])){
            include('connection.php');
            $con = connect();
            $doctorId = $_SESSION['doctor_id'];
            $query = "SELECT * FROM users WHERE id != '$doctorId' AND user_type = 'doctor'";
            $doctor = $con->query($query) or die($con->error);
            $doctors = array();
            while($doctorRow = $doctor->fetch_assoc()){
                $doctors[] = array(
                    'id' => $doctorRow['id'],
                    'name' => $doctorRow['name']
                );
            }

            echo json_encode($doctors);
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>