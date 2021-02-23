<!DOCTYPE html>
<html lang="en">
<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
?>
<head>
    <link rel="stylesheet" href="./style/Stylesheet.css">
    <link rel="stylesheet" href="./style/Training.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create Team</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
    <script src="./Teams/AddNewTeam.js" defer></script> <!-- Tilføjer javascript som kører efter dette script -->
</head>
<body>
<?php include("./navbar/Navbar.php"); // Indkluderer navbar.
?>
<main>	
	<!-- Container til input-felter til opretning af hold -->
	<div class="create-team-container">
		<h1 class="titel"> Create account </h1>
        <input type="text" id="name" class="create-team-input" placeholder="Team name" required>
		<input type="Number" id="minBirthYear" class="create-team-input" placeholder="Minimum birthyear" required>
		<button type="submit" id="submit" class="button-create-team">Create team</button>
	</div>

	<p class="tekst" id="msg" style="color: red"></p> <!-- div til eventuelle fejl til brugeren. -->
</main>

</body>
</html>

