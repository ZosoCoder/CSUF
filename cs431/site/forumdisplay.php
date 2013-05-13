<?php
    session_start();
    if (!session_is_registered(username)) {
        header("location:index.php");
    }
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Thread</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        
        <style type="text/css">
            .table thead tr.info > th {
                background-color: #eeeeee;
            }
        </style>
        
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="wrap">
            <div class="navbar navbar-fixed-top navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">    
                        <a href="#" class="brand">PHP Forum</a>
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class="divider-vertical"></li>
                                <li><a href="user.php"><i class="icon-home icon-white"></i> Home</a></li>
                                <li class="divider-vertical"></li>
                                <li><a href="forums.php"><i class="icon-list-alt icon-white"></i> Forums</a></li>
                                <li class="divider-vertical"></li>
                                <li><a href="#"><i class="icon-comment icon-white"></i> Chatrooms</a></li>
                                <li class="divider-vertical"></li>
                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-user"></i> ZosoCoder <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="inbox.php">Inbox</a></li>
                                        <li><a href="user.php">Account</a></li>
                                        <li class="divider"></li>
                                        <li><a href="logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul> <!-- End of navigation links -->
                        </div>
                    </div>
                </div>
            </div> <!-- End navbar -->

            <div class="container">
                <?php
                    $forumname = $_GET['f'];
                    $query = mysqli_query($link,"SELECT * FROM FORUMS WHERE ForumName='$forumname'");
                    if (mysqli_num_rows($query) > 0) {
                        $forum = mysqli_fetch_assoc($query);
                    } else {
                        echo "<p>Query failed.</p>";
                    }
                ?>

                <ul class="breadcrumb">
                    <li><a href="forums.php">Forums</a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $forum['ForumName']; ?></li>
                </ul> <!-- End breadcrumb -->
                
                <div class="row">
                    <div class="span12">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="info">
                                    <th>Title/Creator</th>
                                    <th>Replies</th>
                                    <th>Last Post By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = mysqli_query($link,"SELECT * FROM THREADS WHERE Forum='$forumname'");
                                    while ($thread = mysqli_fetch_assoc($query)) {
                                        $postq = mysqli_query($link,"SELECT * FROM POSTS WHERE Thread=".$thread['ThreadId']." ORDER BY PostTime DESC LIMIT 1");
                                        $replyq = mysqli_query($link,"SELECT COUNT(*) AS count FROM POSTS WHERE Thread=".$thread['ThreadId']);
                                        $replies = mysqli_fetch_assoc($replyq);
                                        $last = mysqli_fetch_assoc($postq);
                                        echo "
                                            <tr>
                                                <td class='span8'>
                                                    <a href='threaddisplay.php?t=".$thread['ThreadId']."'>".$thread['Title']."</a><br>
                                                    <p class='muted'>by: ".$thread['Creator'].", 2013-05-09</p>
                                                </td>
                                                <td class='span2'>
                                                    Replies: ".$replies['count']."
                                                </td>
                                                <td class='span3'>
                                                    ".$last['Author']."<br>
                                                    ".$last['PostTime']."
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End Container -->

            <div id="push"></div>
        </div> <!-- End wrap -->

        <div id="footer">
            <div class="container">
                <p class="muted credit"> Built with <a href="http://twitter.github.io/bootstrap/index.html">Twitter Bootstrap</a>.</p>
            </div>
        </div> <!-- End of Footer -->

        <!-- Javascript -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap-transition.js"></script>
        <script src="js/bootstrap-alert.js"></script>
        <script src="js/bootstrap-modal.js"></script>
        <script src="js/bootstrap-dropdown.js"></script>
        <script src="js/bootstrap-scrollspy.js"></script>
        <script src="js/bootstrap-tab.js"></script>
        <script src="js/bootstrap-tooltip.js"></script>
        <script src="js/bootstrap-popover.js"></script>
        <script src="js/bootstrap-button.js"></script>
        <script src="js/bootstrap-collapse.js"></script>
        <script src="js/bootstrap-carousel.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>
    </body>
</html>