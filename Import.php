<!DOCTYPE html>
<html lang="en">
<?php
    session_start();  // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
?>
<head>
    <link rel="stylesheet" href="./style/Stylesheet.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Import</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>  <!-- Tilføjer javascript-library "jqeury" -->
</head>
<body>
    <?php include("./navbar/Navbar.php"); // Indkludere navbar
    ?>
    <main>	
        <?php
        // Indhold skal kun vises, hvis man er admin, eller bliver man flyttet til Home-Page.php.
        if(isset($_SESSION['user_id']) && $_SESSION['role'] == 2){ ?>
            <!-- Container med input-felt til antal brugere man vil generere -->
            <div class="import-users-container">
                <form action="./Import/generateNames.php" method="POST">
                    <h1 class="titel"> Import </h1>
                    <label class="tekst" for="submit-import-users">No more than 3 at a time (due to subscription)</label> <!-- Abbonementet på api'en tillader ikke flere end 3 ad gangen -->
                    <input type="Number" name="totalNames" class="total-names-input" placeholder="Amount of names" required>
                    <button type="submit" name="submit-import-users" id="submit" class="button-import-users">Import users</button>
                </form>
            </div>
            <p class="tekst" id="msg" style="color: red"></p> <!-- div til eventuelle fejlbeskeder -->
            <br>
            <a href="./Import/import.php">Import csv-file</a> <!-- Link til php-script der importet 10 brugere fra csv-fil. -->
            <?php
        } else {
            header("Location: ./Home-Page.php");
            exit();
        }
        ?>
    </main>

</body>
</html>

