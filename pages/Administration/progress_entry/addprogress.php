<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "Add Progress";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$spg_flag			= $_SESSION['ne_spg'];
	$spgadm_flag		= $_SESSION['ne_spgadm'];
	$spgentry_flag		= $_SESSION['ne_spgentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$edit			= $_GET['edit'];

//@require_once("get_url.php");
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$itemid						= $_REQUEST['txtitemid'];

$txtcode					= $_REQUEST['txtcode'];
$txtscheduleid				= $_REQUEST['txtscheduleid'];
$txtstartdate				= $_REQUEST['txtstartdate'];
$txtenddate					= $_REQUEST['txtenddate'];
$txtastartdate				= $_REQUEST['txtastartdate'];
$txtaenddate				= $_REQUEST['txtaenddate'];
$txtorder					= $_REQUEST['txtorder'];
$txtbaseline				= $_REQUEST['txtbaseline'];
$txtremarks				   = $_REQUEST['txtremarks'];
$temp_id=1;

if($clear!="")
{

$txtcode 					= '';
$txtscheduleid 				= '';
$txtstartdate				= '';
$txtenddate 				= '';
$txtastartdate 				= '';
$txtaenddate				= '';
$txtorder 					= '';
$txtbaseline 				= '';
$txtremarks					= '';

}




if($edit != ""){
 $eSql = "Select * from activity where aid=$edit";
  $objDb -> dbQuery($eSql);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$eRes = $objDb->dbFetchArray();
	  $code 					= $eRes['code'];
	  $secheduleid	 			= $eRes['secheduleid'];
	  $startdate				= $eRes['startdate'];
	  $enddate 					= $eRes['enddate'];
	  $actualstartdate 			= $eRes['actualstartdate'];
	  $actualenddate	 		= $eRes['actualenddate'];
	  $aorder					= $eRes['aorder'];
	  $baseline 				= $eRes['baseline'];
	  $remarks 					= $eRes['remarks'];
	 	
	}
}

if(isset($temp_id)&&$temp_id!="")
{
$btem="SELECT * FROM baseline_template WHERE temp_id=$temp_id";
			 $objDb2 -> dbQuery($btem);
			  $row3tmpg=$objDb2->dbFetchArray();
			  $temp_title=$row3tmpg["temp_title"];
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
  <link rel="stylesheet" type="text/css" href="../../../css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

       <script type="text/javascript" src="../../../js/JsCommon.js"></script>

  <style>
        .margintopCSS {
          margin-top:10px;
        }
    </style>

<style>
.button
{
	background: #0099ff none repeat scroll 0 0;
    color: black;
    padding: 6px;
    text-decoration: none;


}
</style>
<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 


<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}
</style>
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

  xmlhttp.open("GET","searchprogress.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script>
<script>
function savep_data(pid,rid,itemid,temp_id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtprogress = document.getElementById('txtprogress').value;
var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	     	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }
  xmlhttp1.open("GET","addpdata.php?pid="+pid+"&itemid="+itemid+"&rid="+rid+"&progress="+txtprogress+"&progressdate="+txtprogressdate+"&temp_id="+temp_id,true);
  xmlhttp1.send();
}

</script>

<script>
function updatep_data(pgid,pid,rid,itemid,temp_id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtprogress = document.getElementById('txtprogress').value;
var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
		
      	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }
xmlhttp1.open("GET","updatepdata.php?pgid="+pgid+"&pid="+pid+"&itemid="+itemid+"&rid="+rid+"&progress="+txtprogress+"&progressdate="+txtprogressdate+"&temp_id="+temp_id,true);
  xmlhttp1.send();
}

</script>

<script>
function editp_data(pgid,pid,rid,itemid,temp_id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");  }

var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

      	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;

    }
  }

  xmlhttp1.open("GET","editpdata.php?pgid="+pgid+"&pid="+pid+"&itemid="+itemid+"&rid="+rid+"&progressdate="+txtprogressdate+"&temp_id="+temp_id,true);
  xmlhttp1.send();
}

</script>
<script>
function editp_data1(aid,pid,rid,itemid,temp_id) {
	
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");  }

var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

      	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }

  xmlhttp1.open("GET","editpdata1.php?aid="+aid+"&pid="+pid+"&itemid="+itemid+"&rid="+rid+"&progressdate="+txtprogressdate+"&temp_id="+temp_id,true);
  xmlhttp1.send();
}

</script>
<script>
function cancelp_data(id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
	
    }
  }

  xmlhttp1.open("GET","cancelpdata.php?itemid="+id,true);
  xmlhttp1.send();
}

</script>
<script>

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
}
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

function target_popup() {
   var myForm = document.getElementById('stgt_goal').value;

}

