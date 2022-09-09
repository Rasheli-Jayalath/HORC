<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= BOQDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb6  		= new Database();
$objDb7  		= new Database();
$objDb8  		= new Database();

$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$boq_flag			= $_SESSION['ne_boq'];
	$boqadm_flag		= $_SESSION['ne_boqadm'];
	$boqentry_flag		= $_SESSION['ne_boqentry'];
  $pcd = '';

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
	$size_l=is_countable($item_list);
	$size_a=is_countable($aorder_list);
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#level1').on('click', function(){
        var PCDLevel1 = $(this).val();
        if(PCDLevel1){
            $.ajax({
                type:'POST',
                url:'levelData.php',
                data:'level1='+PCDLevel1,
                success:function(html){
                    $('#level2').html(html);
                    $('#level3').html('<option value="">Select </option>'); 
                    $('#level4').html('<option value="">Select </option>'); 
                    $('#level5').html('<option value="">Select </option>'); 
                }
            }); 
        }else{
            $('#level2').html('<option value="">Select Level 1 first</option>'); 
        }
    });
    
    $('#level2').on('click', function(){
        var PCDLevel2 = $(this).val();
        if(PCDLevel2){
            $.ajax({
                type:'POST',
                url:'levelData.php',
                data:'level2='+PCDLevel2,
                success:function(html){
                    $('#level3').html(html);
                    $('#level4').html('<option value="">Select </option>'); 
                    $('#level5').html('<option value="">Select </option>'); 
                }
            }); 
        }else{
            $('#level3').html('<option value="">Select Level 2 first</option>'); 
        }
    });
    $('#level3').on('click', function(){
        var PCDLevel3 = $(this).val();
        if(PCDLevel3){
            $.ajax({
                type:'POST',
                url:'levelData.php',
                data:'level3='+PCDLevel3,
                success:function(html){
                    $('#level4').html(html);
                    $('#level5').html('<option value="">Select </option>'); 
                }
            }); 
        }else{
            $('#level4').html('<option value="">Select Level 3 first</option>'); 
        }
    });
    $('#level4').on('click', function(){
        var PCDLevel4 = $(this).val();
        if(PCDLevel4){
            $.ajax({
                type:'POST',
                url:'levelData.php',
                data:'level4='+PCDLevel4,
                success:function(html){
                    $('#level5').html(html);
                }
            }); 
        }else{
            $('#level5').html('<option value="">Select Level 4 first</option>'); 
        }
    });
});
</script>
<div id="main-filter">
<form action="" method="post" style="margin-top: 20px;" class="pb-2">


<?php 

    // Fetch state data based on the specific level 
    $query = "SELECT * FROM boqdata WHERE parentcd = 1 AND activitylevel = 1 "; 
    $result = $objDb7->dbQuery($query);
?>

    <!-- level1 dropdown -->
    <div class="row">
    <div class="col-11 row  ">
        <div class="col-3 ">
          <span class="text-muted mx-2 "> Level 1</span>
          <select id="level1" name="level1" class="mt-2"style=" width: 100%; height: 35px; font-size: 14px;">
                  <option value="">Select </option>
                  <?php 
            if( $objDb7->totalRecords()>0){ 
              while($row = $objDb7->dbFetchArray()){  
                $selected=" ";
                if(isset($_POST['submit']) && ($_POST['level1']==$row['itemid'])  ){
                  $selected="selected";
                }
                echo '<option value="'.$row['itemid'].'" '.$selected.'>'.$row['itemname'].'</option>'; 
                  } 
              }else{ 
                  echo '<option value=""> not available</option>'; 
              } 
              ?>
      </select>
        </div>
        <div class="col-3 ">
          <span class="text-muted mx-2 "> Level 2</span>
              <!-- level2 dropdown -->
            <select id="level2" name="level2" class="mt-2"style=" width: 100%; height: 35px; font-size: 14px;">
              <?php
                    if(isset($_POST['submit']) && $_POST['level1']>0 ){
                            // Fetch state data based on the specific level 
                    $query = "SELECT * FROM boqdata WHERE parentcd = ".$_POST['level1']." AND activitylevel = 2 "; 
                    $result = $objDb6->dbQuery($query);
                    // Generate  list 
                        if( $objDb6->totalRecords()>0){ 
                        echo '<option value="">Select </option>'; 
                          while($row = $objDb6->dbFetchArray()){  
                            $selected=" ";
                            if($_POST['level2']==$row['itemid']  ){
                              $selected="selected";
                            }
                              echo '<option value="'.$row['itemid'].'" '.$selected.'>'.$row['itemname'].'</option>'; 
                          }
                      }else{ 
                        echo '<option value=""> not available</option>'; 
                      } 
                    }else{
              ?>
                <option value="">Select </option>
                <?php }?>
            </select>
        </div>
        <div class="col-3 ">
          <span class="text-muted mx-2 "> Level 3</span>
             <!-- level3 dropdown -->
            <select id="level3" name="level3" class="mt-2"style=" width: 100%; height: 35px; font-size: 14px;">
            <?php
                    if(isset($_POST['submit']) && $_POST['level2']>0 ){
            // Fetch  data based on the specific level 
            $query = "SELECT * FROM boqdata WHERE parentcd = ".$_POST['level2']." AND activitylevel = 3 "; 
            $result = $objDb6->dbQuery($query);
            
            // Generate list
                  if( $objDb6->totalRecords()>0){ 
                      echo '<option value="">Select </option>'; 
                      while($row = $objDb6->dbFetchArray()){  
                        $selected=" ";
                        if($_POST['level3']==$row['itemid']  ){
                          $selected="selected";
                        }
                          echo '<option value="'.$row['itemid'].'"'.$selected.'>'.$row['itemname'].'</option>'; 
                      } 
                  }else{ 
                      echo '<option value=""> not available</option>'; 
                  } 
                          
                }else{
                      ?>
                <option value="">Select </option>
                <?php }?>
            </select>
        </div>
        <div class="col-3 ">
          <span class="text-muted mx-2 "> Level 4</span>
              <!-- level4 dropdown -->
              <select id="level4" name="level4" class="mt-2"style=" width: 100%; height: 35px; font-size: 14px;">
              <?php
                      if(isset($_POST['submit']) && $_POST['level3']>0 ){
                        
                      // Fetch  data based on the specific level 
                      $query = "SELECT * FROM boqdata WHERE parentcd = ".$_POST['level3']." AND activitylevel = 4 "; 
                      $result = $objDb6->dbQuery($query);
                      
                      // Generate list
                      if( $objDb6->totalRecords()>0){ 
                          echo '<option value="">Select </option>'; 
                          while($row = $objDb6->dbFetchArray()){  
                            $selected=" ";
                            if($_POST['level4']==$row['itemid']  ){
                              $selected="selected";
                            }
                              echo '<option value="'.$row['itemid'].'"'.$selected.'>'.$row['itemname'].'</option>'; 
                          } 
                      }else{ 
                          echo '<option value=""> not available</option>'; 
                      } 
                      }else{
                        ?>
                  <option value="">Select </option>
                  <?php }?>
              </select>
        </div>
                      </div>
                      <div class="col-1">         
        <div class="col-1">
      
        <input type="submit" name="submit" class="btn btn-info bg-primary text-white px-3 mx-1 mt-4" value="Submit"/>
        </div>
                      </div>
    </div>
    <br>

    <!-- level5 dropdown -->
    <!-- <select id="level5" name="level5">
        <option value="">Select level5</option>
    </select> -->
	
   
