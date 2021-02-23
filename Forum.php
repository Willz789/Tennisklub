<html>
    <?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
    ?>
    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forum</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
    </head>
    <body>
        <?php 
        include("./navbar/Navbar.php"); // Indkluderer navbar.
        include("Information_class.php"); // Indkluderer script med klasser.

        // Vælger alle opslag som er gemt i databasen.
        $sqli = "SELECT * FROM `information`;";
        $result = mysqli_query($db, $sqli);
        if(!$result ){
            die("Couldn't query select-statement");
        }
        if(mysqli_num_rows($result) == 0){
            die("No posts in the database");
        }
        // Gemmer alle opslagene i en liste
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            array_push($rows, $row['opslag']);
        }
        rsort($rows); // rsort() vender om på rækkefølgen i listen, da vi gerne vil have de nye opslag øverst på siden.
        foreach($rows as $opslag){
            // For hvert opslag bliver det decoded fra BLOB-element som kan gemmes i databasen til php-objekt.
            $opslag = base64_decode($opslag);
            $opslag = unserialize($opslag);
            
            // Hvis man her en vigtig nok rolle til at se opslaget, så køres display()-funktion for objektet.
            if(isset($_SESSION['user_id'])){
                if($_SESSION['role'] >= $opslag->gruppe){
                    $opslag->display();
                }
            } else if($opslag->gruppe == -1){
                $opslag->display();
            }
        }
        ?>
    </body>
</html>