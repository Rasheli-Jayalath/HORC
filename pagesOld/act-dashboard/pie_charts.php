<?php include_once("../../config/config.php"); 
$objDb  		= new Database();?>

<?php

$sql = "select * from courses";
$objDb->dbQuery($sql);
while($result = $objDb->dbFetchArray())
{
$rows[]=array("c"=>array("0"=>array("v"=>$result['subject'],"f"=>NULL),"1"=>array("v"=>(int)$result['number'],"f" =>NULL)));

}

echo $format = '{
"cols":
[
{"id":"","label":"Subject","pattern":"","type":"string"},
{"id":"","label":"Number","pattern":"","type":"number"}
],
"rows":'.json_encode($rows).'}';

?>