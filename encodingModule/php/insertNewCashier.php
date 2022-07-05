<?php
    include('connection.php');
    $con = connect();
    $date = getCurrentDate();

    if(isset($_POST)){
        $name = $_POST['name'];
        $email = $_POST['email'];

        $password = password_hash("password", PASSWORD_DEFAULT);


        $query = "INSERT INTO cashiers(`name`,`email`,`password`,`created_at`,`updated_at`)VALUES('$name','$email','$password','$date','$date')";
        $con->query($query) or die($con->error);

        $query = "SELECT * FROM cashiers WHERE id = LAST_INSERT_ID()";
        $cashier = $con->query($query) or die($con->error);
        $row = $cashier->fetch_assoc();

        echo json_encode($row);
    }
?>