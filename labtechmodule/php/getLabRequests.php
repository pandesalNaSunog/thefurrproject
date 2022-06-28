<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT * FROM lab_requests ORDER BY created_at ASC";
        $labRequest = $con->query($query) or die($con->error);
        $data = array();
        while($row = $labRequest->fetch_assoc()){
            $data[] = $row;
        }

        $newData = array();
        foreach($data as $dataItem){
            $petId = $dataItem['pet_id'];
            $query = "SELECT * FROM patient_details WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $labRequestId = $dataItem['id'];
            $query = "SELECT * FROM lab_results WHERE lab_request_id = '$labRequestId'";
            $labResult = $con->query($query) or die($con->error);
            $labResultRow = $labResult->fetch_assoc();

            if($labResultRow == null){
                $labResultRow['result'] = "";
            }
            $newData[] = array(
                'name' => $petRow['pet_name'],
                'request' => $dataItem['lab_request'],
                'request_id' => $labRequestId,
                'result' => 'php/'.$labResultRow['result']
            );
        }

        echo json_encode($newData);
    }
?>