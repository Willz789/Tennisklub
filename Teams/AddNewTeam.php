<?php
    session_start();
    require_once("../core/db_connect.php");

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $minBirthYear = mysqli_real_escape_string($db, $_POST['minBirthYear']);

    $selectSQL = "SELECT * FROM `teams` WHERE `name`='$name';";
    $result = mysqli_query($db, $selectSQL);
    if(!$result){
        die(json_encode(array(
            'result' => 2,
        )));
    }
    if(mysqli_num_rows($result) != 0){
        die(json_encode(array(
            'result' => 1,
        )));
    }

    $user_id = $_SESSION['user_id'];

    $insertSQL = "INSERT INTO `teams`(`name`, `trainer_user_id`, `minBirthYear`) VALUES (
        '$name',
        '$user_id',
        '$minBirthYear'
    );";
    $result = mysqli_query($db, $insertSQL);
    if(!$result){
        die(json_encode(array(
            'result' => 2,
        )));
    }
    die(json_encode(array(
        'result' => 0,
    )));

?>