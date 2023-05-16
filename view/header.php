<!DOCTYPE HTML>
<html lang="en">

<head>
    <!-- <meta charset="UTF-8" http-equiv="refresh" content="300">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Keeping</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" type="text/css">
    <link rel="stylesheet" href="themes/base/jquery.ui.all.css">

    <style type="text/css">
        /* see the .brand styling in bootstrap .css */
        .login-blurb {
            display: block;
            float: right;
            padding: 10px 20px 10px;
            margin-left: -20px;
            color: #18ff00;
        }

        .login-blurb2 {
            display: block;
            float: left;
            padding: 10px 20px 10px;
            margin-left: -20px;
            color: #18ff00;
        }

        /*    #buzzer {
    position:absolute;
    top:7px;
    right:10px;
    width: 75px;
    height: 75px;
    overflow: hidden;
}*/

        .homepage_logo {
            position: absolute;
            width: 300px;
            left: 37%;
            z-index: 100;
            top: 26px;
        }

        #buzzer div {
            display: block;
            background: url(images/g3_buzzer.png) no-repeat 0 0px;
            width: 75px;
            height: 75px;
            text-indent: -1000px;
        }

        #buzzer div:hover {
            cursor: pointer;
            background: url(images/g3_buzzer.png) no-repeat 0 -75px;
        }

        #buzzer.act div {
            background: url(images/g3_buzzer.png) no-repeat 0 -150px;
        }

        #buzzer.act div:hover {
            cursor: pointer;
            background: url(images/g3_buzzer.png) no-repeat 0 -225px;
        }

        #buzzer.disabled div,
        #buzzer.disabled div:hover {
            cursor: auto;
            background: url(images/g3_buzzer.png) no-repeat 0 -300px;
        }
    </style>
    <script src="bootstrap/js/jquery-1.9.1.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <link href="assest/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="assest/facebox/facebox.js" type="text/javascript"></script>
    <script src="assest/js/jquery.ui.core.js"></script>
    <script src="assest/js/jquery.ui.widget.js"></script>
    <script src="assest/js/jquery.ui.datepicker.js"></script>
    <script src="assest/js/time_picker.js"></script>

    <!--        <script src="bootstrap/js/bootstrap-datetimepicker.min.js"></script>
         <link href="bootstrap/css/bootstrap-datetimepicker.min.css" media="screen" rel="stylesheet" type="text/css" />-->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
                loadingImage: 'facebox/loading.gif',
                closeImage: 'facebox/closelabel.png'

            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add').click(function() {
                $('#employeeform').toggle();

            })
            $('body').on('touchstart.dropdown', '.dropdown-menu', function(e) {
                e.stopPropagation();
            });
        })
        $(document).ready(function() {
            $("[rel=tooltip]").tooltip({
                placement: 'right'
            });
        });
    </script>
</head>

<body>