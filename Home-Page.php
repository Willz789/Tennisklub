<?php
    session_start();
    require_once("core/db_connect.php");
?>

<!DOCTYPE html>
<html>
<body>
<a href="./CreateAccount.php">Create an account</a>
<a href="./Login.php">Go to login page</a>
<a href="./account/logout.php">Log out</a>

<?php 
    $nummer1 = new Turnering("hej", "H"); 
    opret_post($nummer1);

   
    function opret_post($opslag){
        $opslag = serialize($opslag);
        $opslag = base64_encode($opslag);
        global $db;
        $insertSQL = "insert into information (opslag)
        values ('$opslag')";

        mysqli_query($db, $insertSQL);

    }

    $sqli = 'SELECT * FROM information WHERE id = 3';
    $result = mysqli_query($db, $sqli);
    $res = mysqli_fetch_array ($result,MYSQLI_ASSOC);

    $opslag1 = base64_decode($res['opslag']);
    $opslag2 = unserialize($opslag1);
    $opslag2->display();
    

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
            echo("titel: {$this->titel} \n tekst: {$this->titel}");
        }
    }

    class Turnering extends Information {

        function __contruct(){
            parent::__construct();
        }

        function display() {
            echo("titel: {$this->titel} \n tekst: {$this->tekst}");
        }
    }

    class Event extends Information {
        function __contruct(){
            parent::__construct();
        }
 
        function display() {
            echo("titel: {$this->titel} \n tekst: {$this->titel}");
        }
    }

    class Træner_information extends Information {
        function __contruct(){
            parent::__construct();
        }
 
        function display() {
            if($_SESSION['role']>=1){
                echo("titel: {$this->titel} \n tekst: {$this->titel}");
                




            }
        }
    }









    
?>

</body>
</html>




