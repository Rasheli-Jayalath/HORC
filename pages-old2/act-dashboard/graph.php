<?php 
include_once("../../config/config.php"); 
$objDb  		= new Database();


$sql1 = "select min(a_month) as start, max(a_month) as end, planned,actual from activity_dashboard_graph";
$objDb->dbQuery($sql1);
$range_result = $objDb->dbFetchArray();
$open=date('Y',strtotime($range_result['start']));
$start=date('Y',strtotime($range_result['start']));
$end=date('Y',strtotime($range_result['end']));
$sql2 = "select planned from activity_dashboard_graph";
$objDb->dbQuery($sql2);
$i=0;
$j=0;
while($planned_result = $objDb->dbFetchArray())
{
$planned[$i]=$planned_result['planned'];
$i++;
}
$planned=implode(",",$planned);

$sql2 = "select actual from activity_dashboard_graph";
$objDb->dbQuery($sql2);
while($actual_result = $objDb->dbFetchArray())
{
$actual[$j]=$actual_result['actual'];
$j++;
}
$actual=implode(",",$actual);
echo "Range: $start to $end/$planned/$actual/$open";
?>