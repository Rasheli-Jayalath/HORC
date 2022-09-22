<?php
include_once("../../config/config.php");
$objDb  		= new Database();
//////////////////// Step 5 ////////////////////////////////////////////////////////////

$objDb->dbQuery("truncate table kpidata_etl");
$objDb->dbQuery("truncate table kpidata_result");

//////////////////// Step 6 ////////////////////////////////////////////////////////////

$psSQL = "select kpiid, parentcd, parentgroup, scid, unit, baseline, kpi_comm_planned, kpi_comm_actual from kpi_base_level_report group by kpiid, temp_id, scid";
$psResult =$objDb->dbQuery($psSQL);
while ($psData = $objDb->dbFetchArray()) {
	$kpiid = $psData['kpiid'];
	$parentcd = $psData['parentcd'];
	$parentgroup = $psData['parentgroup'];
	$scid = $psData['scid'];
	$unit = $psData['unit'];
	$baseline = $psData['baseline'];
	$kpi_comm_planned = $psData['kpi_comm_planned'];
	$kpi_comm_actual = $psData['kpi_comm_actual'];
	$psarray = array();
	$psarray = explode("_", $parentgroup);
	$pslength = count($psarray);
	$weight = 1;
	for ($i = ($pslength-1); $i >=0; $i--) {
		
		$ptdataSQL = "insert into kpidata_etl (kpiid, parentcd, parentgroup, activitylevel, stage, itemcode, itemname, weight, isentry, resources, aorder, kpi_temp_id, scid, unit, baseline, weighted_planned, weighted_actual, kpi_comm_planned, kpi_comm_actual) SELECT kpiid, parentcd, parentgroup, activitylevel, stage, itemcode, itemname, weight, isentry, resources, aorder, kpi_temp_id, ".$scid." as scid, '".$unit."' as unit, ".$baseline." as baseline, ".(($kpi_comm_planned/$baseline)*($weight))." as weighted_planned, ".(($kpi_comm_actual/$baseline)*($weight))." as weighted_actual, ".$kpi_comm_planned." as kpi_comm_planned, ".$kpi_comm_actual." as kpi_comm_actual FROM kpidata WHERE kpiid = ".$psarray[$i];
		$ptResult = $objDb->dbQuery($ptdataSQL);
		$getweightSQL = "select weight from kpidata where kpiid = ".$psarray[$i];
		$wieghtResult = $objDb->dbQuery($getweightSQL);
		$weightdata = $objDb->dbFetchArray();
		$weightfactor = $weightdata['weight']/100;
		$weight = $weight * $weightfactor;
	}
//==================================== Data Clearing
$kpiid = '';
$parentcd = '';
$parentgroup = '';
$scid = '';
$baseline = '';
$kpi_comm_planned = '';
$kpi_comm_actual = '';
unset($psarray);
}

$objDb->dbQuery("insert into kpidata_result (kpiid, parentcd, parentgroup, activitylevel, stage, itemcode, itemname, weight, isentry, resources, aorder, kpi_temp_id, scid, unit, baseline, weighted_planned, weighted_actual, kpi_comm_planned, kpi_comm_actual) SELECT kpiid, parentcd, parentgroup, activitylevel, stage, itemcode, itemname, weight, isentry, resources, aorder, kpi_temp_id, scid, unit, baseline, sum(weighted_planned) as weighted_planned, sum(weighted_actual) as weighted_actual, kpi_comm_planned, kpi_comm_actual FROM kpidata_etl group by kpiid, scid");
echo "Data is Making Process is complete";
?>
<a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>