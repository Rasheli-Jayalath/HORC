<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= BOQDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$boq_flag			= $_SESSION['ne_boq'];
	$boqadm_flag		= $_SESSION['ne_boqadm'];
	$boqentry_flag		= $_SESSION['ne_boqentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$edit			= $_GET['edit'];
/*$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}
$objDb  		= new Database( );
@require_once("get_url.php");*/
$msg						= "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$aorder_list=$_POST["aorder"];
	$item_list=$_POST["itemid"];
	$size_l=sizeof($item_list);
	$size_a=sizeof($aorder_list);
	$msg="";
	if($size_l==$size_a)
	{
	for($i=0; $i<$size_a;$i++)
	{
		$sq="Update boqdata SET aorder='".$aorder_list[$i]."' WHERE itemid=".$item_list[$i];
		$objDb->dbQuery($sq);
	}
	$msg= "Order has been updated";
	}
	
}
$eSqls = "Select * from project_currency ";
  $objDb -> dbQuery($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->totalRecords();
	if($eeCount > 0){
		$res_e=$objDb->dbFetchArray();
	  $cur_1_rate 					= $res_e['cur_1_rate'];
	  $cur_2_rate 					= $res_e['cur_2_rate'];
	  $cur_3_rate 					= $res_e['cur_3_rate'];
	  $base_cur 				= $res_e['base_cur'];
	  $cur_1 					= $res_e['cur_1'];
	  $cur_2 					= $res_e['cur_2'];
	  $cur_3 					= $res_e['cur_3'];
	  
	  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add BOQ Entry</title>

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

<script>
function showResult(strmodule,strstage,stritemcode,stritemname,strisentry) {
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
  xmlhttp.open("GET","searchboq.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script>
<script>
function add_data(id) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }

var txtboqcode = document.getElementById('txtboqcode').value;
var txtboqitem = document.getElementById('txtboqitem').value;
var txtboqunit = document.getElementById('txtboqunit').value;
var txtboqqty =  document.getElementById('txtboqqty').value;

var url_string="adddataboq.php?itemid="+id+"&boqcode="+txtboqcode+"&boqitem="+txtboqitem+"&boqunit="+txtboqunit+"&boqqty="+txtboqqty;
 <?php if($cur_1!="") {?>
var boq_cur_1_rate = document.getElementById('boq_cur_1_rate').value;
url_string +="&boq_cur_1_rate="+boq_cur_1_rate;
<?php }?>
 <?php if($cur_2!=""){?>
var boq_cur_2_rate = document.getElementById('boq_cur_2_rate').value;
url_string +="&boq_cur_2_rate="+boq_cur_2_rate;
<?php }?>
 <?php if($cur_3!=""){?>
var boq_cur_3_rate = document.getElementById('boq_cur_3_rate').value;
url_string +="&boq_cur_3_rate="+boq_cur_3_rate;
<?php }?>
xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	 document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
        
    }
  }

  xmlhttp1.open("GET",url_string,true);
  xmlhttp1.send();
}

</script>

<script>
function edit_data(id,itemid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
	
      document.getElementById("abc"+itemid).innerHTML=xmlhttp1.responseText;
	  document.getElementById("addnew"+itemid).style.display="none";
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	
    }
  }

  xmlhttp1.open("GET","editdataboq.php?boqid="+id+"&itemid="+itemid,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(boqid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtitemid = document.getElementById('itemid').value;
var txtboqcode = document.getElementById('txtboqcode').value;
var txtboqitem = document.getElementById('txtboqitem').value;
var txtboqunit = document.getElementById('txtboqunit').value;
var txtboqqty = document.getElementById('txtboqqty').value;

var url_string="updatedataboq.php?boqid="+boqid+"&itemid="+txtitemid+"&boqcode="+txtboqcode+"&boqitem="+txtboqitem+"&boqunit="+txtboqunit+"&boqqty="+txtboqqty;
<?php if($cur_1!="")
						  {?>
var boq_cur_1_rate = document.getElementById('boq_cur_1_rate').value;
url_string +="&boq_cur_1_rate="+boq_cur_1_rate;
<?php }?>
 <?php if($cur_2!="")
						  {?>
var boq_cur_2_rate = document.getElementById('boq_cur_2_rate').value;
url_string +="&boq_cur_2_rate="+boq_cur_2_rate;
<?php }?>
 <?php if($cur_3!="")
						  {?>
var boq_cur_3_rate = document.getElementById('boq_cur_3_rate').value;
url_string +="&boq_cur_3_rate="+boq_cur_3_rate;
<?php }?>

  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtitemid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp4.open("GET",url_string,true);
  xmlhttp4.send();
}

</script>
<script>
function remove_data(activityid,kpiid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+kpiid).innerHTML=xmlhttp4.responseText;
	 // document.getElementById("addnew"+milestoneid).style.display="block";
    }
  }

  xmlhttp4.open("GET","removedatakpi.php?activityid="+activityid+"&kpiid="+kpiid,true);
  xmlhttp4.send();
}

