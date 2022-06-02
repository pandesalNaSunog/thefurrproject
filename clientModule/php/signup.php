<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $contact = $_POST['contact'];
        $name = $_POST['name'];
        

        //check if email exists
        $query = "SELECT * FROM users WHERE email = '$email'";
        $user = $con->query($query) or die($con->error);
        $data = array();
        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) > 0){
            echo 'email exists';
        }else{
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

            $clientCode = createClientCode($name);
            $query = "INSERT INTO users(`email`,`password`,`contact_no`,`name`)VALUES('$email','$encryptedPassword','$contact','$name')";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }

    function createClientCode($name){
        $thisName = $name;
        $generatedCode = "";
        $arrayOfnameWords = explode(" ",$thisName);

        foreach($arrayOfnameWords as $word){
            $generatedCode .= strtoupper($word[0]);
        }

        $generatedCode .= generateRandomNumber();
    }

    function generateRandomNumber(){
        $numbers = "0123456789";
        $counter = 1;
        do{
            $generatedNumber .= $numbers[rand(0,8)];
            $counter++;
        }while($counter < strlen($numbers));

        return $generatedNumber;
    }
?>