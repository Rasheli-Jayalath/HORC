<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
$ObjMapDrawing  = new  MapsDrawings();
$ObjMapDrawing2 = new MapsDrawings();
$ObjMapDrawing3 = new MapsDrawings();
$ObjMapDrawing4 = new MapsDrawings();
$user_cd=$_SESSION['ne_user_cd'];
$_SESSION['ne_user_type'];
//$user_cd=1;
//$_SESSION['ne_user_type']=1;
//$data_url="drawings/";
$file_path="drawings/";
$_SESSION['log_id']=1;

						 $pictomaxpid = $ObjMapDrawing->getMaxPid(); 
						 while($plevelrows=$ObjMapDrawing->dbFetchArray())
						{
						  $pid = $plevelrows['pid'];
						} 
						 
//===============================================

function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}
$album_id=$_REQUEST['album_id'];
 $pdSQL_get_right1_d = "SELECT parent_group FROM  t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$album_id;
			                $ObjMapDrawing->dbQuery($pdSQL_get_right1_d);
							$result_get_right1d =$ObjMapDrawing->dbFetchArray();
			                //$result_get_right1d = mysql_fetch_array($pdSQLResult_get_right1d); 
							$p_groupd=$result_get_right1d['parent_group'];
				$arr_gpd=explode("_", $p_groupd);
				$group_countd=count($arr_gpd);
				if($group_countd>1)
				{
				$get_album_idd=$arr_gpd[1];
				$pdSQL_get_rightd = "SELECT user_ids,user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_idd;
			 $ObjMapDrawing2->dbQuery($pdSQL_get_rightd);
			 $result_get_rightd =$ObjMapDrawing2->dbFetchArray();
			// $result_get_rightd = mysql_fetch_array($pdSQLResult_get_rightd);
				}
				

								
				
				
				$u_rightr=$result_get_rightd['user_right'];
			
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			$arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
						
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
                       
						 if($read_right==2 || $read_right=="")
								  {
									  header("Location: index.php?init=3");
									  }
							
						}
				}
			
							
if(isset($_REQUEST['dwgid']))
{
$dwgid=$_REQUEST['dwgid'];
$pdSQL1="SELECT dwgid, pid, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings  WHERE pid= ".$pid." and album_id= ".$album_id." and  dwgid = ".$dwgid;
$ObjMapDrawing->dbQuery($pdSQL1);
 $pdData1 =$ObjMapDrawing->dbFetchArray();
//$pdData1 = mysql_fetch_array($pdSQLResult1);
$al_file=$pdData1['al_file'];
 $dwg_type=$pdData1['dwg_type'];
 $dwg_no=$pdData1['dwg_no'];
	$dwg_title=$pdData1['dwg_title'];
	$dwg_date=$pdData1['dwg_date'];
	$revision_no=$pdData1['revision_no'];
	$dwg_status=$pdData1['dwg_status'];
}

/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
	$dwg_type=$_REQUEST['dwg_type'];
    $dwg_no=$_REQUEST['dwg_no'];
	$dwg_title=trim($_REQUEST['dwg_title']);
	$dwg_date=$_REQUEST['dwg_date'];
	$revision_no=$_REQUEST['revision_no'];
	$dwg_status=$_REQUEST['dwg_status'];
		//echo $name_array = $_FILES['al_file']['name'];
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| 
	($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
		
	 $sql_query="INSERT INTO t027project_drawings(pid, album_id, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file) Values(".$pid.",".$album_id.", '".$dwg_type."', '".$dwg_no."', '".$dwg_title."', '".$dwg_date."', '".$revision_no."','".$dwg_status."', '".$file_name."')";
	$ObjMapDrawing->dbQuery($sql_query);
	$insert_id=$con->lastInsertId();
	//$insert_id=mysql_insert_id();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=$album_id."-".$insert_id." - New Drawing record added successfully";
	} else {
    //$message= mysql_error($db);
	$activity= "Error in adding drawing record";
	}
	$log_id=$_SESSION['log_id'];
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$ObjMapDrawing2->dbQuery($iSQL);
	}
	}
	}
	$al_file='';
	
	//header("Location: sp_drawing_album_input.php?album_id=$album_id");
	
}