function add_sd(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_ed(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_asd(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_aed(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

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

        <div class="col-md-12" style="margin-bottom:10px;">
   


      </div>

          <div class="col-md-12 stretch-card" style="padding-left:0px;">

              <!-- Table All Data DIV-->
              <div class="col-md-12" id="table_all_data">
             <!-- <h1> <?php //echo $module; ?> Entry Control Panel</h1>-->
<form name="reports" id="reports"  method="post"   style="display:inline-block; width:100%;" enctype="multipart/form-data"> 
		<div style="margin-bottom:12px; width:100%">
		<!--<input type="submit" value="Add IPC Data" formaction="ipcdata.php"/>-->
		
        
        <?php  if($spgentry_flag==1 || $spgadm_flag==1)
		{
		?>
		<a href="progress.php?temp_id=<?php echo $temp_id;?>"  class=" btn btn-warning  btn-md">Add Progress Month</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class=" btn btn-warning  btn-md" >Add Progress Month</a>
		<?php
		}
		?>
		</div>
<?php /*?>		
<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportipc.php"/><?php */?>
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%">
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <th align="center" width="50%"><strong>Item Name</strong></th>
	  <th align="center" width="15%"><span class="label">Stage</span></th>
	  <th align="center" width="15%"><span class="label">Item Code</span></th>
	  <th width="10%"><strong>Weight</strong></th>
	   <th align="center" width="10%"><span class="label">Isentry</span></th>
<!--      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reportsp"  onclick="group_checkbox();"/></strong></th>
-->		 
     </tr>
<?php
		$sSQL = "SELECT * FROM maindata where  isentry=0 order by parentgroup, parentcd";
		$sqlresult = $objDb2->dbQuery($sSQL);
while ($data = $objDb2->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from maindata where itemid = ".$cdlist[0];
	$cdsqlresult12 = $objDb1->dbQuery($cdsql2);
	$cddata1 = $objDb1->dbFetchArray();
	$itemname = $cddata1['itemname'];
	
				

				
?>
<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		 $cdsql = "select * from maindata where itemid = ".$cdlist[$items-1];
		$cdsqlresult = $objDb->dbQuery($cdsql);
		$cddata = $objDb->dbFetchArray();
		$itemid = $cddata['itemid'];
		$parentcd = $cddata['parentcd'];
		$stage=$cddata['stage'];
		$activitylevel=$cddata['activitylevel'];
		if($cddata['isentry']==0)
				{
				$isentry1="No";
				}
				else
				{
				$isentry1="Yes";
				}

			?>
<script>


function AddNewSizeProject<?php echo $itemid; ?>(){
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:right; width:100px"/><input type="text" name="txtcode" id="txtcode"  size="25" style="text-align:right; width:100px"/>';
	var td4 = '<input type="text" name="txtstartdate" id="txtstartdate" onClick=add_sd("txtstartdate");  size="25" style="text-align:right; width:100px" />';
                                   
	var td5 = '<input type="text" name="txtenddate" id="txtenddate" onClick=add_ed("txtenddate"); size="25" style="text-align:right; width:100px"/>';
	var td6 = '<input type="text" name="txtastartdate" id="txtastartdate" onClick=add_asd("txtastartdate"); size="25" style="text-align:right; width:100px"/>';
	var td7 = '<input type="text" name="txtaenddate"  id="txtaenddate"  onClick=add_aed("txtaenddate"); size="25" style="text-align:right; width:100px"/>';
	var td8 = '<input type="text" name="txtorder"  id="txtorder"  size="25" style="text-align:right; width:100px"/>';
	var td9 = '<input type="text" name="txtbaseline" id="txtbaseline"  size="25" style="text-align:right; width:100px"/>';
	var td10 = '<input type="text" name="txtweight" id="txtweight"  size="25" style="text-align:right; width:100px"/>';
	var td11 = '<input type="text" name="txtremarks" id="txtremarks"  size="25" style="text-align:right; width:100px"/>';
	var td12 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
	var td3 = '<select name="txtscheduleid" id="txtscheduleid" style="width:70px">' + "\n";

	
	<?php 
	 $sqlg="Select * from baseline where temp_id=$temp_id";
			$resg=$objDb1->dbQuery($sqlg);
			while($row3g=$objDb1->dbFetchArray())
			{
			?>
	td3 	+= "\t" + '<option value="<?php echo $row3g['rid'];?>"><?php echo $row3g['base_desc'];?></option>' + "\n";
	<?php }?>
	
	td3 	+= '</select>' + "\n";
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	var arrTds = new Array(td1, td2, td3,td4, td5, td6,td7, td8, td9,td10,td11,td12);
	doAddTr(arrTds, 'tblPrdSizesProject<?php echo $itemid; ?>');
}
</script>			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td rowspan="2"></td>
			<td style=" font-size:12px; color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parentcd==0){	
			echo "<b>".$itemname."</b>";
			}
			else
			{
			echo $h.$cddata['itemname'];
		
			}
		  
		  
		   ?>
		</td>
		<td style=" font-size:12px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td>
		<td style=" font-size:12px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<td style=" font-size:12px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td>
		<td style=" font-size:12px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
<!--		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reportsp" onclick="group_checkbox();">		</td>
-->		
		</tr>
<tr>
		<td colspan="8">
			 <?php
		$cdsql_a = "select * from maindata where parentcd = '$cddata[itemid]' and isentry=1 ";
		$cdsqlresult_a = $objDb->dbQuery($cdsql_a);
		if($objDb->totalRecords()>0)
			 
	/*if($cddata['isentry']==1)*/
		{	
		?> 
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
		
			var id=<?php echo $itemid; ?>;
			var temp_id=<?php echo $temp_id; ?>;
			
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp3=new XMLHttpRequest();
			  } else {  // code for IE6, IE5
				xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			
			  xmlhttp3.onreadystatechange=function() {
				if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
				
					
					document.getElementById("abc"+id).innerHTML=xmlhttp3.responseText;
					document.getElementById("addnew"+id).style.display="block";
					
				 // document.getElementById("search").style.border="1px solid #A5ACB2";
				  
				
				 
				}
			  }
			
			  xmlhttp3.open("GET","reloadprogress.php?itemid="+id+"&temp_id="+temp_id,true);
			  xmlhttp3.send();
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 
			</div>	
			 		
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php  if($spgentry_flag==1 || $spgadm_flag==1)
				{
				?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancelp_data(<?php echo $itemid; ?>)" />
			  <?php
			  }
			  ?>

	</div>
		  </div>
		  <?php
		  }
		  ?>
		</td></tr>
		
		
		
	
	<?php        
			}
		
	?>

	</table>
</div>
</form>
</div>
              <!-- Table All Data DIV-->

         </div>

        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
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


</body>

</html>