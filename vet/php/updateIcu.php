<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();

        $price = htmlspecialchars($_POST['price']);
        $icuId = $_POST['icu_id'];

        $query = "UPDATE icus SET price = '$price' WHERE id = '$icuId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>