<?php
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}

include_once("connect.php");
include_once("functions.php");
//===============================================
/*
brid
pgid
pid
serial
description
total
inprogress
completed
*/
if(isset($_REQUEST['save']))
{
	
	$act_id=$_REQUEST['act_id'];
	$ppt_planned=$_REQUEST['ppt_planned'];
	$ppt_actual=$_REQUEST['ppt_actual'];
	$message="";
	$pgid=1;
$sql_pro=mysqli_query($db, "INSERT INTO t024project_progress_table (pid, act_id, ppt_planned, ppt_actual) Values(".$pid.",'".$act_id."',".$ppt_planned.",".$ppt_actual.")");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysqli_error($db);
}
	
	$act_id='';
	$ppt_planned='';
	$ppt_actual='';
	
}

if(isset($_REQUEST['update']))
{
	$ppt_id=$_REQUEST['ppt_id'];
	$act_id=$_REQUEST['act_id'];
	$ppt_planned=$_REQUEST['ppt_planned'];
	$ppt_actual=$_REQUEST['ppt_actual'];
	$message="";
	$pgid=1;
	
echo $sql_pro="UPDATE t024project_progress_table SET act_id='$act_id', ppt_planned=$ppt_planned, ppt_actual=$ppt_actual where ppt_id=".$ppt_id;
	
	$sql_proresult=mysqli_query($db, $sql_pro) or die(mysqli_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysqli_error($db);
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
header("Location: sp_major_items.php");
}
if(isset($_REQUEST['ppt_id']))
{
$ppt_id=$_REQUEST['ppt_id'];

$pdSQL1="SELECT ppt_id,pid, act_id, ppt_planned, ppt_actual  FROM t024project_progress_table where  pid=$pid and ppt_id=$ppt_id order by ppt_id";

$pdSQLResult1 = mysqli_query($db, $pdSQL1) or die(mysqli_error());
$pdData1 = mysqli_fetch_array($pdSQLResult1);

	$act_id=$pdData1['act_id'];
	$ppt_planned=$pdData1['ppt_planned'];
	$ppt_actual=$pdData1['ppt_actual'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tarbela 4th Extension  Hydropower Project</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
<img src="nha1.jpg" alt="nha logo" width="68.12"  height="60.98" style="position:absolute; top: 0px; left: 20px;"  />
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
<img src="nha2.jpg" alt="nha logo" width="104.64" style="position:absolute; top: 20px; right: 20px;" />
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Major Items Progress</span><span style="float:right"><form action="sp_major_items.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_major_items_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Activity Name:</label></td><td><input  type="text" name="act_id" id="act_id" value="<?php echo $act_id; ?>"  size="50px"/></td></tr>
  
    <tr><td><label>Planned Percent:</label></td><td><input  type="text" name="ppt_planned" id="ppt_planned" value="<?php echo $ppt_planned; ?>" /></td></tr>
   
     <tr><td><label>Planned Actual:</label></td><td><input  type="text" name="ppt_actual" id="ppt_actual" value="<?php echo $ppt_actual; ?>" /></td></tr>
	
	 
	  
	  <tr><td colspan="2"> <?php if(isset($_REQUEST['ppt_id']))
	 {
		 
	 ?>
     <input type="hidden" name="ppt_id" id="ppt_id" value="<?php echo $_REQUEST['ppt_id']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
