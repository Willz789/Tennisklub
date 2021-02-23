<!DOCTYPE html>
<html lang="en">
    <?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
    ?>
    <head>
        <link rel="stylesheet" href="./style/Stylesheet.css"> <!-- Stylesheet -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assign role</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
        <script src="./assignRole/assignRole.js" defer></script> <!-- Hører javascript efter dette script -->
    </head>
    <body>
        <?php include("./navbar/Navbar.php"); // Indkludere navbar
        // Tjekker om er logget ind som admin.
        if(!isset($_SESSION['role'])){
            header("Location: ./Home-Page.php");
        } else if ($_SESSION['role'] != 2){
            header("Location: ./Home-Page.php");
        } else {
            ?>
            <!-- Input, hvor man vælger brugeren hvis rolle skal ændre, dit eget password, og den rolle som brugeren skal have -->
            <h1 class="titel">Assign Role</h1>
            <input type="text" id="username" class="assign-role-username" placeholder = "Their username" required>
            <input type="password" id="password" placeholder = "Your password" required>
            <label for="label-new-role">Their new role: </label>
            <select id="select-new-role">
                <option value="0">Member</option>
                <option value="1">Trainer</option>
                <option value="2">Administrator</option>
            </select>
            <button type="submit" id="submit">Assign Role</button>
            <?php
        }
        ?>
    </body>
</html>