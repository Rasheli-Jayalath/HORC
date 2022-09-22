<?php
error_reporting(E_ALL & ~E_NOTICE);
include_once("../../../config/config.php");

$module		= "Manage Photos";

/*$pic_flag			= $_SESSION['ne_pic'];
	$picadm_flag		= $_SESSION['ne_picadm'];
	$picentry_flag		=$_SESSION['ne_picentry'];*/
	$pic_flag			= 1;
	$picadm_flag		= 1;
	$picentry_flag		=1;
	$uid				= $_SESSION['ne_user_cd']; 
	$uname				= $_SESSION['ne_username'];
	$superadmin_flag 		= $_SESSION['ne_sadmin'];
if ($uname==null  ) {
header("Location: ../../../index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: ../../../index.php?init=3");
}	
$edit			= $_GET['edit'];
$objDb  		= new Database( );
$objDb1  		= new Database( );
$objDb2  		= new Database( );
//@require_once("get_url.php");
//===============================================

function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);
    return $res;
}

$file_path="photos/";
$user_cd=$uid;
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = $objDb->dbQuery($pSQL);
						 $pData = $objDb->dbFetchArray();
						 $pid=$pData["pid"];
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
 $pdSQL_get_right1 = "SELECT parent_group FROM  t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$album_id;
			                $pdSQLResult_get_right1 = $objDb->dbQuery($pdSQL_get_right1);
			                $result_get_right1 = $objDb->dbFetchArray(); 
							$p_group=$result_get_right1['parent_group'];
				$arr_gp=explode("_", $p_group);
				$group_count=count($arr_gp);
				if($group_count>1)
				{
				$get_album_id=$arr_gp[1];
				$pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $pdSQLResult_get_right = $objDb1->dbQuery($pdSQL_get_right);
			 $result_get_right = $objDb1->dbFetchArray();
				}
if(isset($_REQUEST['vid']))
{
$vid=$_REQUEST['vid'];
$pdSQL1="SELECT vid, pid,album_id,v_cap, v_al_file  FROM t32project_videos  WHERE pid= ".$pid." and album_id= ".$album_id." and  vid = ".$vid;
$pdSQLResult1 =$objDb->dbQuery($pdSQL1);
$pdData1 = $objDb1->dbFetchArray();
$v_al_file=$pdData1['v_al_file'];
$v_cap=$pdData1['v_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['vid'])&&isset($_REQUEST['album_id'])&&$_REQUEST['vid']!="")
{
@unlink($file_path.$v_al_file);
$objDb->dbQuery("Delete from t32project_videos where vid=".$_REQUEST['vid']." and album_id=".$_REQUEST['album_id']);
  $activity="Album id(".$_REQUEST['album_id'].") video id(".$_REQUEST['vid'].") - Video Deleted Successfully";
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
 header("Location: sp_video_input.php?album_id=$album_id");
}
/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
   $v_cap=RemoveSpecialChar($_REQUEST['v_cap']);
	// $file_name1 = $_FILES['v_al_file']['name'];
 //echo  $file_type = $_FILES['v_al_file']['type'];
    echo $file_size = $_FILES['v_al_file']['size'];
	echo $_FILES['v_al_file']['tmp_name'];
	  echo  $_FILES["v_al_file"]["error"];
	//echo $file_type=mime_content_type($file_path.$file_name1);
	//echo $ext = pathinfo($file_name1, PATHINFO_EXTENSION);
	if(isset($_FILES["v_al_file"]["name"])&&$_FILES["v_al_file"]["name"]!="")
	{
		
 $allowed_extensions = array("webm","ogv","mov", "mp4", "3gp", "ogg","avi","mpeg");
 $pattern = implode("|" , $allowed_extensions);
 $extension = pathinfo($_FILES['v_al_file']['name'], PATHINFO_EXTENSION);
	//$extension=getExtention($_FILES["al_file"]["type"]);
	echo $file_name=genRandom(5)."-".$pid. ".".$extension;
 echo   $tmpFilePath = $_FILES['v_al_file']['tmp_name'];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
	 if (preg_match("/({$pattern})$/i", $_FILES['v_al_file']['name']) )
        {
			echo "if";
			
            if (($extension == "webm") || ($extension == "mp4") || ($extension == "ogv") || ($extension == "avi")|| ($extension == "mpeg"))
            
	{ 
	echo $extension;
	echo $target_file=$file_path.$file_name;
	echo $tmpFilePath;
	if(move_uploaded_file($tmpFilePath,$target_file))
	{
		
	echo $sql_pro1="INSERT INTO t32project_videos(pid,album_id,v_cap,v_al_file) Values(".$pid.",".$album_id.", '".$v_cap."', '".$file_name."' )";
	$sql_pro=$objDb2->dbQuery($sql_pro1);
	$insert_id=$con->lastInsertId();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=$album_id."-".$insert_id." - New Video record added successfully";
	} else {
    $message= "Error in Adding Video REcord";
	 $activity= "Error in Adding Video REcord";
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
	}
	}
	
	
		}
			}
	}
	$v_al_file='';
	
	//header("Location: sp_video_input.php?album_id=$album_id");
	
}

