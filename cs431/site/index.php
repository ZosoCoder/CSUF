<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf=8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Site</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <style type="text/css">
            label.valid {
                width: 24px;
                height: 24px;
                background: url(img/Done.png) center center no-repeat;
                display: inline-block;
                text-indent: -9999px;
            }
            label.error {
                font-weight: bold;
                color: red;
                padding: 2px 8px;
                margin-top: 2px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="row">
                <div class="span12">
                    <nav class="navbar">
                        <div class="navbar-inner">
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
                        </div> <!-- End navbar-inner -->
                    </nav> <!-- End navbar -->
                </div> <!-- End span12 -->
            </header> <!-- End of header -->
            <div class="row" id="main-content">
                <div class="span4" id="sidebar">
                    <div class="well">
                        <form action="checkLogin.php" method="post">
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
            </div> <!-- End of Main Content -->

            <footer class="row">
                <div class="span12">
                    <hr>
                    Developed by Anthony Gonzalez using Twitter Bootstrap.
                </div>
            </footer> <!-- End of Footer -->
            

        </div><!-- End of Container -->

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
                        <input type="text" class="span5" name="fullname" id="fullname" placeholder="Full Name">
                    </div>
                    <div class="control-group controls">
                        <input type="text" class="span5" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="control-group controls">
                        <input type="password" class="span5" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="control-group controls">
                        <input type="password" class="span5" name="confpass" id="confpass" placeholder="Confirm Password">
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-success" name="registerUser">Register</button>
            </div>
                </form>
            
        </div> <!-- End of Modal Register -->

        <div id="nameTaken" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Username Taken!</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Error!</strong>This username is already taken. Please choose another.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#register">Try again</button>
            </div>
        </div> <!-- End of Modal nameTaken -->

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
        </div>
        
        <!-- Javascript -->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/show_modals.js"></script>

        <?php
            if (isset($_POST['registerUser'])) {
                $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die("Could not connect.");
                mysqli_select_db($link,'cs431s21') or die("No such database.");

                $username = $_POST['username'];
                $user_query = mysqli_query($link,"SELECT COUNT(*) AS count FROM USERS WHERE Username='$username'");
                $result = mysqli_fetch_assoc($user_query);
                if ($result['count'] > 0) {
                    echo '<script>user_taken();</script>';
                } else {
                    $password = $_POST['password'];
                    $fullname = $_POST['fullname'];
                    $add_user = "INSERT INTO USERS VALUES('$fullname','$username',Password('$password'))";
                    mysqli_query($link,$add_user);
                    echo '<script>register_success();</script>';
                }
            }
        ?>
    </body>
</html>
