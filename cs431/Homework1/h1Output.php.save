<html>
   <head>
      <title>Homework 1</title>
   </head>
   <body>
   <h1>Sorted Class List</h1>
   <?php
      $file = fopen("classlist.txt", "r");
      $classList = array();
      
      while (!feof($file)) {
         $line = fgets($file);
         list($id, $last, $firstMiddle) = split('[,]', $line);
         $classList[$id] = array($firstMiddle, $last);
      }
      fclose($file);
      ksort($classList);
      
      $cols = 3;
      $count = 0;
      echo "<table border='1'>
            <tr>
            <th>CWID</th>
            <th>First Name Middle Name</th>
            <th>Last Name</th>
            </tr>";
      foreach ($classList as $key => $val){
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
   ?>
   </body>
</html>
