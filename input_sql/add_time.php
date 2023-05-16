<?php
include 'admin.php';

if (isset($_POST['add_time'])) {
    $from = trim($_POST['from']);
    $to = trim($_POST['to']);

    if ($from != "" && $to != "") {
        $from = (date('H:i', strtotime($from)));

        $to = (date('H:i', strtotime($to)));

        $param = array(":from" => $from, ":to" => $to);
        $count = $pm->getCount("SELECT count(id) as c from predefined_hours");
        if ($count == 0) {
            $pm->run("INSERT INTO predefined_hours(`from`,`to`) VALUES(:from,:to)", $param);
            echo '<div class="alert alert-success" style="display: ">Time added successfully</div>';
        } else {
            $pm->run("UPDATE predefined_hours SET `from` =:from ,`to` =:to", $param);
            echo '<div class="alert alert-success" style="display: ">Time updated successfully</div>';
        }
    } else {
        echo '<div class="alert alert-error" style="display: ">Field cannot be empty</div>';
    }
}
?>
<div class="container">
    <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i>Manage Time</li>
    </ul>
    <div class="row">
        <div class="span9">
            <form action="add_time.php" method="post">
                <table class="table table-bordered table-hover table-striped">
                    <tbody> 
                        <tr><th>Predefined Time</th>

                            <td>  <div class="time_pick">
                                    <input class="time1"
                                           type="search" name="from" id="from" placeholder="from" readonly>
                                    <input class="time2"
                                           type="search" name="to" id="to"  placeholder="to" readonly>   </div>
                            </td>

                        </tr><tr>
                            <th></th><td>&nbsp;</td>
                        </tr><tr>
                            <th></th><td>&nbsp;</td>
                        </tr>
                        <tr>
                            <th></th><td>&nbsp;</td>
                        </tr><tr>
                            <th></th><td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td><input  type="submit"
                                        class="btn btn-primary" id="btnSubmit" value="Save" name="add_time" /> 
                                <input type="hidden" name="ks_token" id="ks_token" value="ba27e8263968e78a7a784da65ee0a9a5" />
                                <input type="hidden" name="ks_scriptname" value="list" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>  
        </div>
        <div class="span3">
            <table class="table table-bordered table-hover table-striped">

                <tbody><?php
$result_time = $pm->run("SELECT * from predefined_hours");
$from_time = $result_time[0]['from'];
$to_time = $result_time[0]['to'];
?>
                <div class="alert alert-info" style="display: ">
                    <p>Default Predefined Hours </p><h2><?php echo date("g:i A", strtotime($from_time)) . "<br>";
echo date("g:i A", strtotime($to_time));
?></h2>
                </div>

                </tbody>
            </table>
        </div>
    </div>
</div>
 <?php include 'footer.php'; ?>
<script src="js/timepicker/timepicki.js">
</script>
<script>
    $('#from').timepicki();
    $("#to").timepicki();
</script>
