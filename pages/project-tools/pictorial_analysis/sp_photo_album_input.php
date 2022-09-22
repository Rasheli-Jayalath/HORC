<?php
error_reporting(~E_ALL & ~E_NOTICE);
include_once("../../../config/config.php");
header("Content-Type: text/html; charset=utf-8");
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
$objDb1 		= new Database( );
function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);
    return $res;
}

//@require_once("get_url.php");
$file_path="photos/";
$file_thumb_path="photos/thumb/";
$user_cd=$uid;
$log_id = $_SESSION['log_id'];
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = $objDb->dbQuery($pSQL);
						 $pData = $objDb->dbFetchArray();
						 $pid=$pData["pid"];
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
if(isset($_REQUEST['phid']))
{
$phid=$_REQUEST['phid'];
$pdSQL1="SELECT phid, pid, album_id, al_file, ph_cap FROM t027project_photos  WHERE pid= ".$pid." and album_id= ".$album_id." and  phid = ".$phid;
$pdSQLResult1 = $objDb->dbQuery($pdSQL1);
$pdData1 = $objDb->dbFetchArray();
$al_file=$pdData1['al_file'];
$ph_cap=$pdData1['ph_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['phid'])&&isset($_REQUEST['album_id'])&&$_REQUEST['phid']!="")
{
@unlink($file_path.$al_file);
@unlink($file_thumb_path.$al_file);
 $objDb->dbQuery("Delete from t027project_photos where phid=".$_REQUEST['phid']." and album_id=".$_REQUEST['album_id']);
 $activity="Album id(".$_REQUEST['album_id'].") photo id(".$_REQUEST['phid'].") - Photo Deleted Successfully";
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
 header("Location:sp_photo_album_input.php?album_id=$album_id");
}
/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
    
	
	$ph_cap=RemoveSpecialChar($_REQUEST['ph_cap']);
	
	
		
		
	    //Loop through each file
        for($i=0; $i<count($_FILES['al_file']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['al_file']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
              $shortname1 = $_FILES['al_file']['name'][$i];
			
				$ext = pathinfo($shortname1, PATHINFO_EXTENSION);
				$array_sname=explode(".",$shortname1);
				if(count($_FILES['al_file']['name'])==1 && $ph_cap!='')
				{
				$report_title=$ph_cap;
				}
				else
				{
				$report_title= trim($array_sname[0]);
				}
				$report_title_1=$array_sname[0];
				
		
		
				$file_name=genRandom(5)."-".$album_id.".".$ext;
               
			 	$target_file=$file_path.$file_name;
			
              

                
                if(move_uploaded_file($tmpFilePath, $target_file)) {
				
	
		///create thumbnail
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($target_file);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($target_file);
                    break;

                case 'png':
                    $source = imagecreatefrompng($target_file);
                    break;
			
                case 'gif':
                    $source = imagecreatefromgif($target_file);
                    break;
                default:
                    $source = imagecreatefromjpeg($target_file);
            }

            imagecopyresampled($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail);
            }

	}
	//// End thumbnails
	
	$sql_query="INSERT INTO t027project_photos(pid, album_id, al_file, original_file_name,ph_cap) Values(".$pid.",".$album_id.", '".$file_name."', '".$shortname1."', '".$report_title."' )";
	$sql_pro=$objDb->dbQuery($sql_query);
	$insert_id=$con->LastInsertId();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=$album_id."-".$insert_id." - New photo record added successfully";
	} else {
    $message= "Error in adding photo Record";
	 $activity= "Error in adding photo Record";
	}
	
	
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
	}
				
              }
			
        }
	
	
	//header("Location: sp_photo_album_input.php?album_id=$album_id");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=RemoveSpecialChar($_REQUEST['ph_cap']);
$pdSQL = "SELECT a.phid, a.pid, a.album_id, a.al_file FROM t027project_photos a WHERE pid = ".$pid." and album_id=".$album_id." and phid=".$phid." order by phid";
$pdSQLResult = $objDb->dbQuery($pdSQL);
$sql_num=$objDb->totalRecords();
$pdData = $objDb->dbFetchArray();
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
				@unlink($file_thumb_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
            
                //save the filename
				$tmpFilePath = $_FILES['al_file']['tmp_name'];
                $shortname1 = $_FILES['al_file']['name'];
				$ext = pathinfo($shortname1, PATHINFO_EXTENSION);
				$array_sname=explode(".",$shortname1);
				if(count($_FILES['al_file']['name'])==1 && $ph_cap!='')
				{
				$report_title=$ph_cap;
				}
				else
				{
				$report_title= trim($array_sname[0]);
				}
				$report_title_1=preg_replace("/[^a-zA-Z0-9.]/", "", $array_sname[0]);
				$shortname=$shortname1.$ext;
				
				
		
		
				$file_name=genRandom(5)."-".$album_id.".".$ext;
                //save the url and the file
				$target_file=$file_path.$file_name;
              //  $filePath = $report_path."/".$filename;

                
                if(move_uploaded_file($tmpFilePath, $target_file)) {
	
		///create thumbnail
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($target_file);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($target_file);
                    break;

                case 'png':
                    $source = imagecreatefrompng($target_file);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($target_file);
                    break;
                default:
                    $source = imagecreatefromjpeg($target_file);
            }

            imagecopyresampled($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail);
            }

	}
	//// End thumbnails
	 $sql_pro="UPDATE t027project_photos SET ph_cap='$report_title', al_file='$file_name' where phid=$phid and album_id=$album_id";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $album_id."-".$phid." - Photo Record updated successfully";
	} else {
		$message= "Error in updating photo record";
		$activity= "Error in updating photo record";
	}
	
	
	}
	
  
	
	}
	else
	{
	 $sql_pro="UPDATE t027project_photos SET ph_cap='$ph_cap' where phid=$phid and album_id=$album_id";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $album_id."-".$phid." - Photo Record updated successfully";
	} else {
		$message= "Error in updating photo record";
		$activity= "Error in updating photo record";
	}
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
header("Location: sp_photo_album_input.php?album_id=$album_id");
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
				</script>
                <!DOCTYPE html>
