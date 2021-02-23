<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    // Dette script kan kun bruges, hvis man er admin.
    if(isset($_SESSION['user_id']) && $_SESSION['role'] == 2) {
        // URL til api:
        $url = "https://api.parser.name/?";
        $api_key = "api_key=32e7531bbb0691eb77c018728606002f"; // api_key
        $endpoint_code = "&endpoint=generate"; 
        $amount = $_POST['totalNames']; // Mængde af navne der skal genereres.
        $amount_code = "&results=$amount";
        $country_code = "&country_code=DK"; // Land som navne skal tilhøre.
        $url.=$api_key.$endpoint_code.$country_code.$amount_code; // URL sættes sammen.
        $apiResponse = generateFromAPI($url); // Funktion der henter JSON fra API.
        insertUsers($apiResponse); // Behandler JSON og indsætter brugere.
    }
    header("Location: ../Home-Page.php"); // Går til Home-Page.php
    exit(); // Stopper scriptet.

    function generateFromAPI($url){
        $response = file_get_contents($url); // Henter data fra api.
        if(!$response){ // Giver fejl, hvis den ikke kunne hente data. (Med vores abbonement på api-siden, kan api'en kun bruges en bestemt mængde gange om dagen.)
            die("couldn't access api-call (Perhaps you reached the limit)");
        }
        $response = json_decode($response); // Omdanner data til JSON-format.
        return $response; // Returner JSON-objekt.
    }

    // Indsætter nye brugere i databasen.
    function insertUsers($apiReponse){
        global $db;
        
        foreach($apiReponse->data as $character){// For hver person i databasen.
            // Henter data fra api'en.
            $firstname = $character->name->firstname->name; 
            $lastname = $character->name->lastname->name;
            $username = $firstname.$lastname;
            $name = "$firstname $lastname";
            $myUserId = $_SESSION['user_id'];
            $selectSQL = "SELECT `password_hash` FROM `users` WHERE `id`='$myUserId';"; // Alle brugere har samme password, nemlig "1234", for vores skyld :).
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
            $phonenumber = rand(10000001,99999999); // Generere tilfældigt telefonnummer.
            $ranking_points = 0;
            $role = rand(0,1); // Tilfældig rolle. (mellem træner og member).
            // Generere tilfældig fødselsdag:
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
            // Tjekker at brugernavnet ikke allerede findes:
            $selectSQL = "SELECT * FROM `users` WHERE username='$username';";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die();
            }
            if(mysqli_num_rows($result) == 0){
                // Tjekker at mailen ikke allerede er i brug:
                $selectSQL = "SELECT * FROM `users` WHERE mail='$mail';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die();
                }
                if(mysqli_num_rows($result) == 0){

                    // Indsætter bruger i database.
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