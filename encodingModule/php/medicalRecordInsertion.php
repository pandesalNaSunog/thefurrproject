<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $patientName = $_POST['patient_name'];
        $clientCode = $_POST['client_code'];
        $createdDate = $_POST['created_date'];
        $medicalHistory = $_POST['medical_history'];
        $contactNumber = $_POST['contact_number'];
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

        $query = "SELECT * FROM users where name = '$patientName' AND client_code = '$clientCode'";
        $user = $con->query($query) or die($con->error);
        $data = array();
        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }

        $type = "";
        //if doesn't exist, Insert new to users
        if(count($data) == 0){
            $type = "new";
            //generate random email
            do{
                $email = uniqid()."@gmail.com";
                $password = password_hash("password",PASSWORD_DEFAULT);
                $query = "SELECT * FROM users WHERE email = '$email'";
                $user = $con->query($query) or die($con->error);
                $data = array();
                while($row = $user->fetch_assoc()){
                    $data[] = $row;
                }
            }while(count($data) > 0);
            $query = "INSERT INTO users (`name`,`email`,`client_code`,`password`) VALUES('$patientName','$email','$clientCode','$password')";
            $con->query($query) or die($con->error);
        }else{
            $type = "returnee";
        }
        $query = "INSERT INTO medical_records
                    (`type`,`date`,`patient_name`,`contact_no`,`client_code`,`medical_history`,
                    `wellness_behavior`,`date_of_birth`,`species`,`sex`,`breed`,`weight`,`temp`,
                    `hr`,`rr`,`physical_exam`,`cc_hx`,`dx_tools`,`tdx_dx_case`,`treatment`,`in_patient`,
                    `surgery`,`out_patient`,`take_home_meds_rx`) 
                    VALUES('$type','$createdDate','$patientName','$contactNumber','$clientCode',
                    '$medicalHistory','$wellnessBehavior','$birthDate','$species','$sex','$breed',
                    '$weight','$temp','$hr','$rr','$physicalExam','$cchx','$dxTools','$tdxDxCase',
                    '$treatment','$inPatient','$surgery','$outPatient','$takeHomeMeds')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM medical_records WHERE id = LAST_INSERT_ID()";
        $medicalRecord = $con->query($query) or die($con->error);
        $row = $medicalRecord->fetch_assoc();

        echo json_encode($row);
    }
?>