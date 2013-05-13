<html>
	<head>
		<title>Results</title>
		<style type="text/css">
			.label {font-weight: bold;
					text-align: right;}
		</style>
	</head>
	<body>
		<?php
			$link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
			mysqli_select_db($link,"cs431s21") or die(mysqli_error());
			$query = '';
			if (isset($_POST['namesearch'])) {
				//Retrieve all photos that match the exact name given
				$query = "SELECT * FROM PHOTOS WHERE PhotoName='".$_POST['filename']."'";
			} else if (isset($_POST['capsearch'])) {
				//Will return all images if caption input was left empty
				$query = "SELECT * FROM PHOTOS WHERE caption LIKE '%".$_POST['caption']."%'";
			} else {
				//Page reloaded without a post
				echo "<h1>Please retry your query.</h1>";
			}
			if ($query != '') {
				$result = mysqli_query($link,$query);
				if ($result && mysqli_num_rows($result) > 0) {
					$count = 0;
					while ($row = mysqli_fetch_assoc($result)) {
						//Get image info and print each result
						$name = $row['PhotoName'];
						$caption = $row['caption'];
						$mimetype = $row['mimetype'];
						$data = $row['photodata'];
						$count += 1;
						echo "<table>
							  <tr>
							  <td class='label'>Name:</td>
							  <td>$name</td>
							  </tr>
							  <tr>
							  <td class='label'>Caption:</td>
							  <td>$caption</td>
							  </tr>
							  </table>";
						echo "<img src='data:$mimetype;base64," . base64_encode($data) . "'/>";
						echo "<br><br>";
					}
				echo "<a href='user.php'>Back</a><br>";
				mysqli_close($link);
				} else {
					//Inform user if query retruns 0 rows.
					echo "<h1>Your search turned up 0 results</h1>";
				}
			}
		?>
	</body>
</html>