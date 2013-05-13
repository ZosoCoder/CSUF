<?php
	session_start();
	if (!session_is_registered(username)) {
		header("location:home.php");
	}
?>
<html>
	<head>
		<title><?php echo $_SESSION['username']; ?></title>
		<style type="text/css">
			.nomsgs {text-align: center;
					 font-style: italic;
					  font-size: 30px;
					      color: silver;}
			.cell {text-align: center;
					  padding: 5px;}
			.radio {padding: 2px}
			.msgs {margin-left: 40px}
			.label {text-align: right;
					font-weight: bold;}
			.content {padding: 4px;}
			.error {color: red;}
		</style>
	</head>
	<body>
		<h1>Inbox</h1>
		<!-- Grab messages from database and display with php-->
		<?php
			//Connect to ecs and select database
			$link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die("Could not connect.");
			mysqli_select_db($link,"cs431s21") or die("No such database.");
			//Get username from url parameters and query db for messages
			$username = $_SESSION['username'];
			$inbox_query = "SELECT * FROM MAILBOX WHERE Receiver='".$username."' ORDER BY MsgTime DESC";
			$result = mysqli_query($link,$inbox_query);
			//If there are messages, print them. Otherwise, print a No Messages message.
			if (mysqli_num_rows($result) > 0) {
				echo "<form method='post'>
					  <div class='msgs'><input type='submit' name='inboxView' value='View'>
					  <input type='submit' name='delete' value='Delete'></div>
				  	  <table border='1' class='msgs'>
				  	  <tr>
				  	  <th class='cell'> </th>
					  <th class='cell'>Status</th>
					  <th class='cell'>Sender</th>
					  <th class='cell'>Subject</th>
					  <th class='cell'>Date</th>
					  </tr>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td class='radio'><input type='radio' name='msgs' value=".$row['MessageID']."></td>";
					echo "<td class='cell'>[".$row['Status']."]</td>";
					echo "<td class='cell'>".$row['Sender']."</td>";
					echo "<td class='cell'>".$row['Subject']."</td>";
					echo "<td class='cell'>".$row['MsgTime']."</td>";;
					echo "</tr>";
				}
				echo "</table>";
				echo "</form>";
			} else {
				echo "<div class='nomsgs'>No Messages</div><br><br>";
			}
			if (isset($_POST['inboxView']) && $_POST['msgs'] != '') {
				$msg_id = $_POST['msgs'];
				$msg_query = "SELECT * FROM MAILBOX WHERE MessageID=".$msg_id;
				$update_query = "UPDATE MAILBOX SET Status='Read' WHERE MessageID=".$msg_id;
				$result = mysqli_query($link,$msg_query);
				if (mysqli_num_rows($result) > 0) {
					mysqli_query($link,$update_query);
					$message = mysqli_fetch_assoc($result);
					$usr_query = "SELECT * FROM USERS WHERE Username='".$message['Sender']."'";
					$usr_result = mysqli_query($link,$usr_query);
					$user = mysqli_fetch_assoc($usr_result); 

					echo "<table>
						  <tr>
						  <td class='label'>Subject:</td>
						  <td class='content'>".$message['Subject']."</td>
						  </tr>
						  <tr>
						  <td class='label'>From:</td>
						  <td class='content'>".$user['UserFullName']." &lt;".$message['Sender']."&gt;</td>
						  </tr>
						  <tr>
					 	  <td class='label'>Message:</td>
						  <td class='conten'>".$message['MsgText']."</td>
						  </tr>
						  </table>";
				} else {
					echo 'Fix the query <p>';
				}
			}
			if (isset($_POST['delete'])) {
				$msg_id = $_POST['msgs'];
				$del_query = "DELETE FROM MAILBOX WHERE MessageID=$msg_id";
				mysqli_query($link,$del_query);
				echo "<meta http-equiv='refresh' content='0'>";
			}
		?>
		<!-- End inbox php script -->
		<hr>
		<h1>Sent</h1>
		<?php
			$sent_query = "SELECT * FROM MAILBOX WHERE Sender='".$username."' ORDER BY MsgTime DESC";
			$result = mysqli_query($link,$sent_query);
			//If there are messages, print them. Otherwise, print a No Messages message.
			if (mysqli_num_rows($result) > 0) {
				echo "<form method='post'>
					  <div class='msgs'><input type='submit' name='sentView' value='View'></div>
				  	  <table border='1' class='msgs'>
				  	  <tr>
				  	  <th class='cell'> </th>
					  <th class='cell'>Receiver</th>
					  <th class='cell'>Subject</th>
					  <th class='cell'>Date</th>
					  </tr>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td class='radio'><input type='radio' name='sentmsgs' value=".$row['MessageID']."></td>";
					echo "<td class='cell'>".$row['Receiver']."</td>";
					echo "<td class='cell'>".$row['Subject']."</td>";
					echo "<td class='cell'>".$row['MsgTime']."</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</form>";
			} else {
				echo "<div class='nomsgs'>No Messages</div><br><br>";
			}
			if (isset($_POST['sentView']) && $_POST['sentmsgs'] != '') {
				$msg_id = $_POST['sentmsgs'];
				$msg_query = "SELECT * FROM MAILBOX WHERE MessageID=$msg_id";
				$result = mysqli_query($link,$msg_query);
				if (mysqli_num_rows($result) > 0) {
					$message = mysqli_fetch_assoc($result);
					$usr_query = "SELECT * FROM USERS WHERE Username='".$message['Receiver']."'";
					$usr_result = mysqli_query($link,$usr_query);
					$user = mysqli_fetch_assoc($usr_result); 

					echo "<table>
						  <tr>
						  <td class='label'>Subject:</td>
						  <td class='content'>".$message['Subject']."</td>
						  </tr>
						  <tr>
						  <td class='label'>To:</td>
						  <td class='content'>".$user['UserFullName']." &lt;".$message['Receiver']."&gt;</td>
						  </tr>
						  <tr>
					 	  <td class='label'>Message:</td>
						  <td class='content'>".$message['MsgText']."</td>
						  </tr>
						  </table>";
				} else {
					echo 'Fix the query <p>';
				}
			}
		?>
		<!-- End sent php script -->
		<hr>
		<h1>Compose</h1>
		<form method="post">
			<table class="msgs">
				<tr>
					<td class="label">To:</td>
					<td><input type="text" name="receiver"></td>
				</tr>
				<tr>
					<td class="label">Subject:</td>
					<td><input type="text" name="subject"></td>
				</tr>
				<tr>
					<td class="label">Message:</td>
					<td><textarea rows="10" cols="50" name="text"> </textarea></td>
				</tr>
				<tr>
					<td class="label"> </td>
					<td align="right"><input type="submit" name="msgSubmit"></td>
				</tr>
			</table>
		</form>
		<!-- Handle client side check for erros in submission -->
		<?php
			if(isset($_POST['msgSubmit'])) {
				$receiver = $_POST['receiver'];
				$subject = $_POST['subject'];
				$text = nl2br($_POST['text']);
				if (strlen($receiver) > 0) {
					$result = mysqli_query($link,"SELECT COUNT(*) AS count FROM USERS WHERE Username='$receiver'");
					$row = mysqli_fetch_assoc($result);
					if ($row['count'] == 1) {
						if (strlen($subject) == 0) {
							$subject = "(no subject)";
						}
						$insert_query = "INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status) VALUES('$subject',NOW(),'$text','$username','$receiver','Unread')";
						$newRes = mysqli_query($link,$insert_query);
					}
				echo "<meta http-equiv='refresh' content='0'>";
				} else {
					echo "<div class='error msgs'>A recipient is required</div>";
				}
			}
			echo "<a href='logout.php'>Logout</a>";
			mysqli_close($link);
		?>
		<!-- End form php script -->
	</body>
</html>
