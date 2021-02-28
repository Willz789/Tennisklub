
<!DOCTYPE html>
<html lang="en">
    <?php
        session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
        require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
    ?>

    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
    </head>
    <body>
        <?php include("./navbar/Navbar.php"); // Indkluderer navbar.
        ?>
        <!-- Liste med medlemmer i klubben -->
        <div class="members" style="border: 2px solid black">
            <?php
            if(isset($_SESSION['user_id'])){
                ?>
                <h1 class="titel">Members</h1>
                <ul class="member-list">
                    <?php
                    // Vælger alle brugere i databasen.
                    $selectSQL = "SELECT * FROM `users`;";
                    $result = mysqli_query($db, $selectSQL);
                    if(!$result){
                        die("Couldn't select users");
                    }
                    while($row = mysqli_fetch_assoc($result)){
                        extract($row); // Skaber variablerne fra rækken i databasen.
                        $role = generateRole($row['role']); // Funktion der omdanner rolle fra tal til String
                        ?>
                        <!-- Liste med informationer om hver bruger, fx kontaktinformationer, som vises når musen holdes over navnet. -->
                        <li class="member-row"><?php echo $row['name']; ?>
                            <div class="member-info">
                                <p class="titel" style="font-size:medium"><?php echo $row['name']; ?></p>
                                <p class="tekst"><?php echo "Phonenumber: $phonenumber" ?></p>
                                <p class="tekst"><?php echo "Mail: $mail" ?></p>
                                <p class="tekst"><?php echo "Role: $role" ?></p>
                                <p class="tekst"><?php echo "Ranked Points: $ranking_points" ?></p>
                                <p class="tekst"><?php echo "Birthday: $birthday" ?></p>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php 
                // Hvis man er admin, så er der et import-link som autogenerere nogle brugere til databasen.
                if($_SESSION['role'] == 2){
                    echo("<a href=\"./Import.php\">Import Users</a>");
                }
            } else {
                ?>
                <p class="tekst">Sign in to see list of members</p>
                <?php
            }
            ?>
        </div>
        <?php
        // Funktion der omdanner rolle fra int til string.
        function generateRole($roleInt){
            switch($roleInt){
                case 0:
                    return "Member";
                case 1:
                    return "Trainer";
                case 2:
                    return "Admin";
            }
        }
        ?>
    </body>
</html>