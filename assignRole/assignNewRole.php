<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    verify(); // Funktion der tjekker at password-input er rigtigt

    assignRole(); // Ændrer persons rolle på hjemmesiden.

    function verify(){

        global $db;

        // Henter input fra ajax fra scriptet "assignRole.js"
        $password = mysqli_real_escape_string($db, $_POST['password']);

        // Henter hashed password fra brugeren.
        $user_id = $_SESSION['user_id'];
        $selectSQL = "SELECT `password_hash` FROM `users` WHERE id='$user_id';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result || mysqli_num_rows($result) == 0){
            die(json_encode(array(
                'result' => 3,
            )));
        }

        // Tjekker at password er rigtigt.
        $row = mysqli_fetch_assoc($result);
        if(!password_verify($password, $row['password_hash'])){
            die(json_encode(array(
                'result' => 1,
            )));
        } 
    }

    function assignRole(){
        global $db;

        // Henter brugerens username og den rolle som brugeren nu skal have.
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $newRole = mysqli_real_escape_string($db, $_POST['newRole']);

        // Brugerens rolle bliver opdateret.
        $updateSQL = "UPDATE `users` SET `role` = '$newRole' WHERE username='$username';";
        $result = mysqli_query($db, $updateSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 3,
            )));
        }
        if(mysqli_num_rows($result) == 0){
            die(json_encode(array(
                'result' => 2, // Repons til ajax (Bruger findes ikke)
            )));
        }
        // Hvis man ændrede sin egen rolle, så ændres det også i sessionen.
        if($username == $_SESSION['username']){
            $_SESSION['role'] = $newRole;
        }
        die(json_encode(array(
            'result' => 0, // respons til ajax. (Det virkede).
        )));


    }
?>