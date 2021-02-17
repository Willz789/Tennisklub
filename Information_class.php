
<?php

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
            public $image;
            public $image_type;
            /*protected int $maxage;
            protected int $minage;
            protected $dato;*/
            
            function __construct($titel, $tekst, $image, $image_type) {
                $this->titel = $titel;
                $this->tekst = $tekst;

                $this->image = $image;
                $this->image_type = $image_type;
                $this->dato = date('m/d/Y h:i:s a');
                //echo("construct test overklasse");
                
            }

            public function display() {
                echo("
                <div class=\"opslagsbox\">
                    <h1 class=\"titel\">{$this->titel}</h1>
                    <p class=\"tekst\">{$this->tekst}</p>
                    ");

                    if(isset($this->image))
                    {
                    // Enable output buffering
                    ob_start();
                    echo($this->image);
                    // Capture the output
                    $imagedata = ob_get_contents();
                    // Clear the output buffer
                    ob_end_clean();

                    echo '<img src="data:'.$this->image_type.';base64,'.base64_encode($imagedata).'">';
                    }

                    

                    echo("
                    <a class=\"link-opslag\" href=\"{./Forum.php}\">Mere information</a>
                
                </div>
                ");
                return true;
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