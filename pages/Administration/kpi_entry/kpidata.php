<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= KPIDATA;
$objDb5  		= new Database();
$objDb6  		= new Database();
$objAdminUser1   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$kpi_flag			= $_SESSION['ne_kpi'];
$kpiadm_flag		= $_SESSION['ne_kpiadm'];
$kpientry_flag		= $_SESSION['ne_kpientry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$edit			= $_GET['edit'];

//@require_once("get_url.php");
$msg						= "";

$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$kpiid						= $_REQUEST['txtitemid'];
$act_s						= $_REQUEST['act'];
//$length=count($act_s);

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
		$sq="Update kpidata SET aorder='".$aorder_list[$i]."' WHERE itemid=".$item_list[$i];
		$objDb->dbQuery($sq);
	}
	$msg= "Order has been updated";
	}
	
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add KPI Entry</title>

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
function addactivities(itemid,temp_id, temp_is_default) {

 var str="",i;
 var activity="";

for (i=0;i<document.getElementById('act'+itemid).options.length;i++) {
    if (document.getElementById('act'+itemid).options[i].selected) {
        str += document.getElementById('act'+itemid).options[i].value + "_";
    }
}
if (str.charAt(str.length - 1) == '_') {
  str = str.substr(0, str.length - 1);
}

var activity=str;

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

    }
  }

  xmlhttp1.open("GET","addactivitieskpi.php?act="+activity+"&itemid="+itemid+"&temp_id="+temp_id+"&temp_is_default="+temp_is_default,true);
  xmlhttp1.send();
}

</script>
<script>
function edit_data(id,kpiid,temp_id,temp_is_default) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
	
      document.getElementById("abc"+kpiid).innerHTML=xmlhttp1.responseText;
	   document.getElementById("addnew"+kpiid).style.display="none";
     // document.getElementById("search").style.border="1px solid #A5ACB2";

    }
  }

  xmlhttp1.open("GET","editdatakpi.php?aid="+id+"&kpiid="+kpiid+"&temp_id="+temp_id+"&temp_is_default="+temp_is_default,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(kaid,aid, rid, temp_id,temp_is_default) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtkpiid = document.getElementById('kpiid').value;
var kaweight = document.getElementById('kaweight').value;


  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtkpiid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtkpiid).style.display="block";
    }
  }
if(temp_is_default==1)
{
  xmlhttp4.open("GET","updatedatakpi.php?kaid="+kaid+"&kpiid="+txtkpiid+"&kaweight="+kaweight+"&aid="+aid+"&rid="+rid+'&temp_id='+temp_id+"&temp_is_default="+temp_is_default,true);
}
else
{
	var baseline = document.getElementById('used_quantity').value;
	xmlhttp4.open("GET","updatedatakpi.php?kaid="+kaid+"&kpiid="+txtkpiid+"&kaweight="+kaweight+"&aid="+aid+"&rid="+rid+'&temp_id='+temp_id+'&baseline='+baseline+"&temp_is_default="+temp_is_default,true);
}
  xmlhttp4.send();
}

</script>
<script>
function remove_data(activityid,kpiid, temp_id, temp_is_default) {
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

  xmlhttp4.open("GET","removedatakpi.php?activityid="+activityid+"&kpiid="+kpiid+'&temp_id='+temp_id+"&temp_is_default="+temp_is_default,true);
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

  xmlhttp1.open("GET","canceldatakpi.php?itemid="+id,true);
  xmlhttp1.send();
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

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
}
</script>
<script>
	function getQuantity(rid)
   {
	if(rid!=0)
	{
	 document.getElementById("used_quantity").value="";
		
			if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp2=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("h_remaining_quantity").value=xmlhttp1.responseText;
		document.getElementById("remaining_quantity").value=xmlhttp1.responseText;

    }
  }

  xmlhttp1.open("GET","getremainingqty.php?rid="+rid,true);
  xmlhttp1.send();
  xmlhttp2.onreadystatechange=function() {
    if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
	
		
      	document.getElementById("total_quantity").value=xmlhttp2.responseText;
		

    }
  }

  xmlhttp2.open("GET","gettotalqty.php?rid="+rid,true);
  xmlhttp2.send();
			
			
   	}
	else
	{
			document.getElementById("total_quantity").value="";	
			document.getElementById("h_remaining_quantity").value="";
			document.getElementById("remaining_quantity").value="";
			document.getElementById("used_quantity").value="";
			
			
			
	}
	
	}
	
	
	
	function showResult(remaining_quantity,used_quantity,hidden_value,u_r_quantity,itemid) {
		
		//alert(remaining_quantity);
		//alert(used_quantity);
		//alert(hidden_value);
		//alert(u_r_quantity);
	
	
	if(isNaN(used_quantity))
	{
	alert(used_quantity+" Is not a Number");
	document.getElementById("used_quantity").value="";
	document.getElementById("remaining_quantity").value=hidden_value;
	}
	else
	{
	t_q="";

if(u_r_quantity==0)
{
remaining_quantity=hidden_value-0;

}
else
{
remaining_quantity=u_r_quantity-0;

}

document.getElementById("remaining_quantity").value=remaining_quantity-used_quantity;

 } 
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
		<?php
			/*if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
		<a href="ipcdata.php" class=" btn btn-warning  btn-md">Add IPC Data</a>
		<?php
		}*/
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

<!--  only-->
<script type="text/javascript"> 
var totalPages = "<?php if($pages>0){echo $pages; }else{echo 0 ;} ?>"; 
</script>
<script type="text/javascript" src="jquery_pagination.js"></script>
<!--  -->

<?php
$per_page = 50;
//Calculating no of pages

$btem="Select * from kpi_templates where 	is_active=1";
			  $resbtemp=$objDb5->dbQuery($btem);
			   $rowsnum=$objDb5->totalRecords();
			   $row3tmpg=$objDb5->dbFetchArray();
			  $temp_id=$row3tmpg["temp_id"];
if(isset($row3tmpg["kpi_temp_id"])&&$row3tmpg["kpi_temp_id"]!=""&&$row3tmpg["kpi_temp_id"]!=0)
{
$sql = "SELECT * FROM kpidata where 	kpi_temp_id=".$row3tmpg["kpi_temp_id"]." order by aorder";
$objDb6->dbQuery($sql);
$count = $objDb6->totalRecords();


$pages = ceil($count/$per_page);
?>			

<div id="content" style="border: none; "></div>
<div id="pagination">
	<ul class="pagination pt-3">
	<?php
	//Pagination Numbers
	for($i=1; $i<=$pages; $i++)
	{
		echo '<li id="'.$i.'">'.$i.'</li>';
	}
	?>
	</ul>
</div>	

<?php        
			}

else
{?>

<tr><tr><td colspan="12"> <?php echo $msg="Please Add KPI Template"; ?> </td></tr>
<?php }
	?>

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


</body>

</html>