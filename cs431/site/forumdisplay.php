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

        <title>Forum</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
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
                <?php
                    $id = $_GET['f'];
                    $query = mysqli_query($link,"SELECT * FROM FORUMS WHERE ForumId='$id'");
                    if (mysqli_num_rows($query) > 0) {
                        $forum = mysqli_fetch_assoc($query);
                    } else {
                        echo "<p>Query failed.</p>";
                    }
                ?>

                <ul class="breadcrumb">
                    <li><a href=<?php echo '"club.php?c='.$forum['Club'].'"'; ?>><?php echo $forum['Club']; ?></a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $forum['ForumName']; ?></li>
                </ul> <!-- End breadcrumb -->
                
                <div class="row">
                    <div class="span12">
                        <button class='btn btn-success pull-right' href='#startThread' data-toggle='modal'>Start a Thread</button>
                    </div>
                </div>

                <div class="row" style="padding-top: 10px;">
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
                                    $query = mysqli_query($link,"SELECT * FROM THREADS WHERE Forum='$id'");
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
        
        <div id="notAMember" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Not a member</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Error!</strong> You do not have permission to start a thread. You must be a member of the
                    club this forum belongs to.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div> <!-- End of Modal userBanned -->

        <div id="startThread" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3>Start New Thread</h3>
            </div>

            <div class="modal-body">
                <form method="post">
                    <input type="text" class="input-block-level" name="title" placeholder="Thread title">
                    <textarea class="input-block-level" rows="10" name="message" placeholder="Type your message here..."></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-primary" type="submit" name="createThread">Save</button>
            </div>
                </form>
        </div> <!-- End of startThread -->

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
            if (isset($_POST['createThread'])) {
                $perm = mysqli_query($link,"SELECT COUNT(*) AS count FROM CLUBMEMBERS WHERE Club='".
                                    $forum['Club']."' AND User=;".$_SESSION['username']."'");
                if ($perm['count'] == 1 || $_SESSION['username'] == 'admin') {
                    $title = $_POST['title'];
                    $message = $_POST['message'];
                    $author = $_SESSION['username'];
                    $query = mysqli_query($link,"INSERT INTO THREADS (Title,DateCreated,Creator,Forum) ".
                                            "VALUES ('$title',NOW(),'$author','".$forum['ForumId']."')");
                    $tid = mysqli_insert_id($link);
                    $query = mysqli_query($link,"INSERT INTO POSTS (PostText,PostTime,Author,Thread) ".
                                            "VALUES ('$message',NOW(),'$author',$tid)");
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<script type='text/javascript'>$('#notAMember').modal('show');</script>";
                }
            }
        ?>

    </body>
</html>