<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    verify(); // Jeg tjekker at credentials findes på en bruger.

    function verify(){

        global $db;

        // Jeg henter data som blev postet fra ajax i "login.js".
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        // Jeg selecter alle 'users' med matchende username
        $selectSQL = "SELECT * FROM `users` WHERE username='$username';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 2, // respons til ajax.
            )));
        }
        else if(mysqli_num_rows($result) == 0){
            die(json_encode(array(
                'result' => 1, // respons til ajax.
            )));
        }
        else {
            $row = mysqli_fetch_assoc($result); // Jeg henter data fra brugeren.

            // Jeg tjekker at passwords matcher
            if(!password_verify($password, $row['password_hash'])){
                die(json_encode(array(
                    'result' => 1, // respons til ajax.
                )));
            }

            // Jeg tilføjer alle login-detaljer til sessionen som husker, hvem der er logget ind.
            // Jeg gemmer ikke password for sikkerhedsskyld.
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['phonenumber'] = $row['phonenumber'];
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['ranking_points'] = $row['ranking_points'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['birthday'] = $row['birthday'];

            die(json_encode(array(
                'result' => 0, // Respons til ajax. (Det virkede og der logges ind).
            )));
        }
    }
?>