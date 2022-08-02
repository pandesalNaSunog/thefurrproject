<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $query = $con->prepare("INSERT INTO initial_checkups(client_id,medical_history,wellness_behavior,pet_id,pet_weight,temp,hr,rr,physical_exam,cc_hx,dx_tools,tdx_dx_case,treatment,in_patient,surgery,out_patient,take_home_meds,created_at,updated_at)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $petId = $_POST['pet_id'];
            $clientId = $_POST['client_id'];
            $wellnessBehavior = htmlspecialchars($_POST['wellness_behavior']);
            $medicalHistory = htmlspecialchars($_POST['medical_history']);
            $weight = htmlspecialchars($_POST['weight']);
            $temp = htmlspecialchars($_POST['temp']);
            $hr = htmlspecialchars($_POST['hr']);
            $rr = htmlspecialchars($_POST['rr']);
            $physicalExam = htmlspecialchars($_POST['physical_exam']);
            $ccHx = htmlspecialchars($_POST['cc_hx']);
            $dxTools = htmlspecialchars($_POST['dx_tools']);
            $tdx = htmlspecialchars($_POST['tdx_dx_case']);
            $treatement = htmlspecialchars($_POST['treatment']);
            $inPatient = htmlspecialchars($_POST['in_patient']);
            $surgery = htmlspecialchars($_POST['surgery']);
            $outPatient = htmlspecialchars($_POST['out_patient']);
            $takeHomeMeds = htmlspecialchars($_POST['take_home_meds']);

            $query->bind_param("ississsssssssssssss", $clientId, $medicalHistory, $wellnessBehavior, $petId, $weight, $temp, $hr, $rr, $physicalExam, $ccHx, $dxTools, $tdx, $treatement, $inPatient, $surgery, $outPatient, $takeHomeMeds, $today, $today);
            $query->execute();

            $query = "SELECT * FROM initial_checkups WHERE id = LAST_INSERT_ID()";
            $checkup = $con->query($query) or die($con->error);
            $checkupRow = $checkup->fetch_assoc();


            
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $client = $con->query($query) or die($con->error);
            $clientRow = $client->fetch_assoc();
            $name = $clientRow['name'];
            $contact = $clientRow['contact_no'];
            $clientCode = $clientRow['client_code'];


            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();

            $response = array(
                'patient_name' => $name,
                'contact' => $contact,
                'client_code' => $clientCode,
                'medical_history' => $checkupRow['medical_history'],
                'wellness_behavior' => $checkupRow['wellness_behavior'],
                'date_of_birth' => date_format(date_create($petRow['birth_date']), "M d, Y"),
                'species' => $petRow['species'],
                'breed' => $petRow['breed'],
                'sex' => $petRow['sex'],
                'weight' => $checkupRow['pet_weight'],
                'temp' => $checkupRow['temp'],
                'hr' => $checkupRow['hr'],
                'rr' => $checkupRow['rr'],
                'physical_exam' => $checkupRow['physical_exam'],
                'dx_tools' => $checkupRow['dx_tools'],
                'tdx_dx_case' => $checkupRow['tdx_dx_case'],
                'treatment' => $checkupRow['treatment'],
                'in_patient' => $checkupRow['in_patient'],
                'surgery' => $checkupRow['surgery'],
                'out_patient' => $checkupRow['out_patient'],
                'take_home_meds' => $checkupRow['take_home_meds'],
            );
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>