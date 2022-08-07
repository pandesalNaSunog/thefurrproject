<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $today = getCurrentDate();
        $con = connect();
        if(isset($_SESSION['client_id'])){
            $date = $_POST['date'];
            $clientId = $_SESSION['client_id'];
            $todayObject = date_create($today);
            $postedDate = date_create($date);
            $dateDiff = date_diff($postedDate, $todayObject);

            $dateDiffResult = $dateDiff->format("%R");
            if($dateDiffResult == '+'){
                echo 0;
            }else{
                $timeSchedules = array(
                    "10:00 a.m. - 10:45 a.m",
                    "10:45 a.m. - 11:30 a.m",
                    "11:30 a.m. - 12:15 p.m",
                    "12:15 p.m. - 1:00 p.m",
                    "1:00 p.m. - 1:45 p.m",
                    "1:45 p.m. - 2:30 p.m",
                    "2:30 p.m. - 3:15 p.m",
                    "3:15 p.m. - 4:00 p.m",
                    "4:00 p.m. - 4:45 p.m",
                    "4:45 p.m. - 5:30 p.m",
                    "5:30 p.m. - 6:15 p.m",
                    "6:15 p.m. - 7:00 p.m",
                );
                $response = array();
                $availability = 1;
                foreach($timeSchedules as $timeSchedule){
                    $petIds = array();
                    $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
                    $pet = $con->query($query) or die($con->error);
                    while($petRow = $pet->fetch_assoc()){
                        $petIds[] = $petRow['id'];
                    }

                    foreach($petIds as $petId){
                        $query = "SELECT * FROM wellness_records WHERE pet_id = '$petId'";
                        $wellness = $con->query($query) or die($con->error);
                        if($wellnessRow = $wellness->fetch_assoc()){
                            $doctorId = $wellnessRow['doctor_id'];
                        }else{
                            $doctorId = rand(1,4);
                        }

                        $query = "SELECT * FROM appointments WHERE doctor_id LIKE '%$doctorId%' AND time = '$timeSchedule' AND date = '$date'";
                        $appointment = $con->query($query) or die($con->error);
                        if($appointmentRow = $appointment->fetch_assoc()){
                            $availability = 0;
                        }else{
                            $availability = 1;
                        }
                    }

                    $response[] = array(
                        'time' => $timeSchedule,
                        'availability' => $availability,
                    );
                }
                echo json_encode($response);
            }

            
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>