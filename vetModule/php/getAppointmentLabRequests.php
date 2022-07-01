<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $appointmentId = $_GET['appointment_id'];
        $query = "SELECT * FROM lab_requests WHERE appointment_id = '$appointmentId'";
        $appointment = $con->query($query) or die($con->error);
        $data = array();
        while($row = $appointment->fetch_assoc()){
            $data[] = $row;
        }
        $response = array();
        foreach($data as $dataItem){
            $request = $dataItem['lab_request'];
            $labRequestId = $dataItem['id'];
            //fetch result from request
            $query = "SELECT * FROM lab_results WHERE lab_request_id = '$labRequestId'";

            $labResult = $con->query($query) or die($con->error);
            $labResultRow = $labResult->fetch_assoc();

            if($labResultRow == null){
                $labResult = "";
            }else{
                $labResult = $labResultRow['result'];
            }

            $result[] = array(
                'lab_request' => $request,
                'lab_result' => $labResult
            );
        }

        echo json_encode($result);
    }
?>