<?php
    session_start();
    if (!session_is_registered(username)) {
        header("location:index.php");
    }
    if ($_SESSION['username'] == 'admin')
        header("location:admin.php");
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $_SESSION['username']; ?></title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <style type="text/css">
            .table thead tr.info > th {
                background-color: #1b1b1b;
                color: #cccccc;
            }
            input.span5 {
                height: 30px;
            }
        </style>

        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        
        <script type="text/javascript">
            function leaveClub(club, id, user) {
                $('#'+id).remove();
                $('#php').load("sql/leaveClub.php?c="+club+"&u="+user);
            }
        </script>
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
                                <li><a href="clubpage.php"><i class="icon-group"></i> Clubs</a></li>
                                <li class="divider-vertical"></li>
                                <li><a href="forums.php"><i class="icon-list-alt icon-white"></i> Forums</a></li>
                                <li class="divider-vertical"></li>
                                <li><a href="chat/chatrooms.php"><i class="icon-comment icon-white"></i> Chatrooms</a></li>
                                <li class="divider-vertical"></li>
                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="inbox.php"><i class="icon-inbox"></i> Inbox</a></li>
                                        <li><a href="user.php"><i class="icon-wrench"></i> Account</a></li>
                                        <li class="divider"></li>
                                        <li><a href="logout.php"><i class="icon-off"></i>Logout</a></li>
                                    </ul>
                                </li>
                            </ul> <!-- End of navigation links -->
                        </div>
                    </div>
                </div>
            </div> <!-- End navbar -->

            <div class="container">
                <div id="php"></div>
                <div class="row" id="main-content">
                    <div class="span5">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Change Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <form class="form-horizontal" method="post">
                                            <div class="control-group">
                                                <label class="control-label" style="width: 120px;" for="old">Old password</label>
                                                <div class="controls" style="margin-left: 130px;">
                                                    <input type="password" class="input-block-level" name="old"  id="old" placeholder="Usernmame">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" style="width: 120px;" for="new">New password</label>
                                                <div class="controls" style="margin-left: 130px;">
                                                    <input type="password" class="input-block-level" name="new" id="new" placeholder="New password">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" style="width: 120px;" for="confirm">Confirm password</label>
                                                <div class="controls" style="margin-left: 130px;">
                                                    <input type="password" class="input-block-level" name="confirm" id="confirm" placeholder="Confirm password">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary pull-right" name="changepass">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- End change password -->

                    <div class="span7">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>My Clubs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $user = $_SESSION['username'];
                                    $query = mysqli_query($link,"SELECT Club FROM CLUBMEMBERS WHERE User='$user'");
                                    $count = 0;
                                    while ($club = mysqli_fetch_assoc($query)) {
                                        $clubname = str_replace(" ","+",$club['Club']);
                                        echo "
                                            <tr id='club$count'>
                                                <td>
                                                    <a href='club.php?c=".$club['Club']."'>".$club['Club']."</a>
                                                    <a onClick=\"leaveClub('$clubname','club$count','".$_SESSION['username']."')\" class='btn btn-danger pull-right'>Leave<a>
                                                </td>
                                            </tr>";
                                        $count++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- End clubs -->
                </div>
            </div><!-- End of Container -->

            <div id="push"></div>
        </div>

        <div id="footer">
            <div class="container">
                <p class="muted credit"> Built with <a href="http://twitter.github.io/bootstrap/index.html">Twitter Bootstrap</a>.</p>
            </div>
        </div> <!-- End of Footer -->

        <div id="pass_incorrect" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Incorrect Password</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <strong>Error!</strong> Your old password is incorrect. Please try again.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div> <!-- End of Modal pass_incorrect -->

        <div id="pass_mismatch" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Password Mismatch</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <strong>Error!</strong> Your new password and confirmation do not match. Please try again.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div> <!-- End of Modal pass_mismatch -->

        <div id="pass_success" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Success</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <strong>Success!</strong> You have successfully changed your password.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div> <!-- End of Modal pass_success -->

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

        <?php
            if (isset($_POST['changepass'])) {
                $old = $_POST['old'];
                $new = $_POST['new'];
                $confirm = $_POST['confirm'];
                $query = mysqli_query($link,"SELECT COUNT(*) AS count FROM USERS WHERE 
                    Username='".$_SESSION['username']."' AND Password=Password('".$old."')");
                $result = mysqli_fetch_assoc($query);
                if ($result['count'] == 1) {
                    if ($new == $confirm) {
                        mysqli_query($link,"UPDATE USERS SET Password=Password('".$new."') WHERE Username='".$_SESSION['username']."'");
                        echo "<script type='text/javascript'>$('#pass_success').modal('show');</script>";
                    } else
                        echo "<script type='text/javascript'>$('#pass_mismatch').modal('show');</script>";
                } else {
                    echo "<script type='text/javascript'>$('#pass_incorrect').modal('show');</script>";
                }
            }
        ?>
    </body>
</html>
