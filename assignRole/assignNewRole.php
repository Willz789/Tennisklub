<?php
    session_start();
    require_once("../core/db_connect.php");

    verify();

    assignRole();

    function verify(){

        global $db;

        $password = mysqli_real_escape_string($db, $_POST['password']);

        $user_id = $_SESSION['user_id'];
        $selectSQL = "SELECT `password_hash` FROM `users` WHERE id='$user_id';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 4,
            )));
        }
        else if(mysqli_num_rows($result) == 0){
            die(json_encode(array(
                'result' => 1,
            )));
        }

        $row = mysqli_fetch_assoc($result);

        if(!password_verify($password, $row['password_hash'])){
            die(json_encode(array(
                'result' => 1,
            )));
        } 
    }

    function assignRole(){

        global $db;

        $username = mysqli_real_escape_string($db, $_POST['username']);
        $newRole = mysqli_real_escape_string($db, $_POST['newRole']);

        $selectSQL = "SELECT `role` FROM `users` WHERE username='$username';";
        $result = mysqli_query($db, $selectSQL);

        if(!$result){
            die(json_encode(array(
                'result' => 4,
            )));
        }
        else if(mysqli_num_rows($result) == 0){
            die(json_encode(array(
                'result' => 2,
            )));
        } 

        $row = mysqli_fetch_assoc($result);

        if($row['role'] == $newRole){
            die(json_encode(array(
                'result' => 3,
            )));
        }

        $updateSQL = "UPDATE `users` SET `role` = '$newRole' WHERE username='$username';";
        mysqli_query($db, $updateSQL);
        if($username == $_SESSION['username']){
            $_SESSION['role'] = $newRole;
        }
        
        die(json_encode(array(
            'result' => 0,
        )));


    }
?>