<?php
    session_start();
    require_once("../core/db_connect.php");

    $courtId = mysqli_real_escape_string($db, $_POST['courtId']);
    $userId = mysqli_real_escape_string($db, $_POST['userId']);
    
    $myCourt = 1;
    $selectSQL = "SELECT * FROM `bookings` WHERE court_id='$courtId' AND `user_id`='$userId';";
    $result = mysqli_query($db, $selectSQL);
    if(!$result){
        die(json_encode(array(
            'result' => 2,
        )));
    }
    if(mysqli_num_rows($result) == 0){
        $myCourt = 0;
    }

    if($myCourt == 1){
        $deleteSQL = "DELETE FROM `bookings` WHERE court_id='$courtId' AND `user_id`='$userId';";
        $result = mysqli_query($db, $deleteSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 2,
            )));
        }
        die(json_encode(array(
            'result' => 0,
        )));
    } else {
        $selectSQL = "SELECT * FROM `bookings` WHERE court_id='$courtId';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 2,
            )));
        }
        if(mysqli_num_rows($result) == 0){
            if(isset($_SESSION['user_id'])){
                $role = $_SESSION['role'];
                $selectSQL = "SELECT * FROM `bookings` WHERE `user_id`='$userId';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die(json_encode(array(
                        'result' => 2,
                    )));
                }
                if($role == 0 && mysqli_num_rows($result) > 3) {
                    die(json_encode(array(
                        'result' => 3,
                    )));
                } else {
                    $insertSQL = "INSERT INTO `bookings` (`user_id`, `court_id`)
                    VALUES (
                        '$userId',
                        '$courtId'
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
                }
            }
        } else {
            die(json_encode(array(
                'result' => 1,
            )));
        }
    }
?>