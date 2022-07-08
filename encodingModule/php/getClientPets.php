<?php
    include('connection.php');
    $con = connect();


    if(isset($_GET)){
        $appointmentId = $_GET['appointment_id'];
        $query = "SELECT * FROM pet_age_and_sex WHERE appointment_id = '$appointmentId'";
        $pet = $con->query($query) or die($con->error);
        $data = array();
        while($row = $pet->fetch_assoc()){
            $data[] = $row;
        }
        $response = array();
        foreach($data as $dataItem){
            $petId = $dataItem['pet_id'];
            $query = "SELECT * FROM patient_details WHERE pet_id = '$petId'";
            $patient = $con->query($query) or die($con->error);
            $patientRow = $patient->fetch_assoc();
            $name = $patientRow['pet_name'];
            $breed = $patientRow['breed'];
            $species = $patientRow['species'];
            $sex = $patientRow['sex'];
            $weight = $dataItem['weight'];
            $age = $dataItem['age'];

            $response[] = array(
                'name' => $name,
                'breed' => $breed,
                'species' => $species,
                'sex' => $sex,
                'weight' => $weight,
                'age' => $age
            );
        }

        echo json_encode($response);
    }
?>