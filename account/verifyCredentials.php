<?php
    session_start();
    require_once("../core/db_connect.php");

    verify();

    function verify(){

        global $db;

        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        $selectSQL = "SELECT * FROM `users` WHERE username='$username';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 2,
            )));
        }
        else if(mysqli_num_rows($result) == 0){
            die(json_encode(array(
                'result' => 1,
            )));
        }
        else {
            $row = mysqli_fetch_assoc($result);

            if(!password_verify($password, $row['password_hash'])){
                die(json_encode(array(
                    'result' => 1,
                )));
            }

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['phonenumber'] = $row['phonenumber'];
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['ranking_points'] = $row['ranking_points'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['birthday'] = $row['birthday'];

            die(json_encode(array(
                'result' => 0,
            )));
        }

    }



?>