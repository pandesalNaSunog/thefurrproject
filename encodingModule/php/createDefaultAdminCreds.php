<?php
    include('connection.php');
    $con = connect();

    $query = "SELECT * FROM admin_creds";
    $adminCreds = $con->query($query) or die($con->error);
    $data = array();

    while($row = $adminCreds->fetch_assoc()){
        $data[] = $row;
    }

    if(count($data) < 1){

        $username = "admin";
        $password = "admin";
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin_creds(`username`,`password`)VALUES('$username','$password')";
        $con->query($query) or die($con->error);

        echo 'ok';
    }else{
        echo 'nope';
    }
?>