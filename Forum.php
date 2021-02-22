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
        }

        ?>

        <?php
        $sqli = "SELECT * FROM `information` WHERE id=(SELECT max(id) FROM `information`)";
        $result = mysqli_query($db, $sqli);
        $sidst_opslag_id = mysqli_fetch_array($result)['id'];
        $i=$sidst_opslag_id;
        while($i>$sidst_opslag_id-20){
            $sqli = "SELECT * FROM `information` WHERE id=('$i')";
            $result = mysqli_query($db, $sqli);
            
            if (is_null( $opslag = mysqli_fetch_array($result))){
                break;
            }
            $opslag = $opslag['opslag'];
            $opslag = base64_decode($opslag);
            $opslag = unserialize($opslag);
            echo($i);
            if($opslag->display()==true){
                
                //$i = $i-1;
            }
            $i = $i-1;
        }


        
        
        ?>

    </body>
</html>