</script>
<script>
function cancel_data(id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp1.open("GET","canceldataboq.php?itemid="+id,true);
  xmlhttp1.send();
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

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
}
</script>
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
/*$(document).ready(function(){
	$(".msg_body").hide();
	alert("123");
	
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
	$(".msg_body").hide(); 
	$(this).next(".msg_body").slideToggle(600);
	});
	
});*/
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

				<form name="reports" id="reports"  method="post"   style="display:inline-block; width:100%;margin-top:10px;"> 
		<!--<div style="margin-bottom:12px; width:100%">
		<?php  if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
		<a class="button" href="javascript:void(null);" onclick="window.open('subboq.php', '<?php echo ADD_BOQ;?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" ><?php echo ADD_BOQ;?></a>
		<?php
		}
		?>
		
		</div>-->
		
<?php /*?><input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportboq.php"/><?php */?>
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%">
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <?php
	   if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
      <th align="center" width="50%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  else
	  {
	  ?>
	   <th align="center" width="70%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  ?>
	 <!-- <th align="center" width="5%"><strong>Stage</span></strong></th>-->
	  <th align="center" width="10%"><strong><?php echo CODE;?></strong></th>
	<!--  <th width="5%"><strong>Weight</strong></th>-->
	   <th align="center" width="5%"><strong><?php echo IS_ENTRY;?></strong></th>
            
      
	  <?php
	 if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
	   <th align="center" width="30%"><strong><?php echo ACTION;?>
     </strong></th>
	 <?php
	 }
	 ?>
	<!-- <th align="center" width="5%"><strong><?php echo LOG;?>-->
     </strong></th>
	 
     </tr>

<?php
	$sSQL = "SELECT * FROM boqdata where stage='BOQ' order by parentgroup, parentcd";
	$sqlresult = $objDb1->dbQuery($sSQL);
