<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "IPC Data";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
$objDb4  		= new Database();
$objDb5  		= new Database();

$objDb6  		= new Database();
$objDb7  		= new Database();
$objDb8  		= new Database();
$objDb9  		= new Database();
$objDb10  		= new Database();

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
$lid								= $_REQUEST['lid'];
$txtipcno								= $_REQUEST['txtipcno'];
$txtipcno=RemoveSpecialChar($txtipcno);
$txtmonth1								= $_REQUEST['txtipcmonth'];
$txtipcmonth							= $txtmonth1."-01";
$txtipcstartdate						= $_REQUEST['txtipcstartdate'];
$txtipcenddate							= $_REQUEST['txtipcenddate'];
$txtipcsubmitdate						= $_REQUEST['txtipcsubmitdate'];
$txtipcreceivedate						= $_REQUEST['txtipcreceivedate'];
$txtstatus								= $_REQUEST['txtstatus'];

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

if($saveBtn != "")
{
$eSql_l = "Select * from ipc where status=0";
  	$res_q=$objDb->dbQuery($eSql_l);
	if($objDb->totalRecords()==1)
	{
	$msg="You can't add new IPC month if a month has already Active status.";
	}
	else
	{
	 $eSql_5 = "Select * from ipc where lid=$lid and ipcmonth='$txtipcmonth'";
  	$res_5=$objDb->dbQuery($eSql_5);
		if($objDb->totalRecords()>=1)
		{
			$msg="Selected IPC Month and Package is already added.";
		}
		else
		{
 $sSQL = ("INSERT INTO ipc (ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status,lid) VALUES ('$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$lid)");

	$objDb1->dbQuery($sSQL);
	$ipcid = $con->lastInsertId();
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO ipc_log (log_module,log_title,log_ip,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status, transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$ipcid)");
	$objDb2->dbQuery($sSQL);
	header("Location: ipcdata.php");
		}
}	
		
 
}

if($updateBtn !=""){

 $eSql_l = "Select * from ipc where status=0 and ipcid!=$edit";
  	$res_q=$objDb->dbQuery($eSql_l);
	
	if($objDb->totalRecords()==1)
	{
		$msg="You can't update month's status to Active if a month has already Active status";
		
	}
	else
	{
	$eSql_6 = "Select * from ipc where lid=$lid and ipcmonth='$txtipcmonth' and ipcid!=$edit";
  	$res_6=$objDb->dbQuery($eSql_6);
		if($objDb->totalRecords()>=1)
		{
			$msg="Selected IPC Month and Package is already added.";
		}
		else
		{	
$uSql = "Update ipc SET 			
			 ipcno         				= '$txtipcno',
			 ipcmonth   				= '$txtipcmonth',
			 ipcstartdate				= '$txtipcstartdate',
			  ipcenddate         		= '$txtipcenddate',
			 ipcsubmitdate   			= '$txtipcsubmitdate',
			 ipcreceivedate				= '$txtipcreceivedate',
			 status   					= '$txtstatus',
			  lid   					= '$lid'		
			where ipcid 				= $edit";
		  
 	if($objDb1->dbQuery($uSql)){
	
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
$sSQL2 = ("INSERT INTO ipc_log (log_module,log_title,log_ip,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$edit)");
		$objDb2->dbQuery($sSQL2);
		
		
	header("Location: ipcdata.php");

	}
	}
	$txtipcno 						= '';
	$txtipcstartdate 				= '';
	$txtipcenddate					= '';
	$txtipcenddate					= '';
	$txtipcsubmitdate				= '';
	$txtipcreceivedate				= '';
	$txtstatus				= '';
	
	
	}
		
}

if($edit != ""){
 $eSql = "Select lid,ipcno,left(ipcmonth,7) as ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status from ipc where ipcid='$edit'";
  $objDb -> dbQuery($eSql);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$eRes = $objDb->dbFetchArray();
		$lid 								= $eRes['lid'];
	  $ipcno 								= $eRes['ipcno'];
	  $ipcmonth	 							= $eRes['ipcmonth'];
	  $ipcstartdate							= $eRes['ipcstartdate'];
	  $ipcenddate 							= $eRes['ipcenddate'];
	  $ipcsubmitdate	 					= $eRes['ipcsubmitdate'];
	  $ipcreceivedate						= $eRes['ipcreceivedate'];
	  $status								= $eRes['status'];
	 }
}




