<?php
    session_start();
    $labId = $_SESSION['lab_tech_id'];
    include('connection.php');
    $con = connect();
    $date = getCurrentDate();

    if(isset($_FILES) && isset($_POST)){
        $labRequestId = $_POST['lab_request_id'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if($fileExtension == "jpg" || $fileExtension == 'jpeg' || $fileExtension == 'png'){
            move_uploaded_file($_FILES['image']['tmp_name'],$target_file);
            
            $query = "SELECT * FROM lab_results WHERE lab_request_id = '$labRequestId'";
            $labRequest = $con->query($query) or die($con_error);
            $row = $labRequest->fetch_assoc();

            if($row == null){
                $query = "INSERT INTO lab_results(`pet_id`,`lab_tech_id`,`lab_request_id`,`result`,`created_at`,`updated_at`)VALUES('$labId','$labRequestId','$target_file','$date','$date')";
            }else{
                $labResultId = $row['id'];
                $query = "UPDATE lab_results SET result = '$target_file' WHERE id = '$labResultId'";
            }
            $con->query($query) or die($con->error);
            $query = "UPDATE lab_requests SET has_result = 'yes' WHERE id = '$labRequestId'";
            $con->query($query) or die($con->error);
            echo 'php/'.$target_file;
        }else{
            echo 'invalid';
        }
    }
?>