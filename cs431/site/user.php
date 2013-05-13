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
            }
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
                                <li><a href="#"><i class="icon-comment icon-white"></i> Chatrooms</a></li>
                                <li class="divider-vertical"></li>
                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-user"></i> ZosoCoder <b class="caret"></b></a>
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
                <header class="row">
                    <div id="clubs" class="span8 offset2">
                        <table class="table table-bordered span8">
                            <thead>
                                <tr class="info">
                                    <th>Create Clubs</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
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
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select multiple style="min-height: 150px;">
                                                    
                                        </select>
                                        <select multiple style="min-height: 150px;">
                                                    
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- End span12 -->
                </header> <!-- End of header -->
                <div class="row" id="main-content">
                    
                </div> <!-- End of Main Content -->
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
        
    </body>
</html>
