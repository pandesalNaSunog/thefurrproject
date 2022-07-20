<?php
    include('connection.php');
    $con = connect();
    $today = getCurrentDate();
    $password = password_hash('password', PASSWORD_DEFAULT);
    $con->query("INSERT INTO users (`email`,`password`,`name`,`created_at`,`updated_at`,`user_type`)VALUES('admin@gmail.com','$password','Administrator','$today','$today','admin')") or die($con->error);
    echo 'ok';
?>