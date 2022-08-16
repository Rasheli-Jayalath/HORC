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
$msg									= "";
$saveBtn								= $_REQUEST['save']; 
$updateBtn								= $_REQUEST['update'];
$clear									= $_REQUEST['clear'];
$next									= $_REQUEST['next'];
$txtname								= $_REQUEST['txtname'];
$base_code								= $_REQUEST['base_code'];
$txtresource						= $_REQUEST['txtresource'];
$txtunit							= $_REQUEST['txtunit'];
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
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Baseline Entry</title>

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

                <h2 style="text-align:center">ADD BASELINE DATA</h2>
                <hr>
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="" enctype="multipart/form-data" style="margin-top:10px;">
	  
	  <font color="red"><strong><?php echo $msg; ?></strong></font>
               
        <div class="container">

                        <div class="row">
                        

                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" >Baseline Item:</label>
                                    <input placeholder="Enter Name" type="text" id="txtname" name="txtname"  value="<?php echo $txtname; ?>"  minlength="" maxlength=""     required  class="form-control form-control-enhanced" >
                                </div>
                              </div>
                            </div>
                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" >Baseline Item Code:</label>
                                    <input placeholder="Enter Item Code" type="text" id="base_code" name="base_code"  value="<?php echo $base_code; ?>"  minlength="" maxlength=""     required  class="form-control form-control-enhanced" >
                                </div>
                              </div>


                        </div>

                        <div class="row">

                            <div class="col">
                                      <div class="form-group row">
                                      <div class="col-md-12">
                                        <label for="">Baseline Unit:</label>
                                            <input type="text" id="txtunit" name="txtunit"  value="<?php echo $txtunit; ?>"   minlength="  " maxlength="  "     placeholder="Enter Unit"    required  class="form-control form-control-enhanced"    >
                                        </div>
                                      
                                       </div>
                            </div>
                            <div class="col">
                                      <div class="form-group row">
                                      <div class="col-md-12">
                                                <label for="">Baseline Quantity/Amount:</label>
                                                    <input type=="number" step="0.01" name="txtquantity" id="txtquantity" value="<?php echo $txtquantity; ?>"  minlength="  " maxlength="  "     placeholder="Enter Quantity/Amount"    required  class="form-control form-control-enhanced" >
                                                </div>
                                      
                                      </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                                          <div class="form-group row">

                                                
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
        <!-- <div class=" row">
        <div class=" row">

        <input type="cancel" value="Cancel" name="cancel" id="cancel"  class="btn bg-success m-auto text-white btn-sm"/>
        </div>
        </div> -->

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
         
     
     
	 
<form name="reports" id="reports"  method="post"    style="display:inline-block"> 
	<?php /*?><input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
	<input type="text" name="valueipcno"  id="valueipcno" title="IPC NO" placeholder="IPC NO" style="width:100px"  onkeyup="showResult(module.value,this.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
	<select name="txtipcmonth" id="txtipcmonth" onchange="showResult(module.value,valueipcno.value,this.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)">
	<option value="">Select IPC Month</option>
			  <?php 
			  
			 $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
			$resg=$objDb1->dbQuery($sqlg);
			
			while($row3g=$objDb1->dbFetchArray())
			{
			echo $getmonth=$row3g['getmonths'];
			if($getmonth==$pmonth)
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
<input type="text" name="valueipcstartdate"  id="valueipcstartdate" title="Start Date" placeholder="Start Date" style="width:100px"  onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,this.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
<input type="text" name="valueipcenddate"  id="valueipcenddate"  title="End Date" placeholder="End Date" style="width:100px"    onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,this.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
<input type="text" name="valueipcsubmitdate"  id="valueipcsubmitdate" title="Submit Date" placeholder="Submit Date" style="width:100px"  onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,this.value, valueipcreceivedate.value)"/>
<input type="text" name="valueipcreceivedate"  id="valueipcreceivedate"  title="Receive Date" placeholder="Receive Date" style="width:100px"    onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportipcdata.php"/>
<div id="search"></div>
	<div id="without_search"><?php */?>
    
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
 $sSQL = "select * from baseline";
 $objDb2->dbQuery($sSQL);
 $iCount = $objDb2->totalRecords( );
 $j=0;
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

<td width="345px"><?=$txtname;?></td>
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