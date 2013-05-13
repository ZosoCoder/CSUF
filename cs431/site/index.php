<?php ob_start(); ?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Inbox</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href='css/font-awesome.min.css' rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">

        <style type="text/css">
            label.valid {
                display: inline-block;
                position: relative;
            }
            label.valid:before {
                content: "\f00c";
                font-family: 'FontAwesome';
                font-style: normal;
                text-decoration: inherit;
                color: green;
                font-size: 15px;
                display: inline-block;
            }
            label.error {
                font-weight: bold;
                color: red;
                padding: 2px 8px;
                margin-top: 2px;
            }
        </style>
        
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="wrap">
            <div class="navbar navbar-fixed-top navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">
                        <a href="#nameTaken" data-toggle="modal" class="brand">PHP Forum</a>
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <div class="nav-collapse collapse">
                            <ul class="nav pull-right">
                                <li class="divider-vertical"></li>
                                <li><a href="#"><i class="icon-info-sign"></i> About</a></li>
                            </ul> <!-- End navigation links -->
                        </div> <!-- nav-collapse end -->
                    </div>
                </div> <!-- End navbar-inner -->
            </div> <!-- End navbar -->

            <div class="container">
                <div class="row" id="main-content">
                    <div class="span4" id="clubs">
                        <div class="well">
                            <form action="" method="post">
                                <fieldset>
                                    <legend>Login</legend>
                                    <input type="text" class="input-block-level" placeholder="username" name="username">
                                    <input type="password" class="input-block-level" placeholder="password" name="password">
                                    <div class="pull-right">
                                        <input type="submit" class="btn btn-primary" value="Login" name="loginSubmit">
                                        <a class="btn btn-info" href="#register" role="button" data-toggle="modal">Register</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div> <!-- End form well -->
                    </div> <!-- End sidebar -->

                    <div class="span8">
                    </div> <!-- End of Main span8 Content -->
                </div><!-- End of main-content -->
            </div> <!-- End of container -->

            <div id="push"></div>
        </div> <!-- End of Wrap -->

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
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/script.js"></script>

        <div id="register" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Register</h3>
            </div>
            <div class="modal-body">
                <form id="contact-form" method="post" action="index.php">
                    <div class="control-group controls">
                        <input type="text" class="span5" style="min-height: 30px;" name="fullname" id="fullname" placeholder="Full Name">
                    </div>
                    <div class="control-group controls">
                        <input type="text" class="span5" style="min-height: 30px;" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="control-group controls">
                        <input type="password" class="span5" style="min-height: 30px;" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="control-group controls">
                        <input type="password" class="span5" style="min-height: 30px;" name="confpass" id="confpass" placeholder="Confirm Password">
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-success" name="registerUser">Register</button>
            </div>
                </form>
        </div> <!-- End of Modal Register -->

        <div id="name_taken" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Username Taken!</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Error!</strong> This username is already taken. Please choose another.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#register">Try again</button>
            </div>
        </div> <!-- End of Modal nameTaken -->

        <div id="user_banned" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Banned!</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Error!</strong> You are banned from this site.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#register">Close</button>
            </div>
        </div> <!-- End of Modal userBanned -->

        <div id="login_failed" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Login Failed</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Error!</strong> Login failed. Username and/or password is incorrect.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#register">Close</button>
            </div>
        </div> <!-- End of Modal loginFail -->

        <div id="registered" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Success!</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Success!</strong> You have successfully registered for this site. You may now login.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div> <!-- End of Modal registered -->
        

        <?php
            if (isset($_POST['registerUser'])) {
                $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die("Could not connect.");
                mysqli_select_db($link,'cs431s21') or die("No such database.");

                $username = $_POST['username'];
                $user_query = mysqli_query($link,"SELECT COUNT(*) AS count FROM USERS WHERE Username='$username'");
                $result = mysqli_fetch_assoc($user_query);
                if ($result['count'] > 0) {
                    echo "<script type='text/javascript'>$('#name_taken').modal('show');</script>";
                } else {
                    $password = $_POST['password'];
                    $fullname = $_POST['fullname'];
                    $add_user = "INSERT INTO USERS VALUES('$fullname','$username',Password('$password'),'allowed')";
                    mysqli_query($link,$add_user);
                    echo "<script type='text/javascript'>$('#registered').modal('show');</script>";
                }
            }

            if (isset($_POST['loginSubmit'])) {
                $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die("Could not connect.");
                mysqli_select_db($link,'cs431s21') or die("No such database.");

                $username = $_POST['username'];
                $password = $_POST['password'];
                $query = "SELECT * FROM USERS WHERE Username='$username' AND ".
                         "Password=Password('$password')";
                $result = mysqli_query($link,$query);
                if (mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                    if ($user['Status'] == "banned") {
                        echo "<script type='text/javascript'>$('#user_banned').modal('show');</script>";
                    } else {
                        session_register("username");
                        session_register("password");
                        header("location:user.php");
                        ob_end_flush();
                    }
                } else {
                    echo "<script type='text/javascript'>$('#login_failed').modal('show');</script>";
                }
            }
        ?>
    </body>
</html>
