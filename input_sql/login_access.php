<?php
session_start();
include_once 'AppManager.php';
$pm = AppManager::getPM();

function validateIP($ip) {
    return inet_pton($ip) !== false;
}

echo $rec = validateIP("2001:db8:85a3::8a2e:370:7334");
if(isset($_POST['add_time'])){
    $_POST['from'];
 $_POST['to']."<br>";
echo $_POST['menuo_layout']."<br>";
 $time_in_24_hour_format  = date("H:i", strtotime("1:30 PM"));
echo $datetime = date('H:i',strtotime($_POST['from']));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Web Application 1 Control Panel</title>

        <!--To ensure proper rendering and touch zooming-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="x-ua-compatible" content="IE=10">

        <link rel="stylesheet" type="text/css" href="css/timepicker/timepicki.css"/>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/docs.css" rel="stylesheet">
        <style>
            body
            {
                overflow-y:hidden;
            }

        </style>

    </head>

    <body>

        <div class="container">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">


                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li class=""><a href=""><i class="glyphicon glyphicon-home"></i> Home</a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle"
                                                data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Control Panel <b class="caret"></b> </a>

                            <ul class="dropdown-menu megamenu">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <li class="megapills" onClick="location.href='';" ><i class="glyphicon glyphicon-cog"></i> Control Panel Home</li>
                                        <li class="divider"></li>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <li class="labelmegapills">Core Features</li>
                                        <li class="divider"></li>
                                        <li class="megapills" onClick="location.href='';" ><i class="glyphicon glyphicon-dashboard"></i> Dashboard</li>					<li class="megapills" onClick="location.href='//selemann.com/dynamic_admin_panel_v1_0_0/ks_admin/admin-user/';" ><i class="glyphicon glyphicon-user"></i> Users</li>					<li class="megapills" onClick="location.href='//selemann.com/dynamic_admin_panel_v1_0_0/ks_admin/admin-menu/';" ><i class="glyphicon glyphicon-th-list"></i> Menu</li>					<li class="megapills" onClick="location.href='//selemann.com/dynamic_admin_panel_v1_0_0/ks_admin/admin-option/';" ><i class="glyphicon glyphicon-check"></i> Option</li>					<li class="megapills" onClick="location.href='//selemann.com/dynamic_admin_panel_v1_0_0/ks_admin/admin-news/';" ><i class="glyphicon glyphicon-star"></i> News</li>					<li class="megapills" onClick="location.href='//selemann.com/dynamic_admin_panel_v1_0_0/ks_admin/admin-acl/';" ><i class="glyphicon glyphicon-random"></i> Access Control List (ACL)</li>				</div>
                                </div>
                            </ul>
                        </li>
                        <li class="dropdown navbar-right"><a data-toggle="dropdown" class="dropdown-toggle"
                                                             href="#"><i class="glyphicon glyphicon-user"></i> Administrator <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href=""><i class="glyphicon glyphicon-user"></i> Edit Profile</a></li>
                                <li><a href=""><i class="glyphicon glyphicon-edit"></i> Change Password</a></li>
                                <li class="divider"></li>
                                <li><a href=""><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

            <ul class="breadcrumb">
                <li class="active"><i class="glyphicon glyphicon-th-list"></i> Menu</li>
            </ul>

            <div class="" style="display: none">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>

            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#section0"
                                          data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> List All</a></li>
                    <li class=""><a href="#section1"
                                    data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> Add IP</a></li>
                    <li class=""><a href="#section2"
                                    data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> Add Time</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="section0">

                        <div class="media">
                            <div class="media-body">List of Menu found.
                            </div>
                        </div>



                        <br/><br/> 
                        <div class="">    
                            <table class="table table-bordered table-hover table-striped" style="overflow-y:hidden;">	
                                <thead>			
                                    <tr align="center">
                                        <th>#</th>
                                        <th>IP Address</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $results = $pm->run("SELECT * from predefined_ipaddress");
                                    echo '<p class="clearfix">List of users found. <span class="label label-info">' . count($results) . '</span>  users.</p>';
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>

                                            <td align="center"><?php echo $result['id']; ?></td>
                                            <td align="center"><?php echo $result['ipaddress']; ?></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>									
                        </div>
                    </div>
                    <div class="tab-pane " id="section1">
                        <p>Create new Menu.</p>

                        <div class="error" style="display: none">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>

                        <form action="" method="post">
                            <table class="table table-bordered table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th width="30%" align="right">IP Address :</th>
                                        <td><input 
                                                type="search" name="name" id="name" size="50" ></td>
                                    </tr>



                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><input name="btnSubmit" type="submit"
                                                   class="btn btn-primary" id="btnSubmit" value="Save" /> or <a
                                                   href="list.php">Cancel</a>
                                            <input type="hidden" name="ks_token" id="ks_token" value="ba27e8263968e78a7a784da65ee0a9a5" />
                                            <input type="hidden" name="ks_scriptname" value="list" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="tab-pane" id="section2">
                        <div class="row">
                            <div class="span6">
                             
                                  <?php $result_time = $pm->run("SELECT * from predefined_hours");
                                
                                ?>
                                      
                                        
                                     <div class="alert alert-info" style="display: ">
           <p>Default Predefined Hours </p><h2><?php echo $result_time[0]['from'] . "  " . $result_time[0]['to']; ?></h2>
            </div>
                                   
                                
                            </div>
                            <div class="span6">
                                <form action="add_ipaddress.php" method="post">
                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody> 
                                            <tr><th>Predefined Time</th>
                                                <td>
                                                    <input class="time1"
                                                           type="search" name="from" id="from"  value="" placeholder="from">
                                                    <input class="time2"
                                                           type="search" name="to" id="to"  value="" placeholder="to">  
                                                </td>

                                            </tr><tr>
                                                <th></th><td>&nbsp;</td>
                                            </tr><tr>
                                                <th></th><td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td><input name="btnSubmit" type="submit"
                                                           class="btn btn-primary" id="btnSubmit" value="Save" name="add_time" /> 
                                                    <input type="hidden" name="ks_token" id="ks_token" value="ba27e8263968e78a7a784da65ee0a9a5" />
                                                    <input type="hidden" name="ks_scriptname" value="list" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>  
                            </div>
                            
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <!-- Le javascript
   ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
        <script src="js/timepicker/timepicki.js">
        </script>
        <script>
            $('#from').timepicki();
            $("#to").timepicki();
        </script>
        <script src="js/bootstrap-transition.js"></script>
        <script src="js/bootstrap-alert.js"></script>
        <script src="js/bootstrap-modal.js"></script>
        <script src="js/bootstrap-dropdown.js"></script>
<!--        <script src="js/bootstrap-scrollspy.js"></script>-->
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
        <script src="js/manualcheck.form.min.js"></script>
        <script>
            $(document).ready(function() {
                $('input[type="radio"]').click(function() {
                    if($(this).attr('id') == 'specified') {
                        $('#show-me').show();           
                    }

                    else {
                        $('#show-me').hide();   
                    }
                });
            });
        </script>

    </body>
</html>