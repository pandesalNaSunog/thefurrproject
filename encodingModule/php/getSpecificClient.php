<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $userId = $_GET['user_id'];
        $query = "SELECT * FROM users WHERE id = '$userId'";
        $user = $con->query($query) or die($con->error);
        $userRow = $user->fetch_assoc();
        echo json_encode($userRow);
    }
?>