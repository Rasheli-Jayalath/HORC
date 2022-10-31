<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "Progress";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
$objDb4  		= new Database();
$objDb5  		= new Database();
$objDb6  		= new Database();
$objDb7  		= new Database();

$objDb9  		= new Database();
$objDb10  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$spg_flag			= $_SESSION['ne_spg'];
	$spgadm_flag		= $_SESSION['ne_spgadm'];
	$spgentry_flag		= $_SESSION['ne_spgentry'];

if ($uname==null ) {
header("Location: ../../index.php?init=3");
}
else if($spgentry_flag==0 and $spgadm_flag==0 )
{
header("Location: ../../index.php?init=3");
}
$edit			= $_GET['edit'];

$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtmonth1					= $_REQUEST['txtmonth'];
$txtmonth=$txtmonth1."-01";

$pdate=date('Y-m-d',strtotime($txtmonth));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;         
 $txtmonth=$pdate;
 
$txtstatus					= $_REQUEST['txtstatus'];
$txtremarks					= $_REQUEST['txtremarks'];
$temp_id					= 1;
if($clear!="")
{

$txtstatus 					= '';
$txtremarks 				= '';

}

if($saveBtn != "")
{
	$eSql_l = "Select * from progressmonth where status=0 AND temp_id=$temp_id";
  	$res_q=$objDb->dbQuery($eSql_l);
	if($objDb->totalRecords()==1)
	{
	$msg="You can't add new progress month if a month has already Active status";
	}
	else
	{
$sSQL = ("INSERT INTO progressmonth (pmonth,status,remarks,temp_id) VALUES ('$txtmonth','$txtstatus','$txtremarks','$temp_id')");

	$objDb1->dbQuery($sSQL);
	$pmid = $con->lastInsertId();
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO progressmonth_log (log_module,log_title,log_ip,pmonth,  status,remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtmonth', '$txtstatus','$txtremarks',$pmid)");
	$objDb2->dbQuery($sSQL);
	}
		
 
}

if($updateBtn !=""){
$eSql_l = "Select * from progressmonth where status=0 and pmid!=$edit AND temp_id=$temp_id";
  	$res_q=$objDb->dbQuery($eSql_l);
	
	if($objDb->totalRecords()==1)
	{
		$msg="You can't update month's status to Active if a month has already Active status";
		
	}
	else
	{	
$uSql = "Update progressmonth SET 			
			 pmonth         		= '$txtmonth',
			 status   				= '$txtstatus',
			 remarks				= '$txtremarks'	,
			 temp_id				= '$temp_id'		
			where pmid 			= $edit  AND temp_id=$temp_id";
		  
 	if($objDb1->dbQuery($uSql)){
	
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
$sSQL2 = ("INSERT INTO progressmonth_log (log_module,log_title,log_ip,pmonth,  status,remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtmonth', '$txtstatus','$txtremarks',$edit)");
		$objDb2->dbQuery($sSQL2);

		
	}
	$txtstatus 					= '';
	$txtremarks 				= '';
	header("Location: progress.php?temp_id=".$temp_id);
	}
	
		
}

if($edit != ""){
 $eSql = "Select left(pmonth,7) as pmonth,status,remarks from progressmonth where pmid='$edit' AND temp_id=$temp_id";
   $objDb -> dbQuery($eSql);
  $eCount =  $objDb->totalRecords();
	if($eCount > 0){
		$eRes = $objDb->dbFetchArray();
	  $pmonth 						= $eRes['pmonth'];
	  $status	 					= $eRes['status'];
	  $remarks						= $eRes['remarks'];
	 }
}

?>
<?php

if (isset($_POST["submitVerify"])) {


  $sql_tr = "TRUNCATE progress_archive";
  $objDb7->dbQuery($sql_tr);

 $sql_i = "INSERT INTO progress_archive ( itemid,  progressdate, progressqty) SELECT  itemid, progressdate, progressqty FROM progress ";
 $objDb6->dbQuery($sql_i);

  $sql = "INSERT INTO progress ( itemid,  progressdate, progressqty) SELECT  itemid, progressdate, progressqty FROM progress_copy ";
	$objDb4->dbQuery($sql);

  $sql1 = "TRUNCATE  progress_copy";
	$objDb5->dbQuery($sql1);

}

if(isset($_GET['verifiedpmid'])){
  $verifiedpmid = $_GET['verifiedpmid'];
  $sql2 = "UPDATE progressmonth  SET status=1 WHERE pmid= $verifiedpmid";
  $objDb9->dbQuery($sql2);

}
if (isset($_POST["submitDelete"])) {
$sql1 = "DELETE  FROM progress_copy";
$objDb5->dbQuery($sql1);
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Progress Entry</title>

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
function showResult(strmodule,strmonth,strstatus,strremarks) {
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
  xmlhttp.open("GET","searchpm.php?module="+strmodule+"&month="+strmonth+"&status="+strstatus+"&remarks="+strremarks,true);
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

                <h2 style="text-align:center">
			<?php
			if(isset($_REQUEST['edit']))
			{
			$action="Update ";
			}
			else
			{
			$action="Add ";
			}
			?>
            <?php echo $action.$module; ?>
            <span style="text-align:right; float:right" ><a href="addprogress.php?temp_id=<?php echo $_REQUEST["temp_id"];?>p" class="btn btn-secondary px-2 py-1" > 
                  <i  class="mdi mdi-keyboard-backspace mb-5 text-bold" style="vertical-align: top;"></i>  Back</a></span>
               
                  </h2>
                <hr>
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="" enctype="multipart/form-data" style="margin-top:10px;">
	  
	  <font color="red"><strong><?php  if($err_msg!="")
		   {
		   ?>
		   <?php echo $err_msg; ?>
		   <?php
		   }
		   else
		   {?>
            <?php if($msg!="") echo $msg; else echo "";?>
			<?php
			}
			?></strong></font>
               
        <div class="container">

                        <div class="row">
                        

                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-12" >Month </label>
<select name="txtmonth" class="col-sm-5  form-select  form-control form-control-enhanced" style = "width: 70%;">
			  <?php $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
			$resg=$objDb1->dbQuery($sqlg);
			
			while($row3g=$objDb1->dbFetchArray())
			{
			$getmonth=$row3g['getmonths'];
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
			  </select>                                </div>
                              </div>
                            </div>

                            


                        </div>
                        <div class="row">

                            <div class="col">
                                      <div class="form-group row">

                                        <div class="col-md-12">
                                    <label >Staus</label>
                                    <input type="radio"  id="txtstatus" name="txtstatus" value="0" <?php if($status=="0"){ echo "checked='checked'";} else if($status==""){ echo "checked='checked'";} ?>/>Active
			  <input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($status=="1"){ echo "checked='checked'";} ?>/>Inactive
                                        <!-- <input type="text" name="ipc_month" id="ipc_month"    minlength="  " maxlength="  "     placeholder=""    required  class="form-control form-control-enhanced" > -->
                                    </div>
                                       </div>
                            </div>
                            

                        </div>

                        <div class="row">

                            <div class="col">
                                      <div class="form-group row">

                                        <div class="col-md-12">
                                        <label for="">Remarks</label>
                                           <input type="text"  name="txtremarks" id="txtremarks" value="<?php echo $remarks; ?>"   class="form-control form-control-enhanced"    >
                                        </div>
                                       </div>
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
	
    
	<table class="table table-striped" > 
    <tr class="bg-form" style="font-size:12px; color:#CCC;">
    
      <th align="center" width="3%"><strong>Sr. No.</strong></th>
      <th align="center" width="2%"><strong>
	  <input  type="checkbox"  name="txtChkAll" id=
          "txtChkAll"   form="reports"  onclick="group_checkbox();"/>
		  
		  </strong></th>
      <th align="center" width="25%"><strong>Month</strong></th>
      <th width="20%"><strong>Status</strong></th>
      <th width="25%"><strong>Remarks</strong></th>
      <th align="center" width="15%"><strong>Action
    </strong></th>
	<!--<th align="center" width="10%"><strong>Log
    </strong></th>-->
	<!--<th align="center" width="10%"><strong>Log
    </strong></th>-->
    </tr>
    
    <strong>
<?php
 $sSQL = " Select pmid,left(pmonth,7) as pmonths,status,remarks from progressmonth where temp_id=$temp_id";
 $objDb2->dbQuery($sSQL);
 $iCount = $objDb2->totalRecords( );
 if($iCount>0)
 {
	while( $res_e2=$objDb2->dbFetchArray())
	
	{
	  $pmid 							= $res_e2['pmid'];
	  $pmonth 							= $res_e2['pmonths'];
	  $status3 							= $res_e2['status'];
	  if($status3=="0")
	  {
	  $status="Active";
	  }
	  else  if($status3=="1")
	  {
	  $status="Inactive";
	  }
	  $remarks 							= $res_e2['remarks'];
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
</strong>
  <tr <?php echo $style; ?>>
<td width="5px"><center> <?php echo $i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?php echo $pmid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td width="210px"><?php echo $pmonth;?></td>
<td width="100px"><?php echo $status;?></td>
<td width="180px"  ><?php echo $remarks;?></td>

<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;

 <a href="progress.php?edit=<?php echo $pmid;?>&temp_id=<?php echo $_REQUEST["temp_id"];?>"  >
 <button type="button" style="text-align:center;" class="btn btn-outline-info btn-sm" >EDIT</button>
</a>

<?php
 $sSQL4 = "SELECT * FROM progress_copy where pgid= $pmid " ;
 $objDb10->dbQuery($sSQL4);
 $iCount = $objDb10->totalRecords( );
 if($iCount>0){ 
  ?>
    <button type="button" style="text-align:center; margin-left: 5px;" class=" btn-sm  btn btn-success" onclick="location.href='csvdata.php?msg=1&pmid=<?php echo $pmid;?>'">View</button>
<?php } else if($status3=="0"){

?>
<button type="button" style="text-align:center; margin-left: 5px;" class=" btn-sm  btn btn-warning" onclick="location.href='csvdata.php?edit=<?php echo $pmid;?>'">IMPORT</button>
<?php } ?>

</td>
<!-- <td width="210px" align="right" ><a href="log_pm.php?trans_id=<?php// echo $pmid ; ?>&module=<?php //echo $module?>" target="_blank">Log</a></td>
--></tr>  
    
    
    


<?php        
	}
	}
?>
</table>

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

