<?php
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());
    //id, d
    $id = $_GET['id'];
    $d = $_GET['d'];
    $update = mysqli_query($link,"UPDATE MAILBOX SET $d='deleted' WHERE MessageID=$id");
    $query = mysqli_query($link,"SELECT InStatus, OutStatus FROM MAILBOX WHERE MessageID=$id");
    $msg = mysqli_fetch_assoc($query);
    if ($msg['InStatus'] == $msg['OutStatus'])
        mysqli_query($link,"DELETE FROM MAILBOX WHERE MessageID=$id");
?>  