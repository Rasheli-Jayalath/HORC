<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module		= BOQDATA;
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
	$_SESSION['codelength']		=6;

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 


$milestone=$_REQUEST["milestone"];
if(isset($milestone)&&$milestone==1)
 { 
$module		= "Milestone";
 } else
 {
$module		= "BOQ";
 }
 $edit			= $_GET['edit'];
 $delete			= $_GET['del'];
//$item			= $_GET['item'];
 $subaid			= $_GET['subaid'];
if($subaid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from boqdata where stage='BOQ' and itemid=$subaid";
$resgx=$objDb->dbQuery($sqlgx);
$row3gx=$objDb->dbFetchArray();
$name_activity=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$pgroup=$row3gx['parentgroup'];
$ar_group=explode("_",$pgroup);
$sizze= count($ar_group);
for($i=0; $i<$sizze; $i++)
{
$sqlgx1="Select itemname, parentcd from boqdata where itemid=$ar_group[$i]";
$resgx1=$objDb->dbQuery($sqlgx1);
$row3gx1=$objDb->dbFetchArray();
$itemname_1=$row3gx1['itemname'];
 if ($i==0){ 
 if(isset($milestone)&&$milestone==1)
 {
 $title="Milestone"; 
 }
 else
 {
 $title="BOQ"; 
 }
 }
 else if ($i==1){ 
 
 if(isset($milestone)&&$milestone==1)
 {
 $title="SubMilestone"; 
 }
 else
 {
  $title="SubBOQ"; 
 }

 }
 
$trail.="<strong>".$title."</strong>";

 $trail.=":".$itemname_1."<br>"; 


}

 }
 //$subaid			= $_GET['subaid'];

$levelid		= $_GET['levelid'];

//@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "BOQ";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= $_REQUEST['txtitemname'];
$txtweight					= $_REQUEST['txtweight'];
if($subaid!="")
{
$txtboq						= $subaid;
}
if($levelid!="")
{
$boqlevel					=$levelid;
}
else
{
	$boqlevel					=0;
}
//$txtisentry					= $_REQUEST['txtisentry'];

$txtisentry     = $_REQUEST['txtisentry'];


if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtactivity				= '';
}

