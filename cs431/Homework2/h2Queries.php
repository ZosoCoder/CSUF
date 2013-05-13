<html>
	<head>
		<title>Homework 2</title>
		<style type="text/css">
			.label {text-align: right}
		</style>
	</head>
	<body>
		<h1>Search Records</h1>
		<table>
			<tr>
				<form method="post">
					<td class="label">First name:</td>
					<td><input type="text" name="firstName"></td>
					<td><input type="submit" name="firstNameSubmit"></td>
				</form>
			</tr>
			<tr>
				<form method="post">
					<td class="label">Last name:</td>
					<td><input type="text" name="lastName"></td>
					<td><input type="submit" name="lastNameSubmit"></td>
				</form>
			</tr>
			<tr>
				<form method="post">
					<td class="label">ID:</td>
					<td><input type="text" name="id"></td>
					<td><input type="submit" name="idSubmit"></td>
				</form>
			</tr>
		</table>
		<br><br>

		<?php

			$file = fopen("classlist.txt", "r");
			$classlist = array();

			while(!feof($file)) {
				$line = fgets($file);
				list($id, $last, $firstMiddle) = split('[,]', $line);
				$classlist[$id] = array($firstMiddle, $last);
			}
			fclose($file);
			ksort($classlist);

			$resultList = array();

			if (!empty($_POST['firstNameSubmit'])) {
				foreach ($classlist as $key => $val) {
					$len = strlen($_POST['firstName']);
					if ($_POST['firstName'] == substr($val[0],0,$len) && $len > 0) {
						$resultList[$key] = array($val[0],$val[1]);
					}
				}

				if (sizeof($resultList) > 0) {
					printRecords();					
				}
			}

			if (!empty($_POST['lastNameSubmit'])) {
				foreach ($classlist as $key => $val) {
					if ($_POST['lastName'] == $val[1]) {
						$resultList[$key] = array($val[0],$val[1]);
					}
				}
				
				if (sizeof($resultList) > 0) {
					printRecords();					
				}
			}

			if (!empty($_POST['idSubmit'])) {
				foreach ($classlist as $key => $val) {
					if ($_POST['id'] == $key) {
						$resultList[$key] = array($val[0],$val[1]);
					}
				}

				if (sizeof($resultList) > 0) {
					printRecords();					
				}
			}

			function printRecords() {
				GLOBAL $resultList;

				$cols = 3;
		      $count = 0;
		      echo "<table border='1'>
		            <tr>
		            <th>CWID</th>
		            <th>First Name Middle Name</th>
		            <th>Last Name</th>
		            </tr>";
		      foreach ($resultList as $key => $val) {
		         if ($count%5 == 0 && $count != 0) {
		            echo "</table><br/>
		                  <table border='1'>
		                  <tr>
		                  <th>CWID</th>
		                  <th>First Name Middle Name</th>
		                  <th>Last Name</th>
		                  </tr>";
		            $count = 0;
		         }
		         echo "<tr>";
		         for ($c=0; $c<$cols; $c++){
		            if ($c == 0)
		               echo "<td>$key</td>";
		            else {
		               $tmp = $c - 1;
		               echo "<td>$val[$tmp]</td>";
		            }
			 			$count++;
		         }
		         echo "</tr>";
		      }
		      echo "</table>";

				}
		?>

	</body>
</html>