<<<<<<< Updated upstream
=======
<!DOCTYPE html>
<html lang="en">
    <?php
        session_start();
        require_once("core/db_connect.php");
    ?>


    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    </head>
    <body>
        <?php include("./core/Navbar.php"); 

        if(isset($_SESSION['user_id'])){
            echo("<p class=\"text\">Username: {$_SESSION['username']}<br></p>");
        }

        $nummer1 = new Information("hej", "IDL"); 
        gem_opslag($nummer1);

        
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
       

     


        function gem_opslag($opslag){
            $opslag = serialize($opslag);
            $opslag = base64_encode($opslag);
            global $db;
            $insertSQL = "insert into information (opslag)
            values ('$opslag')";

            mysqli_query($db, $insertSQL);

        }

        class Information {
            public $titel;
            public $tekst;
            /*protected int $maxage;
            protected int $minage;
            protected $dato;*/
            
            function __construct($titel, $tekst) {
                $this->titel = $titel;
                $this->tekst = $tekst;
                $this->dato = date('m/d/Y h:i:s a');
                //echo("construct test overklasse");
                
            }

            public function display() {
                echo("
                <div class=\"opslagsbox\">
                    <h1 class=\"titel\">{$this->titel}</h1>
                    
                    <p class=\"tekst\">{$this->tekst}</p>
                    ");
                
                    if(1 == 1){
                        echo("Billede");
                    }
                    echo("
                    <a class=\"link-opslag\" href=\"{./Forum.php}\">Mere information</a>
                
                </div>
                ");
            }
        }

        class Turnering extends Information {

            function __contruct(){
                parent::__construct($this->titel, $this->tekst);
            }

            function display() {
                parent::display();
            }
        }

        class Event extends Information {
            function __contruct(){
                parent::__construct($this->titel, $this->tekst);
            }
    
            function display() {
                parent::display();
            }
        }

        class Træner_information extends Information {
            function __contruct(){
                parent::__construct($this->titel, $this->tekst);
            }
    
            function display() {
                if($_SESSION['role']>=1){
                    parent::display();
                }
            }
        }
        ?>

    </body>
</html>




>>>>>>> Stashed changes
