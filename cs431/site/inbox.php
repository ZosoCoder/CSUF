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
        
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
    <div id="wrap">
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
                                <li><a href="#">Inbox</a></li>
                                <li><a href="#">Account</a></li>
                                <li class="divider"></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul> <!-- End of navigation links -->
                </div> <!-- nav-collapse end -->
            </div> <!-- End navbar-inner -->
        </div> <!-- End navbar -->
        <div class="container">
            <!--
            <script type="text/javascript">
                $(document).ready(function() {
                    var duke = $('input[id^="collapse"]');
                    var pegasus = $('#toggle');
                    duke.on('show', function() {
                        pegasus.removeClass('icon-chevron-right').addClass('icon-chevron-down');
                    });
                    duke.on('hide', function() {
                        pegasus.removeClass('icon-chevron-down').addClass('icon-chevron-right');
                    });

                })
            </script>
            -->
            <div class="hero-unit">
                <h1>Mailbox</h1>
            </div>

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
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if ($row['status'] == "Unread") {
                                                        echo "<tr class='success'>";
                                                    }   else {
                                                        echo "<tr>";
                                                    }
                                                    echo "      <td width=20>
                                                                    <div class='accordion-group'>
                                                                        <div class='accordion-heading'>
                                                                            <a href='#msg$count' data-parents='#accordion2' data-toggle='collapse' class='accordion-toggle'>
                                                                                <i id='toggle' class='icon-chevron-right'></i>
                                                                            </a>
                                                                        </div>
                                                                </td>
                                                                <td>".$row['Sender']."</td>
                                                                <td>".$row['Subject']."</td>
                                                                <td>".$row['MsgTime']."</td>
                                                                <td><a href='#' class='btn btn-danger'>Delete</a></td>
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
                                                    if ($row['status'] == "Unread") {
                                                        echo "<tr class='success'>";
                                                    }   else {
                                                        echo "<tr>";
                                                    }   
                                                    echo "      <td width=20>
                                                                    <div class='accordion-group'>
                                                                        <div class='accordion-heading'>
                                                                            <a href='#outmsg$count' data-parents='#accordion3' data-toggle='collapse' class='accordion-toggle'>
                                                                                <i id='toggle' class='icon-chevron-right'></i>
                                                                            </a>
                                                                        </div>
                                                                </td>
                                                                <td>".$row['Receiver']."</td>
                                                                <td>".$row['Subject']."</td>
                                                                <td>".$row['MsgTime']."</td>
                                                                <td><a href='#' class='btn btn-danger'>Delete</a></td>
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
                                <form id="compose-form" method="post" action="inbox.php">
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
                                            <button class="btn btn-primary">Send</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of Container -->
    </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit"> Built with <a href="twitter.github.io/bootstrap.index.html">Twitter Bootstrap</a>.</p>
            </div>
        </div> <!-- End of Footer -->
    </body>
</html>