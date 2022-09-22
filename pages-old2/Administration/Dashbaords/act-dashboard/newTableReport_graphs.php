<?php
include_once("../../config/config.php");
$objDb  		= new Database();
$ObjKfiDash44 = new ActDashboard();
$ObjKfiDash55 = new ActDashboard();
$ObjKfiDash66 = new ActDashboard();
$ObjKfiDash77 = new ActDashboard();
$ObjKfiDash88 = new ActDashboard();
$ObjKfiDash99 = new ActDashboard();
$ObjKfiDash10 = new ActDashboard();
$ObjKfiDash11 = new ActDashboard();
$ObjKfiDash22 = new ActDashboard();
$ObjKfiDash33 = new ActDashboard();
$ObjKfiDash99 = new ActDashboard();
 $parentcd=NULL;
$lid=0;
$temp_id=1;
$itemids = $_GET['itemids'];
$itemname = $_GET['itemname'];

if(isset($itemids) && $itemids!= 0 &&$itemids!='')
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

<!-- Graph 1 goes here -->
<?php	 
 $total_progress=$ObjKfiDash44->GetActualQtysOutputLevelG($aparentgroup,$aweight);
 $total_planned_progress=$ObjKfiDash55->GetPlannedQtysOutputLevelG($aparentgroup);
 $scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as total_baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale =$objDb->dbQuery($scale_query);
	$reportdata_scale=$objDb->dbFetchArray();
	$total_baseline=$reportdata_scale["total_baseline"];
	$remaining=$total_baseline-$total_progress;
	$last_date=$ObjKfiDash11->GetlastDateOutput($aparentgroup);
			 $actual_start_date=$ObjKfiDash22->ActualStartDateOutput($aparentgroup);
			 $current_date_c=$last_date;
			 $currentTimeStamp=strtotime($last_date);
			 $startTimeStamp=strtotime($reportdata_scale['startdate']);
			 $final_date=$reportdata_scale['enddate'];
			 $endTimeStamp =strtotime($reportdata_scale['enddate']);
			 $numberDays=$ObjKfiDash33->CalculateActualPlannedDays($reportdata_scale['enddate'],$reportdata_scale['startdate']);
			 $actual_finish_date=$current_date_c;
			 $ActualEndTimeStamp =strtotime($actual_finish_date);
			 if($current_date_c>$reportdata_scale['enddate'])
			 {
				 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
				  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
				  $numberDaysDelayed = intval($numberDaysDelayed);
			 }
			 	if($actual_finish_date>$reportdata_scale['startdate'])
			 	{
				 
				  $numberDaysElapsed  =$ObjKfiDash44->CalculateElapsedDays($actual_finish_date,$reportdata_scale['startdate']);
				
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
			if($actual_finish_date!=""&&$reportdata_scale["enddate"]>=$actual_finish_date&& $remaining>0)
	 {
	
		  $timeRemainingDiff= abs($endTimeStamp - $ActualEndTimeStamp);
		  $numberDaysRemaining = ceil($timeRemainingDiff/86400);
		 $numberDaysRemaining = intval($numberDaysRemaining);
	 }
	  if($numberDaysElapsed!=0&&$remaining!=0)
	 {
		 $current_daily_rateg=$total_progress/$numberDaysElapsed;
	 }
	 else
	 {
		 $current_daily_rateg=0;
	 }
	 if($numberDaysRemaining!=0&&$remaining!=0&&$numberDaysElapsed!=0)
	{
	
	$require_daily_rateg=($remaining)/$numberDaysRemaining;
	}
	elseif($numberDaysElapsed==0&& $current_date_c<$reportdata_scale['startdate'])
	{
	 	
	$require_daily_rateg=0;
	}
	else
	{
	$require_daily_rateg=0;
	//$bgcolor='#FF0';
	}
	if($current_daily_rateg!=0&&$remaining>0)
	{
	$projected_days=$remaining/($current_daily_rateg);
	}
	
	$projected_days=intval($projected_days);
	
	if($projected_days!=0&&$numberDaysElapsed!=0)
	{
	$projected_date=date("Y-m-d", strtotime($actual_finish_date. "+".$projected_days." days" ));
	}
	elseif($projected_days==0&&$numberDaysElapsed==0)
	{
		
	$projected_date=$end_date;
	}
	else
	{
	$projected_date="";
	}
	?>
<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding:0; margin:0;"> 
<tr> 
<td align="left" valign="top" width="50%" >
<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<?php echo $adetail;?>'
            },
            subtitle: {
                text: '<?php echo "Progress To-Date "; ?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                     month: '%m-%Y',
                	 year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '% Done'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' <?php echo $unit;?>';
                }
            },
            legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 50,
            floating: true/*,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
        },
            series: [
		{
                name: '<?php echo trim(stripslashes($reportdata['sdetail']));
				echo "Actual Progress: ";?><?php echo '<span style="color:blue">'.number_format(round($total_progress)/$total_baseline*100,2).'%</span>';?>',
                
                data: [
				<?php echo $ObjKfiDash77->GetActualQtysOutputLevel($aparentgroup,$temp_id);?>
       
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned: <?php echo '<span style="color:blue">'.number_format( $total_planned_progress/$total_baseline*100,2).'%</span>';?>',
                data: [
				
				<?php echo $ObjKfiDash88->GetPlannedQtysOutputLevel($aparentgroup,$temp_id);?>
                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			,
			{ name: 'Current Work Rate (Per Day): <?php echo '<span style="color:blue">'.number_format(round($current_daily_rateg)/$total_baseline*100,2).'%</span>';?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Required Rate (Per Day): <?php echo '<span style="color:blue">'.number_format(round($require_daily_rateg)/$total_baseline*100,2).'%</span>';?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Projected Completion Date with Current Rate: <?php 
			if($projected_date!=""&& $projected_date!="1997-01-01" && $projected_date!="0000-00-00") 
			{
				echo '<span style="color:blue">'.date('d-M-Y',strtotime($projected_date)).'</span>';
			}?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }},
				{ name: 'Planned Completion Date: <?php 
				if($final_date!=""&& $final_date!="1997-01-01" && $final_date!="0000-00-00") 
			{
				echo '<span style="color:blue">'.date('d-M-Y',strtotime($final_date)).'</span>';
			}?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
			]
        });
    });
    

		</script>
        <table width="100%"  align="left" border="0" style="margin:0">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
