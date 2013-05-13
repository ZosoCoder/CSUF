<?php
    $user = $_GET['u'];
?>
<h1>This is a test</h1>
<?php
    echo "
        <select multiple style='min-height: 150px; min-width: 150px;''>
            <option>$user</option>
            <option>$user</option>
            <option>$user</option>
        </select>";
?>