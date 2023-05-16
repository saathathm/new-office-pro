<?php 
class Calendar
{
	var $events;
	var $persistanceManager;

	function Calendar($date,$emp_id)
	{  
		if(empty($date)) $date = time();
		define('NUM_OF_DAYS', date('t',$date));
		define('CURRENT_DAY', date('j',$date));
		define('CURRENT_MONTH_A', date('F',$date));
		define('CURRENT_MONTH_N', date('n',$date));
		define('CURRENT_MONTH_M', date('m',$date));
		define('CURRENT_YEAR', date('Y',$date));
		define('START_DAY', date('N', mktime(0,0,0,CURRENT_MONTH_N,1, CURRENT_YEAR)) - 1);
		define('COLUMNS', 7);
		define('PREV_MONTH', $this->prev_month());
		define('NEXT_MONTH', $this->next_month());
		$this->events = array();
		
		// system date
		define('SYSTEM_YEAR', date('Y',time()));
		define('SYSTEM_MONTH', date('m',time()));
		define('SYSTEM_DAY', date('j',time()));
		
		//$this->persistanceManager = ApplicationManager::getInstance()->getPersistanceManager();
	}

	function prev_month()
	{
		return mktime(0,0,0,
				(CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1),
				(checkdate((CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), CURRENT_DAY, (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1),
				(CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR));
	}
	
	function next_month()
	{
		return mktime(0,0,0,
				(CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1),
				(checkdate((CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1) , CURRENT_DAY ,(CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1),
				(CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR));
	}
	
	function getEvent($timestamp)
	{
		$event = NULL;
		if(array_key_exists($timestamp, $this->events))
			$event = $this->events[$timestamp];
		return $event;
	}
	
	function addEvent($event, $day = CURRENT_DAY, $month = CURRENT_MONTH_N, $year = CURRENT_YEAR)
	{
		$timestamp = mktime(0, 0, 0, $month, $day, $year);
		if(array_key_exists($timestamp, $this->events))
			array_push($this->events[$timestamp], $event);
		else
			$this->events[$timestamp] = array($event);
	}
	
	function makeEvents()
	{
		if($events = $this->getEvent(mktime(0, 0, 0, CURRENT_MONTH_N, CURRENT_DAY, CURRENT_YEAR)))
			foreach($events as $event) echo $event.'<br />';
	}
	
	function makeCalendar($action,$include_file_path)
	{
		
//		$modelDialog = new ModelDialog();
//		echo $modelDialog->getStandardDialog("bookingDetailModal", "Booking Detail");

		echo '<div style="float:left;">';
		echo '<ul class="pager" style="margin:0px;">';
		echo '<li><a href="?actionType=custom&action=viewCalendarAction&temp=1&date='.PREV_MONTH.'">Previous</a></li>';
		echo ' '.CURRENT_MONTH_A .' - '. CURRENT_YEAR.' ';
		echo '<li><a href="?actionType=custom&action=viewCalendarAction&temp=1&date='.NEXT_MONTH.'">Next</a></li>';
		echo '</ul>';
		echo '</div>';

		echo '<div style="float:right;">';
		//echo '<a href="?temp=1&month='.CURRENT_MONTH_M.'&year='.CURRENT_YEAR.'" class="btn btn-primary">Table View</a>';
                switch ($action) {
                    case 'individual':
                        echo '<div style="clear:both;"></div>';
		echo '<div style="padding-bottom:10px;"></div>';
		echo '<span class="label label-success">'."Medical".'</span>';
                echo '<span class="label label-info">'."Casual".'</span>';
                echo '<span class="label label-warning">'."Annual".'</span>';
                echo '<span class="label label-inverse">'."Short".'</span>';

                          echo '<a href="view_leave_history.php" class="btn btn-primary">Table View</a>';
                        break;
                     case 'admin':
                         echo '<div style="clear:both;"></div>';
		echo '<div style="padding-bottom:10px;"></div>';
		echo '<span class="label label-success">'."Medical".'</span>';
                echo '<span class="label label-info">'."Casual".'</span>';
                echo '<span class="label label-warning">'."Annual".'</span>';
                echo '<span class="label label-inverse">'."Short".'</span>';
                           echo '<a href="view_leave_summary.php" class="btn btn-primary">Table View</a>';

                        break;

                    default:
                        break;
                }
              
		echo '</div>';
		
		echo '<div style="float:right; padding-right:10px;">';
		//echo '<a href="?actionType=custom&action=bookingCreateFormAction&cc=1&temp=1" class="btn btn-danger">Add New</a>';
		echo '</div>';
		
		
                
		echo '<table border="1" width="100%" class="table">';
		echo '<tr align="center" style="background-color:#000; color:#fff;" height="10px;">';
		echo '<td width="100px;" >Monday</td>';
		echo '<td width="100px;" >Tuesday</td>';
		echo '<td width="100px;" >Wednesday</td>';
		echo '<td width="100px;" >Thursday</td>';
		echo '<td width="100px;" >Friday</td>';
		echo '<td width="100px;" >Saturday</td>';
		echo '<td width="100px;" >Sunday</td>';
		echo '</tr>';
		echo '<tr height="100px;" valign="top" class="">';
		
		
		echo str_repeat('<td>&nbsp;</td>', START_DAY);
		
		$rows = 1;
		function isWeekend($wedate) {
    $weekDay = date('N', strtotime($wedate));
    return ($weekDay == 7 || $weekDay == 6);
}
 
		for($i = 1; $i <= NUM_OF_DAYS; $i++)
		{
                    $m=CURRENT_MONTH_N;
                    $Y=CURRENT_YEAR;
                    $wedate=date("$Y-$m-$i");
                    $t=isWeekend($wedate);
			  if(!$t){	
			echo '<td>'; 
                        echo $i;
                    
        		include ''.$include_file_path.'';
                        //include 'tra_events.php';//include event
                          echo '</td>';
                      }
                        else{echo '<td  style="background-color: #FFFEA6">'; 
                        echo $i;
                        echo '</td>';}
                      
			/*
			if($i == CURRENT_DAY)
				echo '<td style="background-color: #C0C0C0"><strong>'.$i.'</strong></td>';
			else if($event = $this->getEvent(mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR)))
				echo '<td style="background-color: #99CCFF"><a href="?date='.mktime(0,0,0,CURRENT_MONTH_N,$i,CURRENT_YEAR).'">'.$i.'</a></td>';
			else
				echo '<td><a href="?date='.mktime(0 ,0 ,0, CURRENT_MONTH_N, $i, CURRENT_YEAR).'">'.$i.'</a></td>';
			*/
					
			if((($i + START_DAY) % COLUMNS) == 0 && $i != NUM_OF_DAYS)
			{
				echo '</tr>';
				echo '<tr height="100px;"  valign="top">';
				$rows++;
			}
		}
		echo str_repeat('<td>&nbsp;</td>', (COLUMNS * $rows) - (NUM_OF_DAYS + START_DAY)).'</tr></table>';
	}
	

}
?>


