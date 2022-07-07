<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $userId = $_POST['user_id'];
        $name = $_POST['client_name'];
        $code = $_POST['client_code'];
        $contact = $_POST['client_contact'];
        $query = "UPDATE users SET name = '$name', client_code = '$code', contact_no = '$contact' WHERE id = '$userId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }
?>