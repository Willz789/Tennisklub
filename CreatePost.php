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

  

function scaleImage($file) {

    $source_pic = $file;
    $max_width = 400;
    $max_height = 400;

    list($width, $height, $image_type) = getimagesize($file);

    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($file); break;
        case 2: $src = imagecreatefromjpeg($file);  break;
        case 3: $src = imagecreatefrompng($file); break;
        default: return '';  break;
    }



    //skaler billeder afhængigt af størrelse
    //chek først om billede allerede er inden for den acceptable størrelse
    if( ($width <= $max_width) && ($height <= $max_height) ){
        $tn_width = $width;
        $tn_height = $height;
        //hvis ikke check hvilken parameter der størst og skaler, så den største af dem kun er lig med det maksimale
    }else{
        if ($height < $width){
            $ratio = $max_width / $width;
        }else{$ratio = $max_height / $height;}

        $tn_width = $width*$ratio;
        $tn_height = $height*$ratio;
            
    }
    //lav et nyt blank billede i den scalerede størrelse
    $tmp = imagecreatetruecolor($tn_width,$tn_height);

    //Check om billede er gif eller png, og set transperens hvis det er tilfældet.
    if(($image_type == 1) OR ($image_type==3))
    {
        imagealphablending($tmp, false);
        imagesavealpha($tmp,true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
    }
    //
    imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

    /*
     * imageXXX() only has two options, save as a file, or send to the browser.
     * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
     * So I start the output buffering, use imageXXX() to output the data stream to the browser,
     * get the contents of the stream, and use clean to silently discard the buffered contents.
     */
    ob_start();
    //output billede afhængigt af typen
    switch ($image_type)
    {
        case 1: imagegif($tmp); break;
        case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
        case 3: imagepng($tmp, NULL, 0); break; // no compression
        default: echo ''; break;
    }

    $final_image = ob_get_contents();

    ob_end_clean();
    //returner færdige output billede
    return $final_image;
}
        if(!isset($_SESSION['user_id'])){
            header("Location: ./Login.php");
        } else if($_SESSION['role']<2){
            header("Location: ./Home-Page.php");
        } else {
        ?>
        <form  action="" autocomplete="off" enctype="multipart/form-data" method="POST">
            <label for="titel">Titel:</label><br>
            <input type="text" id="titel" name="titel"><br>
            <label for="tekst">Tekst:</label><br>
            <textarea rows = "5" cols = "60" name = "tekst" class= "text"></textarea><br>
            <label for="tekst">Type opslag:</label><br>
            <select id="opslags_type" name="opslags_type" onchange="changeform()">
                <option value="Generel information">Generel information</option>
                <option value="Event">Event</option>
                <option value="Turnering">Turnering</option>
            </select><br>
            <label class="turnerings_opslag" for="tekst">Minimums alder:</label><br class="turnerings_opslag">
            <input type="number" name="min_alder" class="turnerings_opslag" min="5" max="99"><br class="turnerings_opslag"> 
            <label class="turnerings_opslag" for="tekst">Max alder:</label><br class="turnerings_opslag">
            <input type="number" name="max_alder" class="turnerings_opslag" min="5" max="99"> <br>
            

            <label class="informations_opslag event_opslag" for="tekst">Gruppe:</label><br class="informations_opslag event_opslag">
            <select class="informations_opslag event_opslag" name="Gruppe" onchange="changeform()">
                <option value="Alle">Alle</option>
                <option value="Medlemmer">Medlemmer</option>
                <option value="Trænere">Trænere</option>
                <option value="Administration">Administration</option>
            </select>
            <br>
            <br>

            <label for="tekst">Billede(ikke påkrævet):</label><br>
            <input type="file" id="billede" name="billede" accept="image/png, image/jpeg">

            <input type="submit" value="Submit" name="submit">
        </form>


        <script>
        changeform();
            function changeform(){
                var opslags_type = document.getElementById('opslags_type').value;
                console.log(opslags_type);
                var turnering = document.getElementsByClassName("turnerings_opslag");
                var event = document.getElementsByClassName("event_opslag");
                var information = document.getElementsByClassName("informations_opslag");

                switch(opslags_type) {
                case "Generel information":
                    for (i = 0; i < turnering.length; i++) {
                        turnering[i].style.display = "none";
                    }
                    for (i = 0; i < event.length; i++) {
                        event[i].style.display = "none";
                     }
                    for (i = 0; i < information.length; i++) {
                        information[i].style.display = "inline";
                    }
                    
                break;
                case "Event":
                    for (i = 0; i < turnering.length; i++) {
                        turnering[i].style.display = "none";
                    }
                    for (i = 0; i < information.length; i++) {
                        information[i].style.display = "none";
                    }
                    for (i = 0; i < event.length; i++) {
                        event[i].style.display = "inline";
                     }
                    
                break;
                case "Turnering":
                    
                    for (i = 0; i < event.length; i++) {
                        event[i].style.display = "none";
                     }
                    for (i = 0; i < information.length; i++) {
                        information[i].style.display = "none";
                    }
                    for (i = 0; i < turnering.length; i++) {
                        turnering[i].style.display = "inline";
                    }
                }
            }
            </script>


        <?php 
            if(isset($_POST['submit'])){
                $titel = $_REQUEST["titel"];
                $tekst = $_REQUEST["tekst"];
                $opslags_type = $_REQUEST["opslags_type"];

                $billedesrc = $_FILES["billede"]["tmp_name"];
                
                if($billedesrc!=null){
                   
                    
                    $img = scaleImage($billedesrc);
                    $image_type = getimagesize($billedesrc)["mime"];
                }else{
                    $img = null;
                    $image_type = null;
                }

                switch ($opslags_type){
                    case "Generel information":
                        $nyt_opslag =  new Information($titel, $tekst, $img, $image_type);
                    break;
                    case "Event":
                        $nyt_opslag =  new Event($titel, $tekst, $img, $image_type);
                    break;
                    case "Turnering":
                        $nyt_opslag =  new Turnering($titel, $tekst, $img, $image_type);
                    break;
                }

               gem_opslag($nyt_opslag);




            }
} ?>

    </body>
</html>