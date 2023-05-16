<?php
include 'admin.php';
if (isset($_POST['del_list'])) {

    $param = array(":list_id" => $_POST['list_id']);
    $pm->run("DELETE FROM status_list where id=:list_id", $param);
    echo '<div class="alert alert-success" style="display: ">List deleted successfully</div>';
}
if (isset($_POST['add_list'])) {
    if ($_POST['list'] != "") {
        $list = strtoupper(trim($_POST['list']));

        $param = array(":list" => $list);
        $pm->run("INSERT INTO status_list(list) VALUES(:list)", $param);
        echo '<div class="alert alert-success" style="display: ">List added successfully</div>';
    } else {
        echo '<div class="alert alert-error" style="display: ">Field cannot be empty</div>';
    }
}
?>
<div class="container">
    <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i>Status List</li>
    </ul>
    <div class="row">
        <div class="span6">
            <form class="form-inline" role="form" method="post" action="status_list.php">
                <input type="search" name="list" placeholder="List">
                <input type="submit" name="add_list" value="Add" class="btn btn-primary">
            </form>
        </div>
        <div class="span6">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr align="center">
                        <td class="col-lg-1">#</td>
                        <td class="col-lg-2">List</td>
                        <td class="col-lg-2">Delete</td>
                    </tr>
                </thead>
                <tbody><?php
$results = $pm->run("SELECT * from status_list");
foreach ($results as $key => $result) {
    ?>
                        <tr align="center">
                            <td><?php echo $key + 1; ?></td>
                            <td ><?php echo $result['list']; ?></td>
                            <td nowrap>
                                <form method="post" action="status_list.php" onSubmit="if(!confirm('Are you sure you want to delete ?')){return false;}">
                                    <input type="hidden" name="list_id" value="<?php echo $result['id']; ?>">
                                    <input type="submit" name="del_list" class="btn btn-mini btn-danger" value="Delete">
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