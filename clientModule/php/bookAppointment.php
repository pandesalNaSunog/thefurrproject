<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();

        if(isset($_POST) && isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];
            $doctorId = $_POST['doctor_id'];
            $concern = htmlspecialchars($_POST['concern']);
            $date = $_POST['date'];
            $time = $_POST['time'];
            $petIds = $_POST['pet_ids'];
            $status = "Pending";
            $petIdString = "";
            foreach($petIds as $key => $petId){
                if($key == 0){
                    $petIdString .= $petId;
                }else{
                    $petIdString .= "**".$petId;
                }
            }

            $query = $con->prepare("INSERT INTO appointments(user_id,doctor_id,concern,date,time,arrival_status,pet_ids,created_at,updated_at)VALUES(?,?,?,?,?,?,?,?,?)");
            $query->bind_param("iisssssss", $clientId, $doctorId, $concern, $date, $time, $status, $petIdString, $today, $today);
            $query->execute();

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>