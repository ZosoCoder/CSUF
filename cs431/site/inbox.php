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
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

        <script type="text/javascript" language="javascript">
            function read(id,dir) {
                $('#'+dir+'row'+id).removeClass('success').addClass('');
                $('#php').load('sql/markRead.php?id='+id+'&d='+dir+'Status');
            }
            function delrow(id,dir) {
                $('#'+dir+'row'+id).remove();
                $('#php').load('sql/deleteMsg.php?id='+id+'&d='+dir+'Status');
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
                <div class="hero-unit">
                    <h1>Mailbox</h1>
                </div>
                <div id="php"></div>
                <div class="row" id="mailbox">
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#inbox" data-toggle="tab">Inbox</a></li>
                            <li class=""><a href="#sent" data-toggle="tab">Sent</a></li>
                            <li class=""><a href="#compose" data-toggle="tab">Compose</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="inbox">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Sender</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="accordion" id="accordion2">
                                            <?php
                                                $username = $_SESSION['username'];
                                                $inbox_query = "SELECT * FROM MAILBOX WHERE Receiver='".$username."' ORDER BY MsgTime DESC";
                                                $result = mysqli_query($link,$inbox_query);
                                                $total = mysqli_num_rows($result);
                                                if ($total > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['InStatus'] != 'deleted') {    
                                                            if ($row['InStatus'] == "Unread") {
                                                                echo "<tr class='success' id='Inrow".$row['MessageID']."'>";
                                                            }   else {
                                                                echo "<tr id='Inrow".$row['MessageID']."'>";
                                                            }
                                                            echo "      <td width=20>
                                                                            <div class='accordion-group'>
                                                                                <div class='accordion-heading'>
                                                                                    <a href='#msg$count' data-parents='#accordion2' onClick=\"read('".$row['MessageID']."','In')\" data-toggle='collapse' class='accordion-toggle'>
                                                                                        <i class='icon-eye-open'></i>
                                                                                    </a>
                                                                                </div>
                                                                        </td>
                                                                        <td>".$row['Sender']."</td>
                                                                        <td>".$row['Subject']."</td>
                                                                        <td>".$row['MsgTime']."</td>
                                                                        <td><a href='#' onClick=\"delrow('".$row['MessageID']."','In')\" class='btn btn-danger'>Delete</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='more'></td>
                                                                       <td colspan='4' class='more'>
                                                                           <div class='accordion-body collapse' id='msg$count'>
                                                                                <div class='accordion-inner'>
                                                                                    ".nl2br($row['MsgText'])."
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                            </div>";
                                                        }
                                                        $count += 1;
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </tbody>
                                </table> <!-- End of inbox table -->
                            </div>

                            <div class="tab-pane" id="sent">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="accordion" id="accordion3">
                                            <?php
                                                $username = $_SESSION['username'];
                                                $inbox_query = "SELECT * FROM MAILBOX WHERE Sender='".$username."' ORDER BY MsgTime DESC";
                                                $result = mysqli_query($link,$inbox_query);
                                                if (mysqli_num_rows($result) > 0) {
                                                    $count = 0;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['OutStatus'] != 'deleted') {    
                                                            if ($row['OutStatus'] == "Unread") {
                                                                echo "<tr class='success' id='Outrow".$row['MessageID']."'>";
                                                            }   else {
                                                                echo "<tr id='Outrow".$row['MessageID']."'>";
                                                            }   
                                                            echo "      <td width=20>
                                                                            <div class='accordion-group'>
                                                                                <div class='accordion-heading'>
                                                                                    <a href='#outmsg$count' data-parents='#accordion3' onClick=\"read('".$row['MessageID']."','Out')\" data-toggle='collapse' class='accordion-toggle'>
                                                                                        <i class='icon-eye-open'></i>
                                                                                    </a>
                                                                                </div>
                                                                        </td>
                                                                        <td>".$row['Receiver']."</td>
                                                                        <td>".$row['Subject']."</td>
                                                                        <td>".$row['MsgTime']."</td>
                                                                        <td><a onClick=\"delrow('".$row['MessageID']."','Out')\" class='btn btn-danger'>Delete</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='more'></td>
                                                                        <td colspan='4' class='more'>
                                                                            <div class='accordion-body collapse' id='outmsg$count'>
                                                                                <div class='accordion-inner'>
                                                                                    ".nl2br($row['MsgText'])."
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                            </div>";
                                                        }
                                                        $count += 1;
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </tbody>
                                </table> <!-- End of Sent table -->
                            </div>

                            <div class="tab-pane" id="compose">
                                <div class="well">
                                    <form id="compose-form" method="post">
                                        <fieldset>
                                            <div class="control-group controls">
                                                <input type="text" class="input-block-level" name="recipient" id="recipient" placeholder="Send to">
                                            </div>
                                            <div class="control-group controls">
                                                <input type="text" class="input-block-level" name="subject" id="subject" placeholder="Subject">
                                            </div>
                                            <div class="control-group controls">
                                                <textarea class="input-block-level" rows="10" name="message" id="message" placeholder="Type your message here..."></textarea>
                                            </div>
                                            <div class="pull-right">
                                                <button type="submit "class="btn btn-primary" name="composeMsg">Send</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End of Mailbox -->
            </div> <!-- End of Container -->

            <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit"> Built with <a href="http://twitter.github.io/bootstrap/index.html">Twitter Bootstrap</a>.</p>
            </div>
        </div> <!-- End of Footer -->

        <div id="no_user" class="modal hide fade" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <h3 id="modalLabel">Invalid User</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong>Error!</strong> The recipient does not exist. Please try again.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#register">Try again</button>
            </div>
        </div> <!-- End of Modal nameTaken -->

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
            if (isset($_POST['composeMsg'])) {
                $receiver = $_POST['recipient'];
                $result = mysqli_query($link,"SELECT COUNT(*) AS count FROM USERS WHERE Username='$receiver'");
                $users = mysqli_fetch_assoc($result);
                if ($users['count'] > 0) {
                    $subject = $_POST['subject'];
                    $MsgText = $_POST['message'];
                    $sender = $_SESSION['username'];
                    if (strlen($subject) == 0)
                        $subject = "(no subject)";
                    mysqli_query($link,"INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
                                        VALUES ('$subject',NOW(),'$MsgText','$sender','$receiver','Unread','Unread')");
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<script type='text/javascript'>$('#no_user').modal('show');</script>";
                }
            }
        ?>
    </body>
</html>