<html>
    <?php
    session_start();
    require_once("./core/db_connect.php");
    ?>
    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forum</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    </head>
    <body>
        <?php include("./navbar/Navbar.php"); 
        
        include("Information_class.php");
        
        if(isset($_SESSION['user_id'])){
            echo("<p class=\"text\">Username: {$_SESSION['username']}<br></p>");
            echo($_SESSION['birthday']);
        }

        ?>

        <button onclick="window.location='./CreatePost.php'">Create Post</button>
        <br>
        
        <?php

        $nummer1 = new Information("hej", "IDL",0); 
        //gem_opslag($nummer1);
        
        $sqli = "SELECT * FROM `information`;";
        $result = mysqli_query($db, $sqli);
        if(!$result){
            die();
        }
<<<<<<< Updated upstream
        while($row = mysqli_fetch_array($result)){
            extract($row);
            $opslag1 = base64_decode($row['opslag']);
            $opslag2 = unserialize($opslag1);
            $opslag2->display();
=======
        // Gemmer alle opslagene i en liste
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            array_push($rows, $row);
        }
        rsort($rows); // rsort() vender om på rækkefølgen i listen, da vi gerne vil have de nye opslag øverst på siden.
        $maxOpslag = 20;
        $i = 0;
        foreach($rows as $row){
            // For hvert opslag bliver det decoded fra BLOB-element som kan gemmes i databasen til php-objekt.
            $opslag_id = $row['id'];
            $opslag = $row['opslag'];
            $opslag = base64_decode($opslag);
            $opslag = unserialize($opslag);
            
            // Hvis man her en vigtig nok rolle til at se opslaget, så køres display()-funktion for objektet.
            if($i < $maxOpslag){
                if($opslag->display($opslag_id) == true){
                    $i++;
                }
            }
>>>>>>> Stashed changes
        }


        
        
        ?>

    </body>
</html>