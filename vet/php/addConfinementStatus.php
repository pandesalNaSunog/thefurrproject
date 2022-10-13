<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $status = htmlspecialchars($_POST['status']);
            $confinementId = $_POST['confinement_id'];


            $query = "INSERT INTO confinement_records(`confinement_id`,`status`,`created_at`,`updated_at`)VALUES('$confinementId','$status','$today','$today')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM confinement_records WHERE id = LAST_INSERT_ID()";
            $record = $con->query($query) or die($con->error);
            $recordRow = $record->fetch_assoc();

            $status = array(
                'status' => $recordRow['status'],
                'date' => date_format(date_create($recordRow['created_at']), "M d, Y")
            );
            echo json_encode($status);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>