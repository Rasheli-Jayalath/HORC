<?php
include_once("../../config/config.php");
$objDb  		= new Database();
$ObjKfiDash1 = new ActDashboard();
$ObjKfiDash2 = new ActDashboard();
$ObjKfiDash3 = new ActDashboard();
$ObjKfiDash4 = new ActDashboard();
$ObjKfiDash5 = new ActDashboard();
$ObjKfiDash6 = new ActDashboard();
$ObjKfiDash7 = new ActDashboard();
$ObjKfiDash8 = new ActDashboard();
$ObjKfiDash9 = new ActDashboard();
$ObjKfiDash10 = new ActDashboard();
$ObjKfiDash11 = new ActDashboard();
$ObjKfiDash22 = new ActDashboard();
$ObjKfiDash33 = new ActDashboard();
$ObjKfiDash99 = new ActDashboard();

$parentcd=NULL;
$lid=0;
 $itemids = $_GET['itemids'];
$itemname = $_GET['itemname'];
if(isset($itemids)&&$itemids!=0&&$itemids!='')
{
	$sql="SELECT parentcd, parentgroup FROM maindata where itemid=".$itemids;
	$objDb->dbQuery($sql);
	 $iiCount = $objDb->totalRecords();
	 if($iiCount>0)
	 {
		$pcdrows = $objDb->dbFetchArray();
		$parentcd=$pcdrows["parentcd"];
		$parentgroup=$pcdrows["parentgroup"];
	 }

}

?>

<!-- Table 1 goes here -->
<h4 style="margin-top:20px;text-align:center; font-weight:800" id="tabletitlename"><?php echo $itemname ?></h4>
<?php /*?><table   align="center" class="project"  height="265px">
	<tr ><td><div id="container" style="min-width: 310px;height:223px;"></div>
								 </td></tr></table><?php */?>

     <!-- Main data table ends here -->

<table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody>

<tr>
  <th width="17" height="37" rowspan="2">#</th>
  <th width="58" rowspan="2">Code</th>
  <th width="139" rowspan="2">Activity</th>
<!--  <th width="60" rowspan="2">Weight</th>-->
  <th width="60" rowspan="2">Indicator</th>
  <th colspan="2">Planned</th>
  <th width="53" rowspan="2">Upto Date</th>
  <th width="57" rowspan="2">Planned Days</th>
  <th width="53" rowspan="2">Days Elapsed</th>
  <th width="39" rowspan="2">Total Work</th>
  <th width="57" rowspan="2">Planned Work</th>
  <th width="47" rowspan="2">Actual Work</th>
  <th width="71" rowspan="2" title="Difference">&#916;</th>
  <th width="66" rowspan="2"> Required  Rate</th>
  <th width="75" rowspan="2">Projected Date</th>
  <th width="63" rowspan="2">Progress</th>
  <!--  <th width="110">Contract Amount</th> -->  
</tr>
<tr>
  <th width="85">Start</th>
  <th width="91">Finish</th>
  </tr>
  
  <?php 
