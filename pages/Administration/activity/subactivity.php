<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= MAINDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$mdata_flag			= $_SESSION['ne_mdata'];
	$mdataadm_flag		= $_SESSION['ne_mdataadm'];
	$mdataentry_flag	= $_SESSION['ne_mdataentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
/*error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= ACTIVITY;
if ($uname==null  ) {
header("Location: index.php?init=3");
}
$objDb  		= new Database( );
$objDb2  		= new Database( );
$defaultLang = 'en';

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

}*/
$edit			= $_GET['edit'];
$delete			= $_GET['del'];
if(isset($_GET['subaid']))
{
$subaid			= $_GET['subaid'];
}
else
{
$subaid			= $edit;
}
/*$sql_bt="Select * from baseline_template where temp_is_default=1";
			$res_bt=mysql_query($sql_bt);
			$row_bt=mysql_fetch_array($res_bt);
			$temp_id= $row_bt['temp_id'];
			$temp_tilte=$row_bt['temp_title'];
*/
$temp_id=1;
if($subaid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from maindata where  itemid=$subaid";
$resgx=$objDb->dbQuery($sqlgx);
$row3gx=$objDb->dbFetchArray();
$name_activity=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$pgroup=$row3gx['parentgroup'];
$ar_group=explode("_",$pgroup);
$sizze= count($ar_group);
for($i=0; $i<$sizze; $i++)
{
$sqlgx1="Select itemname, parentcd from maindata where itemid=$ar_group[$i]";
$resgx1=$objDb1->dbQuery($sqlgx1);
$row3gx1=$objDb1->dbFetchArray();
$itemname_1=$row3gx1['itemname'];
if ($i==0){ $title="Activity"; }
    else if ($i>1){ $title="Subactivity"; }
$trail.="<table><tr><td><b>".$title;

 $trail.=": </b></td><td>".$itemname_1; 
 $trail.="</td></tr></table>";

}

 }
if(isset($_GET['levelid']))
{

$levelid		= $_GET['levelid'];
}
else
{
$levelid		= 0;
}

//@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "Activity";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= $_REQUEST['txtitemname'];

$txtrid						= $_REQUEST['txtrid'];
$startdate					= $_REQUEST['txtstartdate'];
$enddate					= $_REQUEST['txtenddate'];
$txtremaining_quantity		= $_REQUEST['remaining_quantity'];
$txtused_quantity			= $_REQUEST['used_quantity'];
$txtactivity				= $subaid;
$activitylevel				= $levelid;
$txtisentry					= $_REQUEST['txtisentry'];
if($txtisentry==1)
{
	$res_s						= $_REQUEST['res'];
	$length=count($res_s);
	if($length>0)
	{
	$txtresources="";
		for($i=0; $i<$length; $i++)
		{
		if($i==0)
		{
		$txtresources=$res_s[$i];
		}
		else
		{
		$txtresources=$txtresources.",".$res_s[$i];
		}
		}
	}
	else
	{
	$txtresources="";
	}
}
else
{
$txtresources="";
}

if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtactivity				= '';
}

if($saveBtn != "")
{
if(!isset($_GET['levelid']))
{

 $txtparentcd =0;
   $sSQL = ("INSERT INTO maindata (parentcd,itemcode, itemname,  isentry,resources) VALUES ($txtparentcd,'$txtitemcode', '$txtitemname',$txtisentry,'$txtresources')");
	$objDb->dbQuery($sSQL);
	$txtid = $con->lastInsertId();
	$itemids = $txtid;
	
	$parentgroup=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
	
	
	$uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb->dbQuery($uSqlu);




}
else
{
$eSqls = "Select * from maindata where itemid='$txtactivity'";
  $objDb -> dbQuery($eSqls);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$res_ac=$objDb->dbFetchArray();
	  $parentgroup2 					= $res_ac['parentgroup'];
	   $txtparentcd 					= $res_ac['itemid'];
	  }
 $sSQL = ("INSERT INTO maindata (parentcd, activitylevel, itemcode, itemname,  isentry) VALUES ($txtparentcd,$activitylevel+1,'$txtitemcode', '$txtitemname',$txtisentry)");
	$objDb->dbQuery($sSQL);
	$txtid = $con->lastInsertId();
	$itemids = $txtid;
	
	$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
		
	$parentgroup=$parentgroup2."_".$parentgroup1;
		
	 $uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb1->dbQuery($uSqlu);
}	
if($txtisentry==1)
{	
	echo  $ssSQL = ("INSERT INTO activity (itemid, startdate, enddate, rid,baseline,temp_id) VALUES ($itemids, '$startdate', '$enddate',$txtrid,$txtused_quantity,$temp_id)");
	$objDb2->dbQuery($ssSQL);
	$txtid = $con->lastInsertId();
	$aid = $txtid;	
	$msg="Saved!";

	
	
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$activitylevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemids)");
	//$objDb->dbQuery($sSQL);
	
		
}
	
	
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  

}

