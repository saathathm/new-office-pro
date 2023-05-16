<?php
require 'admin.php';
?>
<div class="container">
    <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i>Log Activity</li>
    </ul>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr align="center">
                <td class="col-lg-1">#</td>
                <td class="col-lg-2">Username</td>
                <td class="col-lg-1">IP</td>
                <td class="col-lg-1">Login</td>
                <td class="col-lg-2">Logout</td>

            </tr>
        </thead>
        <tbody><?php
$res = $pm->getCount("SELECT count(id) as c from log_activity");

$numrows = $res;
$rowsperpage = 10;
$totalpages = ceil($numrows / $rowsperpage);
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
    $currentpage = (int) $_GET['currentpage'];
} else {
    $currentpage = 1;
}
if ($currentpage > $totalpages) {
    $currentpage = $totalpages;
} // end if
if ($currentpage < 1) {
    $currentpage = 1;
} // end if
$offset = ($currentpage - 1) * $rowsperpage;

$results = $pm->run("SELECT * from log_activity LIMIT  $offset, $rowsperpage");
//    echo '<p class="clearfix">List of users found. <span class="label label-info">' . count($results) . '</span>  users.</p>';
foreach ($results as $result) {
    ?>
                <tr align="center">
                    <td><?php echo $result['id']; ?></td>
                    <td align="left"><?php echo $result['username']; ?></td>
                    <td align="left"><?php echo $result['ip_address']; ?></td>
                    <td align="left"><?php echo $result['login']; ?></td>
                    <td align="left"><?php echo $result['logout']; ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
    <h4> <?php
            if ($currentpage > 1) {
                // show << link to go back to page 1
                echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'>First</a> ";
                // get previous page num
                $prevpage = $currentpage - 1;
                // show < link to go back to 1 page
                echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Previous</a> ";
            } // end if 
            $range = 3;
            // loop to show links to range of pages around current page
            for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                // if it's a valid page number...
                if (($x > 0) && ($x <= $totalpages)) {
                    // if we're on current page...
                    if ($x == $currentpage) {
                        // 'highlight' it but don't make a link
                        echo " [<b>$x</b>] ";
                        // if not current page...
                    } else {
                        // make it a link
                        echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
                    } // end else
                } // end if 
            } // end for       
            if ($currentpage != $totalpages) {
                // get next page
                $nextpage = $currentpage + 1;
                // echo forward link for next page 
                echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a> ";
                // echo forward link for lastpage
                echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a> ";
            } // end if
            ?></h4>
    <p>&nbsp;</p> 
</div>
<?php include 'footer.php'; ?>