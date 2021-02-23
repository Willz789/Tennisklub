<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    compareUserCredentials(); // Funktion der sammenligner credentials med eksisterende brugere.

    function compareUserCredentials(){
        global $db;

        // Jeg henter credentials fra posten, som jeg brugte ajax til at sende.
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Jeg hasher password for bruger-sikkerhed.
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $phonenumber = mysqli_real_escape_string($db, $_POST['phonenumber']);
        $mail = mysqli_real_escape_string($db, $_POST['mail']);
        $birthday = mysqli_real_escape_string($db, $_POST['birthday']);

        // Jeg henter alle usernames og mails fra eksisterende brugere.
        $selectSQL = "SELECT `username`, `mail` FROM `users`;";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 3, // Respons til ajax.
            )));
        }
        
        if(mysqli_num_rows($result) == 0){ // Hvis der ikke findes nogle brugere, så laves kontoen.
            createAccount($username, $passwordHash, $name, $phonenumber, $mail, $birthday);
        } else {
            // Tjekker om username eller mail allerede eksisterer på en anden bruger.
            while($row = mysqli_fetch_array($result)){
                if($row['username'] == $username){
                    die(json_encode(array(
                        'result' => 1, // Repons til ajax.
                    )));
                    break;
                } else if ($row['mail'] == $mail){
                    die(json_encode(array(
                        'result' => 2, // Repons til ajax.
                    )));
                    break;
                }
            } 
            // Skaber den nye bruger.
            createAccount($username, $passwordHash, $name, $phonenumber, $mail, $birthday);
        }


    }

    function createAccount($username, $passwordHash, $name, $phonenumber, $mail, $birthday){
        global $db;
        // Indsætter ny række i databasen i tabellen "users".
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
                'result' => 3, // respons til ajax.
            )));
        } else {
            die(json_encode(array(
                'result' => 0, // respons til ajax (Det virkede).
            )));
        }
    }
?>