<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    // Henter input fra ajax fra scriptet "bookCourt.js"
    $courtId = mysqli_real_escape_string($db, $_POST['courtId']);
    $userId = mysqli_real_escape_string($db, $_POST['userId']);
    

    $myCourt = true; // Hvis true, så har den nuværende bruger allerede booket banen.
    $selectSQL = "SELECT * FROM `bookings` WHERE court_id='$courtId' AND `user_id`='$userId';";
    $result = mysqli_query($db, $selectSQL);
    if(!$result){
        die(json_encode(array(
            'result' => 2, // Respons til ajax.
        )));
    }
    if(mysqli_num_rows($result) == 0){ // Hvis der ikke findes nogle rækker i tabellen 'bookings', som har de rigtige data.
        $myCourt = false; // Den nuværende bruger har ikke booket banen.
    }

    if($myCourt == true){ // Hvis den nuværende bruger allerede har booket banen, så fjernes bookningen.
        // Fjerner rækken i tabellen.
        $deleteSQL = "DELETE FROM `bookings` WHERE court_id='$courtId' AND `user_id`='$userId';";
        $result = mysqli_query($db, $deleteSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 2, // Respons til ajax.
            )));
        }
        die(json_encode(array(
            'result' => 0, // Respons til ajax. (Bookning blev fjernet).
        )));
    } else { // Hvis den nuværende bruger ikke allerede har booket banen, så bliver den booket.
        // Tjekker at banen ikke allerede er booket af en anden.
        $selectSQL = "SELECT * FROM `bookings` WHERE court_id='$courtId';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die(json_encode(array(
                'result' => 2, // Respons til ajax.
            )));
        }
        if(mysqli_num_rows($result) == 0){ // Hvis den ikke allerede er booket af en anden.
            if(isset($_SESSION['user_id'])){ // Tjekker at man er logget ind.

                // Hvis man ikke er træner eller admin, så kan man kun have booket op til 4 baner på en gang.
                $role = $_SESSION['role'];
                $selectSQL = "SELECT * FROM `bookings` WHERE `user_id`='$userId';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die(json_encode(array(
                        'result' => 2, // Respons til ajax.
                    )));
                }
                if($role == 0 && mysqli_num_rows($result) > 3) { // Hvis man kun er medlem i klubben, og man allerede har 4 baner.
                    die(json_encode(array(
                        'result' => 3, // Respons til ajax (Kan ikke booke flere baner).
                    )));
                } else {
                    // Banen bookes
                    $insertSQL = "INSERT INTO `bookings` (`user_id`, `court_id`)
                    VALUES (
                        '$userId',
                        '$courtId'
                    );";
                    
                    $result = mysqli_query($db, $insertSQL);
                    if(!$result){
                        die(json_encode(array(
                            'result' => 2, // Respons til ajax.
                        )));
                    } 
                    die(json_encode(array(
                        'result' => 0, // Respons til ajax. (Banen blev booket).
                    )));
                }
            }
        } else {
            // Hvis banen allerede er booket af en anden.
            die(json_encode(array(
                'result' => 1, // Respons til ajax.
            )));
        }
    }
?>