////////
//  ipcv_copy 

if (isset($_POST["submitVerify"])) {


  $sql_tr = "TRUNCATE ipcv_archieve";
  $objDb7->dbQuery($sql_tr);

 $sql_i = "INSERT INTO ipcv_archieve (ipcvid, ipcid, boqid,ipcqty) SELECT ipcvid, ipcid, boqid,ipcqty FROM ipcv ";
	$objDb6->dbQuery($sql_i);

  $sql = "INSERT INTO ipcv (ipcid, boqid,ipcqty) SELECT ipcid, boqid,ipcqty FROM ipcv_copy ";
	$objDb4->dbQuery($sql);

  $sql1 = "TRUNCATE  ipcv_copy";
	$objDb5->dbQuery($sql1);

  if(isset($_GET['verifiedIPCId'])){
    $verifiedIPCId = $_GET['verifiedIPCId'];
    $sql2 = "UPDATE ipc  SET status=1 WHERE ipcid= $verifiedIPCId";
    $objDb9->dbQuery($sql2);

   }

}

if (isset($_POST["submitDelete"])) {




  $sql1 = "DELETE  FROM ipcv_copy";
	$objDb5->dbQuery($sql1);


}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add IPC Entry</title>

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



<script>
function showResult(strmodule,strno,strmonth,strsdate,stredate,strsubdate,strrecdate) {
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
  $url="searchipcdata.php?module="+strmodule+"&ipcno="+strno+"&ipcmonth="+strmonth+"&ipcstartdate="+strsdate+"&ipcenddate="+stredate+"&ipcsubmitdate="+strsubdate+"&ipcreceivedate="+strrecdate;
  alert($url);
  xmlhttp.open("GET","searchipcdata.php?module="+strmodule+"&ipcno="+strno+"&ipcmonth="+strmonth+"&ipcstartdate="+strsdate+"&ipcenddate="+stredate+"&ipcsubmitdate="+strsubdate+"&ipcreceivedate="+strrecdate,true);
  xmlhttp.send();
}

</script>
<!--<script type="text/javascript">
		 
 $(function() {
    $( "#valuetf" ).datepicker();
  });
   $(function() {
    $( "#valuett" ).datepicker();
  });

