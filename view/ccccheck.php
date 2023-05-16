<?php
 echo 'hhhh';  die;
//include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
if(isset($_REQUEST['date2'])){$date=$_REQUEST['date2'];}
 
  $time = strtotime($date);
        $day = date('w',$time);
        if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
        

         //$day=6;
        $time += ((7*@$week)+1-$day)*24*3600;
        $start = date('Y-n-j',$time);
        $time += 6*24*3600;
        $end = date('Y-n-j',$time);
?>
<script type="text/javascript">
function download()
{
	window.location='report.xls';
}
</script>
<?php

        $excel=new ExcelWriter("report.xls");
        if($excel==false)	
        echo $excel->error;
        $myHeader=array("<b>Reports From</b>&nbsp"."<b></b>&nbsp"."<b>To</b>&nbsp"."<b></b>");
        $mySpace=array("");
        $myArr=array("<b>Name</b>","<b>Must Work(H:M)</b>","<b>Hours Worked</b>","<b>Signature</b>");
        $excel->writeLine($myHeader);
        $excel->writeLine($mySpace);
        $excel->writeLine($myArr);

   


      
        $myArr=array("uiui","$ti","$time22");
        $excel->writeLine($myArr);
 ?>


<h1 align="center"><button onClick="download();" class="btn btn-primary">Download Excel Report</button></h1>