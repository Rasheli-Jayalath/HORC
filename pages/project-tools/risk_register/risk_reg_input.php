<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
//$ObjMapDrawing  = new  MapsDrawings();
//$ObjMapDrawing2 = new MapsDrawings();
//$ObjMapDrawing3 = new MapsDrawings();
//$ObjMapDrawing4 = new MapsDrawings();
//$user_cd=1;
//$_SESSION['ne_user_type']=1;
//$data_url="drawings/";
//$file_path="pictorial_data";
//$data_url="photos/";

 //$album_id=$_REQUEST['album_id'];

$edit			= $_GET['edit'];
$risk_id		= $_GET['risk_id'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$_SESSION['ne_user_type']=1;
$user_cd=1;
/*error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Design Progress";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($dp_flag==0)
{
	header("Location: index.php?init=3");
}
$defaultLang = 'en';

//if ($pid=="" ) 
//{
//header("Location: project_calender.php");
//}

$user_cd=$uid;*/
header("Content-Type: text/html; charset=utf-8");
//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
/*if (!empty($_GET["language"])) { //<!-- see this line. checks 
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

$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$objCSDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];*/
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
//$pData = mysql_fetch_array($pSQLResult);
 $pid=$pData["pid"];	
  $dpentry_flag=1;
 $dpadm_flag=1;	
 
function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);

    return $res;
}

 $pSQL = "SELECT a.*, b.* ,c.* FROM `tbl_risk_register` a inner join tbl_risk_register_context b on(a.risk_con_id=b.risk_con_id) 
 inner join structures c on (b.lid=c.lid) where risk_id='$risk_id' ";
 $objDb->dbQuery($pSQL);
 $pdData = $objDb->dbFetchArray();				  
								//$pData = mysql_fetch_array($pSQLResult);
								$pid=$pdData["pid"];	
								$lid=$pdData["lid"];	
								$risk_entry_date=$pdData["risk_entry_date"];	
								$risk_no=$pdData["risk_no"];	
								$risk_con_id=$pdData["risk_con_id"];	
								$risk_status=$pdData["risk_status"];	
								$risk_cons_hazard=$pdData["risk_cons_hazard"];	
								$risk_cause=$pdData["risk_cause"];	
								$risk_like_score=$pdData["risk_like_score"];	
								$risk_impact_score=$pdData["risk_impact_score"];	
								$risk_control_measure=$pdData["risk_control_measure"];	
								$risk_owner=$pdData["risk_owner"];	
								$risk_lastdate=$pdData["risk_lastdate"];	
								$risk_update_date=$pdData["risk_update_date"];	
								$risk_rrls=$pdData["risk_rrls"];	
								$risk_rris=$pdData["risk_rris"];	
								$risk_comments=$pdData["risk_comments"];	
								$ris_con_desc=$pdData["ris_con_desc"];	
								$risk_con_id=$pdData['risk_con_id'];

					
							



 

