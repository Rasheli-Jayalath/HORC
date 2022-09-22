<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
 $pid=$pData["pid"];
	
  $dpentry_flag=1;
 $dpadm_flag=1;		
 
 
if(isset($_REQUEST['item_id']))
{
$item_id=$_REQUEST['item_id'];

$pdSQL1="SELECT item_id, pid, title, lid FROM  t014majoritems  WHERE  item_id = ".$item_id;
$pdSQLResult1 =$objDb->dbQuery($pdSQL1);
 $pdData1=$objDb->dbFetchArray();
$lid=$pdData1['lid'];
$title=$pdData1['title'];

}






if(isset($_REQUEST['delete'])&&isset($_REQUEST['item_id'])&$_REQUEST['item_id']!="")
{

 $objDb->dbQuery("Delete from  t014majoritems where item_id=".$_REQUEST['item_id']);
 header("Location: items_form.php");
}

if(isset($_REQUEST['save']))
{    $lid=$_REQUEST['lid'];
    $title=$_REQUEST['title'];
    if($lid!='0'){
	$sql_pro=$objDb->dbQuery("INSERT INTO  t014majoritems(pid, title,lid) Values(".$pid.", '".$title."', '".$lid."' )");
	if ($sql_pro == TRUE) {
     
    $message=  "New record added successfully";
    echo "<script type='text/javascript'>alert('$message');</script>";

  }
  
}else {
  $message= "Error in updating Record!! Please Choose a Componet Area First";
  echo "<script type='text/javascript'>alert(\"Error in updating Record!! Please Choose a Componet Area First\")</script>";

}
	header("Location: items_form.php");
	
}

if(isset($_REQUEST['update']))
{
$title=$_REQUEST['title'];
$pdSQL = "SELECT a.item_id, a.pid, lid FROM  t014majoritems a WHERE pid = ".$pid." and item_id=".$item_id." order by item_id";
$pdSQLResult = $objDb->dbQuery($pdSQL);
$sql_num=$objDb-> totalRecords();

$pdData=$objDb->dbFetchArray();

$item_id=$_REQUEST['item_id'];
$lid=$_REQUEST['lid'];
		
if($lid!='0'){
  $sql_pro="UPDATE  t014majoritems SET title='$title',lid='$lid' where item_id=$item_id ";
  $sql_proresult=$objSDb->dbQuery($sql_pro);
	
	
  if ($sql_proresult == TRUE) {
  $message=  "Record updated successfully";
  echo $message;
}
	 
	

	} else {
		$message= "Error in updating Record!! Please Choose a Componet Area First";
    
    echo $message;
	}
	
header("Location: items_form.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.location.reload();";
    print "self.close();";
    print "</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<script>
window.onunload = function(){
window.opener.location.reload();
};
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Major Items </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../endors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
 <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />

</head>


<body>
  <style>
	 table, th, td {
  border: 1px solid black;
} 
.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:1%;
  margin-top: 1%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 5px 2px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-33:hover {
  box-shadow: rgba(22, 22, 51,.35) 0 -25px 18px -14px inset,rgba(22, 22, 51,.25) 0 1px 2px,rgba(22, 22, 51,.25) 0 2px 4px,rgba(22, 22, 51,.25) 0 4px 8px,rgba(22, 22, 51,.25) 0 8px 16px,rgba(22, 22, 51,.25) 0 16px 32px;
  transform: scale(1.1) ;
}
    .col-sm-6{

		
    }
	
    #tworow{
      padding: 20px;
    }

    h3{
      font-family: Arial, Helvetica, sans-serif;
    }

    label {
      font-weight: bold;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 100%;
    }
    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }

	
  </style>
    <div class="container-fluid">

    <div class=" grid-margin stretch-card " style = "margin-top: 3%;"></div>
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Please Select desired parameters for Report</h4>
				  <?php echo $message; ?>
                  <form class="forms-sample" action="hr_general_report.php" target="_new" method="post"  enctype="multipart/form-data">
                    
				  <div class="form-group row">

          <!-- <div class="text-end col-sm-6"> <label>Componet Area : </label> </div> -->
		  <form name="frm_Report" id="frm_Report" action="hr_general_report.php"  method="post"  enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
	<!-- <tr>
	<td colspan="16" align="left"   valign="top">
	</tr> -->
	<tr>

	<td colspan="12"   valign="top">
	<label ><h4>Report Title:</h4></label>
	
	<input type="text" id="report_title" name="report_title" style="width:600px;" /></td>
	</tr>
		
	<!-- <tr>
	<td width="4%" style="text-align:center;"> <input type="checkbox" value="oid" name="oid" id="oid"/></td>
	<td width="4%" align="left"><?php echo "Opportunity Id";?></td>

	<td width="4%" style="text-align:center;"> <input type="checkbox" value="smecintl_no" name="smecintl_no" id="smecintl_no"/></td>
	<td width="4%" align="left"><?php echo "SMEC #";?></td>
	<td width="4%" style="text-align:center;"> <input type="checkbox" value="smecind_no" name="smecind_no" id="smecind_no"/></td>
	<td width="4%" align="left"><?php echo "SMEC India #";?></td>
	<td width="4%" style="text-align:center;"> <input type="checkbox" value="sj_no" name="sj_no" id="sj_no"/></td>
	<td width="4%" align="left"><?php echo "SJ #";?></td>
	<td width="4%" style="text-align:center;">
	<input type="checkbox" value="typeof_servic" name="typeof_servic" id="typeof_servic"/></td><td width="11%"  align="left"> <?php echo "Type of Service";?></td>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="proj_name" name="proj_name" id="proj_name"/></td>
	<td width="4%" align="left"><?php echo "Project Name";?></td> -->
		
	<!-- <tr>		
	<td width="4%" style="text-align:center;"><input type="checkbox" value="statename" name="statename" id="statename"/></td>
	<td width="11%"  align="left"> <?php echo "State Name";?></td>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="proj_location" name="proj_location" id="proj_location"/></td>
	<td width="11%"  align="left"> <?php echo "Project Location";?></td>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="tsector" name="tsector" id="tsector"/></td>
	<td width="8%" align="left"><?php echo "Func. Group";?></td>
				
	<td width="4%" style="text-align:center;"><input type="checkbox" value="funded_by" name="funded_by" id="funded_by"/></td>
	<td width="11%"  align="left"> <?php echo "Funded By";?></td>
		
	<td width="4%" style="text-align:center;"><input type="checkbox" value="leadfirm" name="leadfirm" id="leadfirm"/></td>
	<td width="11%"  align="left"> <?php echo "Lead Firm";?></td>
		
	<td width="4%" style="text-align:center;"><input type="checkbox" value="assocfirm" name="assocfirm" id="assocfirm"/></td>
	<td width="11%"  align="left"> <?php echo "Assoc. Firms";?></td>	
