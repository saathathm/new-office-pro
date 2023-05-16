<?php
include_once 'AppManager.php';
$pm = AppManager::getPM();
//include('auth.inc.php');

if(isset($_REQUEST['m']) && $_REQUEST['m']=='app'){
      echo '<div class="alert alert-info" style="display: ">Record sent to admin approval</div>';
}
if (isset($_GET['search_submit'])) {

    $rid = addslashes(trim($_GET['rid']));
    $name = addslashes(trim(strtoupper(@$_GET['name'])));
    $surname = addslashes(strtoupper(trim(@$_GET['surname'])));
    $mobile = addslashes(trim(@$_GET['mobile']));
    $home_phone = addslashes(trim(@$_GET['home_phone']));
    $business_phone = addslashes(trim(@$_GET['business_phone']));
    $alt_phone = addslashes(trim(@$_GET['alt_phone']));
    if ($rid != '' or $name != '' or $surname != '' or $mobile != '' or $home_phone != '' or $business_phone != '' or $alt_phone != '') {
        $sql = "select * from contacts where ";
        if ($rid != '') {
            $sql.="id='$rid' and ";
        }
        if ($name != '') {
            $sql.="name='$name' and ";
        }
        if ($surname != '') {
            $sql.="surname= '$surname' and ";
        }
        if ($mobile != '') {
            $sql.="mobile= '$mobile' and ";
        }
        if ($home_phone != '') {
            $sql.="home_phone= '$home_phone' and ";
        }
        if ($business_phone != '') {
            $sql.="business_phone= '$business_phone' and ";
        }
        if ($alt_phone != '') {
            $sql.="alt_phone= '$alt_phone' and ";
        }
        $sql.="1=1";

        $results = $pm->run($sql);
    }
}
?>
<?php include 'header.php'; 
if($_SESSION['userrole']=='user'){
    if($_SESSION['access_search'] != 1){
        header('Refresh: 0; URL=main.php?q=denied');
                exit();
    }
    }
?>


<div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
       
        <!-- Tables
        ================================================== -->
        <section id="tables">
            <div class="page-header">
                <h1>Search</h1>
            </div>
            <form method="get" action="">
                <div class="row">
                    <div class="span3" >
                        <input type="search" class="form-control" value="<?php ?>" placeholder="ID" name="rid"/>
                    </div>
                    <div class="span3" >
                        <input type="search" class="form-control" placeholder="Name" name="name"/>
                    </div>
                    <div class="span3" >
                        <input type="search" class="form-control" placeholder="Surname" name="surname"/>
                    </div>
                    <div class="span3" >
                        <input type="search" class="form-control" placeholder="Mobile" name="mobile"/>
                    </div>
                    <div class="span3" >
                        <input type="search" class="form-control" placeholder="Home Phone" name="home_phone"/>
                    </div>
                    <div class="span3" >
                        <input type="search" class="form-control" placeholder="Business Phone" name="business_phone"/>
                    </div>
                    <div class="span3" >
                        <input type="search" class="form-control" placeholder="Alt Phone" name="alt_phone"/>
                    </div>

                </div>
                <div class="row" >
                    <div class="span3">
                        <input type="submit" class="form-control btn btn-primary"  name="search_submit" value="Search"/>
                    </div>     
                </div>
            </form>

            <p id = "errormsg"></p>
    <!-- <p>For basic styling&mdash;light padding and only horizontal dividers&mdash;add the base class <code>.table</code> to any <code>&lt;table&gt;</code>.</p> -->
            <div class="bs-docs-currentrow">
                <table class="table">
                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Address</th>
                            <th>Suburb</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Home Phone</th>
                            <th>Business Phone</th>
                            <th>Alt Phone</th>
                            <th>Status</th>
                            <th>Comments</th>
                            <th>Consultant</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($results)) {
                            foreach ($results as $value) {if($_SESSION['userrole']=='user' && $value['status']=='SOLD'){
        continue;}
                                ?>


                                <tr>
                                    <td><?php echo $value['id'] ?></td>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['surname'] ?></td>
                                    <td><?php echo $value['address'] ?></td>
                                    <td><?php echo $value['suburb'] ?></td>
                                    <td><?php echo $value['state'] ?></td>
                                    <td><?php echo $value['zip'] ?></td>
                                    <td><?php echo $value['home_phone'] ?></td>
                                    <td><?php echo $value['business_phone'] ?></td>
                                    <td><?php echo $value['alt_phone'] ?></td>
                                    <td><?php echo $value['status'] ?></td>
                                    <td><?php echo $value['comments'] ?></td>
                                    <td><?php echo $value['constultant'] ?></td>
                                    <td><a href="edit_contacts.php?id=<?php echo $value['id']; ?>" rel="facebox">Edit</a></td>

                                </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
<?php if (count(@$results) == 0) { ?><center><h5 class="text-info">No records were found that match the specified search criteria</h5></center><?php } ?>
            <hr class="bs-docs-separator">

        </section>
    </div>
</div>
</div>



<!-- Footer
================================================== -->
<!--     <footer class="footer">
      <div class="container">
        <p>Designed for input data from csv file and manage the database manually.</p>
      </div>
    </footer> -->



<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script>
    
</script>
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


</body>
</html>
