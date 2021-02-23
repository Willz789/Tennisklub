
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
            public $gruppe;
            
            
            function __construct($titel, $tekst, $image, $image_type, $gruppe) {
                $this->titel = $titel;
                echo($this->titel);
                $this->tekst = $tekst;
                $this->image = $image;
                $this->image_type = $image_type;
                $this->gruppe = $gruppe;
           
                $this->dato = date('d/m/Y');
                
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

                    echo("<p> Dato:{$this->dato}</p>");

                    echo("
                    <a class=\"link-opslag\" href=\"{./Forum.php}\">Mere information</a>
                
                </div>
                ");
                return true;
            }
        }

        class Turnering extends Information{
            public $min_alder;
            public $max_alder;

            function __construct($titel, $tekst, $image, $image_type, $min_alder, $max_alder){
                //passer de normale argumenter videre til basis konstruktøren
                $gruppe = null;
                parent::__construct($titel, $tekst, $image, $image_type, $gruppe);
                $this->min_alder = $min_alder;
                $this->max_alder = $max_alder;
                echo $this->min_alder;
                
            }


            function display() {
                $birthday = $_SESSION['birthday'];
                //del op i array hvor [0] er dag [1] måned og [2] årtals
                $birthday = explode("/",$birthday);
                
                //del nuværende dato for posten op i array på samme måde
                $dato_opdelt = explode("/", $this->dato);

                $alder = $dato_opdelt[2]-$birthday[2];
                echo($this->min_alder);
                echo("-");
                echo($this->max_alder);
                

                if ($dato_opdelt[1]==$birthday[1]){
                    if ($dato_opdelt[0]>$birthday[0]){
                        $alder = $alder-1;
                    }
                }elseif($dato_opdelt[1]<$birthday[1]){
                    $alder = $alder-1;
                }
                if (($alder>=$this->min_alder)&&($alder<=$this->max_alder)){
                    parent::display();
                    return true;
                }
                return false;
            }
            
        }

        class Event extends Information {
            function __construct($titel, $tekst, $image, $image_type, $gruppe){
                parent::__construct($this->titel, $this->tekst, $this->image, $this->image_type, $this->gruppe);
               
            }
    
            function display() {
                parent::display();
                return true;
            }

            function tilmeld() {

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