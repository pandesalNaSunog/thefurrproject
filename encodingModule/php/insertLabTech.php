
<?php
    include('connection.php');
    $con = connect();
    $date = getCurrentDate();

    if(isset($_POST)){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = 'password';
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM lab_technicians WHERE email = '$email'";
        $labtech = $con->query($query) or die($con->error);
        $data = array();
        while($row = $labtech->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) >= 1){
            echo 'email exists';
        }else{
            $query = "INSERT INTO lab_technicians(`name`,`email`,`password`,`created_at`,`updated_at`)VALUES('$name','$email','$password','$date','$date')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM lab_technicians WHERE id = LAST_INSERT_ID()";
            $labtech = $con->query($query) or die($con->error);
            $row = $labtech->fetch_assoc();

            echo json_encode($row);
        }
    }
?>