if(isset($_REQUEST['save']))
{
	
	$pid=1;
	$risk_entry_date=date('Y-m-d',strtotime($_REQUEST['risk_entry_date']));
	$risk_no=RemoveSpecialChar($_REQUEST['risk_no']);
	$risk_con_id=$_REQUEST['risk_con_id'];
	$risk_status=$_REQUEST['risk_status'];
	$risk_cons_hazard=RemoveSpecialChar($_REQUEST['risk_cons_hazard']);
	$risk_cause=RemoveSpecialChar($_REQUEST['risk_cause']);
	$risk_like_score=$_REQUEST['risk_like_score'];
	if($risk_like_score==""){
		$risk_like_score='0';
	}else{
		$risk_like_score=$risk_like_score;
	}
	$risk_impact_score=$_REQUEST['risk_impact_score'];
	if($risk_impact_score==""){
		$risk_impact_score='0';
	}else{
		$risk_impact_score=$risk_impact_score;
	}
	$risk_control_measure=RemoveSpecialChar($_REQUEST['risk_control_measure']);
	$risk_owner=RemoveSpecialChar($_REQUEST['risk_owner']);
	$risk_lastdate=date('Y-m-d',strtotime($_REQUEST['risk_lastdate']));
	$risk_update_date=date('Y-m-d'); 
	$risk_rrls=$_REQUEST['risk_rrls'];
	if($risk_rrls==""){
		$risk_rrls='0';
	}else{
		$risk_rrls=$risk_rrls;
	}
	$risk_rris=$_REQUEST['risk_rris'];
	if($risk_rris==""){
		$risk_rris='0';
	}else{
		$risk_rris=$risk_rris;
	}
	$risk_comments=RemoveSpecialChar($_REQUEST['risk_comments']);
	
	$message="";
	$pgid=1;

$query=("INSERT INTO tbl_risk_register(pid, risk_con_id, risk_no, risk_entry_date, risk_status, risk_cons_hazard, risk_cause, risk_like_score, risk_impact_score, risk_control_measure, 
					risk_owner, risk_lastdate, risk_update_date, risk_rrls, risk_rris, risk_comments) 
		Values('".$pid."','".$risk_con_id."','".$risk_no."', '".$risk_entry_date."', '".$risk_status."', '".$risk_cons_hazard."', '".$risk_cause."', '".$risk_like_score."',
		 '".$risk_impact_score."', '".$risk_control_measure."', '".$risk_owner."', '".$risk_lastdate."', '".$risk_update_date."', '".$risk_rrls."', '".$risk_rris."', '".$risk_comments."')");
$sql_pro=$objDb->dbQuery($query);
						
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= "Error in adding Risk Register record";
}
 	$serial='';
	$description='';
	$total = '';
	$submitted='';
	$revision='';
	$approved='';
	$approvedpct='';
	$unit='';
	$item_id='';
	$remarks='';
	
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}

if(isset($_REQUEST['update']))
{	$risk_id= $_REQUEST['risk_id']; 

	$pid=1;
	$risk_entry_date=date('Y-m-d',strtotime($_REQUEST['risk_entry_date']));
	$risk_no=$_REQUEST['risk_no'];
	$risk_con_id=$_REQUEST['risk_con_id'];
	$risk_status=$_REQUEST['risk_status'];
	$risk_cons_hazard=$_REQUEST['risk_cons_hazard'];
	$risk_cause=$_REQUEST['risk_cause'];
	$risk_like_score=$_REQUEST['risk_like_score'];
	if($risk_like_score==""){
		$risk_like_score='0';
	}else{
		$risk_like_score=$risk_like_score;
	}
	$risk_impact_score=$_REQUEST['risk_impact_score'];
	if($risk_impact_score==""){
		$risk_impact_score='0';
	}else{
		$risk_impact_score=$risk_impact_score;
	}
	$risk_control_measure=$_REQUEST['risk_control_measure'];
	$risk_owner=$_REQUEST['risk_owner'];
	$risk_lastdate=date('Y-m-d',strtotime($_REQUEST['risk_lastdate']));
	$risk_update_date=date('Y-m-d'); 
	$risk_rrls=$_REQUEST['risk_rrls'];
	if($risk_rrls==""){
		$risk_rrls='0';
	}else{
		$risk_rrls=$risk_rrls;
	}
	$risk_rris=$_REQUEST['risk_rris'];
	if($risk_rris==""){
		$risk_rris='0';
	}else{
		$risk_rris=$risk_rris;
	}
	$risk_comments=$_REQUEST['risk_comments'];
	
	
$sql_pro="UPDATE tbl_risk_register SET pid='$pid', risk_con_id='$risk_con_id', risk_no='$risk_no', risk_entry_date='$risk_entry_date', risk_status='$risk_status', risk_cons_hazard='$risk_cons_hazard', risk_cause='$risk_cause', risk_like_score='$risk_like_score', risk_impact_score='$risk_impact_score', risk_control_measure='$risk_control_measure', 
risk_owner='$risk_owner', risk_lastdate='$risk_lastdate', risk_update_date='$risk_update_date', risk_rrls='$risk_rrls', risk_rris='$risk_rris', risk_comments='$risk_comments' WHERE risk_id=$risk_id"; 
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= "Error in updating design progress record";
}

print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
//header("Location: sp_design.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Risk Register</title>
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


</head>

