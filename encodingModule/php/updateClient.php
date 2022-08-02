<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        $clientId = $_POST['client_id'];
        $name = $_POST['name'];
        $email = htmlspecialchars($_POST['email']);
        $contact = htmlspecialchars($_POST['contact']);
        $code = htmlspecialchars($_POST['code']);

        $query = "UPDATE users SET name = '$name' , email = '$email', contact_no = '$contact', client_code = '$code' WHERE id = '$clientId'";
        $con->query($query) or die($con->error);

        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>