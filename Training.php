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
<?php include("./navbar/Navbar.php"); // Indkluderer navbar.
?>
<main>
	<div class="teams-div" id="teams-div">
        <h1 class="titel">Teams:</h1>
		<ul class="teams-list"> <!-- Liste med hold -->
            <?php
            // For hvert hold laves de som en knap, som leder til information omkring holdet på scriptet "TrainingTeam.php".
            $selectSQL = "SELECT * FROM `teams`;";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die("Couldn't query teams.");
            }
            while($row = mysqli_fetch_assoc($result)){
                // Henter information omkring holdet
                $team_id = $row['id'];
                $name = $row['name'];
                $coach_id = $row['trainer_user_id'];
                $minBirthYear = $row['minBirthYear'];
                ?>
                <li class="team-row">
                    <form action="./TrainingTeam.php" method="POST">
                        <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
                        <input type="hidden" name="team_name" value="<?php echo $name; ?>">
                        <input type="hidden" name="coach_id" value="<?php echo $coach_id; ?>">
                        <input type="hidden" name="minBirthYear" value="<?php echo $minBirthYear; ?>">
                        <input type="submit" class="team-list-button" value="<?php echo $name; ?>"> <!-- Knap der leder til information omkring holdet -->
                    </form>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
        if(isset($_SESSION['user_id']) && $_SESSION['role'] > 0)
            echo("<a href=\"./CreateTeam.php\" class=\"tekst\">Create new team</a>");
        ?>
	</div>
</main>

</body>
</html>
