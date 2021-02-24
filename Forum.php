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
        $sqli = "SELECT * FROM `information` WHERE id=(SELECT max(id) FROM `information`)";
        $result = mysqli_query($db, $sqli);
        if(!$result ){
            die("Couldn't query select-statement");
        }
        if(mysqli_num_rows($result) == 0){
            die("No posts in the database");
        }
        
        $opslag_vist = 0;
        $maxOpslag = 20;
        //find id'et på den nyeste post
        $sidst_opslag_id = mysqli_fetch_array($result)['id'];
        //sæt i lig med det nyeste id
        $i=$sidst_opslag_id;
        /*kør et loop indtil der enten ikke er flere post at hente, eller indtil der bliver displayet maxOpslag.
        display() retunerer true hvis opslaget er gyldigt og bliver vist 
        og false hvsi brugeren ikke har ret til at interegere eller se opslaget*/
        while($opslag_vist<$maxOpslag){
            //hent opslag hvor id er lig med i
            $sqli = "SELECT * FROM `information` WHERE id=('$i')";
            $result = mysqli_query($db, $sqli);
            //break loop hvis der ikke er flere opslag
            if (is_null( $opslag = mysqli_fetch_array($result))){
                break;
            }
            $opslag = $opslag['opslag'];
            $opslag = base64_decode($opslag);
            $opslag = unserialize($opslag);
            echo(" <div class=\"row\">");
            if($opslag->display()==true){
                
                $opslag_vist++;
            }
            echo(" </div>");
            $i = $i-1;
        }
        ?>
    </body>
</html>