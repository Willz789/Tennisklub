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
	<script src="./account/login.js" defer></script>
</head>
<body>

<main>
	<div id="msg"></div>
	
	<div id="login_form">
		<h1> Login </h1>
		<input type="text" id="username" placeholder = "Username" required>
		<input type="password" id="password" placeholder = "Password" required>
		<button type="submit" id="submit">Login</button>
	</div>
</main>

</body>
</html>
