<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $id = $_POST['id'];
            $service = htmlspecialchars($_POST['service']);
            $petWeight = htmlspecialchars($_POST['pet_weight']);
            $remarks = htmlspecialchars($_POST['remarks']);
            $nextAppointment = htmlspecialchars($_POST['next_appointment']);
            $nextService = htmlspecialchars($_POST['next_service']);
            if($nextAppointment == ""){
                $query = "SELECT next_appointment FROM wellness_records WHERE id = '$id'";
                $nextAppointmentQuery = $con->query($query) or die($con->error);
                $nextAppointmentRow = $nextAppointmentQuery->fetch_assoc();
                $nextAppointment = $nextAppointmentRow['next_appointment'];
            }

            $query = "UPDATE wellness_records SET next_service = '$nextService', service = '$service', pet_weight = '$petWeight', remarks = '$remarks', next_appointment = '$nextAppointment' WHERE id = '$id'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>