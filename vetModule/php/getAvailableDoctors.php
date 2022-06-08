<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(isset($_POST)){
        $appointmentId = $_POST['appointment_id'];

        $query = "SELECT * FROM appointments WHERE id = '$appointmentId'";
        $appointment = $con->query($query) or die($con->error);
        $row = $appointment->fetch_assoc();

        $date = $row['date'];
        $time = $row['time'];
        $doctorId = $row['doctor_id'];

        //fetch other doctors

        $query = "SELECT * FROM doctors WHERE id != '$doctorId'";
        $doctor = $con->query($query) or die($con->error);
        $data = array();
        while($row = $doctor->fetch_assoc()){
            $data[] = $row;
        }


        $availableDoctors = array();

        //check each doctor if they have an appointment during that date and time
        foreach($data as $dataItem){
            $thisDoctorId = $dataItem['id'];

            $query = "SELECT * FROM appointments WHERE doctor_id = '$thisDoctorId' AND date = '$date' AND time = '$time'";
            $appointment = $con->query($query) or die($con->error);
            $data = array();
            while($row = $appointment->fetch_assoc()){
                $data[] = $row;
            }

            //if not, list him as available
            if(count($data) == 0){
                $availableDoctors[] = array(
                    'doctor_id' => $dataItem['id'],
                    'name' => $dataItem['name'],
                    'appointment_id' => $appointmentId
                );
            }
        }

        echo json_encode($availableDoctors);
    }
?>