
<?php
    session_start();
    require_once("../core/db_connect.php");

    header("Location: ../Training.php");

    $user_id = $_POST['user_id'];
    $team_id = $_POST['team_id'];

    $insertSQL = "INSERT INTO `team_members`(`user_id`, `team_id`) VALUES (
        '$user_id',
        '$team_id'
    );";
    $result = mysqli_query($db, $insertSQL);
    if(!$result){
        die("Couldn't query insertion");
    }

    exit();

?>