if($updateBtn !=""){


		 $eSql_s = "Select * from maindata where itemid='$txtactivity'";
  	$objDb -> dbQuery($eSql_s);
  	$eCount2 = $objDb->totalRecords();
	if($eCount2 > 0){
		$res_e=$objDb->dbFetchArray();
	  $parentgroup_s	 				= $res_e['parentgroup'];
	  }
	   $itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
	
		$parentgroup=$parentgroup_s."_".$itmid;
	
	 $uSql = "Update maindata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 parentcd				= $txtactivity,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry'
			where itemid 			= $edit ";
		  
 	if($objDb->dbQuery($uSql)){
	
	$eSql_l = "Select * from maindata where itemid='$edit'";
  	$objDb1 -> dbQuery($eSql_l);
  	$eCount1 = $objDb1->totalRecords();
	if($eCount1 > 0){
		$res_t=$objDb1->dbFetchArray();
	  $parentcd 					= $res_t['parentcd'];
	  $parentgroup	 				= $res_t['parentgroup'];
	  }
	  $eSql_s = "Select * from activity where itemid=".$edit;
  	$ms_res=$objDb->dbQuery($eSql_s);
	$res_m=$objDb->dbFetchArray();
	$act_count=$objDb->totalRecords();
	if($eCount1 > 0&&$act_count==0)
	{
		 $ssSQL = ("INSERT INTO activity (itemid, startdate, enddate, rid,baseline,temp_id) VALUES ($edit, '$startdate', '$enddate',$txtrid,$txtused_quantity,$temp_id)");
	$objDb2->dbQuery($ssSQL);
	$txtid = $con->lastInsertId();
	$aid = $txtid;	
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$activitylevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemids)");
	$objDb->dbQuery($sSQL);
	
		
	}
	else
	{
	$aid=$res_m['aid'];
	$rid=$res_m['rid'];
	 $uSql_act = "Update activity SET 			
			 startdate         	= '$startdate',
			 enddate  			= '$enddate',
			 rid				= $txtrid,
			 baseline      		= $txtused_quantity
			where itemid 		= $edit ";
		$objDb->dbQuery($uSql_act);  
	
	  $msg="Updated!";
		
	
	$sSQL2 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', $txtisentry, '$txtresources',$edit)");
	//	$objDb1->dbQuery($sSQL2);
	
	
	 
	
	
		
		$txtparentcd				= '';
		$txtparentgroup				= '';
		$txtstage					= '';
		$txtitemcode 				= '';
		$txtitemname 				= '';
		$txtweight					= '';
		$txtactivities				= '';
		$txtisentry					= '';
		$txtresources 				= '';
	}
	}
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($delete != ""){
$eSql = "Select * from maindata where itemid=$delete";
$q_ry=$objDb->dbQuery($eSql);
$res_s=$objDb->dbFetchArray();
$p_group=$res_s['parentgroup'];
$aSql = "Select * from activity where itemid=$delete";
$a_ry=$objDb->dbQuery($aSql);
$res_a=$objDb->dbFetchArray();
$aid=$res_a['aid'];
$p_group=$res_s['parentgroup'];
$eSqlr = "Select * from maindata where parentgroup like '$p_group%'";
$q_ryr=$objDb2->dbQuery($eSqlr);
while($res_sr=$objDb2->dbFetchArray())
{
	$itemid			=$res_sr['itemid'];
	$parentcd		=$res_sr['parentcd'];
	$parentgroup	=$res_sr['parentgroup'];
	$activitylevel  =$res_sr['activitylevel'];
	$stage			=$res_sr['stage'];
	$itemcode		=$res_sr['itemcode'];
	$itemname		=$res_sr['itemname'];
	$isentry  		=$res_sr['isentry'];
	$txtactivities	="";
	$txtresources	="";
	
	
	 $msg="Deleted!";
	$log_module  = $module." Module";
	$log_title   = "Deleted".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	$sSQL7 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	//$objDb->dbQuery($sSQL7);
	
		
	$eSql_child = "delete from activity where itemid=$itemid";
   $objDb->dbQuery($eSql_child);
	$eSql_child1 = "delete from planned where itemid=$itemid";
   $objDb->dbQuery($eSql_child1);
	$eSql_child2 = "delete from progress where itemid=$itemid";
    $objDb->dbQuery($eSql_child2);
	
	$eSql_d = "delete from maindata where itemid=$itemid";
    $objDb->dbQuery($eSql_d);

}

header("Location: maindata.php");	
}

