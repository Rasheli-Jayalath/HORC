<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");

$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objDb1  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$_SESSION['ne_user_type']=1;
$user_cd=1;
$pid=1;

header("Content-Type: text/html; charset=utf-8");
function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);

    return $res;
}
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
//$pData = mysql_fetch_array($pSQLResult);
 $pid=$pData["pid"];	
  $dpentry_flag=1;
 $dpadm_flag=1;		
 
 if(isset($_REQUEST['lid']))
{
 $lid=$_REQUEST['lid'];
}

if(isset($_REQUEST['save']))
{
	
	$serial=RemoveSpecialChar($_REQUEST['serial']);
	$description=RemoveSpecialChar($_REQUEST['description']);
	
	$total=$_REQUEST['total'];
	$submitted=$_REQUEST['submitted'];
	$revision=$_REQUEST['revision'];
	$approved=$_REQUEST['approved'];
	$approvedpct=$_REQUEST['approvedpct'];
	$item_id=$_REQUEST['item_id'];
	$unit=RemoveSpecialChar($_REQUEST['unit']);
	$lid=$_REQUEST['lid'];
	$pid="1";
	

	$remarks=RemoveSpecialChar($_REQUEST['remarks']);
	$message="";
	$pgid=1;
	if($total=="")
	{
		$total=0;
	}
	if($submitted=="")
	{
		$submitted=0;
	}
	if($revision=="")
	{
		$revision=0;
	}
	if($approved=="")
	{
		$approved=0;
	}
	if($approvedpct=="")
	{
		$approvedpct=0;
	}

 $query=("INSERT INTO t0101designprogress (pid, lid,serial, description, total, submitted, revision, approved, approvedpct,item_id,unit,remarks) 
Values(".$pid.",".$lid.",'".$serial."','".$description."',".$total.",".$submitted.",".$revision.",".$approved.",".$approvedpct.",".$item_id.",'".$unit."','".$remarks." ')");
$sql_pro=$objSDb->dbQuery($query);
						
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= "Error in adding design progress record";
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
{
	$dgid=$_REQUEST['dgid'];
	$serial=RemoveSpecialChar($_REQUEST['serial']);
	$description=RemoveSpecialChar($_REQUEST['description']);
	$total=$_REQUEST['total'];
	$submitted=$_REQUEST['submitted'];
	$revision=$_REQUEST['revision'];
	$approved=$_REQUEST['approved'];
	$approvedpct=$_REQUEST['approvedpct'];
	$item_id=$_REQUEST['item_id'];
	$unit=RemoveSpecialChar($_REQUEST['unit']);
	 $remarks=RemoveSpecialChar($_REQUEST['remarks']);
	 $lid=$_REQUEST['lid'];
	//$pid=$_REQUEST['pid'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0101designprogress SET serial='$serial', description='$description', total = $total, submitted=$submitted, revision=$revision, approved=$approved, approvedpct=$approvedpct , item_id=$item_id , unit='$unit' ,remarks='$remarks' where dgid=$dgid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= "Error in updating design progress record";
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";

}
if(isset($_REQUEST['dgid']))
{
$dgid=$_REQUEST['dgid'];

$pdSQL1="SELECT * FROM t0101designprogress  where pid = ".$pid." and  dgid = ".$dgid;

$pdSQLResult1 = $objDb->dbQuery($pdSQL1);
$pdData1=$objDb->dbFetchArray();
//$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial=$pdData1['serial'];
	$description=$pdData1['description'];
	$total=$pdData1['total'];
	$submitted=$pdData1['submitted'];
	$revision=$pdData1['revision'];
	$approved=$pdData1['approved'];
	$approvedpct=$pdData1['approvedpct'];
	$item_id=$pdData1['item_id'];
	$unit=$pdData1['unit'];
	$remarks=$pdData1['remarks'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Design Progress</title>
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
    <div class="container-fluid">

    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Design Progress</h4>
				 <span style="color:green; font-size:16px; font-weight:bold"> <?php echo $message; ?></span>
                  <form class="forms-sample" action="sp_design_input.php" target="_self" method="post"  >
				 
				  <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Serial #: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"  name="serial" id="serial" value="<?php echo $serial; ?>"  style="width: 60%;" placeholder="Serial #" Required maxlength="100">
                      </div>
                 </div>


                 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Component Area: </label> </div>
                      <div class="text-start col-sm-6">
									<select class="form-control  bg-light text-dark" id="lid" name="lid" style="width: 60%;" onchange="getMajor(this.value);" required>
					<option value="">Select Component Area</option>
					<?php $pdSQL = "SELECT lid,pid,code,title FROM  structures  order by lid";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["lid"];?>" <?php if($item_id==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>

				<?php } 
				}?>
					</select>
	              </div>
                 </div>
     
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Major Item: </label> </div>
                      <div class="text-start col-sm-4" id="item_div">
									<?php  if(isset($_REQUEST['dgid']))
{
	?>

                      <select  id="item_id" name="item_id"  class="form-control"  style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);"  required>
                        <option value="">Select Major Component</option>

                        <?php $pdSQL = "SELECT item_id, title FROM  t014majoritems  where item_id=$item_id";
										$pdSQLResult = $objDb1->dbQuery($pdSQL);
										$i=0;
										if($objDb1-> totalRecords()>=1);
											
											{
											while($pdData2=$objDb1->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData2["item_id"];?>" <?php if($item_id==$pdData2["item_id"]) {?> selected="selected" <?php }?>><?php echo $pdData2["title"];?></option>
                       
                                  
                        <?php
                            }
											}
                           ?>

  </select>
  <?php
}
?>
	              </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Description: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"  name="description" id="description" value="<?php echo $description; ?>"  style="width: 60%;" placeholder="Description" >
                      </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Unit: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"   name="unit" id="unit" value="<?php echo $unit; ?>"  style="width: 60%;" placeholder="Unit" Required>
                      </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Total:</label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="number"  step="0.01"  name="total" id="total" value="<?php echo $total; ?>" style="width: 60%;"  > Numbers Only
                      </div>
                 </div>

				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Design Submitted:</label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="number" step="0.01"  name="submitted" id="submitted" value="<?php echo $submitted; ?>"  style="width: 60%;" placeholder="Design Submitted" >Numbers Only
                      </div>
                 </div>				 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Under Revision:</label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="number" step="0.01" name="revision" id="revision" value="<?php echo $revision; ?>"  style="width: 60%;" placeholder="Under Revision" >Numbers Only
                      </div>
                 </div>				 
			 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Approved : </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="number" step="0.01"  name="approved" id="approved" value="<?php echo $approved; ?>" style="width: 60%;" placeholder="Approved" >Numbers Only
                      </div>
                 </div>				 
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label>Approval %: </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="number" step="0.01"   name="approvedpct" id="approvedpct" value="<?php echo $approvedpct; ?>" style="width: 60%;" placeholder="Approval %" >Decimal Numbers Only
                      </div>
                 </div>
				 <div class="form-group row">
                    <div class="text-end col-sm-6"> <label> Remarks :</label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"  name="remarks" id="remarks" value="<?php echo $remarks; ?>" style="width: 60%;" placeholder="Remarks" >
                      </div>
                 </div>

				 <?php if(isset($_REQUEST['dgid']))
	 {
		 
	 ?>
	    <input type="hidden" name="dgid" id="dgid" value="<?php echo $_REQUEST['dgid']; ?>" />
	    <button  type="submit" class="btn btn-primary me-2" name="update" id="update" value="Update" style="width:20%">Update</button>
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
function getMajor(lid)
{
 // alert(lid);
	
	if (lid!=0) {
			var strURL="findcanal.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {						
							document.getElementById("item_div").innerHTML=req.responseText;						
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

