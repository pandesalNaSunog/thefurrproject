<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $keyword = htmlspecialchars($_POST['keyword']);

            if($keyword == ""){
                $query = "SELECT id, client_code, name, contact_no FROM users WHERE user_type = 'client' ORDER BY name ASC";
            }else{
                $query = "SELECT id, client_code, name, contact_no FROM users WHERE user_type = 'client' AND (client_code LIKE '%$keyword%' OR name LIKE '%$keyword%') ORDER BY name ASC";
            }
            
            $user = $con->query($query) or die($con->error);
            $users = array();
            while($userRow = $user->fetch_assoc()){
                $users[] = $userRow;
            }

            echo json_encode($users);
            // $doctor_id = $_SESSION['doctor_id'];
            // $keyword = htmlspecialchars($_POST['keyword']);
            // $users = array();
            // $query = "SELECT * FROM wellness_records WHERE doctor_id = '$doctor_id'";
            // $wellness = $con->query($query) or die($con->error);
            // $petIds = array();
            // $userIds = array();
            // while($wellnessRow = $wellness->fetch_assoc()){
            //     $petIds[] = $wellnessRow['pet_id'];
            // }

            // foreach($petIds as $petId){
            //     $query = "SELECT * FROM pets WHERE id = '$petId'";
            //     $pet = $con->query($query) or die($con->error);
            //     while($petRow = $pet->fetch_assoc()){
            //         $userIds[] = $petRow['user_id'];
            //     }
            // }
            // $currentUserId = 0;
            // foreach($userIds as $userIdItem){
            //     if($userIdItem != $currentUserId){
            //         $query = "SELECT * FROM users WHERE id = '$userIdItem' AND user_type = 'client' AND (name LIKE '%$keyword%' OR client_code LIKE '%$keyword%')";
            //         $userQuery = $con->query($query) or die($con->error);
                    
            //         if($userRow = $userQuery->fetch_assoc()){
            //             $users[] = array(
            //                 'name' => $userRow['name'],
            //                 'email' => $userRow['email'],
            //                 'client_code' => $userRow['client_code'],
            //                 'contact_no' => $userRow['contact_no'],
            //                 'id' => $userRow['id'],
            //                 'banned' => $userRow['banned']
            //             );
            //             $currentUserId = $userIdItem;
            //         }
                    
            //     }
            // }
            // echo json_encode($users);
        }else{
            echo 'invalid session';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>