if(isset($_REQUEST['update']))
{
	$dwg_type=$_REQUEST['dwg_type'];
	$dwg_no=$_REQUEST['dwg_no'];
	$dwg_title=trim($_REQUEST['dwg_title']);
	$dwg_title=stripslashes($dwg_title);
	$dwg_date=$_REQUEST['dwg_date'];
	$revision_no=$_REQUEST['revision_no'];
	$dwg_status=$_REQUEST['dwg_status'];
$pdSQL = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." and dwgid=".$dwgid." order by dwgid";
$ObjMapDrawing->dbQuery($pdSQL);
$sql_num=$ObjMapDrawing-> totalRecords();
//$sql_num=mysql_num_rows($pdSQLResult);
$pdData =$ObjMapDrawing->dbFetchArray();
//$pdData = mysql_fetch_array($pdSQLResult);
$dwgid=$_REQUEST['dwgid'];
$old_al_file= $pdData["al_file"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid. ".".$extension;
  
	if(($_FILES["al_file"]["type"] == "application/pdf")|| 
	($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	
    $sql_pro="UPDATE t027project_drawings SET  dwg_type='$dwg_type',dwg_no='$dwg_no',dwg_title='$dwg_title',dwg_date='$dwg_date',revision_no='$revision_no',dwg_status='$dwg_status',al_file='$file_name' where dwgid=$dwgid and album_id=$album_id";
	
	$ObjMapDrawing->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $album_id."-".$dwgid." - Drawing Record updated successfully";
	} else {
		//$message= mysql_error($db);
		$activity= "error in updating drawing record";
	}
	}
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
	 $sql_pro="UPDATE t027project_drawings SET  dwg_type='$dwg_type',dwg_no='$dwg_no',dwg_title='$dwg_title',dwg_date='$dwg_date',revision_no='$revision_no',dwg_status='$dwg_status' where dwgid=$dwgid and album_id=$album_id";
	
	$ObjMapDrawing->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $album_id."-".$dwgid." - Photo Record updated successfully";
	} else {
		//$message= mysql_error($db);
		$activity= "error in updating drawing attachment record";
	}
	
	}
	$log_id=$_SESSION['log_id'];
		$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
		echo $iSQL;
				$ObjMapDrawing->dbQuery($iSQL);
//header("Location: sp_drawing_album_input.php?album_id=$album_id");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Drawingss</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">

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

 <!-- bootstrap -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
<script>
window.onunload = function(){
window.opener.location.reload();
};
				</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>
<style type="text/css">

.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}

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

.new_div li {
    list-style: outside none none;
}

