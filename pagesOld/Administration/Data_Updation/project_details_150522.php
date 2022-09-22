<?php
include_once "../../../config/config.php";

$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDdb  		= new Database();
$objSDb  		= new Database();
$objDb1  		= new Database();
$objDb2 		= new Database();
$objDb3		= new Database();
$objDb  		= new ProjectSetup();
$objDbW  		= new ProjectSetup();
$objDbc  		= new ProjectSetup();
$objDbS  		= new ProjectSetup();
$objVSDb  		= new ProjectSetup();
$objCSDb  		= new ProjectSetup();
$objPD  		= new ProjectSetup();
$objPDM  		= new ProjectSetup();
$objIC   		= new ProjectSetup();
$objCur   		= new ProjectSetup();
$objYrHol  		= new ProjectSetup();
$objwday  		= new ProjectSetup();
$objAdminUser   = new AdminUser();
$objCommon		= new Common();
$mode	= "I";
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "Project";
 $objPD->getProject();
  $PCount=$objPD->totalRecords();
  
  if($PCount==1)
  {
	  $pdrows = $objPD->dbFetchArray();
	  $pid=$pdrows["pid"];
  }

$base_cur				= $_REQUEST['base_cur'];
$cur_1					= $_REQUEST['cur_1'];
$cur_1_rate			    = trim($_REQUEST['cur_1_rate']);
$cur_2					= $_REQUEST['cur_2'];
$cur_2_rate				= trim($_REQUEST['cur_2_rate']);
$cur_3					= $_REQUEST['cur_3'];
$cur_3_rate				= trim($_REQUEST['cur_3_rate']);
$txtpcode				= $_REQUEST['txtpcode'];
$txtpdetail				= $_REQUEST['txtpdetail'];
$txtpdetail	= str_replace("'","",$txtpdetail);

//echo $txtpdetail				=  preg_replace('/\'\"/', '', $txtpdetail);
$ptype				= $_REQUEST['txtptype'];
$txtpstart				= date('Y-m-d',strtotime($_REQUEST['txtpstart']));
$txtpend				= date('Y-m-d',strtotime($_REQUEST['txtpend']));
$client					= $_REQUEST['client'];
$funding_agency			= $_REQUEST['funding_agency'];
$contractor				= $_REQUEST['contractor'];
$pcost				    =str_replace(',','',$_REQUEST['pcost']);
$sector_id				= $_REQUEST['sector_id'];
$country_id				= $_REQUEST['country_id'];
$location				= $_REQUEST['location'];
$consultant				= $_REQUEST['consultant'];
$smec_code				= $_REQUEST['smec_code'];
$pcid				= $_REQUEST['pcid'];
if($clear!="")
{
$txtpcode 				= '';
$txtpdetail 				= '';
$txtpstart					= '';
$client                    ='';
$funding_agency='';
$contractor='';
$pcost=0;
}

