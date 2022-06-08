<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $doctorsName = "Dr.".$_POST['name'];
        $doctorsEmail = $_POST['email'];


        $query = "SELECT * FROM doctors WHERE email = '$doctorsEmail'";
        $doctor = $con->query($query) or die($con->error);
        $data = array();
        while($row = $doctor->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) >= 1){
            echo 'email exists';
        }else{

            $password = "password";
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO doctors(`name`,`email`,`password`) VALUES('$doctorsName','$doctorsEmail','$encryptedPassword')";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }
?>