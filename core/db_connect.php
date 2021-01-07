<?php
	$db = mysqli_connect("localhost:3306", "root", "", "tennis_club");
	if(mysqli_connect_errno($db) > 0) {
		die("Unable to connect to database: " . mysqli_connect_error($db));
	}
?>