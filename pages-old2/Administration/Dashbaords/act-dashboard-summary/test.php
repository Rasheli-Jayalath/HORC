<?php include_once("../../config/config.php"); 
$objDb  		= new Database();
$objDb3 		= new Database();

$sql2 = "select * from activity_dashboard_graph";
$objDb->dbQuery($sql2);
 $count=$objDb->totalRecords();

$planned_str= '[{
                type: "line",
                name: "Planned",
                data:[';
$ii=0;
while($gresult = $objDb->dbFetchArray())
{
	$ii++;
$planned=$gresult['planned'];
$date_month=strtotime($gresult['a_month'])."000";
$file=fopen("file.json","w");

		$planned_str.= "
				[".$date_month." , ".$planned." ]";
				if($ii<$count)
					 {
						$planned_str.=",";
					 }
				
}
	$planned_str.= ']},{
                type: "line",
                name: "Actual",
                data: [';		
	$jj=0;
$sql3 = "select * from activity_dashboard_graph";
$objDb3->dbQuery($sql3);
 $count=$objDb3->totalRecords();
while($gresult = $objDb3->dbFetchArray())
{
	$jj++;
$actual=$gresult['actual'];
$date_month=strtotime($gresult['a_month'])."000";

		$planned_str.= "
				[".$date_month." , ".$actual." ]";
				if($jj<$count)
					 {
						$planned_str.=",";
					 }
				
}	
$planned_str.="]}]";
				file_put_contents('file.json', $planned_str);
				

?>