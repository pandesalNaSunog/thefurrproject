<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $response = "";
        //check if username exists
        $query = "SELECT * FROM admin_creds WHERE username = '$username'";
        $admincred = $con->query($query) or die($con->error);
        $data = array();
        while($row = $admincred->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) > 0){
            if(password_verify($password,$data[0]['password'])){
                $response = "ok";
            }else{
                $response = "invalid";
            }
        }else{
            $response = "invalid";
        }

        echo $response;
    }
?>