///////////////////////// Insert Query//////////////////////
if($_SERVER['REQUEST_METHOD'] == "POST")
{



$objIC->setProperty("pcode",$txtpcode);
$objIC->setProperty("pdetail",$txtpdetail);
$objIC->setProperty("ptype",$ptype);
$objIC->setProperty("pstart",$txtpstart);
$objIC->setProperty("pend",$txtpend);
$objIC->setProperty("client",$client);
$objIC->setProperty("funding_agency",$funding_agency);
$objIC->setProperty("contractor",$contractor);
$objIC->setProperty("pcost",$pcost);
$objIC->setProperty("sector_id",$sector_id);
$objIC->setProperty("country_id",$country_id);
$objIC->setProperty("location",$location);
$objIC->setProperty("consultant",$consultant);
$objIC->setProperty("smec_code",$smec_code);	
  $pid = ($_POST['mode'] == "U") ? $_POST['pid'] : $objAdminUser->genCode("project", "pid");		
$objIC->setProperty("pid",$pid);
	if($objIC->actProject($_POST['mode'])){
		
		 $pcid = ($_POST['mode'] == "U") ? $_POST['pcid'] : $objAdminUser->genCode("project_currency", "pcid");
		 $objCur->setProperty("pcid",$pcid);
		$objCur->setProperty("base_cur",$base_cur);
		$objCur->setProperty("cur_1",$cur_1);
		$objCur->setProperty("cur_1_rate",$cur_1_rate);
		$objCur->setProperty("cur_2",$cur_2);
		$objCur->setProperty("cur_2_rate",$cur_2_rate);
		$objCur->setProperty("cur_3",$cur_3);
		$objCur->setProperty("cur_3_rate",$cur_3_rate);
		$objCur->actCurrency($_POST['mode']);
		 #Check if the new dates are added
			$arr_yh_title 	= $_POST['yh_title'];
			$arr_yh_date 	= $_POST['yh_date'];
			$arr_yh_status 	= $_POST['yh_status'];
			if(count($arr_yh_title) >= 1 && count($arr_yh_date) == count($arr_yh_status)){
				for($i = 0; $i < count($arr_yh_title); $i++){
					if($arr_yh_title[$i] != "" && $arr_yh_date[$i] != "" && $arr_yh_status[$i] != ""){
						
						$yh_title 	= $arr_yh_title[$i];
						echo $yh_status	= $arr_yh_status[$i];
						$yh_date	= date('Y-m-d',strtotime($arr_yh_date[$i]));
						$objYrHol->setProperty("yh_title",$yh_title);
						$objYrHol->setProperty("yh_date",$yh_date);
						$objYrHol->setProperty("yh_status",$yh_status);
						$objYrHol->setProperty("pid",$pid);
						$objYrHol->actYearlyHolidays('I');
					
					}
				}
			}
			
			
			if($_POST['mode'] == "I")
			{
				$activitylevel=0;
		$stage="BOQ";
		$factor=0;
		$itemcode=$txtpcode;
		$itemname=$txtpdetail;
		$weight=0;
		$isentry=0;
		$aorder=0;
		$parentcd=0;
		$lid=0;
				
				echo $sql_pro1="INSERT INTO boqdata(parentcd,  activitylevel,stage,factor,itemcode,itemname,weight, isentry, aorder,lid) 
		Values( ".$parentcd.",  '".$activitylevel."' , '".$stage."' , '".$factor."' , '".$itemcode."' , '".$itemname."' , '".$weight."' , '".$isentry."' , '".$aorder."' , ".$lid.")";
		$sql_pro=$objDb->dbQuery($sql_pro1);
		$itemid=$con->lastInsertId();
		
		if($parentcd==0)
		{		
			if(strlen($itemid)==1)
			{
			$parent_group="00000".$itemid;
			}
			else if(strlen($itemid)==2)
			{
			$parent_group="0000".$itemid;
			}
			else if(strlen($itemid)==3)
			{
			$parent_group="000".$itemid;
			}
			else if(strlen($itemid)==4)
			{
			$parent_group="00".$itemid;
			}
			else if(strlen($itemid)==5)
			{
			$parent_group="0".$itemid;
			}
			else
			{
			$parent_group=$itemid;
			}
		}
		$parent_group=$parent_group;
	$sql_pro="UPDATE boqdata SET parentgroup='$parent_group' where itemid=$itemid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
	//////MainData
	$activitylevel=0;
		$stage="Activity";
		$factor=0;
		$itemcode=$txtpcode;
		$itemname=$txtpdetail;
		$weight=0;
		$isentry=0;
		$aorder=0;
		$parentcd=0;
		$lid=0;
				
				echo $sql_pro1="INSERT INTO maindata(parentcd,  activitylevel,stage,factor,itemcode,itemname,weight, isentry, aorder,lid) 
		Values( ".$parentcd.",  '".$activitylevel."' , '".$stage."' , '".$factor."' , '".$itemcode."' , '".$itemname."' , '".$weight."' , '".$isentry."' , '".$aorder."' , ".$lid.")";
		$sql_pro=$objDb1->dbQuery($sql_pro1);
		$itemid_main=$con->lastInsertId();
		
		if($parentcd==0)
		{		
			if(strlen($itemid_main)==1)
			{
			$parent_group="00000".$itemid_main;
			}
			else if(strlen($itemid_main)==2)
			{
			$parent_group="0000".$itemid_main;
			}
			else if(strlen($itemid_main)==3)
			{
			$parent_group="000".$itemid_main;
			}
			else if(strlen($itemid_main)==4)
			{
			$parent_group="00".$itemid_main;
			}
			else if(strlen($itemid_main)==5)
			{
			$parent_group="0".$itemid_main;
			}
			else
			{
			$parent_group=$itemid_main;
			}
		}
		$parent_group=$parent_group;
	echo $sql_pro="UPDATE maindata SET parentgroup='$parent_group' where itemid=$itemid_main";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	
	
	
	////////////KPIDATA
	
	
echo 	$sql_protem="INSERT INTO kpi_templates(kpi_temp_title, kpi_temp_desc, temp_id, is_default_temp, is_active, is_eva) VALUES ('KPI Dashboard','KPI Dashboard',1,1,1,0)";
	$sql_pro_tem=$objDb3->dbQuery($sql_protem);
		$kpi_temp_id=$con->lastInsertId();
	
	
	
	
	$activitylevel=0;
		$stage="KPI";
		$factor=0;
		$itemcode=$txtpcode;
		$itemname=$txtpdetail;
		$weight=100;
		$isentry=0;
		$aorder=0;
		$parentcd=0;
		$lid=0;
				
				echo $sql_pro1="INSERT INTO kpidata(parentcd,  activitylevel,stage,itemcode,itemname,weight, isentry, aorder,kpi_temp_id,lid) 
		Values( ".$parentcd.",  '".$activitylevel."' , '".$stage."'  , '".$itemcode."' , '".$itemname."' , '".$weight."' , '".$isentry."' , '".$aorder."', ".$kpi_temp_id." , ".$lid.")";
		$sql_pro=$objDb2->dbQuery($sql_pro1);
		$itemid_kpi=$con->lastInsertId();
		
		if($parentcd==0)
		{		
			if(strlen($itemid_kpi)==1)
			{
			$parent_group="00000".$itemid_kpi;
			}
			else if(strlen($itemid_kpi)==2)
			{
			$parent_group="0000".$itemid_kpi;
			}
			else if(strlen($itemid_kpi)==3)
			{
			$parent_group="000".$itemid_kpi;
			}
			else if(strlen($itemid_kpi)==4)
			{
			$parent_group="00".$itemid_kpi;
			}
			else if(strlen($itemid_kpi)==5)
			{
			$parent_group="0".$itemid_kpi;
			}
			else
			{
			$parent_group=$itemid_kpi;
			}
		}
		$parent_group=$parent_group;
	echo $sql_pro="UPDATE kpidata SET parentgroup='$parent_group' where kpiid=$itemid_kpi";
	
	$sql_proresult=$objDb2->dbQuery($sql_pro);
	
	
			}
		# See if any child to be deleted (checked for deletion)
			$arr_yh_ids = $_POST['yh_id'];
			if(count($arr_yh_ids) >= 1){
				for($i = 0; $i < count($arr_yh_ids); $i++){
					$yh_id 	= $arr_yh_ids[$i];
					 $yhDSQL = ("DELETE FROM yearly_holidays where yh_id=$yh_id");
						$objDdb->dbQuery($yhDSQL);
				}
			}
			# See if any sizes are updated
					$swwSQL = " Select * from yearly_holidays ";
							 $objSDb->dbQuery($swwSQL);
							  $iiCount = $objSDb->totalRecords();
					 if($iiCount>0)
					 {
						while($urows = $objSDb->dbFetchArray())
						{
						 $yh_id= $urows["yh_id"];
						if($_POST['yh_title_' . $yh_id] && $_POST['yh_date_'. $yh_id])
						{
							
						$yh_title 	= $_POST['yh_title_' .$yh_id];
						$yh_status	= $_POST['yh_status_' . $yh_id];
						$yh_date 	= date('Y-m-d',strtotime($_POST['yh_date_' . $yh_id]));
						$yhSQL = ("Update yearly_holidays SET yh_title='$yh_title',yh_date='$yh_date',yh_status='$yh_status'  where yh_id=$yh_id");
						$objDdb->dbQuery($yhSQL);
						
					  }
				}
			}
			
			$objCommon->setMessage('Project is saved successfully.','Info');
			header("location: project_details.php?pid=".$pid);
			//redirect('./?p=project_detail&pid='.$pid);
		}	
	
			$status=0;
			$objwday->updateWeekDays();
			
			$arr_working_days 	= $_REQUEST['working_days'];
			
 		
						foreach($arr_working_days as $work_day)
						{
							$objwday->UpdateAllWeekDays($work_day);
						
						}
			

////////////////////// Change Planned Data//////////////////////////
$objDbP 		= new Database( );
$objDbPP		= new Database( );

if($txtpstart>$pstart)
{
$d1_m=date('m',	strtotime($txtpstart));
$d1_y=date('Y',	strtotime($txtpstart));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$txtpstart=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($pstart));
$d2_y=date('Y',	strtotime($pstart));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$pstart=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($txtpstart);
$d2 = strtotime($pstart);
 $min_date = min($d1, $d2);
 $max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) < $max_date) {

  	$eSqls = "Select itemid,aid,rid from activity ";
 	$objDbP->dbQuery($eSqls);
 	$iCount = $objDbP->totalRecords();
	 if($iCount>0)
	 {
		while ($yrows = $objDbP->dbFetchArray())
		{
		$aid 	= $yrows['aid'];
		$rid 	= $yrows['rid'];
		$itemid 	= $yrows['itemid'];
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		$qq="DELETE FROM planned WHERE itemid='$itemid ' AND  rid='$rid' AND budgetdate='$planned_date'";
		$objDbPP->dbQuery($qq);
		
	}
 }
   $i++;
}	// end while
}
if($pstart>$txtpstart)
{
$d1_m=date('m',	strtotime($txtpstart));
$d1_y=date('Y',	strtotime($txtpstart));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$txtpstart=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($pstart));
$d2_y=date('Y',	strtotime($pstart));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$pstart=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($txtpstart);
$d2 = strtotime($pstart);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
 $objDbP->dbQuery($eSqls);
 	$iCount = $objDbP->totalRecords();
	 if($iCount>0)
	 {
		while ($yrows = $objDbP->dbFetchArray())
		{
		$aid 	= $yrows['aid'];
		$rid 	= $yrows['rid'];
		$itemid 	= $yrows['itemid'];
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ('$itemid ', '$rid', '$planned_date', 0)";
		
		$objDbPP->dbQuery($qq);
	}
 }
   $i++;
}	// end while
}
if($txtpend>$pend)
{
$d1_m=date('m',	strtotime($pend));
$d1_y=date('Y',	strtotime($pend));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$pend=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($txtpend));
$d2_y=date('Y',	strtotime($txtpend));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$txtpend=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($pend);
$d2 = strtotime($txtpend);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-1 MONTH", $min_date);
//$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP->dbQuery($eSqls);
 	$iCount = $objDbP->totalRecords();
	 if($iCount>0)
	 {
		while ($yrows = $objDbP->dbFetchArray())
		{
		$aid 	= $yrows['aid'];
		$rid 	= $yrows['rid'];
		$itemid 	= $yrows['itemid'];
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ('$itemid ', '$rid', '$planned_date', 0)";
		
		$objDbPP->dbQuery($qq);
	}
 }
   $i++;
}	// end while
}
if($txtpend<$pend)
{
$d1_m=date('m',	strtotime($pend));
$d1_y=date('Y',	strtotime($pend));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$pend=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($txtpend));
$d2_y=date('Y',	strtotime($txtpend));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$txtpend=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($pend);
$d2 = strtotime($txtpend);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP->dbQuery($eSqls);
 	$iCount = $objDbP->totalRecords();
	 if($iCount>0)
	 {
		while ($yrows = $objDbP->dbFetchArray())
		{
		$aid 	= $yrows['aid'];
		$rid 	= $yrows['rid'];
		$itemid 	= $yrows['itemid'];
		 $planned_date=date('Y-m-d',$min_date);
		  $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		  $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="DELETE FROM planned WHERE itemid='$itemid ' AND  rid='$rid' AND budgetdate='$planned_date'";
		$objDbPP->dbQuery($qq);
	}
 }
   
}	// end while
}
////////////////////// End Change Planned Data//////////////////////////
////////////////////////// Make Project Data/////////////////