</script>-->
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
</script>
<script type="text/javascript">
		 
 $(function() {
 $('#txtipcstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtipcenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtipcsubmitdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtipcreceivedate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });


</script>
<!--<script type="text/javascript">
		 
 $(function() {
 $('#valueipcstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueipcenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueipcsubmitdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueipcreceivedate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });


</script>-->

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

            <div class="card bg-form">
                <div class="col-md-8 m-auto py-4" style="color:#fff">

                <h2 style="text-align:center">ADD IPC DATA 
                <span style="text-align:right; float:right" ><a href="addipc.php" class="btn btn-secondary px-2 py-1" > 
                  <i  class="mdi mdi-keyboard-backspace mb-5 text-bold" style="vertical-align: top;"></i>  Back</a></span>
              </h2>
                <hr>
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="" enctype="multipart/form-data" style="margin-top:10px;">
	  
	  <font color="red"><strong><?php echo $msg; ?></strong></font>
               
        <div class="container">

                        <div class="row">
							<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" >Packages/Components</label>
                                   <select name="lid" id="lid" class="col-sm-5  form-select  form-control-enhanced" style = "width: 70%;" required>
                                             <?php $sqlgg="SELECT * FROM boqdata where parentcd=1";
			$resg=$objDb3->dbQuery($sqlgg);
			
			while($row3g=$objDb3->dbFetchArray())
			{
			$getcom=$row3g['lid'];
			if($getcom==$lid)
			{
			$sel =" selected='selected' ";
			}
			else
			{
			$sel ="";
			}
			
			?>
			  <option  value="<?php echo $row3g['itemid'];?>" <?php echo  $sel; ?>  ><?php echo $row3g['itemname']; ?> </option>
			  <?php
			  }
			  
			  ?>
                                            
                                        </select>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        
							
                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" >IPC No </label>
                                    <input placeholder="Enter IPC Number" type="text" id="txtipcno" name="txtipcno"  value="<?php echo $ipcno; ?>"  minlength="" maxlength=""     required  class="form-control form-control-enhanced" >
                                </div>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label >Month </label>
                                    <select name="txtipcmonth" id="txtipcmonth" class="col-sm-5  form-select  form-control-enhanced" style = "width: 70%;" required>
                                             <?php $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
			$resg=$objDb1->dbQuery($sqlg);
			
			while($row3g=$objDb1->dbFetchArray())
			{
			$getmonth=$row3g['getmonths'];
			if($getmonth==$ipcmonth)
			{
			$sel =" selected='selected' ";
			}
			else
			{
			$sel ="";
			}
			
			?>
			  <option value="<?php echo $getmonth;?>" <?php echo  $sel; ?>  ><?php echo $getmonth; ?> </option>
			  <?php
			  }
			  
			  ?>
                                            
                                        </select>
                                        <!-- <input type="text" name="ipc_month" id="ipc_month"    minlength="  " maxlength="  "     placeholder=""    required  class="form-control form-control-enhanced" > -->
                                    </div>
                              </div>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col">
                                      <div class="form-group row">

                                        <div class="col-md-12">
                                        <label for="">IPC Start Date</label>
                                            <input type="text" id="txtipcstartdate" name="txtipcstartdate"  value="<?php echo $ipcstartdate; ?>"   minlength="  " maxlength="  "     placeholder="Select Start Date"    required  class="form-control form-control-enhanced"    >
                                        </div>
                                       </div>
                            </div>
                            <div class="col">
                                      <div class="form-group row">

                                            <div class="col-md-12">
                                            <label for=""  >IPC End Date</label>
                                                <input type="text"  name="txtipcenddate" id="txtipcenddate" value="<?php echo $ipcenddate; ?>"   minlength="  " maxlength="  "     placeholder="Select End Date"    required  class="form-control form-control-enhanced" >
                                            </div>
                                      </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                                          <div class="form-group row">

                                                <div class="col-md-12">
                                                <label for="">IPC Submit Date</label>
                                                    <input type="text" name="txtipcsubmitdate" id="txtipcsubmitdate" value="<?php echo $ipcsubmitdate; ?>"  minlength="  " maxlength="  "     placeholder="Select Submit Date"    required  class="form-control form-control-enhanced" >
                                                </div>
                                          </div>
                            </div>
                            <div class="col">

                                <div class="form-group row">

                                      <div class="col-md-12">
                                      <label for=""  > IPC Receive Date	</label>
                                          <input type="text" name="txtipcreceivedate" id="txtipcreceivedate" value="<?php echo $ipcreceivedate; ?>"    minlength="  " maxlength="  "     placeholder="Select Receive Date"    required  class=" form-control form-control-enhanced" >
                                      </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                              <div class="form-group row">

                              <div class="col-md-12">
                                 <label for=""> Status &nbsp;	&nbsp;	&nbsp;	&nbsp;	
</label>
                              <input type="radio"  id="txtstatus" name="txtstatus" value="0" <?php if($status=="0"){ echo "checked='checked'";} else if($status==""){ echo "checked='checked'";} ?>/>Active
			 &nbsp;	&nbsp; <input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($status=="1"){ echo "checked='checked'";} ?>/>Inactive
                           
                                         
                              </div>
                              </div>

                            </div>

                            <div class="col">

                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                              <div class=" row">
                              <label for=""></label>
                              <div class="col-sm-6">
                              <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update"  class="btn bg-success m-auto text-white btn-sm" />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save"  class="btn bg-success m-auto text-white btn-sm"/>
			 <!-- &nbsp;&nbsp;<input type="submit" value="Clear" name="clear" class="btn bg-success m-auto text-white btn-sm"/>-->
			  <?php } ?>
                              

                              </div>
                              </div>

                            </div>

                            <div class="col">

                            </div>

                        </div>


                    </div>
     </form>
      </div>
            </div>
            </div>



         </div>

         <div class="row"  style = "margin-top: 20px;margin-right:15px; align-items: center; justify-content: center;">
     
     
	 
<form name="reports" id="reports"  method="post"   onsubmit="return atleast_onecheckbox(event)" style="display:inline-block"> 

 <div class ="table-responsive" style="width: 105%;">
	<table class="table table-striped " > 

    <tr class="bg-form" style="font-size:12px; color:#CCC;  ">
    
      <th align="center" ><strong><?php echo wordwrap("Sr. No",5,"<br><br>\n"); ?> </strong></th>
      <th align="center" ><strong>Package</strong></th>
      <th align="center" ><strong>IPC No</strong></th>
      <th ><strong>IPC Month</strong></th>
      <th ><strong> <?php echo wordwrap("IPC Start Date",10,"<br><br>\n"); ?> </strong></th>
	    <th ><strong> <?php echo wordwrap("IPC End Date",10,"<br><br>\n"); ?>  </strong></th>
      <th ><strong> <?php echo wordwrap("IPC Submit Date",10,"<br><br>\n"); ?> </strong></th>
	    <th ><strong> <?php echo wordwrap("IPC Receive Date",15,"<br><br>\n"); ?> </strong></th>
	    <th class="text-center"><strong>Status</strong></th>
      <th style="text-align:center"><strong>Action</strong></th>

	<!--<th align="center" width="10%"><strong>Log
    </strong></th>-->
    </tr>
<strong>
<?php
 $sSQL = "select ipcid,ipcno,lid,left(ipcmonth,7) as ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status from ipc";
 $objDb2->dbQuery($sSQL);
 $iCount = $objDb2->totalRecords( );
 if($iCount>0)
 {
	 $j=0;
	while( $res_e2=$objDb2->dbFetchArray())
	
	{
	 $j++;
		
	  $ipcid 								= $res_e2['ipcid'];
	  $ipcno 								= $res_e2['ipcno'];
	  $ipcmonth	 							= $res_e2['ipcmonth'];
	  $ipcstartdate							= $res_e2['ipcstartdate'];
	  $ipcenddate 							= $res_e2['ipcenddate'];
	  $ipcsubmitdate	 					= $res_e2['ipcsubmitdate'];
	  $ipcreceivedate						= $res_e2['ipcreceivedate'];
	  $status3								= $res_e2['status'];
	  $itemid_p								= $res_e2['lid'];
	  
	  $sSQL6 = "select itemname from boqdata where itemid=".$itemid_p;
 	$objDb3->dbQuery($sSQL6);
	$res_e3=$objDb3->dbFetchArray();
	  
	   if($status3=="0")
	  {
	  $status="Active";
	  }
	  else  if($status3=="1")
	  {
	  $status="Inactive";
	  }
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}

?>
</strong>
<tr <?php echo $style; ?> style="font-size:12px; ">
<td width="5px"><center> <?php echo $j;?> </center> </td>

<td> <?php echo wordwrap($res_e3['itemname'],15,"<br>\n"); ?> </td>
<td><?=$ipcno;?></td>
<td><?=$ipcmonth;?></td>
<td><?=$ipcstartdate;?></td>
<td><?=$ipcenddate;?></td>
<td><?=$ipcsubmitdate;?></td>
<td><?=$ipcreceivedate;?></td>
<td><?=$status;?></td>

<td style="border-bottom:1px solid #cccccc; " width="210px" >&nbsp;
<button type="button" style="text-align:center;" class="btn btn-outline-info btn-sm" onclick="location.href='ipcdata.php?edit=<?php echo $ipcid;?>'">EDIT</button>

<?php
 $sSQL4 = "SELECT * FROM ipcv_copy where ipcid= $ipcid " ;
 $objDb10->dbQuery($sSQL4);
 $iCount = $objDb10->totalRecords( );
 if($iCount>0){ 
  ?>
    <button type="button" style="text-align:center; margin-left: 5px;" class=" btn-sm  btn btn-success" onclick="location.href='csvdata.php?msg=1&ipcid=<?php echo $ipcid;?>'">View</button>
<?php } else if($status3=="0"){

?>
<button type="button" style="text-align:center; margin-left: 5px;" class=" btn-sm  btn btn-warning" onclick="location.href='csvdata.php?edit=<?php echo $ipcid;?>'">IMPORT</button>
<?php } ?>
 </td>

<!-- <td width="210px" align="right" ><a href="log_ipcdata.php?trans_id=<?php echo $ipcid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>-->
</tr>
<?php        
	}
	}
?>
</table>
</div>
</div>
</form>
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
 <!--   <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>-->
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
  <link rel="stylesheet" type="text/css" media="all" href="../../../datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="../../../datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="../../../datepickercode/jquery-ui.js"></script>

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





</body>

</html>