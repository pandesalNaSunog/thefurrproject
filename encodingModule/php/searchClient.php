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
            $users[] = $row;
        }
        echo json_encode($users);
    }
?>