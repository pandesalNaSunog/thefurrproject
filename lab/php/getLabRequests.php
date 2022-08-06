<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        $query = "SELECT * FROM lab_requests";
        $labRequest = $con->query($query) or die($con->error);
        while($labRequestRow = $labRequest->fetch_assoc()){
            $petId = $labRequestRow['pet_id'];

            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $petName = $petRow['name'];
            if($labRequest['has_result'] == 'No'){
                $result = "pending";
            }else{
                $result = "has result";
            }
            $response[] = array(
                'id' => $labRequestRow['id'],
                'patient_name' => $petName,
                'request' => $labRequestRow['request'],
                'result' => $result,
            );

            
        }
        echo json_encode($response);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>