<html>
    <?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
    ?>
    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forum</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
    </head>
    <body>
        <?php include("./navbar/Navbar.php"); // Indkludere navbar
        include("Information_class.php"); // Indkluderer script med klasser og underklasser.

        // Funktion der skalerer billedet fra filen "$file".
        function scaleImage($file) {

            $source_pic = $file; 
            $max_width = 400;
            $max_height = 400;

            list($width, $height, $image_type) = getimagesize($file); // Skaber variabler med størrelsen og typen af billedet

            // Skaber sourcen til billedet.
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
            } else {
                if ($height < $width){
                    $ratio = $max_width / $width;
                }else{$ratio = $max_height / $height;}

                $tn_width = $width*$ratio;
                $tn_height = $height*$ratio;
                    
            }
            //lav et nyt blank billede i den skalerede størrelse
            $tmp = imagecreatetruecolor($tn_width,$tn_height);

            //Check om billede er gif eller png, og set transperens hvis det er tilfældet.
            if(($image_type == 1) OR ($image_type==3))
            {
                imagealphablending($tmp, false);
                imagesavealpha($tmp,true);
                $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
                imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
            }
            imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

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

        // Tjekker at man er logget ind som træner eller admin.
        if(!isset($_SESSION['user_id'])){ 
            header("Location: ./Login.php");
        } else if($_SESSION['role'] == 0){
            header("Location: ./Home-Page.php");
        } else {
        ?>

        <!-- Form med input felter afhængigt af, hvilken type opslag man vil lægge på forummet. -->
        <form action="" autocomplete="off" enctype="multipart/form-data" method="POST">
            <label for="titel">Title:</label><br>
            <input type="text" id="titel" name="titel"><br>
            <label for="tekst">Text:</label><br>
            <textarea rows = "5" cols = "60" name = "tekst" class= "text"></textarea><br>
            <label for="tekst">type of post:</label><br>
            <select id="opslags_type" name="opslags_type" onchange="changeform()">
                <option value="Generel information">General information</option>
                <option value="Event">Event</option>
                <option value="Turnering">Turnament</option>
                <option value="Træner_Information">Coach Information</option>
            </select><br>

            <!-- Min_alder og Max_alder skal kun tilføjes for turnerings-opslag. -->
            <label class="turnerings_opslag" for="tekst">Minimum age:</label><br class="turnerings_opslag">
            <input type="number" name="min_alder" class="turnerings_opslag" min="5" max="99"><br class="turnerings_opslag"> 
            <label class="turnerings_opslag" for="tekst">Maximum age:</label><br class="turnerings_opslag">
            <input type="number" name="max_alder" class="turnerings_opslag" min="5" max="99"> <br>
            <!-- Gruppen som kan se opslaget er ikke tilgængelig at vælge for træneropslag og turneringsopslag. -->
            <label class="informations_opslag event_opslag" for="tekst">Gruppe:</label><br class="informations_opslag event_opslag">
            <select class="informations_opslag event_opslag" name="gruppe" onchange="changeform()">
                <option value="-1">Everyone</option>
                <option value="0">Members</option>
                <option value="1">Coaches</option>
                <option value="2">Administration</option>
            </select>
            <br>
            <br>
            <!-- Input felt til image-fil (Behøves ikke tilføjes)-->
            <label for="tekst">Image (not required):</label><br>
            <input type="file" id="billede" name="billede" accept="image/png, image/jpeg">
            <input type="submit" value="Submit" name="submit">
        </form>

        <script>
        changeform();

            // Funktion der ændrer layoutet på siden, hver gang man ændrer opslagstypen.
            function changeform(){
                var opslags_type = document.getElementById('opslags_type').value;
                console.log(opslags_type);
                var turnering = document.getElementsByClassName("turnerings_opslag");
                var event = document.getElementsByClassName("event_opslag");
                var information = document.getElementsByClassName("informations_opslag");
                var træner_information = document.getElementsByClassName("træner_information_opslag");

                for (i = 0; i < turnering.length; i++) {
                    turnering[i].style.display = "none";
                }
                for (i = 0; i < event.length; i++) {
                    event[i].style.display = "none";
                }
                for (i = 0; i < træner_information.length; i++) {
                    træner_information[i].style.display = "none";
                }
                for (i = 0; i < information.length; i++) {
                    information[i].style.display = "none";
                }

                switch(opslags_type) {
                    case "Generel information":
                        for (i = 0; i < information.length; i++) {
                            information[i].style.display = "inline";
                        }
                        break;
                        
                    case "Event":
                        for (i = 0; i < event.length; i++) {
                            event[i].style.display = "inline";
                        }
                        break;

                    case "Turnering":
                        for (i = 0; i < turnering.length; i++) {
                            turnering[i].style.display = "inline";
                        }
                        break;

                    case "Træner_Information":
                        for (i = 0; i < træner_information.length; i++) {
                            træner_information[i].style.display = "inline";
                        }
                        break;
                }
            }
            </script>
        <?php 
            if(isset($_POST['submit'])){ // Når submit-knappen trykkes på, så postes opslaget.

                // Henter data fra input-felterne.
                $titel = $_REQUEST["titel"];
                $tekst = $_REQUEST["tekst"];
                $opslags_type = $_REQUEST["opslags_type"];
                $gruppe = $_REQUEST["gruppe"];
                $min_alder = $_REQUEST["min_alder"];
                $max_alder = $_REQUEST["max_alder"];
                $billedesrc = $_FILES["billede"]["tmp_name"];
                
                // Hvis der ikke er tilføjet en billedefil, så skal den være null.
                if($billedesrc!=null){
                    $img = scaleImage($billedesrc);
                    $image_type = getimagesize($billedesrc)["mime"];
                }else{
                    $img = null;
                    $image_type = null;
                }

                // Afhængigt af opslags-typen skal der skabes et nyt objekt.
                // "Event", "Turnering" og "Træner_information" er subklasser til "Information.
                switch ($opslags_type){
                    case "Generel information":
                        $post_type = 0;
                        $nyt_opslag = new Information($post_type, $titel, $tekst, $img, $image_type, $gruppe);
                        break;
                    case "Event":
                        $post_type = 1;
                        $nyt_opslag = new Event($post_type, $titel, $tekst, $img, $image_type, $gruppe);
                        break;
                    case "Turnering":
                        $post_type = 2;
                        $gruppe = -1;
                        $nyt_opslag = new Turnering($post_type, $titel, $tekst, $img, $image_type, $gruppe, $min_alder, $max_alder);
                        break;
                    case "Træner_Information":
                        $post_type = 3;
                        $gruppe = 1;
                        $nyt_opslag = new Træner_information($post_type, $titel, $tekst, $img, $image_type, $gruppe);
                        break;
                }
                gem_opslag($nyt_opslag); // Funktion i scriptet "Information_class.php" som gemmer objekt i database som BLOB.
            }
        } 
        ?>
    </body>
</html>