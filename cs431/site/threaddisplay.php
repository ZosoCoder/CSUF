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
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        
        <style type="text/css">
            .well {
                padding-bottom: 0;
            }
            .well .green {
                background-color: #dff0d8;
            }
            hr.style-two {
                border: 0;
                height: 1px;
                padding: 0;
                background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
                background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
                background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
                background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
            } /* hr style obtained from http://css-tricks.com/examples/hrs/  */
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
                    $threadId = $_GET['t'];
                    $query = mysqli_query($link,"SELECT * FROM THREADS WHERE ThreadId=$threadId");
                    if (mysqli_num_rows($query) > 0) {
                        $thread = mysqli_fetch_assoc($query);
                        $query = mysqli_query($link,"SELECT ForumName, Club FROM FORUMS WHERE ForumId=".$thread['Forum']);
                        $forum = mysqli_fetch_assoc($query);
                    } else {
                        echo "<p>Query failed.</p>";
                    }
                ?>

                <ul class="breadcrumb">
                    <li><a href=<?php echo '"club.php?c='.$forum['Club'].'"'; ?>><?php echo $forum['Club']; ?></a> <span class="divider">/</span></li>
                    <li><a href=<?php echo '"forumdisplay.php?f='.$thread['Forum'].'"'; ?>><?php echo $forum['ForumName']; ?></a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $thread['Title']; ?></li>
                </ul>

                <?php
                    $query = mysqli_query($link,"SELECT * FROM POSTS WHERE Thread=$threadId ORDER BY PostTime ASC");
                    $count = 0;
                    while ($post = mysqli_fetch_assoc($query)) {
                        echo "
                            <div class='well well-small'>
                                <i class='icon-user icon-large'></i> ".$post['Author']."<br>
                                Date: ".$post['PostTime']."
                                <div class='well well-small green'>
                                    <fieldset>";
                        if ($count == 0) {
                            echo "<h5>".$thread['Title'];    
                        } else {
                            echo "<h5>Re: ".$thread['Title'];
                        }
                        echo "</h5>
                                        <hr class='style-two'>
                                        <p>".$post['PostText']."</p>
                                        <div class='pull-right'>
                                            <button class='btn' href='#reply' data-toggle='modal'>Reply</button>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>";
                        $count += 1;
                    }
                ?>
            </div>
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

        <div id="member_err" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Not A Member</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <strong>Error!</strong> You must be a member of this club to post to the forums.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div> <!-- End of Modal nameTaken -->

        <div id="reply" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3>Reply in thread</h3>
            </div>

            <div class="modal-body">
                <form method="post">
                    <textarea class="input-block-level" rows="10" name="message" placeholder="Type your message here..."></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-primary" type="submit" name="reply">Reply</button>
            </div>
                </form>
        </div> <!-- End reply -->

        <?php
            if (isset($_POST['reply'])) {
                $q = "SELECT COUNT(*) AS count FROM CLUBMEMBERS WHERE User='".$_SESSION['username']."' AND Club='".$forum['Club']."'";
                $query = mysqli_query($link,$q);
                $result = mysqli_fetch_assoc($query);
                if ($result['count'] == 0) {
                    echo "<script type='text/javascript'>$('#member_err').modal('show');</script>";
                } else {
                    $text = nl2br($_POST['message']);
                    $author = $_SESSION['username'];
                    $result = mysqli_query($link,"INSERT INTO POSTS (PostText,PostTime,Author,Thread) VALUES('$text',NOW(),'$author',".$thread['ThreadId'].")");
                    echo "<meta http-equiv='refresh' content='0'>";    
                }
            }
        ?>
    </body>
</html>