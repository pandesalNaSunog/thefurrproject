<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $clientId = $_POST['client_id'];
        $doctorId = $_POST['doctor_id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $concern = $_POST['concern'];

        $query = "INSERT INTO appointments(`client_id`,`doctor_id`,`date`,`time`,`concern`)VALUES('$clientId','$doctorId','$date','$time','$concern')";
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
?>