<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "BASELINE Data";
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
$edit			= $_GET['edit'];

//@require_once("get_url.php");
function RemoveSpecialChar($str){

	// Using preg_replace() function
	// to replace the word
	$res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);

	// Returning the result
	return $res;
}
$msg									= "";
$saveBtn								= $_REQUEST['save']; 
$updateBtn								= $_REQUEST['update'];
$clear									= $_REQUEST['clear'];
$next									= $_REQUEST['next'];
$txtname								= $_REQUEST['txtname'];
$txtname=RemoveSpecialChar($txtname);
$base_code								= $_REQUEST['base_code'];
$base_code=RemoveSpecialChar($base_code);
$txtresource						= $_REQUEST['txtresource'];
$txtresource=RemoveSpecialChar($txtresource);
$txtunit							= $_REQUEST['txtunit'];
$txtunit=RemoveSpecialChar($txtunit);
$txtquantity						= $_REQUEST['txtquantity'];
$txtipcreceivedate						= $_REQUEST['txtipcreceivedate'];
$txtstatus								= $_REQUEST['txtstatus'];

$id=$_REQUEST['delete'];

if($clear!="")
{

$txtipcno 						= '';
$txtipcstartdate 				= '';
$txtipcenddate					= '';
$txtipcenddate					= '';
$txtipcsubmitdate				= '';
$txtipcreceivedate				= '';
$txtstatus						= '';
}


if(isset($_REQUEST['save']))
{

  header("Location: addbaseline.php");

}

if(isset($_REQUEST['save']))
{

$sSQL = ("INSERT INTO baseline (base_desc,base_code,unit,quantity,unit_type,temp_id) VALUES ('$txtname ','$base_code','$txtunit','$txtquantity','1','1')");

	$objDb1->dbQuery($sSQL);
	$ipcid = $con->lastInsertId();
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	// $sSQL = ("INSERT INTO ipc_log (log_module,log_title,log_ip,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status, transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$ipcid)");
	// $objDb2->dbQuery($sSQL);

  header("Location: addbaseline.php");
 
}

if(isset($_REQUEST['update'])){


$uSql = "Update baseline SET 			
base_desc         				= '$txtname',
base_code   				= '$base_code',
unit				= '$txtunit',
quantity         		= '$txtquantity' 		
			where rid	= '$edit'";
		  
 	if($objDb1->dbQuery($uSql)){
	
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
// $sSQL2 = ("INSERT INTO ipc_log (log_module,log_title,log_ip,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$edit)");
// 		$objDb2->dbQuery($sSQL2);

		
	}
	$txtipcno 						= '';
	$txtipcstartdate 				= '';
	$txtipcenddate					= '';
	$txtipcenddate					= '';
	$txtipcsubmitdate				= '';
	$txtipcreceivedate				= '';
	$txtstatus				= '';
	header("Location: addbaseline.php");
	
	}
		


if($edit != ""){
 $eSql = "Select * from baseline where rid='$edit'";
  $objDb -> dbQuery($eSql);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$eRes = $objDb->dbFetchArray();
	  
	  $txtname 								= $eRes['base_desc'];
	  $base_code 								= $eRes['base_code'];

	  $txtresource	 							= $eRes['temp_id'];
	  $txtunit							= $eRes['unit'];
	  $txtquantity 							= $eRes['quantity'];
	 }
}

if(isset($_REQUEST['delete'])){
  $insert_q2="DELETE FROM baseline  WHERE rid='$id'";

  echo $insert_q2;
  $sql_pro2= $objDb->dbQuery($insert_q2);
if ($sql_pro2 == TRUE) {
  $message=  "Record Deleted Successfully";
$activity=$insertid." - Record Deleted Successfully";
} else {
  $message= "Error in Deleting record";
}
}
?>


<?php

$per_page = 50;
if($_GET) {
	$page=$_GET['page'];
}
$start = ($page-1)*$per_page;

?>


<table class="table table-striped" > 
    <tr class="bg-form" style="font-size:12px; color:#CCC;">
    
      <th align="center" width="3%"><strong>Sr. No.</strong></th>
    
      <th width="20%"><strong>Name</strong></th>
      <th width="20%"><strong>Baseline Item Code</strong></th>
      <th width="20%"><strong>Baseline Unit</strong></th>
	  <th width="20%"><strong>Baseline Quantity/Amount</strong></th>
      <th align="center" width="15%"><strong>Action
    </strong></th>
	<!--<th align="center" width="10%"><strong>Log
    </strong></th>-->
    </tr>
<strong>
<?php
 $sSQL = "select * from baseline limit $start,$per_page";
 $objDb2->dbQuery($sSQL);
 $iCount = $objDb2->totalRecords( );

 $j=($page-1)*50;
 if($iCount>0)
 {
	while( $res_e2=$objDb2->dbFetchArray())
	
	{
	

    $id=$res_e2['rid'];
	  $txtname 								= $res_e2['base_desc'];
	  $base_code 								= $res_e2['base_code'];
	  $txtresource	 							= $res_e2['temp_id'];
	  $txtunit							= $res_e2['unit'];
	  $txtquantity 							= $res_e2['quantity'];
	 
	  
	  
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?=$j+1;?> </center> </td>

<td width="345px"><?=wordwrap($txtname,30,"<br>\n") ?></td>
<td width="235px"><?=$base_code;?></td>
<td width="340px"><?=$txtunit;?></td>
<td width="230px"><?=$txtquantity;?></td>
<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
<button type="button" style="text-align:center;" class="btn btn-outline-info btn-sm" onclick="location.href='addbaseline.php?edit=<?php echo $id;?>'">EDIT</button>
<button type="submit" title = "Delete" class="btn btn-outline-info btn-sm"  name="delete" id="delete" value="<?php echo $id ; ?>" onclick="return confirm('Are you sure?')" >DELETE</button>
<!-- 
<span style="float:right"><form action="addbaseline.php?rid=<?php echo $id ?>" method="post">
<button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="<?php echo $id ; ?>" onclick="return confirm('Are you sure?')" >
<i class="ti-trash btn-icon-prepend" ></i></button> </form></span> -->
</td>
<!-- <td width="210px" align="right" ><a href="log_ipcdata.php?trans_id=<?php echo $id ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>-->
</tr>
<?php 
$j=$j+1;       
	}
	}
  ?>
</table>