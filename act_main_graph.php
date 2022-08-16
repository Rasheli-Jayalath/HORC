<?php 
include_once("config/config.php"); 
$objDb  		= new Database();


$sql2 = "select * from activity_dashboard_graph_main";
$objDb->dbQuery($sql2);
 $count=$objDb->totalRecords();

$planned_str= '[';
$ii=0;
while($gresult = $objDb->dbFetchArray())
{
	$ii++;
$planned=$gresult['planned'];
$actual=$gresult['actual'];
$date_month=strtotime($gresult['a_month'])."000";


		$planned_str.= "
				[".$date_month." , ".$planned.",". $actual." ]";
				if($ii<$count)
					 {
						$planned_str.=",";
					 }
				
}
$planned_str.=']';
echo $planned_str;
?>