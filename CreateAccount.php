<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
?>
<head>
	<link rel="stylesheet" href="./style/Stylesheet.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign up</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
	<script src="./account/createAccount.js" defer></script>
</head>
<body>
<?php include("./navbar/Navbar.php"); ?>
<main>
	<div id="login-form" class="login-container">
		<h1> Create account </h1>
        <input type="text" id="name" class="login-input" placeholder = "Write your name" required>
		<input type="text" id="username" class="login-input" placeholder = "Username" required>
		<input type="password" id="password" class="login-input" placeholder = "Password" required>
        <input type="password" id="confirm_password" class="login-input" placeholder = "Confirm Password" required>
        <input type="number" id="phonenumber" class="login-input" placeholder = "phonenumber" required>
        <input type="text" id="mail" class="login-input" placeholder = "mail" required>
		<div id="logi-_birthday-form" class="login-birthday-container">
			<label for="birthday">Birthday</label>
			<input type="number" id="birthDay" placeholder = "day" required>
			<input type="number" id="birthMonth" placeholder = "month" required>
			<input type="number" id="birthYear" placeholder = "year" required>
		</div>
		<button type="submit" id="submit" class="button-signup">Sign up</button>
	</div>

	<p id="msg" style="color: red"></p>
</main>

</body>
</html>