if($edit != ""){
	$eSql = "Select * from maindata where itemid=$edit";
    $objDb->dbQuery($eSql);
    $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$res_a=$objDb->dbFetchArray();
	 $parentcd 						= $res_a['parentcd'];
	  $parentgroup	 				= $res_a['parentgroup'];
	  $itemcode 					= $res_a['itemcode'];
	  $itemname 					= $res_a['itemname'];
	  $isentry 						= $res_a['isentry'];
	  $ar_list=explode("_",$parentgroup);
	  $st_g=$ar_list[0];
	  $ou_cm=$ar_list[1];
	  $ou_pt=$ar_list[2];
	  $ac_ty=$ar_list[3];
	 	
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
 function ShowDataDiv(did)
   {
   
	   if(did==1)
	   {
		document.getElementById("data_div").style.display="";
		document.getElementById("w_div").style.display="none";
		document.getElementById("remaining_quantity").value="";
	   }
		else
		{
		document.getElementById("data_div").style.display="none";
		document.getElementById("w_div").style.display="";
		}
	
	}
	
	</script>
   		<script>
	function getQuantity(rid)
   {
	 
if(rid!=0)
{
   <?php 
	$sqlg="Select * from baseline";
			$resg=$objDb1->dbQuery($sqlg);
			while($abc=$objDb1->dbFetchArray())
			{
			
			
			
			?>
			
			if(<?php echo $abc['rid']?>==rid)
			{
			
			<?php
			$sqlg3="Select sum(baseline) as used_qt from activity where rid=".$abc['rid'];
			$resg3=$objDb->dbQuery($sqlg3);
			
			$abc3=$objDb->dbFetchArray();
			$used_qty=$abc3['used_qt'];
			//$used_qty=0;
			$remaining_qtyy=$abc['quantity']-$used_qty;
			
			?>
			
			if(<?php echo $abc['unit_type'] ?>==1)
			{
			var utype="Quantity";
			}
			else if(<?php echo $abc['unit_type'] ?>==2)
			{
			var utype="Amount";
			}
			document.getElementById("total_quantity").value="<?php echo $abc['quantity'] ?>";	
			document.getElementById("quantity_unit").value="<?php echo $abc['unit'] ?>";	
			document.getElementById("quantity_unit_r").value="<?php echo $abc['unit'] ?>";	
			document.getElementById("quantity_unit_a").value="<?php echo $abc['unit'] ?>";		
			document.getElementById("h_remaining_quantity").value="<?php echo $remaining_qtyy ?>";
			document.getElementById("remaining_quantity").value="<?php echo $remaining_qtyy ?>";
			document.getElementById("used_quantity").value="";
			document.getElementById("to_qt").innerHTML=utype;
			document.getElementById("to_av_qt").innerHTML=utype;
			document.getElementById("to_al_qt").innerHTML=utype;
			
			}
			<?php
			}
			?>
   	}
	else
	{
			document.getElementById("total_quantity").value="";	
			document.getElementById("quantity_unit").value="";	
			document.getElementById("quantity_unit_r").value="";	
			document.getElementById("quantity_unit_a").value="";		
			document.getElementById("h_remaining_quantity").value="";
			document.getElementById("remaining_quantity").value="";
			document.getElementById("used_quantity").value="";
			document.getElementById("to_qt").innerHTML="";
			document.getElementById("to_av_qt").innerHTML="";
			document.getElementById("to_al_qt").innerHTML="";
			
			
	}
	
	}
	
	
	
	function showResult(remaining_quantity,used_quantity,hidden_value,u_r_quantity,itemid) {
	
	if(isNaN(used_quantity))
	{
	alert(used_quantity+" Is not a Number");
	document.getElementById("used_quantity").value="";
	document.getElementById("remaining_quantity").value=hidden_value;
	}
	else
	{
	t_q="";

if(u_r_quantity=="")
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
  
  <script type="text/javascript">
		 
 $(function() {
   $('#txtstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
    $('#txtenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
$("#datepicker1,#datepicker2").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});

</script>
   
  <script>
  function validateform(){
var itemcode=document.frmresources.txtitemcode.value;  
var itemname=document.frmresources.txtitemname.value;
var is_entry=document.frmresources.txtisentry.value;
var rid=document.frmresources.txtrid.value;

if (itemcode==null || itemcode==""){  
  alert("Code is required field");  
  return false;  
}else if(itemname==null || itemname==""){  
  alert("Item Name is required field");  
  return false;  
  }
  if(is_entry=="1")
  {	
  	if(rid=="0")
	{
	 alert("Baseline is required field");
	 return false;    
	}
	
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
<?php

			if(isset($_REQUEST['edit']))
			{
			$action=UPDATE." ";
			}
			else
			{
			$action=ADD." ";
			}
			?>
<div class="form-style-2-heading" style="color:#FF9900;"><?php echo $action.$module; ?></div>
<form name="frmresources" id="frmresources"  action=""  method="post" onSubmit="return validateform()" enctype="multipart/form-data">
<input type="hidden" name="txtparentcd" id="txtparentcd"   value="<?php echo $parentcd; ?>">

<div class="container">

                        <div class="row">
                        <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo CODE;?>:</label>
                                    <input type="text" class="input-field" name="txtitemcode" id="txtitemcode"  value="<?php echo $itemcode; ?>" />
                                </div>
                              </div>
                            </div>
                           
                            
						<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo NAME;?>:</label>
                                    <input type="text" class="input-field" name="txtitemname" id="txtitemname" value="<?php echo $itemname; ?>" />
                                </div>
                              </div>


                        </div>

					</div>
                    <div class="row">
                        <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo IS_ENTRY;?>:</label>
                                <select name="txtisentry"  onChange="ShowDataDiv(this.value)" class="input-field" >
<option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
<option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
</select>
                                   
                                </div>
                              </div>
                            </div>
                            <div class="col">
                             <!--<div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo IS_ENTRY;?>:</label>
                                <select name="txtisentry"  onChange="ShowDataDiv(this.value)" class="input-field" >
<option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
<option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
</select>
                                   
                                </div>
                              </div>-->
                            </div>
						

					</div>



<!--<label for="field1"><span><?php echo CODE;?>: <span class="required">*</span></span><input type="text" class="input-field" name="txtitemcode" id="txtitemcode"  value="<?php echo $itemcode; ?>" /></label>
<label for="field2"><span><?php echo NAME;?>: <span class="required">*</span></span><input type="text" class="input-field" name="txtitemname" id="txtitemname" value="<?php echo $itemname; ?>" /></label>
<label for="field4"><span><?php echo IS_ENTRY;?>:</span>
<select name="txtisentry"  onChange="ShowDataDiv(this.value)" class="select-field">
<option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
<option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
</select>
</label>-->

<div id="data_div" <?php if($isentry==0){?>style="display:none"<?php }?>>
               <?php  $itemid_a=$edit;
			   if(isset($itemid_a)&&$itemid_a!=0&&$itemid_a!='')
			   {
			    
			$sql_a="Select * from activity where itemid=$itemid_a";
			$res_a=$objDb->dbQuery($sql_a);
			$i=1;
			$row3=$objDb->dbFetchArray();
			   }
			?>
            
            
             <div class="row">
                        <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo SELECT_RESOR;?>:</label>
                                <select name="txtrid" id="selUser" onChange="getQuantity(this.value)"   >
         <?php  
			$sqlg="Select * from baseline ";
			$resg=$objDb1->dbQuery($sqlg);
			?>
			<option value="0"><?php echo SELECT_RESOR;?></option>
			<?php
			while($row3g=$objDb1->dbFetchArray())
			{
			
				if($row3g['rid']==$row3['rid'])
				{
				$sele = " selected" ;
				}
				else
				{
				$sele = "" ;
				}
				
				
			?>
			  <option value="<?php echo $row3g['rid'];?>"  <?php echo $sele; ?>><?php echo $row3g['base_code']."-".$row3g['base_desc']; ?> </option>
			  <?php
			  }
			   ?>
			   </select>
               <br/>
         <!--<input type='button' value='Seleted option' id='but_read'>-->
          <div id='result'></div>
        <!-- Script -->
        <script>
        $(document).ready(function(){
            
            // Initialize select2
            $("#selUser").select2();

            // Read selected option
            $('#but_read').click(function(){
                var username = $('#selUser option:selected').text();
                var userid = $('#selUser').val();
           
                $('#result').html("id : " + userid + ", name : " + username);
            });
        });
        </script>
                                   
                                </div>
                              </div>
                            </div>
                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                  
        
                                   
                                </div>
                              </div>
                            </div>
						

					</div>


<div class="row">
						<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo START;?>:</label>
                                   <input type="text" class="input-field" name="txtstartdate" id="txtstartdate" value="<?php echo $row3['startdate']; ?>" />
                                </div>
                              </div>


                        </div>

						<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" ><?php echo END;?>:</label>
                                   <input type="text" class="input-field" name="txtenddate" id="txtenddate" value="<?php echo $row3['enddate']; ?>" />
                                </div>
                              </div>


                        </div>

					</div>







<?php  
			$u_r_quantity="";
			$itemid_a=$edit;
			   if(isset($itemid_a)&&$itemid_a!=0&&$itemid_a!=''&&$row3['rid']!="")
			   {
			 $sqlgb="Select * from baseline where rid=".$row3['rid'];
			$resgb=$objDb2->dbQuery($sqlgb);  
			$row3gb=$objDb2->dbFetchArray();
			$total_quantity=$row3gb['quantity'];
			$quantity_unit=$row3gb['unit'];
			$sql_au="Select sum(baseline) as used_q from activity where rid=".$row3['rid'];
			$res_au=$objDb->dbQuery($sql_au);
			$row3u=$objDb->dbFetchArray();
			$remaining=$total_quantity - $row3u['used_q'];
			
			
			
			$sql_as="Select baseline from activity where itemid=".$itemid_a;
			$res_as=$objDb1->dbQuery($sql_as);
			$row3s=$objDb1->dbFetchArray();
			$u_r_quantity=$remaining+$row3s['baseline'];
			
			   }
			?>

	
    <div class="row">
						<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <input type="hidden" name="h_remaining_quantity" id="h_remaining_quantity"  tabindex="3" class="txtinput" value="<?php echo $total_quantity;?>">
                                <label for="" class="col-sm-6" ><?php echo TOTAL;?> :</label>
                                   <input type="text" class="input-field-unit" name="total_quantity" id="total_quantity" value="<?php echo $total_quantity;?>"  readonly=""/>
	
                                </div>
                              </div>


                        </div>
                        <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                
                                <label for="" class="col-sm-6" >Unit:</label>
                                   <input type="text" class="input-field-unit1" name="quantity_unit" id="quantity_unit" value="<?php echo $quantity_unit;?>"  readonly=""/>
                                </div>
                              </div>


                        </div>

					</div>
                    
                    <div class="row">
						<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                
                                <label for="" class="col-sm-6" ><?php echo TOTAL_AVAIL;?> :</label>
                                   <input type="text" class="input-field-unit" name="remaining_quantity" id="remaining_quantity" value="<?php echo $remaining;?>"  readonly=""/>
	
                                </div>
                              </div>


                        </div>
                        <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                
                                <label for="" class="col-sm-6" >Unit :</label>
                                   
	<input type="text" class="input-field-unit1" name="quantity_unit_r" id="quantity_unit_r" value="<?php echo $quantity_unit;?>"  readonly=""/>
    <input type="hidden" name="u_r_quantity" id="u_r_quantity"  value="<?php echo $u_r_quantity; ?>">
                                </div>
                              </div>


                        </div>

					</div>
                    <div class="row">
						<div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                
                                <label for="" class="col-sm-6" ><?php echo ALOCATED;?> :</label>
                                   <input type="text" class="input-field-unit" name="used_quantity" id="used_quantity" value="<?php echo $row3['baseline']; ?>" onKeyUp="showResult(remaining_quantity.value,this.value,h_remaining_quantity.value,u_r_quantity.value,<?php echo $itemid_a ?>)"/>
	
                                </div>
                              </div>


                        </div>
                        <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                
                                <label for="" class="col-sm-6" >Unit :</label>
                                  
	<input type="text" class="input-field-unit1" name="quantity_unit_a" id="quantity_unit_a" value="<?php echo $quantity_unit;?>"  readonly=""/>
                                </div>
                              </div>


                        </div>

					</div>
    
	<!--<label for="field2"><span><?php echo TOTAL;?> <span id="to_qt"></span>:</span><input type="text" class="input-field-unit" name="total_quantity" id="total_quantity" value="<?php echo $total_quantity;?>"  readonly=""/>
	<input type="text" class="input-field-unit1" name="quantity_unit" id="quantity_unit" value="<?php echo $quantity_unit;?>"  readonly=""/>	
	</label>
	<label for="field2"><span><?php echo TOTAL_AVAIL;?> <span id="to_av_qt"></span>:</span><input type="text" class="input-field-unit" name="remaining_quantity" id="remaining_quantity" value="<?php echo $remaining;?>"  readonly=""/>
	<input type="text" class="input-field-unit1" name="quantity_unit_r" id="quantity_unit_r" value="<?php echo $quantity_unit;?>"  readonly=""/></label>			
	<input type="hidden" name="u_r_quantity" id="u_r_quantity"  value="<?php echo $u_r_quantity; ?>">
	<label for="field2"><span><?php echo ALOCATED;?> <span id="to_al_qt"></span>:</span><input type="text" class="input-field-unit" name="used_quantity" id="used_quantity" value="<?php echo $row3['baseline']; ?>" onKeyUp="showResult(remaining_quantity.value,this.value,h_remaining_quantity.value,u_r_quantity.value,<?php echo $itemid_a ?>)"/>
	<input type="text" class="input-field-unit1" name="quantity_unit_a" id="quantity_unit_a" value="<?php echo $quantity_unit;?>"  readonly=""/></label>-->
			
			<?php
			$remaining="";	
			$total_quantity="";
			?>
			</div>

 <?php
			  if($edit!=""){?>
			  <input type="submit" name="update" id="resetbtn"  value="<?php echo UPDATE;?>">
			
			<?php } else { ?>
			<input type="submit" name="save" id="submitbtn"   value="<?php echo SAVE;?>">
			
			 <?php } ?>

</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</body>
</html>
<?php
	//$objDb  -> close( );
?>
