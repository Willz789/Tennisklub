<?php
    session_start();
    require_once("../core/db_connect.php");

    if(isset($_SESSION['user_id']) && $_SESSION['role'] == 2) {
        $url = "https://api.parser.name/?";
        $api_key = "api_key=32e7531bbb0691eb77c018728606002f";
        $endpoint_code = "&endpoint=generate";
        $amount = $_POST['totalNames'];
        $amount_code = "&results=$amount";
        $country_code = "&country_code=DK";
        $url.=$api_key.$endpoint_code.$country_code.$amount_code;
        $apiResponse = generateFromAPI($url);
        insertUsers($apiResponse);
    }
    header("Location: ../Home-Page.php");
    exit();

    function generateFromAPI($url){
        $response = file_get_contents($url);
        if(!$response){
            die("couldn't access api-call (Perhaps you reached the limit)");
        }
        $response = json_decode($response);
        return $response;
    }

    function insertUsers($apiReponse){
        global $db;
        foreach($apiReponse->data as $character){
            $firstname = $character->name->firstname->name;
            $lastname = $character->name->lastname->name;
            $username = $firstname.$lastname;
            $name = "$firstname $lastname";
            $myUserId = $_SESSION['user_id'];
            $selectSQL = "SELECT `password_hash` FROM `users` WHERE `id`='$myUserId';";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die("Couldn't generate password");
            }
            if(mysqli_num_rows($result) == 0){
                die("Your account doesn't exists");
            }
            $row = mysqli_fetch_assoc($result);
            $password_hash = $row['password_hash'];
            $mail = $character->email->address;
            $phonenumber = rand(10000001,99999999);
            $ranking_points = 0;
            $role = rand(0,1);
            $birthDay = strval(rand(1,28));
            if(strlen($birthDay) == 1){
                $birthDay = "0$birthDay";
            }
            $birthMonth = strval(rand(1,12));
            if(strlen($birthMonth) == 1){
                $birthMonth = "/0$birthMonth";
            }
            $birthYear = strval(rand(1980,2010));
            $birthYear = "/$birthYear";
            $birthday = $birthDay.$birthMonth.$birthYear;
            $selectSQL = "SELECT * FROM `users` WHERE username='$username';";
            $result = mysqli_query($db, $selectSQL);
            
            if(!$result){
                die();
            }
            if(mysqli_num_rows($result) == 0){
                $selectSQL = "SELECT * FROM `users` WHERE mail='$mail';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die();
                }
                if(mysqli_num_rows($result) == 0){
                    $insertSQL = "INSERT INTO `users` (`username`, `password_hash`, `phonenumber`, `mail`, `name`, `ranking_points`, `role`, `birthday`) VALUES (
                        '$username',
                        '$password_hash',
                        '$phonenumber',
                        '$mail',
                        '$name',
                        '$ranking_points',
                        '$role',
                        '$birthday'
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