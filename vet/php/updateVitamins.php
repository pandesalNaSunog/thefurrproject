<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();

        $price = htmlspecialchars($_POST['price']);
        $vitaminsId = $_POST['vitamins_id'];
        $vitamins = htmlspecialchars($_POST['vitamins']);
        $query = "UPDATE vitamins SET price = '$price', vitamin = '$vitamins' WHERE id = '$vitaminsId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>