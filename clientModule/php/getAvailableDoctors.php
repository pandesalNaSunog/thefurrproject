<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $time = $_POST['time'];
        $date = $_POST['date'];
        //check if there are doctors appointed on that date and time
        $query = "SELECT doctor_id FROM appointments WHERE date = '$date' AND time = '$time'";
        $doctorId = $con->query($query) or die($con->error);
        $ids = array();
        while($row = $doctorId->fetch_assoc()){
            $ids[] = $row;
        }
        //if there's not, return all names
        if(count($ids) == 0){
            $query = "SELECT name FROM doctors";
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
            foreach($ids as $id){

                $thisId = $id['doctor_id'];
                $query = "SELECT name FROM doctors WHERE id != '$thisId'";
                $doctor = $con->query($query) or die($con->error);
                while($row = $doctor->fetch_assoc()){
                    $response[] = $row;
                }
            }
            echo json_encode($response);
        }
    }
?>