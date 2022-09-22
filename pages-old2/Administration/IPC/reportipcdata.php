<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$ipc_flag			= $_SESSION['ne_ipc'];
	$ipcadm_flag		= $_SESSION['ne_ipcadm'];
	$ipcentry_flag		= $_SESSION['ne_ipcentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$now 			= new DateTime();
$nowyear 		= $now->format("Y");
$sel_checkbox 	= $_REQUEST['sel_checkbox'];
echo $module			= $_REQUEST['module'];
if($module=="IPC Data")
	{
	$id="ipcid";
	$tbl_name="ipc";
	$tbl_name1="ipc_log";
	$file_name="ipcdata.php";
	}

if ($sel_checkbox !='') {

//@require_once("get_url.php");

$sSQL1 = "SELECT * FROM $tbl_name WHERE $id in (".implode(', ', $sel_checkbox).")";
$objDb->dbQuery($sSQL1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php //include ('includes/metatag.php');?>
</head>
<body> 
<div id="wrap" >
<img src="images/cv-bank.jpg" title="Payroll" alt="Payroll" width="950" height="65"  />
<h1>List (<?php echo $module;?>)<span style="text-align:right; float:right"><a href="ipcdata.php">Back</a></span></h1>
<?php
$criteria = '';

		if($_REQUEST['valueipcno']!="")
		{
		$criteria = $criteria."IPC No: <b>".$_REQUEST['valueipcno']." </b>";
		}
		if($_REQUEST['txtipcmonth']!="")
		{
		
		$criteria = $criteria."IPC Month: <b>".$_REQUEST['txtipcmonth']." </b>";
		}
		if($_REQUEST['valueipcstartdate']!="")
		{
		
		$criteria = $criteria."Start Date: <b>".$_REQUEST['valueipcstartdate']." </b>";
		}
		if($_REQUEST['valueipcenddate']!="")
		{
		
		$criteria = $criteria."End Date: <b>".$_REQUEST['valueipcenddate']." </b>";
		}
		if($_REQUEST['valueipcsubmitdate']!="")
		{
		
		$criteria = $criteria."Submit Date: <b>".$_REQUEST['valueipcsubmitdate']." </b>";
		}
		if($_REQUEST['valueipcreceivedate']!="")
		{
		
		$criteria = $criteria."Receive Date: <b>".$_REQUEST['valueipcreceivedate']." </b>";
		}
		


?>


<table width="950px" border="0">
  <tr>
    <td width="950px"><?php echo "<strong>Criteria: </strong>".$criteria."";?>
</td>
    </tr>
</table>
<div id="content">
 <?php
$iCount = $objDb->totalRecords( );
if($iCount>0)
{
?>
  
<table class="reference"  width="100%" align="center">
 <tr align="center" >
  
  <td align="center" width="5%"><strong>Sr. No.</strong></td>
  <td align="center" width="15%"><strong>IPC NO</strong></td> 
  <td width="10%"><strong>IPC Month</strong></td>
  <td width="10%"><strong>IPC Start Date</strong></td>
   <td width="10%"><strong>IPC End Date</strong></td>
    <td width="10%"><strong>IPC Submit Date</strong></td>
	 <td width="10%"><strong>IPC Receive Date</strong></td>
 
 
  
</tr>
<?php
	while($eres = $objDb->dbFetchArray())
	//for ($i = 0 ; $i < $iCount; $i ++)
	{
	 
	  $ipcno 								= $eres['ipcno'];
	  $ipcmonth	 							= $eres['ipcmonth'];
	  $ipcstartdate							= $eres['ipcstartdate'];
	  $ipcenddate 							= $eres['ipcenddate'];
	  $ipcsubmitdate	 					= $eres['ipcsubmitdate'];
	  $ipcreceivedate						= $eres['ipcreceivedate'];
	 
	
	
?>
<tr <?=$color; ?>>
<td width="3px"><center> <?=$i+1;?> </center> </td>

<td width="210px"><?=$ipcno;?></td>
<td width="100px"><?=$ipcmonth;?></td>
<td width="180px"  ><?=$ipcstartdate;?></td>
<td width="210px"><?=$ipcenddate;?></td>
<td width="100px"><?=$ipcsubmitdate;?></td>
<td width="180px"  ><?=$ipcreceivedate;?></td>


</tr>
<?php        
	}
?>
</table>
<a style="text-decoration:none;" href="#" >
  <input  type="submit"  class="button3" name="btnExport" id="btnExport" value="Export to Xls" />
  </a>
</div>

<?php
}
}
echo "<br /><br /> ";
//include ("includes/footer.php");
?>
</div>
</body>
</html>