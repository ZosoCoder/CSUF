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

        <title>Inbox</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <style type="text/css">
            .table thead tr.info > th {
                background-color: #1b1b1b;
                color: #cccccc;
            }
            input.span4 {
                height: 30px;
            }
            /*
            .table-bordered th:first-child,
            .table-bordered td:first-child {
                border-left: 1px solid #dddddd;
            }
            .table-bordered th:last-child,
            .table-bordered td:last-child {
                border-left: 0;
            }
            .table-bordered th,
            .table-bordered td {
                border-top: 0;
                border-bottom: 0;
            }*/
        </style>

        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        
        <script type="text/javascript">
            function re(id) {
                $('#list').load('getusers.php?u='+id);
            }
        </script>
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
                                <li><a href="chat/chatrooms.php"><i class="icon-comment icon-white"></i> Chatrooms</a></li>
                                <li class="divider-vertical"></li>
                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
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
                <div class="row" id="create-club">
                    <div class="span8 offset2">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Create a Club</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="control-group">
                                                <label class="control-label" for="clubName">Club Name</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="clubName" name="clubName" placeholder="Name">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="clubPicture">Picture</label>
                                                <div class="controls">
                                                    <input type="file" id="clubPicture" name="image">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="clubProfile">Profile</label>
                                                <div class="controls">
                                                    <textarea class="span4" rows="5" id="clubProfile" name="clubProfile" placeholder="Profile text..."></textarea>
                                                </div>
                                            </div>
                                
                                            <div class="control-group">
                                                <label class="control-label" for="clubAdmin">Set Admin</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="clubAdmin" name="clubAdmin" placeholder="Username">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary offset4" name="createClub">Save Club</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- End Create Club -->

                <div class="row" id="appoint-admin">
                    <div class="span5 offset2">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Appoint Club Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <form class="form-horizontal">
                                            <div class="control-group">
                                                <label class="control-label" for="clubSelect">Select Club</label>
                                                <div class="controls">
                                                    <div class="btn-group">
                                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Club Names <span class="caret"></span></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#" onClick="re('foo')">This is club name 1</a></li>
                                                            <li><a href="#" onClick="re('bar')">This is club name 1 blah blah blah</a></li>
                                                            <li><a href="#" onClick="re('foobar')">Ban</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">Make admin</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="setAdmin">Set Admin</label>
                                                <div class="controls">
                                                    <input type="text" class="input-block-level" id="setAdmin" placeholder="Username">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary pull-right" name="appointAdmin">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="span3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Ban User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select multiple class="input-block-level" style="min-height: 150px;">
                                            <option>Anon 1</option>
                                            <option>Anon 2</option>
                                            <option>Anon 3</option>
                                            <option>Anon 4</option>
                                            <option>Anon 5</option>
                                            <option>Anon 6</option>
                                            <option>Anon 7</option>
                                        </select>

                                        <button type="submit" class="btn btn-danger pull-right" name="banUser">Ban</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                    
            </div><!-- End of Container -->

            <div id="push"></div>
        </div>

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

        <?php
            if (isset($_POST['createClub'])) {
                $clubName = $_POST['clubName'];
                $clubProfile = $_POST['clubProfile'];
                $clubAdmin = $_POST['clubAdmin'];

                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    $mimetype = $_FILES['image']['type'];
                    $types = array('image/png', 'image/jpeg', 'image/gif', 'image/jpg');
                    

                    if (in_array($mimetype,$types)) {
                        if ($_FILES['image']['error'] > 0) {
                            echo "<p>Error: ".$_FILES['image']['error']."</p>";
                        } else {
                            $image = file_get_contents($_FILES['image']['tmp_name']);
                            $image = addslashes($image);
                            $insert = "INSERT INTO CLUBS (ClubName,Picture,mimetype,Profile,Moderator)
                                        VALUES ('$clubName','$image','$mimetype','$clubProfile','$clubAdmin')";
                            $result = mysqli_query($link,$insert);
                            if ($result) {
                                echo "<p>File was successfully uploaded.</p>";
                            } else {
                                echo "<p>Error while uploading file to db.</p>";
                            }
                        }
                    } else {
                        echo "<p>The image is of the wrong type: ".$_FILES['image']['type']."</p>";
                    }
                } else {
                    $create = "INSERT INTO CLUBS (ClubName,Profile,Moderator)
                                VALUES ('$clubName','$clubProfile','$clubAdmin');";
                    mysqli_query($link,$create);
                }
            }
        ?>
        
    </body>
</html>
