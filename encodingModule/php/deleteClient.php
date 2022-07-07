<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $userId = $_POST['user_id'];
        echo 'ok';
    }
?>