</form>


</div>
<div id="without_search" class="pt-0">
<?php 
if(isset($_POST['submit'])){ 
   if($_POST['level4'] >0){
    $pcd .= $_POST['level4'];
   }else if ($_POST['level3']>0){
    $pcd .= $_POST['level3'];
   }else if($_POST['level2']>0){
    $pcd .= $_POST['level2'];
   }else if($_POST['level1']>0){
    $pcd .= $_POST['level1'];
   }
} 
?>
<!--  -->



<?php
	$per_page = 50;
	//Calculating no of pages
  $sql = "";

 
	

  if(isset($_POST['submit']) && $_POST['level1']>0 ){
    $sqlCheck = "SELECT parentgroup, parentcd, activitylevel FROM boqdata where itemid= $pcd";	
    $objDb8->dbQuery($sqlCheck);
    $row = $objDb8->dbFetchArray();
    $pGroup = $row['parentgroup'];
	  $oneParentcd = $row['parentcd'];
    $activitylevel = $row['activitylevel'];

        if($activitylevel==4){
          $aLevel1 =  substr($pGroup,0,13);
          $aLevel2 =  substr($pGroup,0,20);
          $sql .=  "SELECT * FROM boqdata WHERE parentgroup = '$aLevel1' OR parentgroup = '$aLevel2' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' AND stage='BOQ' order by parentgroup, parentcd ";
        
        }else if($activitylevel==3){
          $aLevel1 =  substr($pGroup,0,13);
          $sql .=  "SELECT * FROM boqdata WHERE parentgroup = '$aLevel1' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' AND stage='BOQ' order by parentgroup, parentcd ";
        
        }else{
          $sql .= "SELECT * FROM boqdata WHERE itemid = $oneParentcd  OR  parentgroup LIKE '$pGroup%'  AND stage='BOQ' order by parentgroup, parentcd  ";
        }

    }else{
      $sql .= "SELECT * FROM boqdata ";
    }
	$result = $objDb1->dbQuery($sql);
	$count =  $objDb1->totalRecords();
	$pages = ceil($count/$per_page)
	?>		
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>

<script type="text/javascript"> var pcd = "<?php if(isset($_POST['submit'])){echo $pcd; } ?>"; 
var totalPages = "<?php if($pages>0){echo $pages; }else{echo 0 ;} ?>"; 
</script>
<script type="text/javascript" src="jquery_pagination.js"></script>

	<?php 
if(isset($_POST['submit']) && $_POST['level1']>0){ 

?>
     <h6 class="text-primary"> <span>&nbsp;&nbsp;<br> &nbsp; Total Records for this filtered result  : 	<?php echo $count; ?></span> </h6>
<?php 

}else{
  echo "<hr>";
  ?>
     <span class="text-muted p-0 m-0" style="margin-top: -25px;"> Total Records   : 	<?php echo $count; ?></span> 

  <?php
}
?>
	<div id="content" style=" border: none;"></div>
	<div id="pagination">
		<ul class="pagination " style="text-align: right;">
		<?php
		//Pagination Numbers
		for($i=1; $i<=$pages; $i++)
		{
			echo '<li style=" border: 1px solid #CCC; border-style: ridge; margin: 10px; padding: 5px;" id="'.$i.'">'.$i.'</li>';
		}
		?> 
		</ul> 
  
	</div>		
<!--  -->


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