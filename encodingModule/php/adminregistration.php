<?php

    include('connection.php');
    $con = connect();

    $password = "admin";
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin_creds(`username`,`password`)VALUES('admin','$encryptedPassword')";
    $con->query($query) or die($con->error);
    $query = "SELECT * FROM admin_creds WHERE id = LAST_INSERT_ID()";
    $user = $con->query($query) or die($con->error);
    $data = $user->fetch_assoc();

    echo json_encode($data);

?>