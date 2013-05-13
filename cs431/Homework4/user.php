<?php
	session_start();
	if (!session_is_registered(username)) {
		header("location:home.php");
	}
	$link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
	mysqli_select_db($link,"cs431s21") or die(mysqli_error());
?>
<html>
	<head>
		<title><?php echo $_SESSION['username']; ?></title>
		<style type="text/css">
			.form {margin-left: 40px}
			.tablelabel {text-align: right;
						font-weight: bold;}
			.label {font-weight: bold;}
		</style>
	</head>
	<body>
		<h1>Upload</h1>
		<!-- Upload pictures -->
		<form method="post" enctype="multipart/form-data">
			<!--<input name="MAX_FILE_SIZE" value="102400" type="hidden">-->
			<table class="form">
				<tr>
					<td class="tablelabel">File:</td>
					<td><input type="file" name="image"></td>
				</tr>
				<tr>
					<td class="tablelabel">Name:</td>
					<td><input type="text" name="fileName"></td>
				</tr>
				<tr>
					<td class="tablelabel">Caption:</td>
					<td><input type="text" name="caption"></td>
				</tr>
				<tr>
					<td class="tablelabel"> </td>
					<td align="right"><input type="submit" name="fileUpload" value="Upload"></td>
				</tr>
			</table>
		</form>
		<?php
			if (isset($_POST['fileUpload'])) {
				if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
					//Get post data
					$filename = $_POST['fileName'];
					$mimetype = $_FILES['image']['type'];
					//Create an array with acceptable file types to test uploaded file
					$types = array('image/png', 'image/jpeg', 'image/gif', 'image/jpg');
					$caption = $_POST['caption'];
					$user = $_SESSION['username'];
					//Continue if file is an image type
					if (in_array($mimetype,$types)) {
						if ($_FILES['image']['error'] > 0) {
							//Error with file upload
							echo "Error: " . $_FILES['image']['error'] . "<br>";
						} else {
							//Get the contents of the file to store in blob
							$image = file_get_contents($_FILES['image']['tmp_name']);
							$image = addslashes($image);
							//Create insert query
							$insert = "INSERT INTO PHOTOS (PhotoName, caption, photodata, mimetype, 
									   Username) VALUES ('$filename', '$caption', '$image', '$mimetype', '$user')";
							$result = mysqli_query($link,$insert);
							if ($result) {
								echo "<p>File was successfully uploaded.</p>";
							} else
								echo "<p>Error uploading file to db</p>";
						}
					} else {
						echo "<p>The image is of the wrong type: $mimetype</p>";
					}
				} else {
					echo "<p>File was not uploaded.</p>";
				}
			}
		?>
		<!-- End upload section -->

		<hr>
		<h1>Search</h1>
		<!-- Search pictures -->
		<div class="label">By Name</div>
		<form method="post" action="results.php">
			<div class="form">
				<input type="text" name="filename">
				<input type="submit" name="namesearch" value="Search">
			</div>
		</form>
		<br>
		<div class="label">By Caption</div>
		<form method="post" action="results.php">
			<div class="form">
				<input type="text" name="caption">
				<input type="submit" name="capsearch" value="Search">
			</div>
		</form>
		<?php
			echo "<a href='logout.php'>Logout</a><br>";
			mysqli_close($link);
		?>
		<!-- End search section -->

	</body>
<html>