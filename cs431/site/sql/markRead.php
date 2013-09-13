<?php
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());
    //id, in/out
    $id = $_GET['id'];
    $direction = $_GET['d'];
    $query = mysqli_query($link,"UPDATE MAILBOX SET $direction='read' WHERE MessageID=$id");
?>