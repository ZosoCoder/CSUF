<?php
    session_start();
    if (!session_is_registered(username)) {
        header("location:../index.php");
    }
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Chatroom</title>
        
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/app.css" rel="stylesheet">
        <link href="../css/footer.css" rel="stylesheet">

        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="wrap">
            <div class="navbar navbar-fixed-top navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">    
                        <a href="#" class="brand">431 Community</a>
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class="divider-vertical"></li>
                                <li><a href="../clubpage.php"><i class="icon-group"></i> Clubs</a></li>
                                <li class="divider-vertical"></li>
                                <li><a href="../forums.php"><i class="icon-list-alt icon-white"></i> Forums</a></li>
                                <li class="divider-vertical"></li>
                                <li><a href="../chat/chatrooms.php"><i class="icon-comment icon-white"></i> Chatrooms</a></li>
                                <li class="divider-vertical"></li>
                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="../inbox.php"><i class="icon-inbox"></i> Inbox</a></li>
                                        <li><a href="../user.php"><i class="icon-wrench"></i> Account</a></li>
                                        <li class="divider"></li>
                                        <li><a href="../logout.php"><i class="icon-off"></i>Logout</a></li>
                                    </ul>
                                </li>
                            </ul> <!-- End of navigation links -->
                        </div>
                    </div>
                </div>
            </div> <!-- End navbar -->

            <div class="container">
                <?php include('chat.php'); ?>
            </div><!-- End of Container -->

            <div id="push"></div>
        </div>

        <div id="footer">
            <div class="container">
                <p class="muted credit"> Built with <a href="http://twitter.github.io/bootstrap/index.html">Twitter Bootstrap</a>.</p>
            </div>
        </div> <!-- End of Footer -->

        <!-- Javascript -->
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap-transition.js"></script>
        <script src="../js/bootstrap-alert.js"></script>
        <script src="../js/bootstrap-modal.js"></script>
        <script src="../js/bootstrap-dropdown.js"></script>
        <script src="../js/bootstrap-scrollspy.js"></script>
        <script src="../js/bootstrap-tab.js"></script>
        <script src="../js/bootstrap-tooltip.js"></script>
        <script src="../js/bootstrap-popover.js"></script>
        <script src="../js/bootstrap-button.js"></script>
        <script src="../js/bootstrap-collapse.js"></script>
        <script src="../js/bootstrap-carousel.js"></script>
        <script src="../js/bootstrap-typeahead.js"></script>
        
    </body>
</html>
