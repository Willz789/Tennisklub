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
            public $imagePath;
            /*protected int $maxage;
            protected int $minage;
            protected $dato;*/
            
            function __construct($titel, $tekst, $imagePath) {
                $this->titel = $titel;
                $this->tekst = $tekst;

                $this->imagePath = $imagePath;
                
                $this->dato = date('m/d/Y h:i:s a');
                //echo("construct test overklasse");
                
            }

            public function display() {
                echo("
                <div class=\"opslagsbox\">
                    <h1 class=\"titel\">{$this->titel}</h1>
                    
                    <p class=\"tekst\">{$this->tekst}</p>
                    ");

                    if(isset($this->imagePath) && $this->imagePath != "")
                    {
                        $imageSource = "./images/" . $this->imagePath;
                        
                        echo("<div class=\"forum-post-image\">
                            <img src=\"{$imageSource}\" class=\"post-image\" >
                        </div>");
                    }

                    echo("
                    <a class=\"link-opslag\" href=\"{./Forum.php}\">Mere information</a>
                
                </div>
                ");
            }
        }

        class Turnering extends Information {

            function __contruct(){
                parent::__construct($this->titel, $this->tekst, $this->imagePath);
            }

            function display() {
                parent::display();
            }
        }

        class Event extends Information {
            function __contruct(){
                parent::__construct($this->titel, $this->tekst, $this->imagePath);
            }
    
            function display() {
                parent::display();
            }
        }

        class Træner_information extends Information {
            function __contruct(){
                parent::__construct($this->titel, $this->tekst, $this->imagePath);
            }
    
            function display() {
                if($_SESSION['role']>=1){
                    parent::display();
                }
            }
        }

        ?>