while ($data = $objDb1->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$aorder = $data['aorder'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from boqdata where itemid = ".$cdlist[0];
	$cdsqlresult12 = $objDb->dbQuery($cdsql2);
	$cddata1 = $objDb->dbFetchArray();
	$itemname = $cddata1['itemname'];
	
				

				
?>

		<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from boqdata where stage='BOQ' and itemid = ".$cdlist[$items-1];
		$cdsqlresult = $objDb2->dbQuery($cdsql);
		$cddata = $objDb2->dbFetchArray();
		$itemid = $cddata['itemid'];
		$parentcd = $cddata['parentcd'];
		$stage=$cddata['stage'];
		$activitylevel=$cddata['activitylevel'];
		if($cddata['isentry']==0)
				{
				$isentry1=NO;
				}
				else
				{
				$isentry1=YES;
				}

			?>
			<script>
function AddNewSizeProject<?php echo $itemid; ?>(){

    var count=0;
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:left; width:100px"/><input type="text" name="txtboqcode" id="txtboqcode"  size="25" style="text-align:left; width:100px"/>';
	var td3 = '<input type="text" name="txtboqitem" id="txtboqitem"  size="25" style="text-align:left; width:200px"/>';
	var td4 = '<input type="text" name="txtboqunit" id="txtboqunit"  size="25" style="text-align:left; width:100px"/>';
	var td6 = '<input type="text" name="txtboqqty"  id="txtboqqty"  size="25" style="text-align:left; width:100px"/>';
	<?php if($cur_1!="")
						  {?>
	var td8 = '<input type="text" name="boq_cur_1_rate" id="boq_cur_1_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php 
	}?>
	<?php if($cur_2!="")
						  {?>
	var td9 = '<input type="text" name="boq_cur_2_rate" id="boq_cur_2_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php }?>
	<?php if($cur_3!="")
						  {?>
	var td11 = '<input type="text" name="boq_cur_3_rate" id="boq_cur_3_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php }?>
	var td14 = '<input type="button" id="save" name="save" value="Save"  onClick=add_data(txtitemid.value); />'
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	if(count==1)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td14);
	}
	if(count==2)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td9,td14);
	}
	if(count==3)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td9,td11,td14);
	}
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
			<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>">
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
        <input type="hidden" id="itemid[]" name="itemid[]" value="<?php echo $itemid;?>" />
		<?php /*?><td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td><?php */?>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<?php /*?><td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td><?php */?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
         
		<?php 
		if($stage=='BOQ' && $activitylevel==0)
		{
		$editlink='boq.php';
		$redirect="subboq.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubBOQ";
		}
		else if($stage=='BOQ' && $activitylevel>0)
		{
		$editlink='subboq.php';
		$redirect="subboq.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubBOQ";
		}
		$deletelink='subboq.php';
		  ?>
		<?php
		if($boqentry_flag==1 || $boqadm_flag==1)
		{
		?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
	
		<?php if($cddata['isentry']==0)
		{	
		?>
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=450,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		 <?php
		 }?>
		 	<?php  if($stage=='BOQ' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=450,scrollbars=yes');" >Edit</a> 
		<?php
		if($boqadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this BOQ and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=450,scrollbars=yes');" >Edit</a>
		<?php
		if($boqadm_flag==1)
		{
		?>
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this BOQ and all of its child?')">Delete</a><?php } } ?>
		
		 	 </td>
			 <?php
			 }
			 ?>
		<!-- <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="logboq.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" ><?php echo LOG;?></a>
	
		 </td>-->
	
		</tr>
		<tr>
		<td colspan="8">
			 <?php
	if($cddata['isentry']==1)
		{	
		?> 
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
			var id=<?php echo $itemid; ?>;
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
			
			  xmlhttp3.open("GET","reloadboq.php?itemid="+id,true);
			  xmlhttp3.send();
			
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext"><?php echo ADD_DATA;?></span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 

	<?php /*?><table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                    <tr>
                       <th style="width:5%;"></th>
                        <th style="width:15%;"><?php echo "BOQ Code";?></th>
						<th style="width:25%;"><?php echo "BOQ Item";?></th>
						 <th style="width:15%;"><?php echo "BOQ Unit";?></th>
						<th style="width:25%;"><?php echo "BOQ Rate";?></th>
						 <th style="width:15%;"><?php echo "BOQ Quantity";?></th>
						<th style="width:25%;"><?php echo "BOQ Amount";?></th>
						 <th style="width:15%;"><?php echo "BOQ Currency";?></th>
						<th style="width:25%;"><?php echo "BOQ Current Rate";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Amount";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Currency";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Rate";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Current Rate";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
				
			<?php $sql_a="Select * from boq where itemid=$itemid";
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$boqid=$row3_a['boqid'];
			?>
			
			<tr >
			
			<td><?php echo $i; ?></td>
			<td><?=$row3_a['boqcode'];?></td>
			<td><?=$row3_a['boqitem'];?></td>
			<td><?=$row3_a['boqunit'];?></td>
			<td ><?=$row3_a['boqrate'];?></td>
			<td ><?=$row3_a['boqqty'];?></td>
			<td><?=$row3_a['boqamount'];?></td>
			<td><?=$row3_a['boqcurrency'];?></td>
			<td><?=$row3_a['boqcurrrate'];?></td>
			<td><?=$row3_a['boqfamount'];?></td>
			<td><?=$row3_a['boqfcurrency'];?></td>
			<td><?=$row3_a['boqfrate'];?></td>
			<td><?=$row3_a['boqfcurrate'];?></td>
			<td><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo $boqid;?>,<?php echo $itemid;?> )"  /></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			?>	
					
                </tbody>
            </table><?php */?>
			</div>	
			 <?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			 <div id="addnew<?php echo $itemid; ?>" style="float:right;">
			 <a onClick="AddNewSizeProject<?php echo $itemid; ?>();" href="javascript:void(null);"><?php echo ADD_NEW;?></a></div>
			 <?php
			 }
			 ?>
			
			  <input type="button" value="<?php echo CLOSE;?>" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			  <input type="button" value="<?php echo CANCEL;?>" name="cancel" id="cancel" onclick="cancel_data(<?php echo $itemid; ?>)" />
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

        <!-- partial:../../../partials/_footer.html -->
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


<!-- Page Load Function -->


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

        function insertipc_data(ipcvid,boqid,ipcqty) {

        //alert(ipcvid+boqid+ipcqty);

          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp1=new XMLHttpRequest();
          } else {  // code for IE6, IE5
            xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
          }

          xmlhttp1.onreadystatechange=function() {
            if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

                //document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
            }
          }
          xmlhttp1.open("GET","add_ipcv_data.php?ipcvid="+ipcvid+"&boqid="+boqid+"&ipcqty="+ipcqty);
          xmlhttp1.send();
          }

          function updateipc_data(ipcid,boqid,ipcqty) {


                //alert(boqid+ipcqty);

                  if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp1=new XMLHttpRequest();
                  } else {  // code for IE6, IE5
                    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
                  }

                  xmlhttp1.onreadystatechange=function() {
                    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

                        //document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
                    }
                  }
                  xmlhttp1.open("GET","update_ipcv_data.php?ipcid="+ipcid+"&boqid="+boqid+"&ipcqty="+ipcqty);
                  xmlhttp1.send();
                  }

      </script>



      <!-- Page Load Function -->

<!-- Page Load Function -->
 <?php /*?> <script>
      window.onload = function() {

        //var secondOptionText = document.getElementById('lastSelectedDropItemName').value;
          //alert(secondOptionText);
          reportgenPageLoad();
      };
  </script><?php */?>

</body>

</html>