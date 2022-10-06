<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();
        if(isset($_GET) && isset($_SESSION['doctor_id'])){


            $query = "SELECT id, client_code, contact_no, name FROM users WHERE user_type = 'client' ORDER BY name ASC";
            $user = $con->query($query) or die($con->error);
            $users = array();
            $doctorName = "NO RECORDS";
            $doctorNameString = "";
            while($userRow = $user->fetch_assoc()){
                
                $userId = $userRow['id'];
                $query = "SELECT * FROM appointments WHERE user_id = '$userId' ORDER BY created_at DESC";
                $appointmentQuery = $con->query($query) or die($con->error);

                if($appointmentRow = $appointmentQuery->fetch_assoc()){
                    $doctorIds = $appointmentRow['doctor_id'];

                    $doctorIdArray = explode("**", $doctorIds);

                    foreach($doctorIdArray as $key => $doctorId){
                        $query = "SELECT name FROM users WHERE id = '$doctorId'";
                        $doctor = $con->query($query) or die($con->error);
                        if($doctorRow = $doctor->fetch_assoc()){
                        
                            $doctorName = $doctorRow['name'];
                            
                            $doctorNameString .= $doctorName . "/";
                        }else{
                            $doctorNameString .= "NO RECORDS";
                        }
                    }
                }
                
                $users[] = array(
                    'id' => $userRow['id'],
                    'name' => $userRow['name'],
                    'client_code' => $userRow['client_code'],
                    'contact_no' => $userRow['contact_no'],
                    'attending_vet' => $doctorNameString
                );
                $doctorNameString = "";
            }

            echo json_encode($users);
        }else{
            echo 'invalid session';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>