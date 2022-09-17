<?php
    $con = new mysqli("localhost","root","","thrfurr_db");
    $password = password_hash('password', PASSWORD_DEFAULT);
    $query = "INSERT INTO users(`email`,`password`)VALUES('admin@gmail.com','$password')";
    $con->query($query) or die($con->error);
    echo 'ok';
?>