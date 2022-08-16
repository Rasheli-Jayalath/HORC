<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database();



$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
 $pid=$pData["pid"];
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/style.css">
<?php //include ('includes/metatag.php'); ?>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.lid.value != ""){
		qString += 'lid=' + escape(frm.lid.value);
	}
	if(frm.iss_status.value != ""){
		qString += '&iss_status=' + escape(frm.iss_status.value);
	}
	
	document.location = 'rfi_info.php?' + qString;
}


</script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RFI</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">

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

 <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
<style>
        .margintopCSS {
          margin-top:10px;
        }   
        
        .text-34{
  background-color: #151563;
  border-radius: 10px;
  /* box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
  padding-bottom: 12px;
  padding-top: 12px;
  border-radius: 5px 5px;
  color: white;
  font-size: 100%;
}
table{
   
   border:  double ;
   }
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
}
.new_div li {
    list-style: outside none none;
}
        
.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("../../../images/images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 130px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}

.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 0px 20px;
  color: white;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


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
.button-34 {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(26, 26, 125);
  color: #1a1a7d;
  /* box-shadow: rgba(34, 34, 199, .02) 0 -25px 18px -14px inset,rgba(34, 34, 199, .05) 0 1px 2px,rgba(34, 34, 199, .05) 0 2px 4px,rgba(34, 34, 199, .05) 0 4px 8px,rgba(34, 34, 199, .05) 0 8px 16px,rgba(34, 34, 199, .10) 0 16px 32px; */
  box-shadow: none;
  padding: 15px 1px;
  border-radius: 0px;
  font-size: 73%;

  font-weight: 900;
  margin-left:0%;
}
.button-34:hover {
  background-color: #1f1f91;
  color: #fff;
  font-weight: 900;
  font-size: 75%;
  transform: scale(1.05) ;
}
.button-35 {

  padding: 12px 2px;

  font-size: 73%;
  font-weight: 700;
  margin-left:0%;
}
.button-35:hover {
  transform: scale(1.0) ;
  font-size: 85%;
}
.sm-unLine {

  font-weight: 600;
  /* text-decoration-line: underline;
  text-decoration: underline solid #1f1f91 1px;
  text-underline-position: under; */
  
  /* border-bottom: 3px solid #f9dd94; */
 
}

/* .sm-unLine::after {
  content: "";
  display: block;

  padding-top: 3px;
  border-bottom: 2px solid #f9dd94;
} */

/* #u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145 );

  border-radius:10px 30px;
  padding:3.8px;
} */
 

    </style>
  <style type="text/css" media="print">
    @page { 
        size: landscape;
    }
    
</style>
 
<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
</head>
<body>

<div id="wrap1">
  
  <div id="content1" >
   <style>
/* for tooltip screenshot only */
#screenshot{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}
#imageToolTip a
{
text-decoration:none;
font-size:12px;
color:#666677;
text-transform:capitalize;
}
.thumb-border{
			border:1px solid #85B93B;
			background-color:#FFF;
			width:250px;
			text-align:center; float:left;
			margin:10px; padding:10px;
}
/***********/

</style>
<script>
function showListing()
{
document.getElementById("listing").focus(); 
}
//call after page loaded
window.onload=showListing ; 
</script>
<?php

$saveBtn	= $_REQUEST['save'];

