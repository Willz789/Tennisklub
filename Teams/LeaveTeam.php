<?php
    session_start();
    require_once("../core/db_connect.php");

    header("Location: ../Training.php");

    $user_id = $_POST['user_id'];
    $team_id = $_POST['team_id'];

    $deleteSQL = "DELETE FROM `team_members` WHERE `user_id`='$user_id' AND `team_id`='$team_id';";
    $result = mysqli_query($db, $deleteSQL);
    if(!$result){
        die("Couldn't query insertion");
    }

    exit();
?>