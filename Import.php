<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
?>
<head>
    <link rel="stylesheet" href="./style/Stylesheet.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Import</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
</head>
<body>
<?php include("./navbar/Navbar.php"); ?>
<main>	
    <?php
    if(isset($_SESSION['user_id']) && $_SESSION['role'] == 2){ ?>
	<div class="import-users-container">
        <form action="./Import/generateNames.php" method="POST">
            <h1 class="titel"> Import </h1>
            <label class="tekst" for="submit-import-users">No more than 3 at a time (due to subscription)</label>
            <input type="Number" name="totalNames" class="total-names-input" placeholder="Amount of names" required>
            <button type="submit" name="submit-import-users" id="submit" class="button-import-users">Import users</button>
        </form>
    </div>
	<p class="tekst" id="msg" style="color: red"></p>
    <br>
    <a href="./Import/import.php">Import Excel file</a>
    <?php
    } else {
        header("Location: ./Home-Page.php");
        exit();
    }
    ?>

</main>

</body>
</html>

