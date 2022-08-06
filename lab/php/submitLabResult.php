<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        if(isset($_FILES)){
            $result = $_FILES['result']['name'];
            $tmpName = $_FILES['result']['tmp_name'];
            $filExtension = strtolower(pathinfo($result, PATHINFO_EXTENSION));
            echo $filExtension;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>