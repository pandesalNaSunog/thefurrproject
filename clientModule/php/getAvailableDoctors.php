<?php
    include('connection.php');
    $con = connect();

    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_POST)){
        $time = $_POST['time'];
        $date = $_POST['date'];
        $clientId = $_SESSION['client_id'];
        //check if client has already booked that schedule
        $query = "SELECT * FROM appointments WHERE date = '$date' AND time = '$time' AND client_id = '$clientId'";
        $appointment = $con->query($query) or die($con->error);
        $data = array();
        while($row = $appointment->fetch_assoc()){
            $data[] = $row;
        }
        if(count($data) >= 1){
            echo 'already booked by client';
        }else{
            //check if there are doctors appointed on that date and time
            $query = "SELECT doctor_id FROM appointments WHERE date = '$date' AND time = '$time'";
            $doctorId = $con->query($query) or die($con->error);
            $ids = array();
            while($row = $doctorId->fetch_assoc()){
                $ids[] = $row;
            }
            //if there's not, return all names
            if(count($ids) == 0){
                $query = "SELECT name, id FROM doctors";
                $doctor = $con->query($query) or die($con->error);
                $data = array();
                while($row = $doctor->fetch_assoc()){
                    $data[] = $row;
                }
                echo json_encode($data);
            }
            //otherwise, return all doctor names not appointed
            else{
                $response = array();
                $query = "SELECT name, id FROM doctors WHERE ";
                foreach($ids as $id){
                    $thisId = $id['doctor_id'];
                    $query .= "id != '$thisId' AND ";
                    
                }
                $query = substr($query, 0, -5);
                $doctor = $con->query($query) or die($con->error);
                while($row = $doctor->fetch_assoc()){
                    $response[] = $row;
                }
                echo json_encode($response);
            }
        }
    }
?>