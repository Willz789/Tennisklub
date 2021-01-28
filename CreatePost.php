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
        <!-- <script src="./createPost/createPost.js" defer></script> -->
    </head>
    <body>
        <?php include("./navbar/Navbar.php"); 
        include("Information_class.php");
        
        
        if(!isset($_SESSION['user_id'])){
            header("Location: ./Login.php");
        } else if($_SESSION['role']<2){
            header("Location: ./Home-Page.php");
        } else {
        
        ?>
            

            <form method="POST" action="CreatePost.php" enctype="multipart/form-data">
                <label for="titel">Titel:</label><br>
                <input type="text" id="titel" name="titel" placeholder="Required" required><br>
                <label for="tekst">Tekst:</label><br>
                <input type="text" id="tekst" name="tekst" placeholder="Required" required>

                <input type="file" id="image" name="image" accept="image/png, image/jpeg">

                <input type="submit" value="Submit" id="submit" name="submit">
            </form>
            

        <?php 
            if(isset($_POST['submit'])){
                $sqlSelect = "SELECT * FROM `information`";
                $result = mysqli_query($db, $sqlSelect);
                if(!$result){
                    die();
                } 

                // Generates a unique path for each image
                $newImagePath = $_FILES['image']['name'];
                $uniqueImagePath = "";
                $imageError = false;
                if($newImagePath != ""){
                    $uniqueImagePath = (string) rand(0,10000000);
                    $uniqueImagePath .= $newImagePath;
                    while(pathExists($uniqueImagePath, $result) == true){
                        $uniqueImagePath = (string) rand();
                        $uniqueImagePath .= $newImagePath;
                    }
                    $target = "images/".basename($uniqueImagePath);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        echo "<script type='text/javascript'>alert('Image uploaded succesfully');</script>";
                    }else{
                        $imageError = true;
                        echo "<script type='text/javascript'>alert('Failed to upload post');</script>";
                    }
                }
                
                if($imageError == false){
                    $text = mysqli_real_escape_string($db, $_POST['tekst']);
                    $title = mysqli_real_escape_string($db, $_POST['titel']);
                    $newOpslag = new Information($title, $text, $uniqueImagePath);
                    gem_opslag($newOpslag);
                }

            }
        }

        function pathExists($newPath, $result){
            while($row = mysqli_fetch_array($result)){
                extract($row);
                $opslag1 = base64_decode($row['opslag']);
                $opslag2 = unserialize($opslag1);
                if($opslag2->imagePath == $newPath){
                    return true;
                }
            }
            return false;
        }
        ?> 
    </body>
</html>