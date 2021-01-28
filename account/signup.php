<?php
    session_start();
    require_once("../core/db_connect.php");

    compareUserCredentials();

    function compareUserCredentials(){
        global $db;

        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $phonenumber = mysqli_real_escape_string($db, $_POST['phonenumber']);
        $mail = mysqli_real_escape_string($db, $_POST['mail']);
        $birthday = mysqli_real_escape_string($db, $_POST['birthday']);

        $selectSQL = "SELECT `username`, `mail` FROM `users`;";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 3,
            )));
        }
        if(mysqli_num_rows($result) == 0){
            createAccount($username, $passwordHash, $name, $phonenumber, $mail, $birthday);
        } else {
            while($row = mysqli_fetch_array($result)){
                if($row['username'] == $username){
                    die(json_encode(array(
                        'result' => 1,
                    )));
                    break;
                } else if ($row['mail'] == $mail){
                    die(json_encode(array(
                        'result' => 2,
                    )));
                    break;
                }
            } 
            createAccount($username, $passwordHash, $name, $phonenumber, $mail, $birthday);
        }


    }

    function createAccount($username, $passwordHash, $name, $phonenumber, $mail, $birthday){
        global $db;
        $insertSql = "INSERT INTO `users`(`username`, `password_hash`, `phonenumber`, `mail`, `name`, `ranking_points`, `role`, `birthday`) VALUES (
            '$username',
            '$passwordHash',
            '$phonenumber',
            '$mail',
            '$name',
            '0',
            '0',
            '$birthday'
        );";
        $result = mysqli_query($db, $insertSql);
        if(!$result){
            die(json_encode(array(
                'result' => 3,
            )));
        } else {
            die(json_encode(array(
                'result' => 0,
            )));
        }
    }
?>