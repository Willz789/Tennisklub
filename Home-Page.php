<!DOCTYPE html>
<html>
<body>


<?php
   // session_start();
    //require_once("core/db_connect.php");

    

/*
    function opret_post(){

        $insertSQL = "insert into information ($post)
        values ('$post')";

        mysqli_query($conn, $insertSQL);

    }

*/
    

    class Information {
        public $titel;
        public $tekst;
        /*protected int $maxage;
        protected int $minage;
        protected $dato;*/
        
        function __construct($titel, $tekst) {
            $this->titel = $titel;
            $this->tekst = $tekst;
            //$dato = date('m/d/Y h:i:s a');
            echo("construct test");
            
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
            echo($this->titel);
        }
    }

    $nummer1 = new Turnering("hej", "HEJHEJ"); 
    $nummer1->display();
?>

</body>
</html>




