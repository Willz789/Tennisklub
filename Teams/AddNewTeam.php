<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    // Henter input fra "AddNewTeam.js".
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $minBirthYear = mysqli_real_escape_string($db, $_POST['minBirthYear']);

    // Tjekker om der allerede findes et hold med dette navn.
    $selectSQL = "SELECT * FROM `teams` WHERE `name`='$name';";
    $result = mysqli_query($db, $selectSQL);
    if(!$result){
        die(json_encode(array(
            'result' => 2, // Respons til ajax.
        )));
    }
    if(mysqli_num_rows($result) != 0){
        die(json_encode(array(
            'result' => 1, // Respons til ajax.
        )));
    }

    // Insætter nyt hold i databasen, hvor opretteren af holdet bliver træneren.
    $user_id = $_SESSION['user_id'];
    $insertSQL = "INSERT INTO `teams`(`name`, `trainer_user_id`, `minBirthYear`) VALUES (
        '$name',
        '$user_id',
        '$minBirthYear'
    );";
    $result = mysqli_query($db, $insertSQL);
    if(!$result){
        die(json_encode(array(
            'result' => 2, // Respons til ajax.
        )));
    }
    die(json_encode(array(
        'result' => 0, // Respons til ajax. (Hold blev oprettet).
    )));

?>