$objPDM->DataMaking($txtpstart,$txtpend,$mode);



 //$sSQLc = ("INSERT INTO t031project_albums(parent_album,parent_group,pid,album_name,status)VALUES('0','001','1','Photos/Videos','1')");


//include("basetable.php");
//header("location: project_calender.php");
}
else
{
	if(isset($_GET['pid']) && !empty($_GET['pid']))
		$pid = $_GET['pid'];
	else if(isset($_POST['pid']) && !empty($_POST['pid']))
		$pid = $_POST['pid'];
	if(isset($pid) && !empty($pid))
	{
		$objPD->setProperty("pid", $pid);
		 $objPD->getProject();
  $ffCount=$objPD->totalRecords();

if($ffCount > 0){
	  while ($prows = $objPD->dbFetchArray()) {
	  $pid 						= $prows['pid'];
	  $pcode 					= $prows['pcode'];
	  $pname	 				= $prows['pname'];
	  $pdetail					= $prows['pdetail'];
	  $ptype					= $prows['ptype'];
	  $pstart 					= $prows['pstart'];
	  $pend 					= $prows['pend'];
	  $client					= $prows['client'];
	  $funding_agency			= $prows['funding_agency'];
	  $contractor				= $prows['contractor'];
	  $pcost					= $prows['pcost'];
	  $ssector_id				= $prows['sector_id'];
	  if($ssector_id!=0)
	  {
		 $objVSDb->setProperty("sector_id",$ssector_id);
		 $objVSDb->getSector();
		 $secrows = $objVSDb->dbFetchArray();
		 $sector_name = $secrows['sector_name'];
			
	  }
	  $scountry_id				= $prows['country_id'];
	  if($scountry_id!=0)
	  {
		  $objCSDb->setProperty("country_id",$scountry_id);
		  $objCSDb->getCountry();
		   $crows = $objCSDb->dbFetchArray();
		  $country_name = $crows['country_name'];
	  }
	  $consultant				=$prows['consultant'];
	  $location				    =$prows['location'];
	  $smec_code				=$prows['smec_code'];
	}
	
			    $objDbc->getCurrency();
				 $cur_rows=$objDbc->dbFetchArray();
				  $pcid 					= $cur_rows['pcid'];
			    $cur_1_rate 					= $cur_rows['cur_1_rate'];
			    $cur_2_rate 					= $cur_rows['cur_2_rate'];
				$cur_3_rate 					= $cur_rows['cur_3_rate'];
			    $cur_1 					= $cur_rows['cur_1'];
			    $cur_2 					= $cur_rows['cur_2'];
				$cur_3 					= $cur_rows['cur_3'];
			    $base_cur 				= $cur_rows['base_cur'];
				
				
}
		$mode	= "U";
		
	}
}
 
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Project</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../JsCommon.js"></script>

