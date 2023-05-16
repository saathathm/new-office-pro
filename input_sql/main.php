<?php
include('auth.inc.php');
if(isset($_REQUEST['q']) && $_REQUEST['q']=='denied'){
    echo '<div class="alert alert-error" style="display: ">Access Denied</div>';
}


?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Input MYSQL Site</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/docs.css" rel="stylesheet">
        <link href="js/google-code-prettify/prettify.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
        <![endif]-->

    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Navbar
        ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="./logout.php">Logout</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active">
                                <a href="./main.php">Home</a>
                            </li>
                            <li class="">
                                <a href="./input.php">Input App</a>
                            </li>
                            <li class="">
                                <a href="./manual_check.php">Manual Check</a>
                            </li>
                            <li class="">
                                <a href="./manual2_check.php">Manual2 Check</a>
                            </li>
                            <li class="">
                                <a href="./search_page.php">Search</a>
                            </li>
                            <li class="">
                                <a href="./admin.php">Admin Panel</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron masthead">
            <div class="container">
                <h1>Input MySQL Site</h1>
                <p>Import csv file and classify the content into various table.</p>
                <ul class="masthead-links">
                    <li>
                        <a href="./input.php">Input Page</a>
                    </li>
                    <li>
                        <a href="./manual_check.php">Manual Check</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container">
        </div>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
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
        <script src="js/bootstrap-affix.js"></script>

        <script src="js/holder/holder.js"></script>
        <script src="js/google-code-prettify/prettify.js"></script>

        <script src="js/application.js"></script>

    </body>
</html>
