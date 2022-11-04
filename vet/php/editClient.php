<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']){
        include('connection.php');
        $con = connect();

        $clientName = htmlspecialchars($_POST['client_name']);
        $email = htmlspecialchars($_POST['email']);
        $clientCode = htmlspecialchars($_POST['client_code']);
        $contact = htmlspecialchars($_POST['contact']);
        $clientId = $_POST['client_id'];

        $query = "UPDATE users SET name = '$clientName', email = '$email', client_code = '$clientCode', contact_no = '$contact' WHERE id = '$clientId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>