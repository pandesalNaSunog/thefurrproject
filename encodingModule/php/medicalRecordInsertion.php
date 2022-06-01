<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $patientName = $_POST['patient_name'];
        $clientCode = $_POST['client_code'];
        $createdDate = $_POST['created_date'];
        $medicalHistory = $_POST['medical_history'];
        $wellnessBehavior = $_POST['wellness_behavior'];
        $birthDate = $_POST['birth_date'];
        $species = $_POST['species'];
        $breed = $_POST['breed'];
        $sex = $_POST['sex'];
        $weight = $_POST['weight'];
        $temp = $_POST['temp'];
        $hr = $_POST['hr'];
        $rr = $_POST['rr'];
        $physicalExam = $_POST['physical_exam'];
        $cchx = $_POST['cc_hx'];
        $tdxDxCase = $_POST['tdx_dx_case'];
        $dxTools = $_POST['dx_tools'];
        $treatment = $_POST['treatment'];
        $inPatient = $_POST['in_patient'];
        $surgery = $_POST['surgery'];
        $outPatient = $_POST['out_patient'];
        $takeHomeMeds = $_POST['take_home_meds'];

        //check if patient is already available at users

        $query = "SELECT * FROM users where client_code = '$clientCode'";
        $user = $con->query($query) or die($con->error);
        $data = array();
        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }

        $type = "";
        //if doesn't exist
        if(count($data) == 0){
            echo 'create client record first';
        }else{
            $clientId = $data[0]['id'];
            $query = "INSERT INTO medical_records
                    (`patient_name`,`client_id`,`date`,`medical_history`,
                    `wellness_behavior`,`date_of_birth`,`species`,`sex`,`breed`,`weight`,`temp`,
                    `hr`,`rr`,`physical_exam`,`cc_hx`,`dx_tools`,`tdx_dx_case`,`treatment`,`in_patient`,
                    `surgery`,`out_patient`,`take_home_meds_rx`)
                    VALUES('$patientName','$clientId','$createdDate','$medicalHistory','$wellnessBehavior','$birthDate',
                    '$species','$sex','$breed',
                    '$weight','$temp','$hr','$rr','$physicalExam','$cchx','$dxTools','$tdxDxCase',
                    '$treatment','$inPatient','$surgery','$outPatient','$takeHomeMeds')";
            $con->query($query) or die($con->error);
            $query = "SELECT users.*, medical_records.* FROM medical_records JOIN users ON medical_records.client_id = users.id WHERE medical_records.id = LAST_INSERT_ID()";
            $medicalRecord = $con->query($query) or die($con->error);
            $row = $medicalRecord->fetch_assoc();
            echo json_encode($row);
        }
    }
?>