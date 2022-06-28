<?php
    session_start();
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM lab_technicians WHERE email = '$email'";
        $labtech = $con->query($query) or die($con->error);
        $data = array();
        while($row = $labtech->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) != 1){
            echo 'invalid';
        }else{
            if(!password_verify($password,$data[0]['password'])){
                echo 'invalid';
            }else{
                $_SESSION['lab_tech_id'] = $data[0]['id'];
                echo 'dashboard.html';
            }
        }
    }
?>