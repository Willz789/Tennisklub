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
        while($row = mysqli_fetch_array($result)){
            extract($row);
            $opslag1 = base64_decode($row['opslag']);
            $opslag2 = unserialize($opslag1);
            $opslag2->display();
        }


        
        
        ?>

    </body>
</html>