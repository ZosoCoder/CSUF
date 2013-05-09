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
        <meta charset="utf=8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Site</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
            body { padding-top: 60px; }
            @media (max-width: 979px) {
                .navbar-fixed-top,
                .navbar-fixed-bottom {
                    margin-left: 0px;
                    margin-right: 0px;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="row">
                <div class="span12">
                    <div class="navbar navbar-fixed-top navbar-inverse" style="position:fixed">
                        <div class="navbar-inner">
                            <a href="#" class="brand">PHP Forum</a>
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <div class="nav-collapse collapse">
                                <ul class="nav">
                                    <li class="divider-vertical"></li>
                                    <li><a href="#"><i class="icon-home"></i> Home</a></li>
                                    <li class="divider-vertical"></li>
                                    <li><a href="#"><i class="icon-list-alt"></i> Forums</a></li>
                                    <li class="divider-vertical"></li>
                                    <li><a href="#"><i class="icon-comment"></i> Chatrooms</a></li>
                                    <li class="divider-vertical"></li>
                                </ul>
                                <ul class="nav pull-right">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-user"></i> <?php echo $_SESSION['username']; ?><b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="inbox.php">Inbox</a></li>
                                            <li><a href="#">Account</a></li>
                                            <li class="divider"></li>
                                            <li><a href="logout.php">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul> <!-- End of navigation links -->
                            </div> <!-- nav-collapse end -->
                        </div> <!-- End navbar-inner -->
                    </div> <!-- End navbar -->
                </div> <!-- End span12 -->
            </header> <!-- End of header -->
            <div class="row" id="main-content">
                
            </div> <!-- End of Main Content -->

            <footer class="row">
                <div class="span12">
                    <hr>
                    Developed by Anthony Gonzalez using Twitter Bootstrap.
                </div>
            </footer> <!-- End of Footer -->
            

        </div><!-- End of Container -->
        
        <!-- Javascript -->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
