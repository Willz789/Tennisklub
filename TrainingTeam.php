<!DOCTYPE html>
<html lang="en">
<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
?>
<head>
    <link rel="stylesheet" href="./style/Stylesheet.css">
    <link rel="stylesheet" href="./style/Training.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Training</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
</head>
<body>
<?php include("./navbar/Navbar.php"); // Indkluderer navbar
?>
<main>
	<div class="team-members-div">
		<table class="team-members-table"> <!-- Tabel med informationer omkring holdet -->
            <tr class="team-members-row">
                <td class="team-members-table-title" style="font-weight: bold;" colspan="3">Team-members</td>
            </tr>
            <?php
           
                // Henter information omkring holdet fra php-scriptet "Training.php".
                $team_id = $_POST['team_id'];
                $team_name = $_POST['team_name'];
                $coach_id = $_POST['coach_id'];
                $minBirthYear = $_POST['minBirthYear'];

                // Finder informationer omkring coachen på holdet ud fra hans id.
                $selectSQL = "SELECT * FROM `users` WHERE id='$coach_id';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die("Couldn't select users");
                }
                if(mysqli_num_rows($result) != 1){
                    die("Wrong coach-count");
                } else {
                    $row = mysqli_fetch_assoc($result);
                    ?>
                        <!-- Række i tabellen som indeholder trænerens navn -->
                        <tr class="team-members-row">
                            <td class="team-members-row-title">Trainer</td>
                            <td colspan="2" class="team-members-row-data"><?php echo $row['name']; ?></td>
                        </tr>
                    <?php
                }
            ?>
            <?php
                // Finder alle id til elever på holdet.
                $selectSQL = "SELECT `user_id` FROM `team_members` WHERE `team_id`='$team_id';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die("Couldn't query selector");
                }
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['user_id'];

                    // For hvert id finder vi en elev, som derefter finder vi elevens navn og fødselsdag.
                    $selectSQL = "SELECT * FROM `users` WHERE id='$id';";
                    $resultUser = mysqli_query($db, $selectSQL);
                    if(!$resultUser){
                        die("Couldn't query selector");
                    }
                    if(mysqli_num_rows($resultUser) != 0){
                        $rowUser = mysqli_fetch_assoc($resultUser);
                        $name = $rowUser['name'];
                        $birthday = $rowUser['birthday'];
                        ?>
                        <!-- Tilføjer en række for hver elev, hvor der står navn og fødselsdag -->
                        <tr class="team-members-row">
                            <td class="team-members-row-title">Student</td>
                            <td class="team-members-row-data"><?php echo $name; ?></td>
                            <td class="team-members-row-data"><?php echo $birthday; ?></td>
                        </tr>
                        <?php
                    }
                }

            ?>
        </table>
        <?php
        // Hvis man er logget ind, så skal man kunne tilmelde sig holdet.
            if(isset($_SESSION['user_id'])){
                $myBirthYear = substr($_SESSION['birthday'],6);
                $user_id = $_SESSION['user_id'];
                $selectSQL = "SELECT * FROM `team_members` WHERE team_id='$team_id' AND `user_id`='$user_id';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die("Couldn't query selector");
                }
                // Man skal kun kunne tilmelde sig, hvis man ikke allerede er på holdet, eller er træner, eller er for gammel.
                if(mysqli_num_rows($result) == 0 && $myBirthYear >= $minBirthYear && $user_id != $coach_id){
                    ?>
                        <!-- form med en knap der tilmelder en til holdet -->
                        <form action="./Teams/JoinTeam.php" method="POST">
                            <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="submit" class="join-team-button" value="Join Team">
                        </form>
                    <?php
                }

                // Hvis man allerede er på holdet, og man ikke er træner, så skal man kunne framelde sig holdet.
                if(mysqli_num_rows($result) == 1 && $user_id != $coach_id){
                    ?>
                        <!-- form med knap der framelder en fra holdet. -->
                        <form action="./Teams/LeaveTeam.php" method="POST">
                            <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="submit" class="leave-team-button" value="Leave Team">
                        </form>
                    <?php
                }
        }
        ?>
	</div>
</main>

</body>
</html>