.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("./images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 90px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}
.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.ms-WPBody a:link {
    color: #0072bc;
    text-decoration: none;
}
/*div a {
    color: #767676 !important;
    font-family: arial;
    font-size: 12px;
    line-height: 17px;
    text-decoration: none !important;
}*/
img {
    border: medium none;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.2/jquery-ui.min.js"></script>

<script> 
$(document).ready(function () {
    var date = new Date();
    $('#dwg_date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script> 
</head>
<body>
<script type="text/javascript">

function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
function required(){
	
		
	var x = document.forms["form2"]["dwg_title"].value;
		var uploadPhoto = document.forms["form2"]["al_file"].value;
		var uploadPhoto_old = document.forms["form2"]["old_al_file"].value;
		
	
  if (x == "") {
    alert("Title must be filled out");
    return false;
  }
   if (uploadPhoto == "" && uploadPhoto_old == "") {
    alert("Photo must be uploaded first");
    return false;
  }
	
	
}


function doFilter(frm){
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	/*if(frm.desg_id.value != ""){
		qString += '&desg_id=' + frm.desg_id.value;
	}
	if(frm.emp_type.value != ""){
		qString += '&emp_type=' + frm.emp_type.value;
	}
	if(frm.smec_egc.value != ""){
		qString += '&smec_egc=' + frm.smec_egc.value;
	}*/
	document.location = 'analysis.php?' + qString;
}
</script>
<script type="text/javascript">
		 
 $(function() {
   $('#dwg_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  


</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
   <link href="css/style.css" rel="stylesheet" /> 

   <div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Manage Drawings</h4>
				  <?php echo $message; ?>
				  <?php
					$pdSQL6 = "SELECT album_name FROM t031project_drawingalbums  WHERE pid= ".$pid." and albumid=".$album_id;
					$ObjMapDrawing->dbQuery($pdSQL6);
					$pdData6 =$ObjMapDrawing->dbFetchArray();
					//$pdData6 = mysql_fetch_array($pdSQLResult6);
					?>
                  <form class="forms-sample pt-3" name="form2" action="sp_drawing_album_input.php?album_id=<?php echo $album_id; ?>" target="_self" method="post"  enctype="multipart/form-data" onSubmit="return required()"  >


					<div class="form-group row">
                    <div class="text-end col-sm-6"><label><?php echo "Drawing Folder Name:";?></label>
                      </div>
                      <div class="text-start col-sm-6" >
					  <span style="font-weight:bold" ><?php echo $pdData6['album_name'];?></span>
                      </div>
           
                    </div>

					<div class="form-group row">
                    <div class="text-end col-sm-6"><label><?php echo "Drawing Type:";?></label>
                      </div>
                      <div class="text-start col-sm-6">
					  <select class="form-control bg-light text-dark" name="dwg_type" id="dwg_type" style="width: 60%;" >
					  <option value="" > Select </option>
						<?php if(isset($dwg_type))
						{
							$drawing_type=$dwg_type;
						}
						else
						{
							$drawing_type="Design";
						}?>
								<option value="Design" <?php if($drawing_type=='Design') echo "selected";?>>Design</option>
								<option value="Survey" <?php if($drawing_type=='Survey') echo "selected";?>>Survey</option>
								<option value="Others" <?php if($drawing_type=='Others') echo "selected";?>>Others</option>
								
						</select>
                      </div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>
				 
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "Drawing No:";?></label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control"  type="text"  name="dwg_no" id="dwg_no" value="<?php echo $dwg_no;?>" style="width: 60%;" placeholder="Drawing No " Required>
                      </div>
                </div>
  			 
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "Drawing Title:";?></label> </div>
                      <div class="text-start col-sm-6">
					  <input class="form-control"  type="text"   name="dwg_title" id="dwg_title" value="<?php echo $dwg_title;?>"  style="width: 60%;"  placeholder=" Drawing Title " Required>
					 <span style="   font-size: 75%;"> Please avoid special characters</span>
					</div>
                </div>
  
								 
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "Drawing Date:";?></label> </div>
                      <div class="text-start col-sm-6">
					  <input class="form-control"  type="text" name="dwg_date" id="dwg_date" autocomplete="off"  value="<?php echo $dwg_date;?>"    style="width: 60%;"  placeholder=" Drawing Date " Required>
					  <span style="   font-size: 75%;"> yyyy-mm-dd</span>
					</div>
                </div>
  
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "Revision No:";?></label> </div>
                      <div class="text-start col-sm-6">
					  <input class="form-control"  type="text" name="revision_no" id="revision_no" value="<?php echo $revision_no;?>"  style="width: 60%;"  placeholder=" Revision No " Required>
                      </div>
                </div>

								 
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "Drawing Status:";?></label> </div>
                      <div class="text-start col-sm-6">
					  <select name="dwg_status" style="width: 60%;"  class="form-control bg-light text-dark">
					  <option value="" >Select</option>
						<option value="1" <?php if($dwg_status=='1')echo "selected";?>>Initiated</option>
						<option value="2" <?php if($dwg_status=='2')echo "selected";?>>Approved</option>
						<option value="3" <?php if($dwg_status=='3')echo "selected";?>>Not Approved</option>
						<option value="4" <?php if($dwg_status=='4')echo "selected";?>>Under Review</option>
						<option value="5" <?php if($dwg_status=='5')echo "selected";?>>Response Awaited</option>
						<option value="7" <?php if($dwg_status=='7')echo "selected";?>>Responded</option>
					</select>
                      </div>
                </div>
  
					                    
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "Upload File:";?></label> </div>
                      <div class="text-start col-sm-6">
					  <input  type="file" name="al_file" id="al_file"  />
                      <input type="hidden" name="old_al_file" value="<?php echo $al_file; ?>" />
                      </div>
                </div>


				<div class="form-group row pt-3">
				     <div class="text-end col-sm-6">
					 <?php if(isset($_REQUEST['dwgid'])) { ?>
						<input type="hidden" name="dwgid" id="dwgid" value="<?php echo $_REQUEST['dwgid']; ?>" />
						<button class="btn btn-primary me-2" type="submit" name="update" id="update" value="Update" style="width:40%"> Update </button>
						<?php
						}
						else
						{
						?>
						<button  class="btn btn-primary me-2" type="submit" name="save" id="save" value="Save" style="width:40%"> Submit </button>
						<?php
						}
					?> 
						</div>
						<div class="text-start col-sm-6">
					<button  type="button" class="btn btn-light" name="cancel" id="cancel" value="Cancel"  style="width:40%"  onclick="cancelButton();">Cancel</button>
					</div>
				</div>


</form>

                </div>
              </div>
            </div>
</div>

					</body>
					</html>