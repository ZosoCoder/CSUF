<?php
    session_start();
    if (!session_is_registered(username)) {
        header("location:index.php");
    }
    $link = mysqli_connect('ecsmysql','cs431s21','aipaiziu') or die(mysqli_error());
    mysqli_select_db($link,"cs431s21") or die(mysqli_error());
    ob_start();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $_GET['c']; ?></title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        
        <style type="text/css">
            .table thead tr.info > th {
                background-color: #1b1b1b;
                color: #cccccc;
            }
        </style>

        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

        <script src="js/jquery.js"></script>
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
            
            <?php
                $c = $_GET['c'];
                $query = mysqli_query($link,"SELECT * FROM CLUBS WHERE ClubName='$c'");
                $club = mysqli_fetch_assoc($query);
                $mimetype = $club['mimetype'];
            ?>

            <div class="container">
                <div class="row">
                    <div class="span4" id="picture">
                        <?php 
                            if ($club['Picture'] == null) {
                                echo '<img src="img/default-club.jpg"></img>';
                            } else {
                                echo "<img src='data:$mimetype;base64," . base64_encode($club['Picture']) . "'/></img>"; 
                            }
                            $query = mysqli_query($link,"SELECT COUNT(1) AS count FROM CLUBMEMBERS WHERE User='".$_SESSION['username']."' AND Club='".$club['ClubName']."'");
                            $query1 = mysqli_query($link,"SELECT COUNT(1) AS count FROM CLUBREQUESTS WHERE User='".$_SESSION['username']."' AND Club='".$club['ClubName']."'");
                            $result = mysqli_fetch_assoc($query);
                            $request = mysqli_fetch_assoc($query1);
                            if ($result['count'] == 0 && $request['count'] == 0)
                                echo "<br><br>
                                    <form method='post'>
                                        <button class='btn btn-info' type='submit' name='join'>Join Club</button>
                                    </form>";
                        ?>
                        <strong>Club Admin:</strong> <?php echo $club['Admin']; ?>
                    </div>
                    <div class="span8" id="name">
                        <h1>
                        <?php
                            echo $club['ClubName']; 
                            if ($_SESSION['username'] == $club['Admin'] || $_SESSION['username'] == 'admin') {
                                echo "<button class='btn btn-primary pull-right' href='#edit' data-toggle='modal'><i class='icon-edit'></i> Edit</button>";
                                $isAdmin = true;
                            } else 
                        ?>
                        </h1>
                        <div>
                            <h3>Profile</h3>
                            <p><?php echo nl2br($club['Profile']); ?></p>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <table id="forums" class="table table-bordered span8 offset2">
                        <thead>    
                            <tr class="info">
                                <th>
                                    Forums
                                    <?php
                                        if ($_SESSION['username'] == $club['Admin'])
                                            echo "<button class='btn btn-small btn-success pull-right' href='#createForum' data-toggle='modal'>Create Forum</button>";
                                    ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = mysqli_query($link,"SELECT * FROM FORUMS WHERE Club='".$club['ClubName']."'");
                                while ($forum = mysqli_fetch_assoc($query)) {
                                    echo "
                                        <tr>
                                            <td>
                                                <a href='forumdisplay.php?f=".$forum['ForumId']."'>".$forum['ForumName']."</a>
                                                <p class='muted'>".$forum['Description']."</p>
                                            </td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <?php
                        if ($isAdmin) {
                            //Requests Form
                            echo "
                            <table class='table table-bordered span4 offset2'>
                                <thead>
                                    <tr class='info'>
                                        <th>Requests</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <form method='post'>
                                                <select multiple class='input-block-level' style='min-height: 150px;'' name='users'>";
                                                        $query = mysqli_query($link,"SELECT User FROM CLUBREQUESTS WHERE Club='".$club['ClubName']."'");
                                                        while ($request = mysqli_fetch_assoc($query)) {
                                                            echo "<option value='".$request['User']."'>".$request['User']."</option>";
                                                        }
                            echo "              </select>

                                                <button type='submit' class='btn btn-success pull-right' style='margin-left: 5px;' name='addUser'>Add</button>
                                                <button type='submit' class='btn btn-danger pull-right' style='margin-left: 5px;' name='denyUser'>Deny</button>&nbsp;
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>";
                            //Remove users form
                            echo "
                            <table class='table table-bordered span4'>
                                <thead>
                                    <tr class='info'>
                                        <th>Remove User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <form method='post'>
                                                <select multiple class='input-block-level' style='min-height: 150px;'' name='users'>";
                                                        $query = mysqli_query($link,"SELECT User FROM CLUBMEMBERS WHERE Club='".$club['ClubName']."'");
                                                        while ($request = mysqli_fetch_assoc($query)) {
                                                            if ($request['User'] != $club['Admin'])
                                                                echo "<option value='".$request['User']."'>".$request['User']."</option>";
                                                        }
                            echo "              </select>

                                                <button type='submit' class='btn btn-danger pull-right' name='removeUser'>Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>";
                        }
                    ?>
                </div>
            </div> <!-- End container -->


            <div id="push"></div>
        </div>

        <div id="footer">
            <div class="container">
                <p class="muted credit"> Built with <a href="http://twitter.github.io/bootstrap/index.html">Twitter Bootstrap</a>.</p>
            </div>
        </div> <!-- End of Footer -->

        <div id="createForum" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3>Create New Forum</h3>
            </div>

            <div class="modal-body">
                <form method="post">
                    <input type="text" class="input-block-level" name="name" placeholder="Forum Name">
                    <textarea class="input-block-level" rows="5" name="description" placeholder="Short description..."></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-primary" type="submit" name="saveForum">Save</button>
            </div>
                </form>
        </div> <!-- End of createForum -->

        <div id="edit" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3>Edit Club</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="control-group">
                        <label class="control-label" style="width: 50px;" for="clubPicture">Picture</label>
                        <div class="controls" style="margin-left: 70;">
                            <input type="file" id="clubPicture" name="image">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" style="width: 50px;" for="clubProfile">Profile</label>
                        <div class="controls" style="margin-left: 70;">
                            <textarea class="span5" rows="5" id="clubProfile" name="clubProfile" placeholder="Profile text..."></textarea>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-success" type="submit" name="edit">Save</button>
            </div>
                </form>
        </div> <!-- End edit club -->

        <!-- Javascript -->
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
            if (isset($_POST['saveForum'])) {
                $forumName = $_POST['name'];
                $forumDesc = $_POST['description'];
                $moderator = $_SESSION['username'];
                $query = mysqli_query($link,"INSERT INTO FORUMS (ForumName,Description,Club,Moderator)
                    VALUES ('$forumName','$forumDesc','".$club['ClubName']."','$moderator')");
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['edit'])) {
                $profile = $_POST['clubProfile'];

                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    //UPDATE PICTURE AND PROFILE
                    $mimetype = $_FILES['image']['type'];
                    $types = array('image/png', 'image/jpeg', 'image/gif', 'image/jpg');

                    if (in_array($mimetype,$types)) {
                        if ($_FILES['image']['error'] > 0) {
                            echo "<p>Error: ".$_FILES['image']['error']."</p>";
                        } else {
                            $image = file_get_contents($_FILES['image']['tmp_name']);
                            $image = addslashes($image);
                            mysqli_query($link,"UPDATE CLUBS SET Picture='$image', mimetype='$mimetype', Profile='$profile' WHERE ClubName='".$club['ClubName']."'");
                        }
                    } else {
                        echo "<p>The image is of the wrong type: ".$_FILES['image']['type']."</p>";
                    }
                } else {
                    //UPDATE PROFILE ONLY
                    mysqli_query($link,"UPDATE CLUBS SET Profile='$profile' WHERE ClubName='".$club['ClubName']."'");
                }
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['join'])) {
                mysqli_query($link,"INSERT INTO CLUBREQUESTS VALUES ('".$club['ClubName']."','".$_SESSION['username']."')");
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['addUser'])) {
                $user = $_POST['users'];
                mysqli_query($link,"INSERT INTO CLUBMEMBERS VALUES ('".$club['ClubName']."','$user')");
                mysqli_query($link,"DELETE FROM CLUBREQUESTS WHERE User='$user' AND Club='".$club['ClubName']."'");
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['denyUser'])) {
                $user = $_POST['users'];
                mysqli_query($link,"DELETE FROM CLUBREQUESTS WHERE User='$user' AND Club='".$club['ClubName']."'");
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['removeUser'])) {
                $user = $_POST['users'];
                mysqli_query($link,"DELETE FROM CLUBMEMBERS WHERE User='$user' AND Club='".$club['ClubName']."'");
                echo "<meta http-equiv='refresh' content='0'>";
            }
        ?>
    </body>
</html>