</tr> -->









<tr>  <td colspan="12" align="centre"><h4><strong>RFI  DETAIL</strong></h4></td> 
</tr>

<tr>

<tr>
	<td colspan="4" align="centre" width="40%" style="text-align:center;"align="centre">
	<label align="centre">From Date</label>
	<input type="date" align="right" class="form-control" name="start_date"  value="start_date" id="start_date" placeholder="yyyy-mm-dd" style="width:50%;" />
</td>
<td colspan="4" align="centre" width="40%" style="text-align:center;"align="centre">
	<label align="centre">Till Date</label>
	<input type="date" class="form-control" name="end_date"  value="end_date" id="end_date" placeholder="yyyy-mm-dd" style="width:50%;" />

	</td>
	
</tr>

	<td width="4%" style="text-align:right;"><input type="checkbox" value="rfi_number" name="rfi_number" id="rfi_number"/></td>
	<td width="4%" align="left"><?php echo "RFI Number";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="rfi_prev_ref" name="rfi_prev_ref" id="rfi_prev_ref"/></td>
	<td width="4%"  align="left"> <?php echo "RFI Referance Number";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="rfi_Date" name="rfi_Date" id="rfi_Date"/></td>
	<td width="4%"  align="left"> <?php echo "RFI Date";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="rfi_activity_location" name="rfi_activity_location" id="rfi_activity_location"/></td>
	<td width="4%"  align="left"> <?php echo "Activity Location";?></td>

</tr>	
				
<tr >  <td colspan="12" align="centre"><h4><strong>SURVEY  DETAIL</strong></h4></td> 
</tr>	
				
<tr>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Survey_Surveyor_name" name="Survey_Surveyor_name" id="Survey_Surveyor_name"/></td>
	<td width="4%"  align="left"> <?php echo "Surveyor Name";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Survey_Date_time" name="Survey_Date_time" id="Survey_Date_time"/></td>
	<td width="8%" align="left"><?php echo "Survey Date";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Survey_comments" name="Survey_comments" id="Survey_comments"/></td>
	<td width="4%"  align="left"> <?php echo "Survey Comments";?></td>
	
