<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
?>
<head>
<link rel="stylesheet" href="./style/Stylesheet.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
	<script src="./account/createAccount.js" defer></script>
</head>
<body>

<main>
	<div id="msg"></div>
	
	<div id="login_form">
		<h1> Create account </h1>
        <input type="text" id="name" placeholder = "Write your name" required>
		<input type="text" id="username" placeholder = "Username" required>
		<input type="password" id="password" placeholder = "Password" required>
        <input type="password" id="confirm_password" placeholder = "Confirm Password" required>
        <input type="number" id="phonenumber" placeholder = "phonenumber" required>
        <input type="text" id="mail" placeholder = "mail" required>
        <label for="birthday">Birthday</label>
        <input type="number" id="birthDay" placeholder = "day" required>
        <input type="number" id="birthMonth" placeholder = "month" required>
        <input type="number" id="birthYear" placeholder = "year" required>
		<button type="submit" id="submit">Login</button>
	</div>
</main>

</body>
</html>

