<?php
include('auth.inc.php');
include_once 'AppManager.php';
$pm = AppManager::getPM();
?>
<?php include 'header.php'; ?>
<div class="container">
    <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i> </li>
    </ul>
   
    
    <?php if (isset($_GET['type']) and $_GET['type'] == "update") { ?>
        <div class="alert alert-info" style="display: ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            User Updated Successfully</div>
    <?php } ?>

    <div class="" style="display: none">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <div class="tabbable tabs-left">
<!--        <ul class="nav nav-pills">
            <li class="active"><a href="#section0"
                                  data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> List All User</a></li>
            <li class=""><a href="#section1"
                            data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> Add User</a></li>
            <li class=""><a href="#section2"
                            data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> Log Activates</a></li>
            <li class=""><a href="#section3"
                            data-toggle="tab"><i class="glyphicon glyphicon-chevron-right"></i> Status List</a></li>
        </ul>-->
        <div class="tab-content">
            <div class="tab-pane active" id="section0">
                <div class="" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <br/>
               


                <script>
                    function doDelete(userId) {
                        if(confirm("Delete user '" + userId + "'?")) {
                            location.href= "delete.php?id=" + userId;
                        }
                    }
                </script>                                    
            </div>
            <div class="tab-pane " id="section1">
                <p>Use this form to add a new user.</p>
                <div class="" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                

                <script>
                    $(document).ready(function(){
                        $("#formAdd").validationEngine();
                        $("#usr_id").select();
                    });	
                </script>
            </div>
            <div class="tab-pane " id="section2">



                <div class="" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>

                <p class="clearfix">List of users found. <span class="label label-info">1</span>  users.</p>

                <form class="form-inline" role="form" method="get" action="list.php">
                    Filter users by : <input id="fname" class="form-control ks-form-control" type="text" value="" size="28" 
                                             maxlength="255" name="fname" placeholder="Name"> 
                    <input id="femail" class="form-control ks-form-control" type="text" value="" size="28" maxlength="255" 
                           name="femail" placeholder="Email">
                    <input type="submit" name="search" value="Search" class="btn btn-primary">
                </form>
                <br/>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr align="center">
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-2">User ID</td>
                            <td class="col-lg-2">Name</td>
                            <td class="col-lg-2">Email</td>
                            <td class="col-lg-1">Role</td>
                            <td class="col-lg-1">Status</td>
                            <td class="col-lg-3">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="center">
                            <td>1.</td>
                            <td align="left"><a href="display.php?id=admin" class="lead">admin</a></td>
                            <td align="left">Administrator</td>
                            <td align="left"><a href="mailto:amri@kometsoft.com.my">amri@kometsoft.com.my</a></td>
                            <td>ADMIN</td>
                            <td align="center" valign="top"><span class="label label-info">Enabled</span>&nbsp;</td>
                            <td nowrap><input type="button" onclick="location.href='display.php?id=admin';"
                                              value="Properties" class="btn btn-primary"> 
                            </td>
                        </tr>
                    </tbody>
                </table>


                <script>
                    function doDelete(userId) {
                        if(confirm("Delete user '" + userId + "'?")) {
                            location.href= "delete.php?id=" + userId;
                        }
                    }
                </script>                            </div>

            <div class="tab-pane " id="section3">

     
                <script>
                    function doDelete(userId) {
                        if(confirm("Delete user '" + userId + "'?")) {
                            location.href= "delete.php?id=" + userId;
                        }
                    }
                </script>                            </div>
           
        </div>   

    </div>
</div>   
<script src="js/jquery.js"></script>
<script src="js/jquery.js"></script>
<script src="facebox/facebox.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox({
            loadingImage : 'facebox/loading.gif',
            closeImage   : 'facebox/closelabel.png'
        
        })
    })
</script>
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

<script src="js/papaparse.min.js"></script> 
<script src="js/inputapp.form.min.js"></script>


</body>
</html>