<?php
    date_default_timezone_set('Asia/Manila');
    include('connection.php');
    $con = connect();
    $createdAt = date('Y-m-d H:i:s');
    $todaysDate = date('Y-m-d');
    if(isset($_POST)){
        $clientId = $_POST['client_id'];
        $doctorId = $_POST['doctor_id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $concern = $_POST['concern'];


        $postedDate = date_create($date);
        $todayDateObject = date_create($todaysDate);
        $dateDiff = date_diff($postedDate, $todayDateObject);
        $diffresult = $dateDiff->format('%R');
        if($diffresult == "-"){
            echo 'invalid date';
        }else{
            $query = "INSERT INTO appointments(`status`,`client_id`,`doctor_id`,`date`,`time`,`concern`,`created_at`,`updated_at`)VALUES('Booked','$clientId','$doctorId','$date','$time','$concern','$createdAt','$createdAt')";
            $con->query($query) or die($con->error);
            
    
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();
    
            $clientName = $userRow['name'];
    
            $query = "SELECT * FROM doctors WHERE id = '$doctorId'";
            $appointment = $con->query($query) or die($con->error);
            $row = $appointment->fetch_assoc();
    
            echo json_encode(array('appointment' => $row, 'client_name' => $clientName));
        }
    }
?>