<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    require_once("./core/db_connect.php");
?>
<head>
    <link rel="stylesheet" href="./style/Stylesheet.css">
    <link rel="stylesheet" href="./style/Training.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Training</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
</head>
<body>
<?php include("./navbar/Navbar.php"); ?>
<main>
	<div class="team-members-div">
		<table class="team-members-table">
            <tr class="team-members-row">
                <td class="team-members-table-title" style="font-weight: bold;" colspan="3">Team-members</td>
            </tr>
            <?php
           
                $team_id = $_POST['team_id'];
                $team_name = $_POST['team_name'];
                $coach_id = $_POST['coach_id'];
                $minBirthYear = $_POST['minBirthYear'];

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
                        <tr class="team-members-row">
                            <td class="team-members-row-title">Trainer</td>
                            <td colspan="2" class="team-members-row-data"><?php echo $row['name']; ?></td>
                        </tr>
                    <?php
                }
            ?>
            <?php
                $selectSQL = "SELECT `user_id` FROM `team_members` WHERE `team_id`='$team_id';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die("Couldn't query selector");
                }
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['user_id'];
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
                        <tr class="team-members-row">
                            <td class="team-members-row-title">Student</td>
                            <td class="team-members-row-data"><?php echo $name; ?></td>
                            <td class="team-members-row-data"><?php echo $birthday; ?></td>
                        </tr>
                        <?php
                    }
                }

                while($row = mysqli_fetch_assoc($result)){
                    extract($row);
                    $name = $row['name'];
                    $birthday = $row['birthday'];
                    ?>
                    <tr class="member-row">
                        <td class="team-members-row-title">Student</td>
                        <td class="team-members-row-data"><?php echo $name; ?></td>
                        <td class="team-members-row-data"><?php echo $birthday; ?></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        <?php
            if(isset($_SESSION['user_id'])){
                $myBirthYear = substr($_SESSION['birthday'],6);
                $user_id = $_SESSION['user_id'];
                $selectSQL = "SELECT * FROM `team_members` WHERE team_id='$team_id' AND `user_id`='$user_id';";
                $result = mysqli_query($db, $selectSQL);
                if(!$result){
                    die("Couldn't query selector");
                }
                if(mysqli_num_rows($result) == 0 && $myBirthYear >= $minBirthYear && $user_id != $coach_id){
                    ?>
                        <form action="./Teams/JoinTeam.php" method="POST">
                            <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="submit" class="join-team-button" value="Join Team">
                        </form>
                    <?php
                }

                if(mysqli_num_rows($result) == 1 && $user_id != $coach_id){
                    ?>
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
