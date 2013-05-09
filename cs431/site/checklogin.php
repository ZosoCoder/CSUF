<?php
	ob_start();
	$link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die("Could not connect.");
	mysqli_select_db($link,"cs431s21") or die("No such database.");

	$username = $_POST['username'];
	$password = $_POST['password'];
	$user_query = "SELECT * FROM USERS WHERE Username='".$username."' AND".
				  " Password=Password('".$password."')";
	$result = mysqli_query($link,$user_query);
	if (mysqli_num_rows($result) > 0) {
		session_register("username");
		session_register("password");
		header("location:user.php");
	} else {
		header("location:foo.html");
	}
	ob_end_flush();
?>