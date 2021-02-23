<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    header("Location: ../Training.php"); // Man føres videre til Training.php.

    // Henter data fra php-script.
    $user_id = $_POST['user_id'];
    $team_id = $_POST['team_id'];

    // Fjerner række i tabellen 'team_members', som knytter bruger til hold.
    $deleteSQL = "DELETE FROM `team_members` WHERE `user_id`='$user_id' AND `team_id`='$team_id';";
    $result = mysqli_query($db, $deleteSQL);
    if(!$result){
        die("Couldn't query insertion");
    }

    exit(); // Stopper scriptet.
?>