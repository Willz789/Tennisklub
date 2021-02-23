
<!DOCTYPE html>
<html lang="en">
    <?php
        session_start();
        require_once("core/db_connect.php");
    ?>

    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    </head>
    <body>
        <?php include("./navbar/Navbar.php");?>
        <div class="members" style="border: 2px solid black">
            <h1 class="titel">Medlemsliste</h1>
            <ul class="member-list">
                <?php
                $selectSQL = "SELECT * FROM `users`;";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die("Couldn't select users");
                }
                while($row = mysqli_fetch_assoc($result)){
                    extract($row);
                    $role = generateRole($row['role']);
                    ?>
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
            if(isset($_SESSION['user_id']) && $_SESSION['role'] == 2){
                echo("<a href=\"./Import.php\">Import Users</a>");
            }
            ?>
        </div>
        <?php
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