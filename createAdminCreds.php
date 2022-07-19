<?php

    $con = new mysqli("localhost","u568496919_thefurr","Thefurrpassword11","u568496919_thefurr_db");

    $password = password_hash('password', PASSWORD_DEFAULT);
    $query = "INSERT INTO users(`name`,`email`,`password`,`user_type`)VALUES('Administrator','admin@gmail.com','$password','admin')";
    $con->query($query) or die($con->error);
?>