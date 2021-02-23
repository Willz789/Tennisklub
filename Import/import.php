<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("../core/db_connect.php"); // Jeg forbinder til databasen.

    // Skal importere, hvis man er logget ind.
    if(isset($_SESSION['user_id'])) {
        $list = extractFromFile('./ImportUsers.csv'); // Funktion der importere brugere.
        importUsers($list); // Funktion der indsætter brugere i database.
    }
    header("Location: ../Home-Page.php"); // Efter import føres man videre til Home-Page.php.
    exit(); // Stopper scriptet.

    function extractFromFile($File){
        $list = array(); // Tom array.
        $import = fopen($File, "r"); // Henter data fra csv-fil.
        if(empty($import) === false) { // Tjekker om filen er tom.
            while(($data = fgetcsv($import, 1000, ",")) !== FALSE){ // Loop så længe der er en række i csv-filen med data.
                $list[] = $data; // Tilføj ny række til liste.
            }
            fclose($import); // Lukker csv-filen igen.
        } else {
            die("File was empty.");
        }
        return $list;
    }

    function importUsers($list){
        global $db;
        foreach($list as $row){ // Loop for hver bruger.
            // Tjekker om username allerede er i brug.
            $selectSQL = "SELECT * FROM `users` WHERE username='$row[1]';"; 
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die();
            }
            if(mysqli_num_rows($result) == 0){
                // Tjekker om mail allerede er i brug.
                $selectSQL = "SELECT * FROM `users` WHERE mail='$row[4]';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die();
                }
                if(mysqli_num_rows($result) == 0){
                    // Indsætter bruger i database.
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