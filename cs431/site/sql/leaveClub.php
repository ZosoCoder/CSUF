<?php
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());

    $clubname = $_GET['c'];
    $user = $_GET['u'];
    $query = mysqli_query($link,"SELECT * FROM CLUBS WHERE ClubName='$clubname'");
    if (mysqli_num_rows($query) > 0) {
        $club = mysqli_fetch_assoc($query);
        if ($club['Admin'] == $user) {
            mysqli_query($link,"UPDATE CLUBS SET Admin='admin' WHERE ClubName='$clubname'");
        }
        mysqli_query($link,"DELETE FROM CLUBMEMBERS WHERE User='$user' AND Club='$clubname'");
    }
?>