$start_date=trim($_POST['start_date']);
$end_date=trim($_POST['end_date']);

	 $report_title		= trim($_POST['report_title']);
	 $rfi_prev_ref				= trim($_POST['rfi_prev_ref']);
	 $rfi_Date		= trim($_POST['rfi_Date']);
	 $rfi_activity_location		= trim($_POST['rfi_activity_location']);
	 $rfi_number				= trim($_POST['rfi_number']);
	 
   $Survey_Surveyor_name			= trim($_POST['Survey_Surveyor_name']);
	 $Survey_Date_time		= trim($_POST['Survey_Date_time']);
	 $Survey_comments			= trim($_POST['Survey_comments']);
   
   $Inspection_inspector_name			= trim($_POST['Inspection_inspector_name']);
	 $Inspection_Date_time		= trim($_POST['Inspection_Date_time']);
	 $Inspection_comments			= trim($_POST['Inspection_comments']);

   $Quality_MT_Engineer_name			= trim($_POST['Quality_MT_Engineer_name']);
   $Quality_testing_Date_time			= trim($_POST['Quality_testing_Date_time']);
	 $Quality_test_report		= trim($_POST['Quality_test_report']);
	 $Quality_test_comments			= trim($_POST['Quality_test_comments']);

   $Approval_authority			= trim($_POST['Approval_authority']);
   $Approval_authority_name			= trim($_POST['Approval_authority_name']);
	 $Approval_status		= trim($_POST['Approval_status']);
	 $Approval_comments			= trim($_POST['Approval_comments']);

	//  $proj_location		= trim($_POST['proj_location']);
	//  $tsector			= trim($_POST['tsector']);
	//  $funded_by			= trim($_POST['funded_by']);
	//  $leadfirm			= trim($_POST['leadfirm']);
	//  $assocfirm			= trim($_POST['assocfirm']);
	 
	//  $eoi_due_dt		= trim($_POST['eoi_due_dt']);
	//  $statuseoi			= trim($_POST['statuseoi']);	
	//  $tf_due_dt			= trim($_POST['tf_due_dt']);
	//  $statustf			= trim($_POST['statustf']);
 	//  $bidresult_dt		= trim($_POST['bidresult_dt']);

	//  $fin_yr			= trim($_POST['fin_yr']);
	//  $estm_val_servc	= trim($_POST['estm_val_servc']);
	//  $expect_pj_star_dt	= trim($_POST['expect_pj_star_dt']);
	//  $confid_factor		= trim($_POST['confid_factor']);

	//  $client_type		= trim($_POST['client_type']);
	//  $client_name		= trim($_POST['client_name']);
	//  $client_email		= trim($_POST['client_email']);
	//  $client_contact	= trim($_POST['client_contact']);
	//  $client_level		= trim($_POST['client_level']);
	 
	//  $bid_statusi		= trim($_POST['bid_statusi']);	 
	//  $emd_yn			= trim($_POST['emd_yn']);
	//  $emd_rs			= trim($_POST['emd_rs']);
	//  $emd_mode			= trim($_POST['emd_mode']);
	//  $bstatus_reason	= trim($_POST['bstatus_reason']);

	//  $prebid_dt			= trim($_POST['prebid_dt']);
	//  $leed_gen			= trim($_POST['leed_gen']);
	 
?>
	
		<div class="tab-content tab-content-basic">

<div class="tab-pane fade show active" id="rfi_report" > 
	<div class="row">
	 <div class="col-sm-12">

	 <div class="col-lg-12 d-flex flex-column">

   
	 <div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<div class="card-body text-center">
  <?php
  if($report_title!=""){?>
  
                  <h3 class="card-title"> <?php echo  $report_title;?></h3>
  <?php }
                  ?>
