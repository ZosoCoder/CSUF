<html>
	<head>
		<title>Login</title>
		<style type="text/css">
			.label {text-align: left}
			.error {color: red}
		</style>
	</head>
	<body>
		<h1>Login</h1>
		<form method="post" action="checklogin.php">	
			<table>
				<tr>
					<td class="label">Username:</td>
					<td><input type="text" name="username"></td>
				</tr>
				<tr>
					<td class="label">Password:</td>
					<td><input type="password" name="password"></td>
				</tr>
				<tr>
					<td class="label"> </td>
					<td align="right"><input type="submit" name="loginSubmit"></td>
				</tr>
			</table>
		</form>
		<br>
		
		<hr>
		<h1>Register</h1>
		<form method="post">	
			<table>
				<tr>
					<td class="label">Full Name:</td>
					<td><input type="text" name="fullName"></td>
				</tr>
				<tr>
					<td class="label">Username:</td>
					<td><input type="text" name="newUser"></td>
				</tr>
				<tr>
					<td class="label">Password:</td>
					<td><input type="password" name="newPass"></td>
				</tr>
				<tr>
					<td class="label">Confirm Password:</td>
					<td><input type="password" name="confirm"></td>
				</tr>
				<tr>
					<td class="label"> </td>
					<td align="right"><input type="submit" name="registerSubmit"></td>
				</tr>
			</table>
		</form>

		<?php
			if (isset($_POST['registerSubmit'])) {
				$link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die("Could not connect.");
				mysqli_select_db($link,"cs431s21") or die("No such database.");
				
				$fullName_len = strlen($_POST['fullName']);
				$user_len = strlen($_POST['newUser']);
				$pass_len = strlen($_POST['newPass']);
				$confirm_len = strlen($_POST['confirm']);


				if ($fullName_len > 0 && $user_len > 0 && $pass_len > 0 && $confirm_len > 0){
					$username = $_POST['newUser'];
					$user_check = "SELECT COUNT(*) AS count FROM USERS WHERE Username='$username'";
					$result = mysqli_query($link,$user_check);
					$user = mysqli_fetch_assoc($result);
					if ($user['count'] > 0) {
						echo "<div class='error'>The username you chose is not available.</div>";
					} else {
						$password = $_POST['newPass'];
						$confirm = $_POST['confirm'];
						if ($password == $confirm) {
							$add_user = "INSERT INTO USERS VALUES('".$_POST['fullName']."',".
										"'$username',Password('$password'))";
							mysqli_query($link,$add_user);
							echo "<div>Welcome $username. You have successfully registered and may now login!</div>";
						} else {
							echo "<div class='error'>Your passwords do not match.</div>";
						}
					}
				} else {
					if ($fullName_len == 0) {
						echo "<div class='error'>You must enter your full name.</div>";
					}
					if ($user_len == 0) {
						echo "<div class='error'>You must enter a a username.</div>";
					}
					if ($pass_len == 0) {
						echo "<div class='error'>You must enter a password.</div>";
					}
					if ($confirm_len == 0) {
						if ($pass_len > 0) {
							echo "<div class='error'>Your password confirmation does not match.</div>";
						}
					}
				}
			}
		?>
	</body>
</html>