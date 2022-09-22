<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module		= KPI;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$kpi_flag			= $_SESSION['ne_kpi'];
$kpiadm_flag		= $_SESSION['ne_kpiadm'];
$kpientry_flag		= $_SESSION['ne_kpientry'];
	$_SESSION['codelength']		=6;
	
function RemoveSpecialChar($str){

	// Using preg_replace() function
	// to replace the word
	$res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);

	// Returning the result
	return $res;
}

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 


$edit			= $_GET['edit'];
$delete			= $_GET['del'];
$item			= $_GET['item'];
if(isset($_GET['item'])&&$item!=""&&$item!=0)
{
 $subaid			= $item;
}
elseif(isset($_GET['subaid'])&&$_GET['subaid']!=""&&$_GET['subaid']!=0)
{
	$subaid			= $_GET['subaid'];
}
else
{
	 $subaid=$edit;
}
if($subaid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from kpidata where kpiid=$subaid";
$resgx=$objDb->dbQuery($sqlgx);
$row3gx=$objDb->dbFetchArray();
$name_activity=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$pgroup=$row3gx['parentgroup'];
$ar_group=explode("_",$pgroup);
$sizze= count($ar_group);
for($i=0; $i<$sizze; $i++)
{
$sqlgx1="Select itemname, parentcd from kpidata where kpiid=$ar_group[$i]";
$resgx1=$objDb1->dbQuery($sqlgx1);
$row3gx1=$objDb1->dbFetchArray();
$itemname_1=$row3gx1['itemname'];
 if ($i==0){ $title="KPI";  }
 else if ($i==1){ $title="SubKPI"; }
 
$trail.="<table><tr><td><b>".$title;

 $trail.=": </b></td><td>".$itemname_1; 
 $trail.="</td></tr></table>";

}

 }
 //$subaid			= $_GET['subaid'];

$levelid		= $_GET['levelid'];

$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "KPI";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= $_REQUEST['txtitemname'];
$txtitemcode=RemoveSpecialChar($txtitemcode);
$txtitemname=RemoveSpecialChar($txtitemname);
$txtweight					= $_REQUEST['txtweight'];
if($txtweight=='' || $txtweight==NULL)
{
	$txtweight=0;
}

$txtkpi						= $subaid;
$kpilevel					=$levelid;
$txtisentry					= $_REQUEST['txtisentry'];
$act_s						= $_REQUEST['act'];
//$length=count($act_s);
$btem="Select * from kpi_templates where is_active=1";
			  $resbtemp=$objDb2->dbQuery($btem);
			  $row3tmpgb=$objDb2->dbFetchArray();
			  $kpi_temp_id					= $row3tmpgb["kpi_temp_id"];
if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtactivity				= '';
}

