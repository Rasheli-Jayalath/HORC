<?php include_once("../../config/config.php"); 
$objDb  		= new Database();?>

<?php


/*$data[] = array('Date','Planned','Actual');
$sql1 = "select min(a_month) as start, max(a_month) as end, planned,actual from activity_dashboard_graph";
$objDb->dbQuery($sql1);
while($result = $objDb->dbFetchArray())
{
$data[] = array($result['a_month'],(int)$result['planned'],(int)$result['actual']);

}*/
//print_r($data);
$sql1 = "select min(a_month) as start, max(a_month) as end, planned,actual from activity_dashboard_graph";
$objDb->dbQuery($sql1);
$range_result = $objDb->dbFetchArray();
$start=$range_result['start'];
$end=$range_result['end'];
$sql2 = "select planned from activity_dashboard_graph";
$objDb->dbQuery($sql2);
$planned_result = $objDb->dbFetchArray();
$planned=$planned_result['planned'];

$sql2 = "select actual from activity_dashboard_graph";
$objDb->dbQuery($sql2);
$actual_result = $objDb->dbFetchArray();
$actual=$actual_result['actual'];

?>