<?php
include 'admin.php';
function validateIP($ip) {
    return inet_pton($ip) !== false;
}

if (isset($_POST['del_ip'])) {
    $ip_id = $_POST['ip_id'];
    $param = array(":ip_id" => $ip_id);
    $pm->run("DELETE from predefined_ipaddress where id=:ip_id", $param);
}
if (isset($_POST['add_ip'])) {
    $ip = trim($_POST['ip_add']);
    if(@validateIP($ip)==1){
    $param = array(":ip" => $ip);
    $count = $pm->getCount("SELECT count(id) as c from predefined_ipaddress where ipaddress =:ip", $param);
    if ($count == 0) {
        $pm->run("INSERT INTO predefined_ipaddress(ipaddress) VALUES(:ip)", $param);
         echo '<div class="alert alert-success" style="display: ">IP address added successfully</div>';
    }
    else{
        echo '<div class="alert alert-error" style="display: ">IP address already exist</div>';
    }
    }
    else{
        echo '<div class="alert alert-error" style="display: ">Wrong IP address</div>';
    }
}
?>
<div class="container">
    <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i>Manage IP</li>
    </ul>
    <div class="row">
        <div class="span6">
            <form class="form-inline" role="form" method="post" action="add_ip.php">
                <input type="search" name="ip_add" placeholder="IP Address">
                <input type="submit" name="add_ip" value="Add" class="btn btn-primary">
            </form>
        </div>
        <div class="span6">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr align="center">
                        <td class="col-lg-1">#</td>
                        <td class="col-lg-2">IP</td>
                        <td class="col-lg-2">Action</td>
                    </tr>
                </thead>
                <tbody><?php
$results = $pm->run("SELECT * from predefined_ipaddress");
foreach ($results as $key => $result) {
    ?>
                        <tr align="center">
                            <td><?php echo $key + 1; ?></td>
                            <td ><?php echo $result['ipaddress']; ?></td>
                            <td nowrap>
                                <form method="post" action="add_ip.php" onSubmit="if(!confirm('Are you sure you want to delete ?')){return false;}">
                                    <input type="hidden" name="ip_id" value="<?php echo $result['id']; ?>">
                                    <input type="submit" name="del_ip" class="btn btn-danger" value="Delete">
                                </form>
                            </td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
 <?php include 'footer.php'; ?>