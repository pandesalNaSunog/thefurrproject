<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();

    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM doctors WHERE email = '$email'";
        $doctor = $con->query($query) or die($con->error);
        $data = array();
        while($row = $doctor->fetch_assoc()){
            $data[] = $row;
        }
        if(count($data) == 1){

            if(password_verify($password, $data[0]['password'])){
                $_SESSION['doctor_id'] = $data[0]['id'];
                echo 'vetDashboard.html';
            }else{
                echo 'nothing';
            }
        }else{
            echo 'nothing';
        }
    }
?>