</div>
	<div class="table-responsive">
    <?php
    
    if($rfi_number== "" && $rfi_prev_ref== "" && $rfi_Date== "" && $rfi_activity_location == "" && $Survey_Surveyor_name== "" && $Survey_Date_time== "" && $Survey_comments == ""
    && $Inspection_inspector_name== "" && $Inspection_Date_time== "" && $Inspection_comments == ""
    && $Quality_MT_Engineer_name== "" && $Quality_testing_Date_time== "" && $Quality_test_report == ""
    && $Quality_test_comments== "" && $Approval_authority== "" && $Approval_authority_name == ""
    && $Approval_status== "" && $Approval_comments== "" ){
      
      if($start_date!="" && $end_date==""){
        $datepicker="";
        $end_date=date("Y/m/d");
        $datepicker=" BETWEEN '".$start_date. "' AND '" .$end_date."'";
      }
      if($start_date=="" && $end_date!=""){
        $datepicker="";
        $start_date="1996-07-01";
        $datepicker=" BETWEEN '".$start_date. "' AND '" .$end_date."'";
      }
      if($start_date!="" && $end_date!=""){
        $datepicker="";
        $datepicker=" BETWEEN '".$start_date. "' AND '" .$end_date."'";
      }
      ?>
      <table class="table table-striped" id="report_table">
      <thead>
                                <tr>
								<th  > S#</th> 
                <th  > RFI Number</th> 
                <th  > RFI Ref Number</th>
                <th >  Date</th>
                <th > Activity Location</th>
                <th  > Surveyor Name</th>
                <th >  Survey Date</th>
                <th > Survey Comment</th>
                <th  > Inspector Name</th>
                <th >  Inspection Date</th>
                <th > Inspection Comment</th>
                <th > Quality Engineer Name</th>
                <th  > Quality Test Date</th>
                <th >  Quality Test Report</th>
                <th > Quality Test Comments</th>
                <th > Approval Authority</th>
                <th  > Authority Name</th>
                <th >  Approval Status</th>
                <th > Approval Comments</th>
                            
                                </tr>
                              </thead>
		
                              <tbody>	
        <?php
	$Sql = "SELECT * FROM tbl_rfi_lab WHERE rfi_sub_date_time ".$datepicker;
  
	$objDb->dbQuery($Sql);
	$counter=1;
	$current="";
  $prev="";

	 while($pdData=$objDb->dbFetchArray())
	 {
     $prev=$pdData['rfi_id'];

    if($current!=$prev){
?>
<tr>
      <td ><?php  echo $counter;  ?>
    
      <td ><?php  echo $pdData['rfi_number'];  ?> 

      <td ><?php  echo $pdData['rfi_prev_ref'];  ?>    
   
      <td ><?php  echo $pdData['rfi_Date']; ?>
   
      <td ><?php  echo $pdData['rfi_activity_location']; ?>
   
      <td ><?php  echo $pdData['Survey_Surveyor_name']; ?>
   
 
      <td ><?php  echo $pdData['Survey_Date_time']; ?>
   
  
      <td ><?php echo $pdData['Survey_comments'];  ?>

      
      <td ><?php  echo $pdData['Inspection_inspector_name']; ?>
   
      
      <td ><?php  echo $pdData['Inspection_Date_time']; ?>
     
    
      <td ><?php echo $pdData['Inspection_comments'];  ?>

      
  
      <td ><?php echo $pdData['Quality_MT_Engineer_name'];  ?>

      
      <td ><?php  echo $pdData['Quality_testing_Date_time']; ?>
   
      
      <td ><?php  echo $pdData['Quality_test_report']; ?>
     
    
      <td ><?php echo $pdData['Quality_test_comments'];  ?>

      
      <td ><?php echo $pdData['Approval_authority'];  ?>

      
      <td ><?php  echo $pdData['Approval_authority_name']; ?>
   
      
      <td ><?php  echo $pdData['Approval_status']; ?>
     
    
      <td ><?php echo $pdData['Approval_comments'];  ?>
      </tr>
 <?php
		$counter=$counter+1;
    $current=$prev;

	 }
  }
?>
</tbody>
</table>
    <?php }
    
    else{
      if($start_date!="" && $end_date==""){
        $end_date=date("Y/m/d");
        $datepicker=" BETWEEN '".$start_date. "' AND '" .$end_date."'";
      }
      if($start_date=="" && $end_date!=""){
        $start_date="1996-07-01";
        $datepicker=" BETWEEN '".$start_date. "' AND '" .$end_date."'";
      }
      if($start_date!="" && $end_date!=""){
        $datepicker=" BETWEEN '".$start_date. "' AND '" .$end_date."'";
      }

    ?>
   <table class="table table-striped" id="report_table">
	 <thead>

   <tr>
			   <th  > S#</th> 
    
  <?php 

if($rfi_number!=""){?>
  <th ><?php echo "RFI NUMBER";  
}


    if($rfi_prev_ref!=""){?>
      <th ><?php  echo "RFI Ref Number";      }


    if($rfi_Date!=""){?>
      <th ><?php  echo "Date"; 
    }

    if($rfi_activity_location!=""){?>
      <th ><?php  echo "Activity Location"; 
    }
    if($Survey_Surveyor_name!=""){?>
      <th ><?php  echo "Surveyor Name"; 
    }
    if($Survey_Date_time!=""){?>
      <th ><?php  echo "Survey Date"; 
    }
    if($Survey_comments!=""){?>
      <th ><?php  echo "Survey Comments"; 
    }
    if($Inspection_inspector_name!=""){?>
      <th ><?php  echo "Inspector Name"; 
    }
    if($Inspection_Date_time!=""){?>
      <th ><?php  echo "Inspection Date"; 
    }
    if($Inspection_comments!=""){?>
      <th ><?php  echo "Inspection Comments"; 
    }
    if($Quality_MT_Engineer_name!=""){?>
      <th ><?php  echo "Quality Engineer Name"; 
    }
    if($Quality_testing_Date_time!=""){?>
      <th ><?php  echo "Quality Test Date"; 
    }
    if($Quality_test_report!=""){?>
      <th ><?php  echo "Quality Test Report"; 
    }
    if($Quality_test_comments!=""){?>
      <th ><?php  echo "Quality Test Comments"; 
    }
    if($Approval_authority!=""){?>
      <th ><?php  echo "Approval Authority"; 
    }
    if($Approval_authority_name!=""){?>
      <th ><?php  echo "Authority Name"; 
    }
    if($Approval_status!=""){?>
      <th ><?php  echo "Approval Status"; 
    }
    if($Approval_comments!=""){?>
      <th ><?php  echo "Approval Comments"; 
    }?>
			   </tr>
			 </thead>
		
			  <tbody>		
<?php   
	$Sql = "SELECT * FROM tbl_rfi_lab WHERE rfi_sub_date_time ". $datepicker;
	$objDb->dbQuery($Sql);
	$counter=1;
  $current="";
  $prev="";

	 while($pdData=$objDb->dbFetchArray())
	 {
     $prev=$pdData['rfi_id'];

    if($current!=$prev){
?>
    <tr>
    <td ><?php  echo $counter;  
    
    if($rfi_number!=""){?>
      <td ><?php  echo $pdData['rfi_number']; 
    }
    if($rfi_prev_ref!=""){?>
      <td ><?php  echo $pdData['rfi_prev_ref'];      }
    if($rfi_Date!=""){?>
      <td ><?php  echo $pdData['rfi_Date']; 
    }
    if($rfi_activity_location!=""){?>
      <td ><?php  echo $pdData['rfi_activity_location']; 
    }
    if($Survey_Surveyor_name!=""){?>
      <td ><?php echo $pdData['Survey_Surveyor_name'];  
    }
    if($Survey_Date_time!=""){?>
      <td ><?php echo $pdData['Survey_Date_time'];  
    }
    if($Survey_comments!=""){?>
      <td ><?php echo $pdData['Survey_comments'];  
    }
    if($Inspection_inspector_name!=""){?>
      <td ><?php echo $pdData['Inspection_inspector_name'];  
    }
    if($Inspection_Date_time!=""){?>
      <td ><?php echo $pdData['Inspection_Date_time'];  
    }
    if($Inspection_comments!=""){?>
      <td ><?php echo $pdData['Inspection_comments'];  
    }
    if($Quality_MT_Engineer_name!=""){?>
      <td ><?php echo $pdData['Quality_MT_Engineer_name'];  
    }
    if($Quality_testing_Date_time!=""){?>
      <td ><?php echo $pdData['Quality_testing_Date_time'];  
    }
    if($Quality_test_report!=""){?>
      <td ><?php echo $pdData['Quality_test_report'];  
    }
    if($Quality_test_comments!=""){?>
      <td ><?php echo $pdData['Quality_test_comments'];  
    }
    
    if($Approval_authority!=""){?>
      <td ><?php if($pdData['Approval_authority']=="1"){echo "Client";}else{echo "Consultant";} 
    }
    if($Approval_authority_name!=""){?>
      <td ><?php  if($pdData['Approval_authority_name']=="1"){echo "option 1";}else{echo "option 2";}  
    }
    if($Approval_status!=""){?>
      <td ><?php if($pdData['Approval_status']=="1"){echo "Approved";}else if($pdData['Approval_status']=="2"){echo "Rejected";}else{echo "Partially Approved";}  
    }
    if($Approval_comments!=""){?>
      <td ><?php echo $pdData['Approval_comments'];  

    }
    ?>
    </tr>
 <?php
    $counter=$counter+1;
		$current=$prev;
	 }
  
  }
?>
</tbody>
</table>
 <?php
    }
 ?>
</div>

<div class="col-sm-10 text-end" > 
<button  class="col-sm-2 button-33" onclick="window.print();" name="print" id="print" value=""> <?php echo "Print"?> </button>
<button  class="col-sm-2 button-33" onclick="fnExcelReport();" name="excel" id="excel" value=""> <?php echo "Export to Excel"?> </button>

	</div>
                          </div>
                        </div>
                      </div>
					  </div>
                      </div>
                </div>
              </div>


      <script>
 function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('report_table'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Report.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}

      </script>

	</body>
	</html>