<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Photos</title>
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
function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
function required(){
	
		
	var x = document.forms["form2"]["ph_cap"].value;
		var uploadPhoto = document.forms["form2"]["al_file"].value;
		var uploadPhoto_old = document.forms["form2"]["old_al_file"].value;
	
  if (x == "") {
    alert("Caption must be filled out");
    return false;
  }
   if (uploadPhoto == "" && uploadPhoto_old=="") {
    alert("Photo must be uploaded first");
    return false;
  }
	
	
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
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
   <link href="css/style.css" rel="stylesheet" /> 
   </head>
   <body>
   
   <div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Manage Photos</h4>

                  <form class="forms-sample" action="sp_photo_album_input.php?album_id=<?php echo $album_id; ?>" method="post" id="add_details" enctype="multipart/form-data"  onSubmit="return required()">
                    <div class="form-group row">
                    <div class="text-center col-sm-4">
                      </div>
                      <div class="text-center col-sm-4">
                       
                        <input type="text" class="form-control text-center"   name="ph_cap" id="ph_cap" value="<?php echo $ph_cap;?>"  placeholder="Enter The Photo Caption Here" maxlength="250" Required>
                        <input class="form-control"  type="hidden" style="width:300px;" id="palid" name="palid" value="<?php echo $album_id;?>">
                      </div>
                      <div class="text-center col-sm-4">
                      </div>
                    </div>
     
                    <div class="form-group row">
                    <div class="text-center col-sm-2">
                      </div>
                      <div class="text-center col-sm-8">
                        
                        
                        <?php if(isset($_GET['phid']))
		{
		?>
        <input  type="file" name="al_file" id="al_file"  class="form-control" />
        <input type="hidden" name="old_al_file" value="<?php echo $pdData1['al_file'];?>" />
	
		<?php
		}
		else
		{?>
         <input  type="file" name="al_file[]" id="al_file" multiple="multiple"  class="form-control" /><div id="selectedFiles"></div>
     
		 <input type="hidden" name="old_al_file" value="" />
		<?php }	?>
                      </div>
                      <div class="text-center col-sm-2">
                     
                      </div>
                    </div>
                    
                    <div class="form-group row">
                    <div class="text-center col-sm-2">
                      </div>
                      <div class="text-center col-sm-8">
                        
                        
                       <strong>Note:</strong>  max_file_uploads=20 <br />upload_max_filesize=1028M
                      </div>
                      <div class="text-center col-sm-2">
                      
                      </div>
                    </div>
                    
                    
                    
					<?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update"  class="btn btn-primary me-2"/>
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save"  class="btn btn-primary me-2"/>
	 <?php
	 }
	 ?> 
     <input  type="button" name="cancel" id="cancel" value="Cancel"   onclick="cancelButton();" class="btn btn-light"/>
          
                    
                  </form>
                </div>
              </div>
            </div>
    <div class="row">
      
    <!-- <div class="col-sm-12" style="background-color:lavender;" id="onerow">
    <div class="row"> <div class="col-sm-6" style=""></div></div></div> -->

 

    <div class="col-sm-12" style="" id="tworow">

<table class="table  table-hover">
    <thead class="" style="background-image: linear-gradient(180deg, #c9c9f5, #c9c9f5);" >
        <th style="font-weight: 900;">S#</th>
        <th style="font-weight: 900;">Photo Caption</th>
        <th style="font-weight: 900;">Thumb</th>
        <th class="text-center "style="font-weight: 900;">Action</th>
    </thead>
    <tbody id="table_data">

    <?php
						 $pdSQL = "SELECT phid, pid,album_id, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  {
							  
							  $i++;
							  ?>

<tr>
        <td><?php echo $i;?></td>
        <td><?php echo $pdData['ph_cap'];?></td>
        <td>  <img src="<?php echo $file_path."thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
        <td class="text-center" style="padding: 0% 6%">
        
         <?php    
                          if($_SESSION['ne_user_type']==1)
			{
				?>
                 <span style="float:left"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid']; ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
                 <span style="float:right"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onClick="return confirm('Are you sure, you want to delete this Photo?')" /></form></span>
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
						  <span style="float:left"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid']; ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   <?php  
							}
							if($read_right==3)
								  {
								   ?>
						   <span style="float:right"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onClick="return confirm('Are you sure, you want to delete this Photo?')" /></form></span>
						   <?php
						   }
						}
				}
			}
						   ?>

        </td>
        </tr>
        
        <?php
       
 }
							  }
							  else
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

</body>
</html>