if($saveBtn != "")
{

  if(isset($txtboq)&&$txtboq!="")
  {
  $eSqls = "Select * from boqdata where itemid=".$txtboq;
  $objDb1->dbQuery($eSqls);
  $eCount = $objDb1->totalRecords();
	if($eCount > 0){
	$e_result = $objDb1->dbFetchArray();	
	  $parentgroup2 					= $e_result['parentgroup'];
	   $txtparentcd 					= $e_result['itemid'];
	  }
 echo  $sSQL = ("INSERT INTO boqdata (parentcd, activitylevel, stage,itemcode, itemname,isentry) VALUES ($txtparentcd,$boqlevel+1,'$txtstage','$txtitemcode', '$txtitemname',$txtisentry)");
  }
  else
  {
	  $parentgroup2="";
	  $txtparentcd=0;
	 echo   $sSQL = ("INSERT INTO boqdata (parentcd, activitylevel, stage,itemcode, itemname,isentry) VALUES ($txtparentcd,$boqlevel,'$txtstage','$txtitemcode', '$txtitemname',$txtisentry)");
	}
 
	$objDb->dbQuery($sSQL);
	$txtid = $con->lastInsertId();
	$itemids = $txtid;
	$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
		/*if(strlen($itemids)==1)
		{
		$parentgroup1="00".$itemids;
		}
		else if(strlen($itemids)==2)
		{
		$parentgroup1="0".$itemids;
		}
		else
		{
		$parentgroup1=$itemids;
		}*/
	 if(isset($txtboq)&&$txtboq!="")
	  {
		$parentgroup=$parentgroup2."_".$parentgroup1;
	  }
	  else
	  {
		  $parentgroup=$parentgroup1;
	   }
		
	 $uSqlu = "Update boqdata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb2->dbQuery($uSqlu);
	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	//$sSQL = ("INSERT INTO boqdata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$boqlevel+1,'$txtstage', '$txtitemcode', '$txtitemname','$txtactivities',$txtisentry, '$txtresources',$itemids)");
	//$objDb->dbQuery($sSQL);
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){


	 $eSql_s = "Select * from boqdata where itemid='$txtboq'";
  	$objDb -> dbQuery($eSql_s);
  	$eCount2 = $objDb->totalRecords();
	if($eCount2 > 0){
		$e2_res = $objDb->dbFetchArray();
	  $parentgroup_s	 				= $e2_res['parentgroup'];
	  }
	  /*if(strlen($edit)==1)
		{
		$itmid="00".$edit;
		}
		else if(strlen($edit)==2)
		{
		$itmid="0".$edit;
		}
		else
		{
		$itmid=$edit;
		}*/
		$itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
		$parentgroup=$parentgroup_s."_".$itmid;
	
	
	
		$uSql = "Update boqdata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 parentcd				= $txtboq,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry'
			where itemid 			= $edit ";
		  
 	if($objDb1->dbQuery($uSql)){
	
	$eSql_l = "Select * from boqdata where itemid='$edit'";
  	$objDb -> dbQuery($eSql_l);
  	$eCount1 = $objDb->totalRecords();
	if($eCount1 > 0){
		$e2_res1 = $objDb->dbFetchArray();
	  $parentcd 					= $e2_res1['parentcd'];
	  $parentgroup	 				= $e2_res1['parentgroup'];
	  }
	  
	  $msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];		
	
	//echo $sSQL2 = ("INSERT INTO boqdata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$boqlevel+1,'$txtstage', '$txtitemcode', '$txtitemname','$txtactivities', $txtisentry, '$txtresources',$edit)");
		//$objDb2->dbQuery($sSQL2);
		
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
echo $eSql = "Select * from boqdata where itemid=$delete";
$q_ry=$objDb->dbQuery($eSql);
$res_s=$objDb->dbFetchArray();
$p_group=$res_s['parentgroup'];
$eSqlr = "Select * from boqdata where parentgroup like '$p_group%'";
$q_ryr=$objDb1->dbQuery($eSqlr);
while($res_sr=$objDb1->dbFetchArray())
{
	$itemid			=$res_sr['itemid'];
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
	
	
	 $msg="Deleted!";
	$log_module  = $module." Module";
	$log_title   = "Deleted".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	//$sSQL7 = ("INSERT INTO boqdata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	//$objDb->dbQuery($sSQL7);
	
	
	////cpmment for this time
	$eSql_boq = "select boqid from boq where itemid=$itemid";
   $ress_boq=$objDb->dbQuery($eSql_boq);
   while($result_boq=$objDb->dbFetchArray)
   {
   $boqid=$result_boq['boqid'];
   $eSql_ipcv = "delete from ipcv where boqid=$boqid";
    $objDb1 ->dbQuery($eSql_ipcv);
   }
	
	
	$eSql_child = "delete from boq where itemid=$itemid";
    $objDb2 -> dbQuery($eSql_child);
	
	$eSql_d = "delete from boqdata where itemid=$itemid";
    $objDb -> dbQuery($eSql_d);
}

header("Location: boqdata.php");	
}


if($edit != ""){
	$eSql = "Select * from boqdata where itemid=$edit";
    $objDb2 -> dbQuery($eSql);
    $eCount = $objDb2->totalRecords();
	if($eCount > 0){
		$r_result=$objDb2->dbFetchArray();
	 $parentcd 						= $r_result['parentcd'];
	  $parentgroup	 				= $r_result['parentgroup'];
	  $stage						= $r_result['stage'];
	  $itemcode 					= $r_result['itemcode'];
	  $itemname 					= $r_result['itemname'];
	  $weight	 					= $r_result['weight'];
	  $activities					= $r_result['activities'];
	  $isentry 						= $r_result['isentry'];
	  $resources 					= $r_result['resources'];
	
	}
	
	
}

?>


<!DOCTYPE html>
<html lang="en">



<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Location Form</title>
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
                                <label ><?php if(isset($milestone)&&$milestone==1)
										 { 
										 echo SUB_MIL_CODE;
										 } else
										 {
										 echo SUB_BOQ_CODE;
										 }?>:</label>
                         <input class="form-control" style="width:150px"   id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>" required placeholder="Enter Code">
                                
                                </div>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label ><?php if(isset($milestone)&&$milestone==1)
										 { 
										 echo SUB_MIL_NAME;
										 } else
										 {
										 echo SUB_BOQ_NAME;
										 }?> </label>
                      <input  required  class="form-control" style="width:200px" id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>" placeholder="Enter Name">
                                   
                                       
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