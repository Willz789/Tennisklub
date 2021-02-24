<?php

<<<<<<< Updated upstream
function gem_opslag($opslag){
            $opslag = serialize($opslag);
            $opslag = base64_encode($opslag);
            global $db;
            $insertSQL = "insert into information (opslag)
            values ('$opslag')";
=======


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
    public function display($opslag_id) {
        if($this->gruppe == -1 || (isset($_SESSION['user_id']) && $_SESSION['role'] >= $this->gruppe)){
            echo("
            <div class=\"opslagsbox\">
                <h1 class=\"titel\">{$this->titel}</h1>
                <p class=\"tekst\">{$this->tekst}</p>
                ");
>>>>>>> Stashed changes

            mysqli_query($db, $insertSQL);

        }

<<<<<<< Updated upstream
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
=======
                echo("<p> Dato:{$this->dato}</p>

            </div>
            ");
            return true;
        } else {
            return false;
>>>>>>> Stashed changes
        }

        class Turnering extends Information {

            function __contruct(){
                parent::__construct($this->titel, $this->tekst, $this->imagePath);
            }

<<<<<<< Updated upstream
            function display() {
                parent::display();
            }
        }
=======
    function display($opslag_id) {
        if(!isset($_SESSION['user_id'])){
            return false;
        } else {
            $birthday = $_SESSION['birthday'];
            // del op i array hvor [0] er dag, [1] er måned, og [2] er årtals
            $birthday = explode("/",$birthday);
            
            //del nuværende dato for posten op i array på samme måde
            $dato_opdelt = explode("/", $this->dato);
>>>>>>> Stashed changes

        class Event extends Information {
            function __contruct(){
                parent::__construct($this->titel, $this->tekst, $this->imagePath);
            }
<<<<<<< Updated upstream
    
            function display() {
                parent::display();
=======
            if (($alder>=$this->min_alder)&&($alder<=$this->max_alder)){
                if(parent::display($opslag_id) == true){
                    return true;
                } else {
                    return false;
                }
>>>>>>> Stashed changes
            }
        }

<<<<<<< Updated upstream
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
=======
class Event extends Information {
    function __construct($post_type, $titel, $tekst, $image, $image_type, $gruppe){
        parent::__construct($post_type, $titel, $tekst, $image, $image_type, $gruppe);
        
    }
    function display($opslag_id){
        global $db;

        if($this->gruppe == -1 || (isset($_SESSION['user_id']) && $_SESSION['role'] >= $this->gruppe)){
            echo("
            <div class=\"opslagsbox\">
                <h1 class=\"titel\">{$this->titel}</h1>
                <p class=\"tekst\">{$this->tekst}</p>
                ");

                if(isset($this->image)){
                    // Enable output buffering
                    ob_start();
                    echo($this->image);
                    // Capture the output
                    $imagedata = ob_get_contents();
                    // Clear the output buffer
                    ob_end_clean();

                    echo '<img src="data:'.$this->image_type.';base64,'.base64_encode($imagedata).'">';
                }

                echo("<p> Dato:{$this->dato}</p>
                <form method='POST'>");

                    if(isset($_SESSION['user_id'])){
                        if(array_key_exists('tilmeld-event', $_POST)) { 
                            $this->tilmeld($opslag_id); 
                        } 
                        else if(array_key_exists('frameld-event', $_POST)) { 
                            $this->frameld($opslag_id); 
                        }

                        $user_id = $_SESSION['user_id'];
                        $selectSQL = "SELECT * FROM `event_members` WHERE `opslag_id`='$opslag_id' AND `user_id`='$user_id';";
                        $result = mysqli_query($db, $selectSQL);
                        if(!$result){
                            die("Couldn't query select-statement.");
                        }
                        
                        if(mysqli_num_rows($result) == 0){
                            ?><input type="submit" name="tilmeld-event" class="tilmeld-event-button" value="Tilmeld"><?php
                        } else {
                            ?><input type="submit" name="frameld-event" class="frameld-event-button" value="Frameld"><?php
                        }
                    }
                echo "</form>
            </div>";
            return true;
        } else {
            return false;
        }
    }

    function tilmeld($opslag_id){
        global $db;
        $user_id = $_SESSION['user_id'];
        $insertSQL = "INSERT INTO `event_members`(`user_id`, `opslag_id`) VALUES (
            '$user_id',
            '$opslag_id'
        );";
        $result = mysqli_query($db, $insertSQL);
        if(!$result){
            die("Couldn't query insert-statement.");
        }
    }
    function frameld($opslag_id){
        global $db;
        $user_id = $_SESSION['user_id'];
        $deleteSQL = "DELETE FROM `event_members` WHERE `user_id`='$user_id' AND `opslag_id`='$opslag_id';";
        $result = mysqli_query($db, $deleteSQL);
        if(!$result){
            die("Couldn't query delete-statement.");
        }
    }
}
>>>>>>> Stashed changes

        ?>