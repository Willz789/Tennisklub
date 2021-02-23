<!DOCTYPE html>
<html lang="en">
<?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
?>
<head>
	<link rel="stylesheet" href="./style/Stylesheet.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>  <!-- Tilføjer javascript-library "jqeury" -->
	<script src="./account/login.js" defer></script> <!-- Tilføjer javascript som kører efter dette script -->
</head>
<body>
<?php include("./navbar/Navbar.php"); // Indkluderer navbar
?>
<main>
	<div class="tekst" id="msg"></div> <!-- div til eventuelle fejlbeskeder -->
	
	<!-- container til login-felt -->
	<div class="login-container" id="login-form">
		<h1 class="titel"> Login </h1>
		<input type="text" class="login-input" id="username" placeholder = "Username" required>
		<input type="password" class="login-input" id="password" placeholder = "Password" required>
		<button type="submit" class="login-submit-button" id="submit">Login</button> <!-- Knap der starter login.js -->
	</div>
</main>

</body>
</html>