<script>
function showResult(strmodule,strstage,stritemcode,stritemname,strweight,strisentry) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("search").innerHTML=xmlhttp.responseText;
      document.getElementById("search").style.border="1px solid #A5ACB2";
	   document.getElementById("without_search").style.display="none";
	  document.getElementById("without_search").disabled=true;
	// document.getElementById("without_search").removeClass("checkbox").addClass("");
	  var nodes = document.getElementById("without_search").getElementsByTagName('*');
			for(var i = 0; i < nodes.length; i++){
			 $("#cvcheck").attr( "class", "" ); 
				 nodes[i].disabled = true;
			}
	 
    }
  }
  xmlhttp.open("GET","search.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script>
<script type="text/javascript">
		 
 $(function() {
   $('#txtpstart').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
    $('#txtpend').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
$("#datepicker1,#datepicker2").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});

</script>
<script>
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function group_checkbox2()
{
	var select_all = document.getElementById("txtChkAll2"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox2"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.with_search .checkbox2:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>
<script>
function group_checkbox()
{
	var select_all = document.getElementById("txtChkAll"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}

function AddNewSize(){
	
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this);" title="Remove size">[X]</a>';
	var td2 = '<input type="text" name="yh_title[]" size="25" />';
	var td3 = '<input type="text" name="yh_date[]" style="text-align:right;" size="15" id="datepicker3"/>';
	var td4 = '<select name="yh_status[]">' + "\n";
	td4 	+= "\t" + '<option value="1">Active</option>' + "\n";
	td4 	+= "\t" + '<option value="0">Inactive</option>' + "\n";
	td4 	+= '</select>' + "\n";
	
	var arrTds = new Array(td1, td2, td3, td4);
	doAddTr(arrTds, 'tblPrdSizes');
}


function CheckProjectDetail(frm){
	var msg = "<?php echo "Please do the following:";?>\r\n-----------------------------------------";
	var flag = true;

	if(frm.txtpdetail.value == ""){
		msg = msg + "\r\n<?php echo "Project Detail is required field";?>";
		flag = false;
	}
	if(frm.txtpstart.value == ""){
		msg = msg + "\r\n<?php echo "Project Start Date is required field";?>";
		flag = false;
	}
	if(frm.txtpend.value == ""){
		msg = msg + "\r\n<?php echo "Project End Date is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />

  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../../css/scrollbarStyle.css" rel="stylesheet" />

  <style>
        .margintopCSS {
          margin-top:10px;
        }
    </style>

</head>

<body>
  <div class="container-scroller">

     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->

     <div class="container-fluid page-body-wrapper" id="pagebodywraper">


       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel" id="mainpanel">
      <div class="content-wrapper">
        <div class="row">

          <div class="col-md-10 m-auto  stretch-card">

            <div class="card ">
            
                <div class="col-md-10 m-auto py-4">
				
                <h2 style="text-align:center">Project Details </h2>
                <hr>
<div class="table-responsive">

                    <form name="frmstgoal" id="frmstgoal" action=""  method="post" 
      onsubmit="return CheckProjectDetail(this)" enctype="multipart/form-data">
      <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        	<input type="hidden" name="pid" id="pid" value="<?php echo $pid;?>" />
            <input type="hidden" name="pcid" id="pcid" value="<?php echo $pcid;?>" />
	  

                    <table class="table table-striped">
			
            <tr >
            <th> <?php echo $action."Project Details:"; ?></th>
            <th colspan="3" style="text-align:right;"> <?php if($pid != ""&&$pid!=0){?> <a href="project_details.php?pid=<?php echo $pid;?>&edit=1"  class="btn btn-primary text-white"><i class="mdi mdi-chart-line menu-icon"></i> Change Project Detail </a><?php }?></th>
            </tr>
                  
           <?php if((isset($pid)&&$pid!=""&&$pid!=0)&&(!isset($_REQUEST['edit'])&&$_REQUEST['edit']==""))
			{
				$objDb->getCurrency();
				 $cur_rows=$objDb->dbFetchArray();
			    $cur_1_rate 					= $cur_rows['cur_1_rate'];
			    $cur_2_rate 					= $cur_rows['cur_2_rate'];
				$cur_3_rate 					= $cur_rows['cur_3_rate'];
			    $cur_1 					= $cur_rows['cur_1'];
			    $cur_2 					= $cur_rows['cur_2'];
				$cur_3 					= $cur_rows['cur_3'];
			    $base_cur 				= $cur_rows['base_cur'];
	?>
      
            <tr>
              <td width="16%" ><strong>Project code:</strong></td>
              <td colspan="3" ><?php echo $pcode; ?></td>
        </tr>
            <tr>
              <td  ><strong>Project Name:</strong></td>
              <td colspan="3" style="line-height:20px"><?php echo $pdetail; ?></td>
            </tr>
             <tr>
              <td  ><strong>Project Type:</strong></td>
              <td colspan="3" ><?php if($ptype==1) echo "Time-Based";
			  elseif($ptype==2) echo "Milestone"; ?></td>
            </tr>
            <tr>
              <td ><strong>Start Date:</strong></td>
              <td colspan="3" ><?php echo date("d-m-Y", strtotime($pstart)); ?></td>
        </tr>
			 <tr>
              <td ><strong>End Date:</strong></td>
              <td colspan="3" ><?php echo date("d-m-Y", strtotime($pend)); ?></td>
             </tr>
              <tr>
              <td ><strong>Client:</strong></td>
              <td colspan="3" ><?php echo $client; ?></td>
             </tr>
               <tr>
              <td ><strong>Consultant:</strong></td>
              <td colspan="3" ><?php echo wordwrap($consultant,100,"<br>\n"); ?></td>
             </tr>
             <tr>
              <td ><strong>Funding Agency:</strong></td>
              <td colspan="3" ><?php echo $funding_agency; ?></td>
             </tr>
             <tr>
              <td ><strong>Contractor:</strong></td>
              <td colspan="3" ><?php echo wordwrap($contractor,100,"<br>\n"); ?></td>
             </tr>
             <tr>
              <td ><strong>Contract Value:</strong></td>
              <td colspan="3" ><?php echo number_format($pcost,0); ?></td>
             </tr>
             <tr>
              <td ><strong>Sector:</strong></td>
              <td colspan="3" ><?php echo $sector_name; ?></td>
             </tr>
             <tr>
              <td ><strong>Country:</strong></td>
              <td colspan="3" ><?php echo $country_name; ?></td>
             </tr>
             <tr>
              <td ><strong>Location:</strong></td>
              <td colspan="3" ><?php echo $location; ?></td>
             </tr>
             <tr>
              <td ><strong>SMEC Code:</strong></td>
              <td colspan="3" ><?php echo $smec_code; ?></td>
             </tr>
              <tr>
              <td ><strong>Project Currencies:</strong></td>
              <td colspan="3" ><table><tr><td colspan="2"><?php echo "<strong>Base Currency:</strong> ".$base_cur;?></td></tr>
              <tr><td><?php echo "<strong>Currency 1:</strong> ".$cur_1;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_1_rate;?></td></tr>
              <?php if($cur_2!="")
			  {?>
              <tr><td><?php echo "<strong>Currency 2:</strong> ".$cur_2;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_2_rate;?></td></tr>
              <?php }?>
              <?php if($cur_3!="")
			  {?>
              <tr><td><?php echo "<strong>Currency 3:</strong> ".$cur_3;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_3_rate;?></td></tr>
              <?php }?>
              </table></td>
             </tr>
             <tr>
			  <td class="labelp"><strong>Working Days:</strong></td>
              <td colspan="3" >
             
              		 <?php  $swSQL = " Select * from weekdays ";
							$objDdb->dbQuery($swSQL);
							 $iCount = $objDdb->totalRecords();
							 if($iCount>0)
							 {
								while ($wrows = $objDdb->dbFetchArray())
								{
								  $wd_id						= $wrows['wd_id'];
								  $wd_day						= $wrows['wd_day'];
								  $wd_detail					= $wrows['wd_detail'];
								  $status						= $wrows['status'];
								  ?>
                                  <?php if($status==1) { 
								  echo $wd_detail; 
								  if($i < $iCount-1)
								  {
								  echo ", ";
								  }
								  }?>
                                  <?php
								}
							}
						?>
         
	
              </td>
             </tr>
             <tr>
			  <td class="labelp"><strong>Annual Holidays:</strong></td>
              <td colspan="3" >
             
              		 <?php  $swSQL = " Select * from yearly_holidays where yh_status=1 ";
							$objDdb->dbQuery($swSQL);
							 $iCount = $objDdb->totalRecords();
							 if($iCount>0)
							 {
								while ($yrows = $objDdb->dbFetchArray())
								{
								  $yh_id=$yrows['yh_id'];
								  $yh_title=$yrows['yh_title'];
								  $yh_date=$yrows['yh_date'];			
								  $yh_status=$yrows['yh_status'];
								  ?>
                                  <?php if($yh_status==1) { 
								  echo $yh_title." - ".date("d-m-Y",strtotime($yh_date)); 
								  if($i < $iCount-1)
								  {
								  echo ", ";
								  }
								  }?>
                                  <?php
								}
							}
						?>
         
	
              </td>
             </tr>
			
			 
      
	<?php }
	else
	{
	?>
			
    <tr>
              <td width="16%" ><strong>Project code:</strong></td>
              <td colspan="3" ><input id="txtpcode" name="txtpcode" type="text" value="<?php echo $pcode; ?>" class="form-control" style="width:100px"/></td>
            </tr>
            <tr>
              <td ><strong>Project Name:<span style="color:#FF0000;">*</span></strong></td>
              <td colspan="3" ><input id="txtpdetail" name="txtpdetail" type="text" value="<?php echo $pdetail; ?>"  required class="form-control"/></td>
            </tr>
             <tr>
              <td ><strong>Project Type:<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3">
             
              <select id="txtptype" name="txtptype" class="form-control" required> 
              <option value="">Select Project Type</option>
              <option value="1" <?php if($ptype==1) {?> selected="selected" <?php }?>>Time-Based</option>
              <option value="2" <?php if($ptype==2) {?> selected="selected" <?php }?>>Milestone</option>
               </select>
              
              </td>
             </tr>
             <?php
			 if($_REQUEST['edit']!="")
			 {
			 ?>
            <tr>
              <td ><strong>Start Date<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3">
              <input  name="txtpstart" type="text" value="<?php echo $pstart; ?>"  readonly class="form-control"/> &nbsp;<span style="color:#FF0000;">(Note: PMIS will use start and end date for calculations)</span>
              </td>
             </tr>
             <tr>
              <td ><strong>End Date<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3" ><input  name="txtpend" type="text" value="<?php echo $pend; ?>" readonly class="form-control"/>
              </td>
             </tr>
             <?php
			 }
			 else
			 {
				 ?>
            <tr>
              <td ><strong>Start Date<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3">
              <input  id="txtpstart" name="txtpstart" type="text" value="<?php echo $pstart; ?>"  required class="form-control"/> &nbsp;<span style="color:#FF0000;">(Note: PMIS will use start and end date for calculations)</span>
              </td>
             </tr>
             <tr>
              <td ><strong>End Date<span style="color:#FF0000;">*</span>:</strong></td>
              <td colspan="3" ><input id="txtpend"  name="txtpend" type="text" value="<?php echo $pend; ?>"  required class="form-control"/>
              </td>
             </tr>
             <?php
			 }
			 ?>
			 <tr>
			   <td ><strong>Client:</strong></td>
			   <td colspan="3" >
               <input id="client" name="client" type="text" value="<?php echo $client; ?>" class="form-control"/></td>
	    </tr>
			 <tr>
			   <td ><strong>Funding Agency:</strong></td>
			   <td colspan="3" ><input id="funding_agency" name="funding_agency" type="text" 
               value="<?php echo $funding_agency; ?>" class="form-control"/></td>
	    </tr>
			 <tr>
			   <td ><strong>Project Cost:</strong></td>
			   <td colspan="3" ><input id="pcost" name="pcost" type="number" step="0.01"
               value="<?php if($pcost!=0&&$pcost!="")echo number_format($pcost,0); ?>" class="form-control"/></td>
	    </tr>
			 <tr>
			   <td ><strong>Contractor:</strong></td>
			   <td colspan="3" ><input id="contractor" name="contractor" type="text" 
               value="<?php echo $contractor; ?>" class="form-control"/></td>
	    </tr>
			 <tr>
			   <td ><strong>Consultant:</strong></td>
			   <td colspan="3" ><input id="consultant" name="consultant" type="text" 
               value="<?php echo $consultant; ?>" class="form-control"/></td>
	    </tr>
			 <tr>
			   <td ><strong>Sector:</strong></td>
			   <td colspan="3" ><select id="sector_id" name="sector_id" class="form-control"> 
               	<option value="">Select Sector</option>
              		 <?php  
					 // $objDbS->setProperty("sector_id",$ssector_id);
					  $objDbS->getSector();
					 while($secrows=$objDbS->dbFetchArray())
					 {
		 						echo   $sector_name = $secrows['sector_name'];
								  $sector_id= $secrows['sector_id'];
								 
								 
								  ?>
                                  <option value="<?php echo $sector_id;?>" 
								  <?php if($ssector_id==$sector_id) {?> selected="selected" 
								  <?php }?>><?php echo $sector_name; ?></option>
                                  <?php
								
							}
						?>
              </select>
              </td>
	    </tr>
			 <tr>
			   <td ><strong>Country</strong></td>
			   <td colspan="3" ><select id="country_id" name="country_id" class="form-control"> 
               	<option value="">Select Country</option>
              		 <?php  
							  /* $objDbc->setProperty("country_id",$scountry_id);*/
							   $objDbc->getCountry();
							  while($crows = $objDbc->dbFetchArray())
							  {
							  	$country_name = $crows['country_name'];
								$country_id = $crows['country_id'];
								  ?>
                                  <option value="<?php echo $country_id;?>" 
								  <?php if($scountry_id==$country_id) {?> selected="selected" 
								  <?php }?>><?php echo $country_name; ?></option>
                                  <?php
								
							}
						?>
              </select></td>
	    </tr>
			 <tr>
			   <td ><strong>Location</strong></td>
			   <td colspan="3" >
               <input id="location" name="location" type="text" value="<?php echo $location; ?>" class="form-control"/></td>
	    </tr>
			 <tr>
			   <td ><strong>SMEC Project Code</strong></td>
			   <td colspan="3"><input id="smec_code" name="smec_code" type="text" value="<?php echo $smec_code; ?>" class="form-control"/></td>
	    </tr>
			 
			 <tr>
              <td width="16%" ><strong>Base Currency:<span style="color:#FF0000;">*</span></strong></td>
              <td colspan="3" ><input id="base_cur" name="base_cur" type="text" value="<?php echo $base_cur; ?>" required class="form-control"/></td>
            </tr>
                <tr>
                  <td ><strong>Currency 1:<span style="color:#FF0000;">*</span></strong></td>
                  <td width="20%" ><input id="cur_1" name="cur_1" type="text" value="<?php echo $cur_1; ?>" required class="form-control"/></td>
                  <td width="18%" ><strong>Currency 1 Rate:<span style="color:#FF0000;">*</span></strong></td>
                  <td width="46%" ><input id="cur_1_rate" name="cur_1_rate" type="text" value="<?php echo $cur_1_rate; ?>"  required class="form-control"/></td>
                </tr>
                <tr>
                   <td ><strong>Currency 2:</strong></td>
                   <td ><input id="cur_2" name="cur_2" type="text" value="<?php echo $cur_2; ?>" class="form-control"/></td>
                   <td ><strong>Currency 2 Rate:</strong></td>
                   <td ><input id="cur_2_rate" name="cur_2_rate" type="text" value="<?php echo $cur_2_rate; ?>" class="form-control"/></td>
            </tr>
                <tr>
                   <td ><strong>Currency 3:</strong></td>
                   <td ><input id="cur_3" name="cur_3" type="text" value="<?php echo $cur_3; ?>" class="form-control"/></td>
                   <td ><strong>Currency 3 Rate:</strong></td>
                   <td ><input id="cur_3_rate" name="cur_3_rate" type="text" value="<?php echo $cur_3_rate; ?>" class="form-control"/></td>
            </tr>
                <tr>
			  <td ><strong>Project Working Days:</strong></td>
              <td colspan="3" >
              <select id="working_days[]" name="working_days[]" multiple="multiple" class="js-example-basic-multiple w-100"> 
              <!--<option>Select Working Days</option>-->
              		 <?php  
							 $objDbW->getWeekDays();
							while($wrows=$objDbW->dbFetchArray())
							{
								  $wd_id						= $wrows['wd_id'];
								  $wd_day						=  $wrows['wd_day'];
								  $wd_detail					=  $wrows['wd_detail'];
								  $status						=  $wrows['status'];
								  ?>
                                  <option value="<?php echo $wd_id;?>" <?php if($status==1) {?> selected="selected" <?php }?>><?php echo $wd_detail; ?></option>
                                  <?php
							}
							
						?>
              </select>
			 </td>
             </tr>
			    <tr>
					   <td  valign="middle"><strong>Project Annual Holidays</strong></td>
					  <td colspan="3"  valign="top"><table class="clsTable" width="500" cellpadding="1" cellspacing="1">
            	<tbody id="tblPrdSizes">
                    <tr>
                        <th style="width:5%;">&nbsp;</th>
						<th style="width:45%;"><?php echo "Title";?></th>
                        <th style="width:25%;"><?php echo "Date (yyyy-mm-dd)";?></th>
                        <th style="width:25%;"><?php echo "Status";?></th>
                    </tr>
                    <?php
					
							
							 $objDb->getYearlyHolidays();
							 $iCount = $objDb->totalRecords();
							 if($iCount>0)
							 {
							while($yhrows=$objDb->dbFetchArray())
							{
								  $yh_id					= $yhrows['yh_id'];
								  $yh_title					= $yhrows['yh_title'];
								  $yh_date					= $yhrows['yh_date'];
								  $yh_status				= $yhrows['yh_status'];
								?>
					<tr>
			        <td>
                    <input type="checkbox" name="yh_id[]" value="<?php echo $yh_id;?>" />
                    </td>
					<td><input type="text" name="yh_title_<?php echo $yh_id;?>" 
                    value="<?php echo $yh_title;?>" size="25" /></td>
		             <td><input type="text" name="yh_date_<?php echo $yh_id;?>" 
                       value="<?php echo $yh_date;?>" style="text-align:right;" size="15" />
                       </td>
			           <td><select name="yh_status_<?php echo $yh_id;?>">
							<option value="1" selected>Active</option>
							<option value="0"<?php echo ($yh_status == "0") ? " selected" : "";?>>
                            Inactive</option>
										</select>
									</td>
			                    </tr>
								<?php
							}
						}
					
					else{
					?>
                    <tr>
                    	<td>&nbsp;</td>
                        <td><input type="text" name="yh_title[]" size="25" /></td>
                        <td><input type="text" name="yh_date[]" style="text-align:right;" size="15" /></td>
                    	<td>
							<select name="yh_status[]">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</td>
					</tr>
                    <?php }?>
                </tbody>
            </table>
            <div style="width:410px;padding:2px;height:25px;text-align:right;"><a onClick="AddNewSize();" href="javascript:void(null);">Add New</a></div></td>
					 
			  </tr>
              	
                
			<tr>
			 <td height="39"></td>
			 <td align="left" colspan="7"  >
			 <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" class="btn btn-primary me-2"/>
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save" class="btn btn-primary me-2" />
			  
			  <?php } ?></td>
			 </tr>
             
              <?php }?>
 		</table>
     </form>
       </div>         </div>
            </div>
            </div>



         </div>

         

        <!-- partial:../../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <script src="../../../js/settings.js"></script>
  <script src="../../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- <script src="../../../js/navtype_session.js"></script> -->
   <!--  commented because of date picker js files
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->
  <!-- End custom js for this page-->

 <script>
      $(function(){
        $("#partials-navbar").load("../../../partials/_navbar.php");
      });
  </script>

  <script>
    $(function(){
      $("#partials-theme-setting-wrapper").load("../../../partials/_settings-panel.php");
    });
  </script>

  <script>
    $(function(){
      $("#partials-sidebar-offcanvas").load("../../../partials/_sidebar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-footer").load("../../../partials/_footer.php");
  });
</script>


<!-- Page Load Function -->

<script>
            $(document).ready(function() {

                $(function() {
                    $("#ipc_start_date").datepicker({});
                });

                $(function() {
                    $("#ipc_end_date").datepicker({});
                });

                $(function() {
                    $("#ipc_submit_date").datepicker({});
                });

                $(function() {
                    $("#ipc_receive_date").datepicker({});
                });

                $('#ipc_start_date').change(function() {
                    startDate = $(this).datepicker('getDate');
                    $("#ipc_end_date").datepicker("option", "minDate", startDate);
                })

                $('#ipc_end_date').change(function() {
                    endDate = $(this).datepicker('getDate');
                    $("#ipc_start_date").datepicker("option", "maxDate", endDate);
                })

                $('#ipc_submit_date').change(function() {
                    startDate = $(this).datepicker('getDate');
                    $("#ipc_receive_date").datepicker("option", "minDate", startDate);
                })

                $('#ipc_receive_date').change(function() {
                    endDate = $(this).datepicker('getDate');
                    $("#ipc_submit_date").datepicker("option", "maxDate", endDate);
                })
            })
        </script>

<script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }

function editbtnclick(ipcid){
  //alert(ipcid);

  var strURL="fetchipcdatafrm_id.php?ipcid="+ipcid;
    var req= getXMLHTTP();

    if(req)
    {
      req.onreadystatechange = function() {
            if (req.readyState == 4) {
              //alert(req.readyState);
            // alert(req.status);
              // only if "OK"
              if (req.status == 200) {

            //alert(req.responseText);

            var ipcid,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status;

                      var jsonData = JSON.parse(req.responseText);
                      for (var i = 0; i < jsonData.Ipc_detail.length; i++) {
                          var Ipc_detail = jsonData.Ipc_detail[i];

                         ipcid = Ipc_detail.ipcid;
                         ipcno = Ipc_detail.ipcno;
                         ipcmonth = Ipc_detail.ipcmonth;
                         ipcstartdate = Ipc_detail.ipcstartdate;
                         ipcenddate = Ipc_detail.ipcenddate;
                         ipcsubmitdate = Ipc_detail.ipcsubmitdate;
                         ipcreceivedate = Ipc_detail.ipcreceivedate;
                         status = Ipc_detail.status;
                      }
                      //alert(status);
                      document.getElementById("ipc_ipcid").value = ipcid;
                      document.getElementById("ipc_ipcno").value = ipcno;
                      document.getElementById("ipc_month").value = ipcmonth;
                      document.getElementById("ipc_start_date").value = ipcstartdate;
                      document.getElementById("ipc_end_date").value = ipcenddate;
                      document.getElementById("ipc_submit_date").value = ipcsubmitdate;
                      document.getElementById("ipc_receive_date").value = ipcreceivedate;
                      document.getElementById("ipc_status").value = status;
                      document.getElementById("SubmitUpdate").style.display = "block";
                      document.getElementById("SubmitAdd").style.display = "none";




              } else {

                alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
              }
            }
          }
          req.open("GET", strURL, true);
          req.send(null);
    }



}

</script>

</body>

</html>