if($saveBtn != "")
{

  $eSqls = "Select * from kpidata where kpiid=".$txtkpi;
  $objDb ->dbQuery($eSqls);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$res1=$objDb->dbFetchArray();
	  $parentgroup2 					= $res1['parentgroup'];
	   $txtparentcd 					= $res1['kpiid'];
	  }
  echo  $sSQL = ("INSERT INTO kpidata (parentcd, activitylevel, itemcode, itemname, weight, isentry, kpi_temp_id) VALUES ($txtparentcd,$kpilevel+1,'$txtitemcode', '$txtitemname',$txtweight,$txtisentry,'$kpi_temp_id')");
	$objDb1->dbQuery($sSQL);
	$txtid = $con->lastInsertId();
	$kpiids = $txtid;
	$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($kpiids)).$kpiids;
		/*if(strlen($kpiids)==1)
		{
		$parentgroup1="00".$kpiids;
		}
		else if(strlen($kpiids)==2)
		{
		$parentgroup1="0".$kpiids;
		}
		else
		{
		$parentgroup1=$kpiids;
		}*/
	$parentgroup=$parentgroup2."_".$parentgroup1;
		
	 $uSqlu = "Update kpidata SET 
			 parentgroup			= '$parentgroup'
			where kpiid 				= $kpiids";	
	$objDb1->dbQuery($uSqlu);

	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	/*$sSQL = ("INSERT INTO kpidata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$kpilevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$kpiids)");
	$objDb->execute($sSQL);*/
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){


	 $eSql_s = "Select * from kpidata where kpiid='$txtkpi'";
  	$objDb -> dbQuery($eSql_s);
  	$eCount2 = $objDb->totalRecords();
	if($eCount2 > 0){
		$res2=$objDb->dbFetchArray();
	  $parentgroup_s	 				= $res2['parentgroup'];
	  }
	
		 $itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
		 if($edit==$_GET['item'])
		 {
			 $parentgroup=$parentgroup_s;
		 }
		 else
		 {
		$parentgroup=$parentgroup_s."_".$itmid;
		 }
	
	
		 $uSql = "Update kpidata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 weight					= $txtweight,
			 parentcd				= $txtkpi,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry'
			 where kpiid 			= $edit";
		  
 	if($objDb1->dbQuery($uSql)){
	
	$eSql_l = "Select * from kpidata where kpiid='$edit'";
  	$objDb2 -> dbQuery($eSql_l);
  	$eCount1 = $objDb2->totalRecords();
	if($eCount1 > 0){
		$res3=$objDb->dbFetchArray();
	  $parentcd 					=$res3['parentcd'];
	  $parentgroup	 				= $res3['parentgroup'];
	  }

	  
	  $msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];		
	
/*	$sSQL2 = ("INSERT INTO kpidata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$kpilevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', $txtisentry, '$txtresources',$edit)");
		$objDb->execute($sSQL2);*/
		
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
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($delete != ""){
$eSql = "Select * from kpidata where kpiid=$delete";
$q_ry=$objDb -> dbQuery($eSql);
$res_s=$objDb -> dbFetchArray();
$p_group=$res_s['parentgroup'];
$eSqlr = "Select * from kpidata where parentgroup like '$p_group%'";
$q_ryr=$objDb1 -> dbQuery($eSqlr);
while($res_sr=$objDb1 -> dbFetchArray())
{
	$kpiid		=$res_sr['kpiid'];
	$parentcd		=$res_sr['parentcd'];
	$parentgroup	=$res_sr['parentgroup'];
	$activitylevel  =$res_sr['activitylevel'];
	$stage			=$res_sr['stage'];
	$itemcode		=$res_sr['itemcode'];
	$itemname		=$res_sr['itemname'];
	$weight			=$res_sr['weight'];
	$isentry  		=$res_sr['isentry'];
	$txtactivities	="";
	$txtresources	="";
	
	
	/* $msg="Deleted!";
	$log_module  = $module." Module";
	$log_title   = "Deleted".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	$sSQL7 = ("INSERT INTO kpidata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$kpiid)");
	$objDb->execute($sSQL7);*/
	
	$eSql_child = "delete from kpi_activity where kpiid=$kpiid";
    $objDb -> dbQuery($eSql_child);
	$eSql_d = "delete from kpidata where kpiid=$kpiid";
    $objDb -> dbQuery($eSql_d);
}

header("Location: kpidata.php");	
}


if($edit != ""){
	$eSql = "Select * from kpidata where kpiid=$edit";
    $objDb1 -> dbQuery($eSql);
    $eCount = $objDb1->totalRecords();
	if($eCount > 0){
		$res_s1=$objDb1 -> dbFetchArray();
	 $parentcd 						= $res_s1['parentcd'];
	  $parentgroup	 				= $res_s1['parentgroup'];
	  $stage						= $res_s1['stage'];
	  $itemcode 					= $res_s1['itemcode'];
	  $itemname 					= $res_s1['itemname'];
	  $weight	 					= $res_s1['weight'];
	  $activities					= $res_s1['activities'];
	  $isentry 						= $res_s1['isentry'];
	 
	 	}
}
?>


<!DOCTYPE html>
<html lang="en">



<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add KPI</title>
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
  <script>
window.onunload = function(){
window.opener.location.reload();
};


  function required(){
	
	var x =document.getElementById("component").value;
	var subtitle =document.getElementById("subtitle").value;
	
	 if (x == 0) {
    alert("Select Component first");
    return false;
  		}
		else if(subtitle == "") {
    alert("Enter Sub Component Name first");
    return false;
  		}
  
  }
  function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
</script>
</head>
<body>
    
    <style>
    .col-sm-6{
      text-align: center;
      background-color:lavender;
      display: block;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
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

	button.hidden {
		display: none;
	}

	thead {
		text-align: center;	
	}

	tbody {
		text-align: center;	
	}

    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    #back{
        float:right;
    }
    table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }
	
       
    </style>
    <div class="container-fluid" >
    <div class="row">

          <div class="col-md-10 m-auto  stretch-card">

            <div class="card bg-form" style="height:450px">
            <div style="margin-left:30px; margin-top:30px; margin-bottom:10px"> <h5 style="text-align:left; color:white"><?php echo  $trail; ?></h5></div>
                <div class="col-md-8 " style="color:#fff;margin-top:20px;margin-left:110px" >

                <h2 style="text-align:center">Add  BOQ</h2>
                <hr>

                    <form class="forms-sample" name="frmresources" id="frmresources" action=""  method="post" onsubmit="" enctype="multipart/form-data">

                   

                 

                        <div class="row">
 
  <h5 style="text-align:center"><?php  if($err_msg!="")
		   {
		   ?>
		   <font color="red"><strong><?php echo $err_msg; ?></strong></font>
		   <?php
		   }
		   else
		   {?>
           <font color="#009933"><strong><?php if($msg!="") echo $msg; else echo "";?></strong></font>
			<?php
			}
			?></h5>
            <input id="txtparentcd" name="txtparentcd" type="hidden" value="<?php echo $parentcd; ?>" readonly=""/>
                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label >SubKPI Code:</label>
                         <input class="form-control" style="width:150px"   id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>" required placeholder="Enter Code">
                                
                                </div>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label >SubKPI  Name:</label>
                      <input  required  class="form-control" style="width:200px" id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>" placeholder="Enter Name">
                                   
                                       
                                    </div>
                              </div>
                            </div>
                            
                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label >SubKPI Weight:</label>
                      <input  required  class="form-control" style="width:200px" type="text"  name="txtweight" id="txtweight" value="<?php echo $weight; ?>" placeholder="Enter Name">
                                   
                                       
                                    </div>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label ><?php echo IS_ENTRY;?>: </label>
                     <select  style="font-size: 14px; color: #000;background-color: #fff; width:50px" onchange="" class="form-control" name="txtisentry"  >
                        <option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  ><?php echo NO;?></option>
			 			<option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> ><?php echo YES;?></option>
  </select>
                                   
                                       
                                    </div>
                              </div>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col">

                              <div class=" row">
                             
                              <div >
                              
                               <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">

          <?php
			  if($edit!=""){?>
    <input type="submit" value="Update" name="update"   class="btn bg-success m-auto text-white btn-sm" style="font-weight:500"/>
   
	 <?php
	 }
	 else
	 {
	 ?>
     <input type="submit"  class="btn bg-success m-auto text-white btn-sm" style="font-weight:500" value="<?php echo SAVE;?>" name="save" id="save" />
			  
  
	 <?php
	 }
	 ?>
                              
                             
                              

                              </div>
                              </div>

                            </div>

                            <div class="col">

                            </div>

                        </div>


                  




                    </form>

                </div>
            </div>
            </div>



         </div>
    <div class="row">
    
    
    

    
            

    <!-- tworow -->
</div><!-- class="row" -->
    </div><!-- class="container" -->

    

</body>
</html>