<?php
include 'admin.php';
?>

<div class="container">
    <?php if (isset($_GET['type']) and $_GET['type'] == "notsent_mail") { ?>
        <div class="alert alert-error" style="display: ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Mail Not Sent</div>
    <?php } ?>
    <?php if (isset($_GET['type']) and $_GET['type'] == "sent_mail") { ?>
        <div class="alert alert-info" style="display: ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Mail Sent Successfully</div>
    <?php } ?>
     <?php if (isset($_GET['type']) and $_GET['type'] == "update") { ?>
        <div class="alert alert-info" style="display: ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            User Updated Successfully</div>
    <?php } ?>
     <?php if (isset($_GET['type']) and $_GET['type'] == "delete") { ?>
        <div class="alert alert-info" style="display: ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            User Deleted Successfully</div>
    <?php } ?>
     <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i>List All User </li>
    </ul>
    <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr align="center">
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-2">Name</td>
                            <td class="col-lg-1">Surname</td>
                            <td class="col-lg-1">Username</td>
                            <td class="col-lg-2">Email</td>
                            <td class="col-lg-1">Mobile</td>
                            <td class="col-lg-1">Role</td>
                            <td class="col-lg-1">Status</td>
                            <td class="col-lg-1">Action</td>
                            <td class="col-lg-1">Delete</td>
                            <td class="col-lg-1">Send Mail</td>
                        </tr>
                    </thead>
                    <tbody><?php
    $results = $pm->run("SELECT * from user");
    echo '<p class="clearfix">List of users found. <span class="label label-info">' . count($results) . '</span>  users.</p>';
    foreach ($results as $result) {
        ?>
                            <tr align="center">
                                <td><?php echo $result['id']; ?></td>
                                <td align="left"><?php echo $result['name']; ?></td>
                                <td align="left"><?php echo $result['surname']; ?></td>
                                <td align="left"><?php echo $result['username']; ?></td>
                                <td align="left"><?php echo $result['email']; ?></td>
                                <td align="left"><?php echo $result['mobile']; ?></td>
                                <td align="left"><?php echo @$result['role']; ?></td>
                                <td align="center" valign="top"><?php if ($result['enabled'] == 1) { ?>
                                        <span class="label label-info">Enabled</span>&nbsp;
                                    <?php } else { ?> <span class="label label-danger">Disabled</span>&nbsp;<?php } ?>
                                </td>

                                <td nowrap>
                                    <a href="edit_user.php?id=<?php echo $result['id']; ?>" rel="facebox"><input type="button"  value="Edit" class="btn btn-primary"></a> 
                                </td>
                                <td nowrap>
                                    <form method="post" action="delete_user.php" onSubmit="if(!confirm('Are you sure you want to delete ?')){return false;}">
                                        <input type="hidden" name="user_id" value="<?php echo $result['id']; ?>">
                                        <input type="submit" name="del_user" class="btn btn-danger" value="Delete">
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="send_email.php" >
                                        <input type="hidden" name="user_id" value="<?php echo $result['id']; ?>">
                                        <input type="submit" name="send_mail" class="btn btn-primary" value="Send">
                                    </form> 
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
<script src="js/timepicker/timepicki.js">
</script>


</body>
</html>