</tr>
<tr>	<td colspan="12" align="centre"><h4><strong>INSPECTION DETAIL</strong></h4></td> 
</tr>
<tr>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Inspection_inspector_name" name="Inspection_inspector_name" id="Inspection_inspector_name"/></td>
	<td width="4%"  align="left"> <?php echo "Inspector Name";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Inspection_Date_time" name="Inspection_Date_time" id="Inspection_Date_time"/></td>
	<td width="4%"  align="left"> <?php echo "Inspection Date";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Inspection_comments" name="Inspection_comments" id="Inspection_comments"/></td>
	<td width="4%"  align="left"> <?php echo "Inspection Comments";?></td>
</tr>

<tr>	<td colspan="12" align="centre"><h4><strong>QUALITY DETAIL</strong></h4></td> 
</tr>
<tr>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Quality_MT_Engineer_name" name="Quality_MT_Engineer_name" id="Quality_MT_Engineer_name"/></td>
	<td width="4%"  align="left"> <?php echo "Quality Engineer Name";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Quality_testing_Date_time" name="Quality_testing_Date_time" id="Quality_testing_Date_time"/></td>
	<td width="4%"  align="left"> <?php echo "Quality Test Date";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Quality_test_report" name="Quality_test_report" id="Quality_test_report"/></td>
	<td width="4%"  align="left"> <?php echo "Quality Test Report";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Quality_test_comments" name="Quality_test_comments" id="Quality_test_comments"/></td>
	<td width="4%"  align="left"> <?php echo "Quality Test Comments";?></td>
</tr>
<tr>	<td colspan="12" align="centre"><h4><strong>APPROVAL DETAIL</strong></h4></td> 
</tr>
<tr>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Approval_authority" name="Approval_authority" id="Approval_authority"/></td>
	<td width="4%"  align="left"> <?php echo "Approval Authority";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Approval_authority_name" name="Approval_authority_name" id="Approval_authority_name"/></td>
	<td width="4%"  align="left"> <?php echo "Authority Name";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Approval_status" name="Approval_status" id="Approval_status"/></td>
	<td width="4%"  align="left"> <?php echo "Approval Status";?></td>
	<td width="4%" style="text-align:right;"><input type="checkbox" value="Approval_comments" name="Approval_comments" id="Approval_comments"/></td>
	<td width="4%"  align="left"> <?php echo "Approval Comments";?></td>
</tr>
 <!-- <tr>  	
	<td width="4%" style="text-align:center;"><input type="checkbox" value="emd_rs" name="emd_rs" id="emd_rs"/>	<td width="11%"  align="left"> <?php echo "Earnest Money Amount(INR)";?></td>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="emd_mode" name="emd_mode" id="emd_mode"/></td>
	<td width="11%"  align="left"> <?php echo "Earnest Money Mode";?></td>
</tr> -->


				
<!-- 		
<tr >  <td colspan="12" align="left"><h3><strong>EOI STATUS</strong></h3></td> 
</tr>		
	<tr>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="eoi_due_dt" name="eoi_due_dt" id="eoi_due_dt"/></td>
	<td width="8%" align="left"><?php echo "EOI Submission Date";?></td>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="statuseoi" name="statuseoi" id="statuseoi"/></td>
	<td width="8%" align="left"><?php echo "EOI Status";?></td>

	<td width="4%" style="text-align:center;"><input type="checkbox" value="tf_due_dt" name="tf_due_dt" id="tf_due_dt"/></td>
	<td width="8%" align="left"><?php echo "Technical Submission Date";?></td>
	<td width="4%" style="text-align:center;"><input type="checkbox" value="statustf" name="statustf" id="statustf"/></td>
	<td width="8%" align="left"><?php echo "Technical Status";?></td>
 </tr>

<tr>
	<td width="4%"  style="text-align:center;"><input type="checkbox" value="prebid_dt" name="prebid_dt" id="prebid_dt"/></td>
	<td width="11%" align="left"> <?php echo "Pre-Bid Meering Date";?></td>
	<td width="4%"  style="text-align:center;"><input type="checkbox" value="bidresult_dt" name="bidresult_dt" id="bidresult_dt"/></td>
	<td width="11%" align="left"> <?php echo "Bid Result Date";?></td>



	<td width="4%" style="text-align:center;"><input type="checkbox" value="leed_gen" name="leed_gen" id="leed_gen"/></td>
	<td width="11%"  align="left"> <?php echo "Lead Generator";?></td>
</tr>
    -->
   <tr>
	<td  colspan="14" align="center">
	<button  class="col-sm-2 button-33" align="centre"type="submit" name="save" id="save" value="Generate Report"> <?php echo "Generate Report"?> </button>
	
	</td>

	</tr>
	
	</table>
	

</div><!-- tworow -->
</div><!-- class="row" -->
    </div><!-- class="container" -->
</body>
</html>