<body>
  <style>
    .col-sm-6{
   
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
    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }
  </style>
   <script  type="text/javascript">
  function required_1(){
	  
	var x = document.forms["form1"]["risk_no"].value;
	var lid = document.forms["form1"]["lid"].value;
	var risk_entry_date = document.forms["form1"]["risk_entry_date"].value;
	var risk_owner = document.forms["form1"]["risk_owner"].value;
	var risk_lastdate = document.forms["form1"]["risk_lastdate"].value;
	
	if(lid!="")
	{
	var risk_con_id = document.forms["form1"]["risk_con_id"].value;
	}
  if (x == "") {
    alert("Risk Number must be filled out");
    return false;
  }
   if (lid== "") {
    alert("Select Component first");
    return false;
  }
  if(lid!="")
	{
   if (risk_con_id== "") {
    alert("Select Risk Context");
    return false;
  }
	}
	 if (risk_entry_date== "") {
    alert("Select Risk entry Date first");
    return false;
  }
   if (risk_owner== "") {
    alert("Add Risk Owner Name");
    return false;
  }
   if (risk_lastdate== "") {
    alert("Select Risk Action by Date");
    return false;
  }

	
	
}
</script>
    <div class="container-fluid">

    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Design Progress</h4>
				  <?php echo $message; ?>
                  <form class="forms-sample" action="risk_reg_input.php" target="_self" method="post" name="form1" onsubmit="return required_1()">
				 
				  <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Risk Id #: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"  name="risk_no" id="risk_no" value="<?php echo $risk_no; ?>"  style="width: 60%;" >
                      </div>
                 </div>


                 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Risk Component Area: </label> </div>
                      <div class="text-start col-sm-6">
									<select class="form-control  bg-light text-dark" id="lid" name="lid" style="width: 60%;"onchange="getRisk(this.value);" >
					<option value="">Select Component Area</option>
					<?php $pdSQL = "SELECT lid,pid,code,title FROM  structures  order by lid";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

