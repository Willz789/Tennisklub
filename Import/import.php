<?php
    session_start();
    require_once("../core/db_connect.php");

    if(isset($_SESSION['user_id'])) {
        $list = extractFromFile('./ImportUsers.csv');
        importUsers($list);
    }
    header("Location: ../Home-Page.php");
    exit();

    function extractFromFile($File){
        $arrResult = array();
        $handle = fopen($File, "r");
        if(empty($handle) === false) {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $arrResult[] = $data;
            }
            fclose($handle);
        }
        return $arrResult;
    }

    function importUsers($list){
        global $db;
        foreach($list as $row){
            $selectSQL = "SELECT * FROM `users` WHERE username='$row[1]';";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die();
            }
            if(mysqli_num_rows($result) == 0){
                $selectSQL = "SELECT * FROM `users` WHERE mail='$row[4]';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die();
                }
                if(mysqli_num_rows($result) == 0){
                    $insertSQL = "INSERT INTO `users` (`username`, `password_hash`, `phonenumber`, `mail`, `name`, `ranking_points`, `role`, `birthday`) VALUES (
                        '$row[1]',
                        '$row[2]',
                        '$row[3]',
                        '$row[4]',
                        '$row[5]',
                        '$row[6]',
                        '$row[7]',
                        '$row[8]'
                        );";
                    $result = mysqli_query($db, $insertSQL);
                    if(!$result){
                        die();
                    }
                }
            }
        }
    }

?>