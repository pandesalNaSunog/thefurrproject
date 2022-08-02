<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $keyword = htmlspecialchars($_POST['keyword']);
        if($keyword == ""){
            $query = "SELECT * FROM users WHERE user_type = 'client'";
        }else{
            $query = "SELECT * FROM users WHERE name LIKE '%$keyword%' AND user_type = 'client'";
        }
        
        $user = $con->query($query) or die($con->error);
        $users = array();
        while($row = $user->fetch_assoc()){
            $users[] = array(
                'name' => $row['name'],
                'email' => $row['email'],
                'client_code' => $row['client_code'],
                'contact_no' => $row['contact_no'],
                'id' => $row['id'],
                'banned' => $row['banned'],
            );
        }
        echo json_encode($users);
    }
?>