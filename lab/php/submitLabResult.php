<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        if(isset($_FILES)){
            $result = $_FILES['result']['name'];
            $tmpName = $_FILES['result']['tmp_name'];
            $filExtension = strtolower(pathinfo($result, PATHINFO_EXTENSION));

            $allowedExtensions = array("jpg","jpeg","png");

            if(in_array($filExtension, $allowedExtensions)){
                $filepath = "images/".uniqid().$filExtension;
                move_uploaded_file($tmpName, $filepath);
            }else{
                echo 'invalid file';
            }
            
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>