if(isset($_REQUEST['update']))
{
$v_cap=RemoveSpecialChar($_REQUEST['v_cap']);
$pdSQL = "SELECT a.vid, a.pid,a.album_id, a.v_al_file FROM t32project_videos a WHERE pid = ".$pid." and vid=".$vid." and album_id=".$album_id." order by vid";
$pdSQLResult = $objDb->dbQuery($pdSQL);
$sql_num=$objDb->totalRecords();
$pdData = $objDb->dbFetchArray();
$vid=$_REQUEST['vid'];
$old_al_file= $pdData["v_al_file"];
		if($old_al_file){
			if(isset($_FILES["v_al_file"]["name"])&&$_FILES["v_al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["v_al_file"]["name"])&&$_FILES["v_al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["v_al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid. ".".$extension;
  
	if(
	($_FILES["v_al_file"]["type"] == "video/webm")|| 
	($_FILES["v_al_file"]["type"] == "video/mp4")|| 
	($_FILES["v_al_file"]["type"] == "video/ogv") || 
	($_FILES["v_al_file"]["type"] == "video/avi")|| 
	($_FILES["v_al_file"]["type"] == "video/mpeg"))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['v_al_file']['tmp_name'],$target_file))
	{
  $sql_pro="UPDATE t32project_videos SET v_cap='$v_cap', v_al_file='$file_name' where vid=$vid and album_id=$album_id";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  "albumid- ".$album_id." videoid-".$vid." -  Video Record updated successfully";
	} else {
		$message= "Error in updating video record";
		$activity= "Error in updating video record";
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
	 $sql_pro="UPDATE t32project_videos SET v_cap='$v_cap' where vid=$vid and album_id=$album_id";
	
	$sql_proresult= $objDb1->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  "albumid- ".$album_id." videoid-".$vid." - Video Record updated successfully";
	} else {
		$message= "Error in updating video record";
		$activity= "Error in updating video record";
	}
	
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb->dbQuery($iSQL);
header("Location: sp_video_input.php?album_id=$album_id");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<script>
window.onunload = function(){
window.opener.location.reload();
};

function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
function required(){
	var x = document.forms["form2"]["v_cap"].value;
	var uploadPhoto = document.forms["form2"]["v_al_file"].value;
	var uploadPhoto_old = document.forms["form2"]["old_al_file"].value;

  if (x == "") {
    alert("Caption must be filled out");
    return false;
  }
   if (uploadPhoto == "" && uploadPhoto_old=="") {
    alert("Video must be uploaded first");
    return false;
  }
	
	
}
</script>


<!DOCTYPE html>
<html lang="en">
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Manage Albums</title>
</head> -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Albums</title>
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
<script>
function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
</script>
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
    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }
  </style>
<script type="text/javascript">
function cancelButton()
{
 window.opener.location.reload();
 self.close();
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
	
function getDates(lid)
{
	
	if (lid!=0) {
			var strURL="finddate.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("location_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 

}
</script>


<div class="container-fluid">

    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Manage Videos</h4>

  <form  name="form2" action="sp_video_input.php?album_id=<?php echo $album_id; ?>" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required();">
                    <div class="form-group row">
                    <div class="text-center col-sm-4">
                      </div>
                      <div class="text-center col-sm-4">
                       <input class="form-control text-center  " type="text" name="v_cap" id="v_cap" value="<?php echo $v_cap;?>"    placeholder="Enter The Video Caption Here"/>
                  
                       
                      </div>
                      <div class="text-center col-sm-4">
                      </div>
                    </div>
     
                    <div class="form-group row">
                    <div class="text-center col-sm-2">
                      </div>
                      <div class="text-center col-sm-8">
                       <input  type="file" name="v_al_file" id="v_al_file" value="<?php echo $v_al_file?>"  class="form-control"/>
  <input type="hidden" name="old_al_file" value="<?php echo $v_al_file?>" />
                       
                      </div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>
<?php if(isset($_REQUEST['vid']))
	 {
		 
	 ?>
     <input type="hidden" name="vid" id="vid" value="<?php echo $_REQUEST['vid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" class="btn btn-primary me-2"/>
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" class="btn btn-primary me-2"/>
	 <?php
	 }
	 ?> <input  type="button" name="cancel" id="cancel" value="Cancel" onclick="cancelButton();" class="btn btn-light"/>
          
                   <!-- <button type="submit" class="btn btn-primary me-2" name="save" id="save" style="width:20%">Submit</button>
                    <button class="btn btn-light" type="button" style="width:20%" onclick="javascript:window.close()">Cancel</button>-->
                  </form>
                </div>
              </div>
            </div>

    <div class="row">

    <div class="col-sm-12" style="" id="tworow">

<table class="table table-hover">
    <thead class="" style="background-image: linear-gradient(180deg, #c9c9f5, #c9c9f5);">
        <th style="font-weight: 900;">#</th>
        <th style="font-weight: 900;">Video Cap</th>
        <th style="font-weight: 900;">Thumb</th>
        <th class="text-center "  style="font-weight: 900;">Action</th>
    </thead>
    <tbody id="table_data">
    <?php
						 $pdSQL = "SELECT vid, pid,album_id,v_cap, v_al_file  FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  $i++;
							  ?>

<tr>
        <td><?php echo $ss;?></td>
        <td><?php echo $pdData['v_cap'];?></td>
        <td>  <img src="photos/video_file_icon.jpg"  width="50" height="50"/></td>
        <td class="text-center" style="padding: 0% 6%">
         <?php    
                          if($_SESSION['ne_user_type']==1)
			{
				?>
                  <span style="float:left"><form action="sp_video_input.php?vid=<?php echo $pdData['vid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
                   <span style="float:right"><form action="sp_video_input.php?vid=<?php echo $pdData['vid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>
                   <?php
			}
			else
			{
						   $u_rightr=$result_get_right['user_right'];
			
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
                       
						 if($read_right==1 || $read_right==3)
								  {
								   ?>
						   <span style="float:left"><form action="sp_video_input.php?vid=<?php echo $pdData['vid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   <?php  
							}
							if($read_right==3)
								  {
								   ?>
						   <span style="float:right"><form action="sp_video_input.php?vid=<?php echo $pdData['vid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>
						   <?php
						   }
						}
				}
			}
						   ?>
        </td>
        </tr>

        
        <?php
        $i++;

						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
      
    </tbody>
</table>

<script>

</script>
<br>
</div><!-- tworow -->
</div><!-- class="row" -->
    </div>
 
