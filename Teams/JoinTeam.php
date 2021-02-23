<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    header("Location: ../Training.php"); // Man føres til siden Training.php.

    // Henter data fra php-scriptet
    $user_id = $_POST['user_id'];
    $team_id = $_POST['team_id'];

    // Indsætter nyt medlem på hold i databasen.
    $insertSQL = "INSERT INTO `team_members`(`user_id`, `team_id`) VALUES (
        '$user_id',
        '$team_id'
    );";
    $result = mysqli_query($db, $insertSQL);
    if(!$result){
        die("Couldn't query insertion");
    }

    exit(); // Stopper scriptet.

?>