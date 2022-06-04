<?php
    include('../../encodingModule/php/connection.php');
    $con = connect();


    if(isset($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM doctors WHERE email = '$email' AND password = '$password'";
        $doctor = $con->query($query) or die($con->error);
        $data = array();
        while($row = $doctor->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) == 1){
            echo 'vetDashboard.html';
        }else{
            echo 'nothing';
        }
    }
?>