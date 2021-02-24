
<?php

// Funktion der gemmer opslag til forummet i database som BLOB
function gem_opslag($opslag){
    global $db;

    // php-objekt bliver omkodet til BLOB-element der kan indsættes i database.
    // BLOB er smart, fordi det kan indeholde billeder, hvilket betyder at man kan gemme billeder i databasen.
    $opslag = serialize($opslag);
    $opslag = base64_encode($opslag);
    
    // Indsætter opslag i databasen.
    $insertSQL = "INSERT INTO `information` (`opslag`) VALUES ('$opslag')";
    $result = mysqli_query($db, $insertSQL);
    if(!$result){
        die("Couldn't query insert-statement");
    }
}

// parent-klasse til opslag.
class Information {
    public $titel;
    public $tekst;
    public $image;
    public $image_type;
    public $gruppe;
    public $post_type;

    // Klassens constructor.
    function __construct($post_type, $titel, $tekst, $image, $image_type, $gruppe) {
        $this->titel = $titel;
        $this->tekst = $tekst;
        $this->image = $image;
        $this->image_type = $image_type;
        $this->gruppe = $gruppe;
        $this->post_type = $post_type;
    
        $this->dato = date('d/m/Y');
        
    }

    // Display-funktion der viser opslaget på forummet.
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
            </div>
            ");
            return true;
        
    }
}

class Turnering extends Information{
    public $min_alder; // Nye variabler som kun gælder for turneringer.
    public $max_alder;

    function __construct($post_type, $titel, $tekst, $image, $image_type, $gruppe, $min_alder, $max_alder){
        //passerer de normale argumenter videre til basis konstruktøren
        $gruppe = null;
        parent::__construct($post_type, $titel, $tekst, $image, $image_type, $gruppe); // Kører parent-constructor
        $this->min_alder = $min_alder;
        $this->max_alder = $max_alder;
    }

    function display() {
        if(!isset($_SESSION['user_id'])){
            return false;
        } else {
            $birthday = $_SESSION['birthday'];
            // del op i array hvor [0] er dag, [1] er måned, og [2] er årtals
            $birthday = explode("/",$birthday);
            
            //del nuværende dato for posten op i array på samme måde
            $dato_opdelt = explode("/", $this->dato);

            // Opslaget skal kun vises, hvis brugeren er inde i aldersgruppen for turneringen.
            $alder = $dato_opdelt[2]-$birthday[2];
            if ($dato_opdelt[1]==$birthday[1]){
                if ($dato_opdelt[0]>$birthday[0]){
                    $alder = $alder-1;
                }
            } elseif ($dato_opdelt[1]<$birthday[1]){
                $alder = $alder-1;
            }
            if (($alder>=$this->min_alder)&&($alder<=$this->max_alder)){
                if(parent::display() == true){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}

class Event extends Information {
    function __construct($post_type, $titel, $tekst, $image, $image_type, $gruppe){
        parent::__construct($post_type, $titel, $tekst, $image, $image_type, $gruppe);
        
    }

    function display(){
        if(parent::display() == true){
            return true;
        } else {
            return false;
        }
    }

    function tilmeld(){
        
    }
}

?>