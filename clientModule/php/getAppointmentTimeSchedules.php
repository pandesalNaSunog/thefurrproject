<?php
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d');
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $date = $_POST['date'];

        $todayDateObject = date_create($today);
        $postedDateObject = date_create($date);

        $dateDifference = date_diff($todayDateObject, $postedDateObject);
        $dateDiffResult = $dateDifference->format("%R");
        if($dateDiffResult == "-"){
            echo 'invalid';
        }else{
            $timeSchedules = array('10:00am - 10:45am','10:45am - 11:30am','11:30am - 12:15pm','12:15pm - 1:00pm','1:00pm - 1:45pm','1:45pm - 2:30pm','2:30pm - 3:15pm','3:15pm - 4:00pm','4:00pm - 4:45pm','4:45pm - 5:30pm','5:30pm - 6:15pm','6:15pm - 7:00pm');
        
            $response = array();
            foreach($timeSchedules as $time){
                $query = "SELECT * FROM appointments WHERE date = '$date' AND time = '$time'";
                $appointment = $con->query($query) or die($con->error);
                $data = array();
                while($row = $appointment->fetch_assoc()){
                    $data[] = $row;
                }
                $availability = "";
                if(count($data) == 4){
                    $availability = "Fully Booked!";
                }else{
                    $availability = "Available";
                }
    
                $response[] = array('date' => $date, 'time' => $time, 'availability' => $availability);
            }
            echo json_encode($response);
        }
        
    }
?>