<option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
				<?php } 
				}?>
					</select>
	              </div>
                 </div>
     
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Risk Context: </label> </div>
                      <div class="text-start col-sm-4" id="context_div">
						<?php
					  if($risk_id!=''){ ?>


					<select class="form-control  bg-light text-dark" id="risk_con_id" name="risk_con_id" style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);" >
					<option value="">Select Risk Context</option>
					<?php $pdSQL = "SELECT * FROM  tbl_risk_register_context  order by risk_con_id";
										$pdSQLResult = $objSDb ->dbQuery($pdSQL);
										$i=0;
										if($objSDb -> totalRecords()>=1);
											
											{
											while($pdData=$objSDb ->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["risk_con_id"];?>" <?php if($risk_con_id==$pdData["risk_con_id"]) {?> selected="selected" <?php }?>><?php echo $pdData["ris_con_desc"];?></option>

				<?php } 
				}?>
					</select>
					 	<?php }
					  ?>
	              </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Risk Entry Date: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="date"  name="risk_entry_date" id="risk_entry_date" value="<?php echo $risk_entry_date; ?>"  style="width: 60%;"  >
                      </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Risk Status: </label> </div>
                      <div class="text-start col-sm-6">
					   
					  <label class="form-check-label" style="padding-left: 1%; ">
                                  <input  type="radio" class="form-check-input"  id="risk_status" name="risk_status" value="1"  checked="checked"/> Open
                            </label>
                            

                              
                            <label class="form-check-label " style="padding-left: 5%;">
                                   <input  type="radio" class="form-check-input" id="risk_status" name="risk_status" value="0" <?php if($risk_status==0) {echo 'checked="checked"';}?> /> Closed
                            </label>
                         
					 </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Risk Consequence Hazard: </label> </div>
                      <div class="text-start col-sm-6">
					  <textarea  class="form-control" rows="4" style=" height: 100px; "  name="risk_cons_hazard"  id="risk_cons_hazard" ><?php echo $risk_cons_hazard;?> </textarea>
                      </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Risk Cause (Description):</label> </div>
                      <div class="text-start col-sm-6">
					  <textarea  class="form-control" rows="4" style=" height: 100px; "  name="risk_cause"  id="risk_cause"  ><?php echo $risk_cause;?> </textarea>
                      </div>
                 </div>


				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Likelihood Score:</label> </div>
                      <div class="text-start col-sm-6">
					  <select class="form-control  bg-light text-dark" id="risk_like_score" name="risk_like_score" style="width: 60%;" >
					<option value="">Select Likelihood Score</option>
					<?php $pdSQL = "SELECT * FROM  tbl_risk_likelihood_rating  order by score";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["score"];?>" <?php if($risk_like_score==$pdData["score"]) {?> selected="selected" <?php }?>><?php echo $pdData["score"]."-".$pdData["like_per"]."-".$pdData["like_desc"];?></option>

				<?php } 
				}?>
					</select>
				     </div>
                 </div>


				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Impact Score:</label> </div>
                      <div class="text-start col-sm-6">
					  <select class="form-control  bg-light text-dark" id="risk_impact_score" name="risk_impact_score" style="width: 60%;" >
					<option value="">Select Impact Score</option>
					<?php $pdSQL = "SELECT * FROM  tbl_risk_impact_rating  order by impact_score";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["impact_score"];?>" <?php if($risk_impact_score==$pdData["impact_score"]) {?> selected="selected" <?php }?>><?php echo $pdData["impact_score"]."-".$pdData["impact_desc"];?></option>

				<?php } 
				}?>
					</select>
				      </div>
                 </div>	

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Risk Control Measure:</label> </div>
                      <div class="text-start col-sm-6">
					  <textarea  class="form-control" rows="4" style=" height: 100px; "  name="risk_control_measure"  id="risk_control_measure"  Required><?php echo $risk_control_measure;?>  </textarea>
                      </div>
                 </div>				 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Risk Action Owner:</label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"  name="risk_owner" id="risk_owner" value="<?php echo $risk_owner; ?>"  style="width: 60%;" placeholder="Risk Action Owner" >
                      </div>
                 </div>				 
			 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Action By Date: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="date" name="risk_lastdate" id="risk_lastdate" value="<?php echo $risk_lastdate; ?>" style="width: 60%;" placeholder="Action By Date" >
                      </div>
                 </div>	
				 
				 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> RRLS:</label> </div>
                      <div class="text-start col-sm-6">
					  <select class="form-control  bg-light text-dark" id="risk_rrls" name="risk_rrls" style="width: 60%;" >
					<option value="">Select RRLS</option>
					<?php $pdSQL = "SELECT * FROM  tbl_risk_likelihood_rating  order by score";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["score"];?>" <?php if($risk_rrls==$pdData["score"]) {?> selected="selected" <?php }?>><?php echo $pdData["score"]."-".$pdData["like_per"]."-".$pdData["like_desc"];?></option>

				<?php } 
				}?>
					</select>
				     </div>
                 </div>


				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>RRIS:</label> </div>
                      <div class="text-start col-sm-6">
					  <select class="form-control  bg-light text-dark" id="risk_rris" name="risk_rris" style="width: 60%;" >
					<option value="">Select RRIS</option>
					<?php $pdSQL = "SELECT * FROM  tbl_risk_impact_rating  order by impact_score";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["impact_score"];?>" <?php if($risk_rris==$pdData["impact_score"]) {?> selected="selected" <?php }?>><?php echo $pdData["impact_score"]."-".$pdData["impact_desc"];?></option>

				<?php } 
				}?>
					</select>
				      </div>
                 </div>	

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Comments/Additional Information:</label> </div>
                      <div class="text-start col-sm-6">
					  <textarea  class="form-control" rows="4" style=" height: 100px; "  name="risk_comments"  id="risk_comments"  Required><?php echo $risk_comments;?> </textarea>
                      </div>
                 </div>
				

				 <?php if(isset($_REQUEST['risk_id']))
	 {
		 
	 ?>
	    <input type="hidden" name="risk_id" id="risk_id" value="<?php echo $_REQUEST['risk_id']; ?>" />
	    <button  type="submit" class="btn btn-primary me-2" name="update" id="update" value="<?php echo $_REQUEST['risk_id']; ?>" style="width:20%">Update</button>
		<button class="btn btn-light" type="button" style="width:20%" onclick="javascript:window.close()">Cancel</button>
	   <?php
	 }
	 else
	 {
	 ?>
	    <button  type="submit" class="btn btn-primary me-2" name="save" id="save" value="Save" style="width:20%">Save</button>
		<button class="btn btn-light" type="button" style="width:20%" onclick="javascript:window.close()">Cancel</button>
		<?php
	 }
	 ?> 
 

                  </form>
                </div>
              </div>
            </div>

			<div id="search"></div>
	<div id="without_search"></div>
    </div><!-- class="container" -->
<script>

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
function getRisk(lid)
{
 // alert(lid);
	
	if (lid!=0) {
			var strURL="findcontext.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {						
							document.getElementById("context_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}


</script>
</body>
</html>