$projected_daten=$projected_date;
$average_progress=0;
$total_work_done=0;
$grand_total=0;
$pgrand_total=0;
$total_amount=0;
$i=0;
$today_qty=0;
$till_today_qty=0;
$work_done=0;
$p_work_done=0;
$numberDaysRemaining=0;
$timeDelayedDiff=0;
$numberDaysDelayed=0;
$start_date="";
$end_date="";
$difference=0;
$remaining=0;
$require_daily_rate=0;
$average_rate=0;
$projected_date="";
$totalNumberDays=0;
$actualEndTimeStamp =0;
$actualStartTimeStamp=0;
$actTimeDiff =0;
$ActualnumberDays = 0;
$days_remaining=0;
$current_daily_rate=0;
$count=0;
$case=0;
$tolerance=0.1;
$timeRemainingDiff=0;
$next_level_id=0;?>
<?php if($parentgroup!=0&&$parentgroup!="")
		{
		 $reportquery_act ="SELECT * from maindata where parentcd=".$itemids ;
		 $ObjKfiDash1->dbQuery($reportquery_act);
			 $check=$ObjKfiDash1->totalRecords();
			
		if($check==0)
		{
		 $reportquery_act ="SELECT * from maindata where itemid=".$parentcd;
		 $ObjKfiDash1->dbQuery($reportquery_act);
		}
	while ($reportdata_act = $ObjKfiDash1->dbFetchArray()) {
		
		$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
		$i++;
		$parent_group=$reportdata_act["parentgroup"];
		$act_name=$reportdata_act["itemname"];
	    $act_code=$reportdata_act["itemcode"];
		
			$average_rate=0;
		    $projected_days=0;
		    $projected_date='';
		   // $next_level_id=GetNextLevel($reportdata_act["itemid"]);
		  /* if($reportdata_act["isentry"]==1)
		   {
   $reportquery ="select startdate , enddate, baseline, progressmonth, total_progress, required_rate, actual_rate, expected_date, total_days, days_elapsed, isdelay, isdelayed From activity  where itemid=".$reportdata_act["itemid"];
		   }
		   else
		   {
			    $reportquery ="select startdate , enddate, baseline, progressmonth, total_progress, required_rate, actual_rate, expected_date, total_days, days_elapsed, isdelay, isdelayed From activity0  where itemid=".$reportdata_act["itemid"];
		   }*/
	  $reportquery ="select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline,max(b.progressmonth) as progressmonth, sum(b.total_progress) as total_progress, b.required_rate, b.actual_rate, b.expected_date, b.total_days, b.days_elapsed, b.isdelay, b.isdelayed from (select a.startdate, a.enddate, a.baseline ,a.itemid,a.progressmonth, a.total_progress, a.required_rate, a.actual_rate, a.expected_date, a.total_days, a.days_elapsed, a.isdelay, a.isdelayed From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$reportdata_act["parentgroup"]."%'  GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
		 //echo "<br/>";
		/*if($reportdata_act["isentry"]==1)
		{
		echo $reportquery ="select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline,b.progressmonth,b.total_progress, b.required_rate, b.actual_rate, b.expected_date, b.total_days, b.days_elapsed, b.isdelay, b.isdelayed from (select a.startdate, a.enddate, a.baseline ,a.itemid,a.progressmonth, a.total_progress, a.required_rate, a.actual_rate, a.expected_date, a.total_days, a.days_elapsed, a.isdelay, a.isdelayed From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$reportdata_act["parentgroup"]."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
		}
		else
		{
				echo $reportquery ="select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline,b.progressmonth,b.total_progress, b.required_rate, b.actual_rate, b.expected_date, b.total_days, b.days_elapsed, b.isdelay, b.isdelayed from (select a.startdate, a.enddate, a.baseline ,a.itemid,a.progressmonth, a.total_progress, a.required_rate, a.actual_rate, a.expected_date, a.total_days, a.days_elapsed, a.isdelay, a.isdelayed From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$reportdata_act["parentgroup"]."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
		}
*/	        //echo "<br/>";
	         $ObjKfiDash3->dbQuery($reportquery);
			 $ObjKfiDash3->totalRecords();
			$reportdata = $ObjKfiDash3->dbFetchArray();
			if(isset($reportdata['enddate'])&&$reportdata['enddate']!=""&&isset($reportdata['startdate'])&&$reportdata['startdate']!="")
			{
			$numberDays=$ObjKfiDash4->CalculateActualPlannedDays($reportdata['enddate'],$reportdata['startdate']);
			}
			// $numberDays=$reportdata["total_days"];
			 $last_date=$reportdata["progressmonth"];
			 $current_date_c=$last_date;
			 $currentTimeStamp=strtotime($last_date);
			 $actual_finish_date=$current_date_c;
			 $ActualEndTimeStamp =strtotime($actual_finish_date);
			  $final_date=$reportdata_scale['enddate'];
			 $endTimeStamp =strtotime($reportdata_scale['enddate']);
			 if($current_date_c>$reportdata['enddate'])
			 {
				 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
				  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
				  $numberDaysDelayed = intval($numberDaysDelayed);
			 }
			 $till_today_qty=$reportdata["total_progress"];
			 if(isset($reportdata['enddate'])&&$reportdata['enddate']!=""&&isset($reportdata['startdate'])&&$reportdata['startdate']!="")
			{
			  $planned_progress=$ObjKfiDash7->PlannedProgressOutput($reportdata_act["itemid"],$current_date_c,$reportdata['enddate'],$reportdata['startdate'],$reportdata_act["isentry"]);
			  //$ObjKfiDash11->GetActualQtysOutputLevel($aparentgroup,$temp_id);
$ObjKfiDash22->GetPlannedQtysOutputLevel($reportdata_act["parentgroup"],$reportdata_act["itemid"],$current_date_c,$reportdata['enddate'],$reportdata['startdate'],$reportdata_act["isentry"]);
			}
			  if($reportdata['baseline']!=0)
			{
			//$work_done=$till_today_qty/$reportdata['baseline']*100;
			$work_done=$till_today_qty/100;
			$total_work_done +=$work_done;
			}
			else
			{
			$work_done=0;
			}
			if($planned_progress!=0)
			{
			$difference=$planned_progress-$till_today_qty;
			}
			else
			{
			$difference=0;
			}
			if($reportdata["baseline"]!=0)
			{
			$remaining=$reportdata["baseline"]-$till_today_qty;
			}
			else
			{
			$remaining=0;
			}
			$tolerance_check=$reportdata["baseline"]*$tolerance/100;
			if($remaining<0)
			{
				
				if(abs($remaining)<=$tolerance_check)
				{
					$remaining=0;
					
				}
				
			}
			if($current_date_c>$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
			{
			$case=1;
			$actual_finish_date=$current_date_c;
			}
			elseif($current_date_c>$reportdata["enddate"]&& $remaining==0 && $till_today_qty!=0)
			{
			$case=2;
			$actual_finish_date=$reportdata["progressmonth"];
			}
			elseif($current_date_c<$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
			{
			$case=3;
			$actual_finish_date=$current_date_c;
			}
			elseif($current_date_c<$reportdata["enddate"]&&$remaining==0&&$till_today_qty!=0)
			{
			$case=4;
			$actual_finish_date=$reportdata["progressmonth"];
			}
			elseif($remaining<0&&$till_today_qty!=0)
			{
			
			$case=5;
			$actual_finish_date=$reportdata["progressmonth"];
			}
			elseif($till_today_qty==0)
			{
			
			$case=6;
			$actual_finish_date=$current_date_c;
			}
			else
			{
				$case=0;
				
				$actual_finish_date="";
			}
			if($actual_finish_date>$reportdata['startdate'])
			 {
			 $numberDaysElapsed =$reportdata["days_elapsed"];
				
			  if($numberDays!=0)
			  {
				  
			  $time_elapsed_percent=($numberDaysElapsed/$numberDays)*100;
			  }
			  else
			  {
				  $time_elapsed_percent=0;
				   $numberDaysElapsed=0;
				 }
			 }
			 else
			 {
				 $time_elapsed_percent=0;
				 $numberDaysElapsed=0;
			}
				//////////////////// Remaining days
				if($actual_finish_date!=""&&$reportdata["enddate"]>=$actual_finish_date&& $remaining>0)
				 {
					
					  $timeRemainingDiff= abs($endTimeStamp - $ActualEndTimeStamp);
					  $numberDaysRemaining = ceil($timeRemainingDiff/86400);
					  $numberDaysRemaining = intval($numberDaysRemaining);
				 }
				 
				 //  Current Daily rate
				 $ActualnumberDays=$numberDays;
				 
				 if($ActualnumberDays!=0&&$remaining!=0)
				 {
					 $current_daily_rate=$till_today_qty/$ActualnumberDays;
				 }
				 else
				 {
					 $current_daily_rate=0;
				 }
				if($numberDaysRemaining!=0&&$remaining!=0)
				{
				 //$require_daily_rate=$reportdata['required_rate'];
				 $require_daily_rate=($remaining)/$numberDaysRemaining;
				 				}
				else
				{
				$require_daily_rate=0;
				//$bgcolor='#FF0';
				}
				if($current_daily_rate!=0&&$remaining>0)
				{
				$projected_days=$remaining/($current_daily_rate);
				}
				
				$projected_days=intval($projected_days);
				if($projected_days!=0)
				{
				 $projected_date=date("Y-m-d", strtotime($actual_finish_date. "+".$projected_days." days" ));
				}
				else
				{
				$projected_date="";
				}
				$count++;
				
			 if($totalNumberDays!=0&&$totalNumberDays!="")
			 {
				$weight=($numberDays/$totalNumberDays);
			 }
			 else
			 {
				 $weight=0;
			 }
		
	?>
  <tr style="background-color:<?php echo $bgcolor;?>; ">
<td height="20" style="text-align:center;"><?php echo $i;?></td>
<td style="text-align:left;"><span style="text-align:center;"><?php echo $act_code;?></span></td>
<td ><span style="text-align:left;"><?php echo $act_name;?></span></td>
<?php /*?><td style="text-align:center;"><?php echo $act_weight;?></td><?php */?>
<td style="text-align:center;"><?php 
if($case==1)
									echo '<img src="../../images/images/indicators/red.png" width="25px" title="Delayed Against Schedule">';
								    elseif($case==2)
									echo '<img src="../../images/images/indicators/green.png" width="25px" title="Completed">';
									elseif($case==3)
									echo '<img src="../../images/images/indicators/yellow.png" width="25px" title="Continued">';
									elseif($case==4)
									echo '<img src="../../images/images/indicators/green.png" width="25px" title="Completed">';
									elseif($case==5)
									echo '<img src="../../images/images/indicators/pink.png" width="25px" title="Indicator for Quantity Overuse" >';
									elseif($case==6)
									echo '<img src="../../images/images/indicators/blue.png" width="25px" title="Not yet Started" >';
									?></td>
<td style="text-align:right;"><?php 
if(isset($reportdata["startdate"])&&$reportdata["startdate"]!=""&&$reportdata["startdate"]!="1970-01-01"&&$reportdata["startdate"]!="0000-00-00")
  	{
		echo date('d-m-Y',strtotime($reportdata["startdate"]));
		
	}
	else
	{
	echo "-";}?></td>
<td style="text-align:right;"><?php 
if(isset($reportdata["enddate"])&&$reportdata["enddate"]!=""&&$reportdata["enddate"]!="1970-01-01"&&$reportdata["enddate"]!="0000-00-00")
  	{
		echo date('d-m-Y',strtotime($reportdata["enddate"]));
		
		
	}
	else
	{
	echo "-";}?></td>
<td style="text-align:right;"><?php 
if(isset($actual_finish_date)&&$actual_finish_date!=""&&$actual_finish_date!="1970-01-31"&&$actual_finish_date!="0000-00-00")
  	{
		echo date('d-m-Y',strtotime($actual_finish_date));
		
		
	}
	else
	{
	echo "-";}?></td>
<td style="text-align:right;"><?php echo $numberDays;?></td>
<td style="text-align:right;"><?php echo $numberDaysElapsed;?></td>
<td style="text-align:right;"><?php echo number_format(($reportdata["baseline"]),0);?></td>
<td style="text-align:right;"><?php echo number_format($planned_progress,0);?></td>
<td style="text-align:right;"><?php echo number_format($till_today_qty,0);?></td>
<td style="text-align:right;"><?php echo number_format(($difference),0);?></td>
<td style="text-align:right;"><?php echo number_format(($require_daily_rate),4);?></td>
<td style="text-align:right;"><?php if($projected_date!=""&&$projected_date!="1970-01-01"&&$projected_date!="0000-00-00")
									echo date('d-m-Y',strtotime($projected_date));?></td>
<td style="text-align:right;"><?php if($reportdata["baseline"]!=0){
	echo number_format($till_today_qty/$reportdata["baseline"]*100,2) ." %";
}
else
{
echo "0.00 %";}?></td>
</tr>
<?php
$numberDays=0;
$numberDaysElapsed=0;
$planned_progress=0;
$till_today_qty=0;
$difference=0;
$require_daily_rate=0;

	} // end inner loop
	
?>

<?php 
  
			
			}  // end if condition  ?>
            <tr >
<td height="20" style="text-align:left;border-bottom-color:#FFF;background-color: rgb(169, 210, 248);" colspan="16">
<img src="../../images/images/indicators/green.png" width="25px" title="Completed" style="vertical-align:middle">&nbsp;&nbsp;<span >Completed</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="../../images/images/indicators/red.png" width="25px" title="Delayed Against Schedule" style="vertical-align:middle">&nbsp;&nbsp;<span >Delayed Against Schedule</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="../../images/images/indicators/yellow.png" width="25px" title="Continued" style="vertical-align:middle">&nbsp;&nbsp;<span style="vertical-align:middle" >Continued</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="../../images/images/indicators/pink.png" width="25px" title="Indicator for Quantity Overuse"  style="vertical-align:middle">&nbsp;&nbsp;<span style="vertical-align:middle" >Indicator for Quantity Overuse</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="../../images/images/indicators/blue.png" width="25px" title="Not yet Started" style="vertical-align:middle" >&nbsp;&nbsp;<span style="vertical-align:middle" >Not yet Started</span>
</td>
</tr>
           
 </tbody>         
</table>

<?php
$actual_finish_date="";
$case=0;
$numberDaysRemaining=0;

?>