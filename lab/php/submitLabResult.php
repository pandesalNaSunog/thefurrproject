<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_FILES) && isset($_SESSION['lab_tech_id'])){
            $labRequestId = $_POST['lab_request_id'];
            $labTechId = $_SESSION['lab_tech_id'];
            $result = $_FILES['result']['name'];
            $tmpName = $_FILES['result']['tmp_name'];
            $filExtension = strtolower(pathinfo($result, PATHINFO_EXTENSION));

            $allowedExtensions = array("jpg","jpeg","png");

            if(in_array($filExtension, $allowedExtensions)){
                $filepath = "images/".uniqid().".".$filExtension;
                move_uploaded_file($tmpName, $filepath);
                $query = "INSERT INTO lab_results(`lab_request_id`,`result`,`created_at`,`updated_at`)VALUES('$labRequestId','$filepath','$today','$today')";
                $con->query($query) or die($con->error);
                $query = "UPDATE lab_requests SET has_result = 'Yes', lab_tech_id = $labTechId WHERE id = '$labRequestId'";
                $con->query($query) or die($con->error);
                $query = "SELECT * FROM lab_results WHERE id = LAST_INSERT_ID()";
                $labResultQuery = $con->query($query) or die($con->error);
                $labResultRow = $labResultQuery->fetch_assoc();
                echo json_encode($labResultRow);
            }else{
                echo 'invalid file';
            }
            
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>