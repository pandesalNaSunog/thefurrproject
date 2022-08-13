<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');

        include('connection.php');
        $con = connect();

        $query = "SELECT * FROM appointments WHERE created_at LIKE '%$today%'";

        $appointment = $con->query($query) or die($con->error);
        $appointments = array();

        while($appointmentRow = $appointment->fetch_assoc()){
            $appointments[] = $appointmentRow;
        }

        echo json_encode($appointments);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>