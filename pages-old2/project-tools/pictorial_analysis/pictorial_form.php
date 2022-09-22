<?php
include_once("../../../config/config.php");
//@require_once("../../../config/session.php");
require_once('../../../rs_lang.admin.php');
	$ObjPictoAna1 = new PictorialAnalysis();
	$ObjPictoAna = new PictorialAnalysis();
 $module		= "Manage Photos";
/*if ($uname==null  ) {
header("Location: index.php?init=3");
}*/ 
 
$defaultLang = 'en';
$user_cd=1;
$edit			= $_GET['edit'];
$objDb  		= new Database( );
$objDb1  		= new Database( );
//@require_once("get_url.php");
$msg						= "";
$giscode=0;
$file_path="pictorial_data/";
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
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = $objDb1->dbQuery($pSQL);
						 $pData = $objDb1->dbFetchArray();
						 $pid=$pData["pid"];
if(isset($_REQUEST['phid']))
{
$phid=$_REQUEST['phid'];
$pdSQL1="SELECT phid,lcid, pid, al_file, ph_cap, date_p FROM  project_photos  WHERE pid= ".$pid." and  phid = ".$phid;
$pdSQLResult1 = $objDb->dbQuery($pdSQL1);
$pdData1 = $objDb->dbFetchArray();
$al_file=$pdData1['al_file'];
$ph_cap=$pdData1['ph_cap'];
$lcid=$pdData1['lcid'];
 $date_p=$pdData1["date_p"];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['phid'])&$_REQUEST['phid']!="")
{

@unlink($file_path."/". $al_file);
@unlink($file_path."/thumb/" . $al_file);
 $objDb->dbQuery("Delete from  project_photos where phid=".$_REQUEST['phid']);
  $activity=$ph_cap. " - Pictorial Analysis Photo Deleted Successfully";
//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
 header("Location: pictorial_form.php");
}
$size=50;
$max_size=($size * 1024 * 1024);
if(isset($_REQUEST['save']))
{ 
    $ph_cap=$_REQUEST['ph_cap'];
	 $lcid=$_REQUEST['canal_name'];
	// $check_query_g="SELECT giscode from locations_component where lid=".$ph_cap." AND lcid=".$lcid;
	//$check_res_g=$objDb1->dbQuery($check_query_g);
	//$pdData_g = $objDb1->dbFetchArray();
	//$giscode=$pdData_g['giscode'];
	 
	 
	$date_p=date("Y-m-d",strtotime($_REQUEST['date_p']));
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$ph_cap."-".$lcid.".".$extension;
	//echo $name_array = $_FILES['al_file']['name'];
	if(($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	///create thumbnail
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($extension){
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
            switch($extension){
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
	
	 $check_query="SELECT * from project_photos where ph_cap=".$ph_cap." AND lcid=".$lcid." and date_p='".$date_p."'";
	$check_res=$objDb->dbQuery($check_query);
	 $check_row=$objDb->totalRecords();
	if($check_row>0)
	{
	 $message=  "<b>Photo Already Exist for this Date & Location</b>";	
	}
	else
	{
	
	$sql_pro=$objDb1->dbQuery("INSERT INTO  project_photos(pid, al_file,ph_cap,lcid,date_p,giscode) 
	Values(".$pid.", '".$file_name."', '".$ph_cap."',".$lcid.", '".$date_p."',".$giscode." )");
	if ($sql_pro == TRUE) {
		
    $message=  "<b>New record added successfully</b>";
	$activity=$ph_cap." - New photo for pictorial analysis added successfully";
	} else {
    $message= "Error in adding record";
	$activity= "Error in adding record";
	}
	}
	//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//mysql_query($iSQL);
	}
	}
	
	 $ph_cap="";
	$lcid="";
	$date_p="";
	$al_file='';

	
	header("Location: pictorial_form.php");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=$_REQUEST['ph_cap'];
$lcid=$_REQUEST['canal_name'];
//$check_query_g="SELECT giscode from locations_component where lid=".$ph_cap." AND lcid=".$lcid;
	//$check_res_g=$objDb->dbQuery($check_query_g);
	//$pdData_g = $objDb->dbFetchArray();
	//$giscode=$pdData_g['giscode'];


$pdSQL = "SELECT a.phid, a.pid, a.al_file,a.date_p FROM  project_photos a WHERE a.pid = ".$pid." and a.phid=".$phid." and lcid=".$lcid." order by phid";
$pdSQLResult = $objDb1->dbQuery($pdSQL);
$sql_num=$objDb1->totalRecords();
$pdData = $objDb1->dbFetchArray();
//$date_p=$pdData["date_p"];
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
$date_p=date("Y-m-d",strtotime($_REQUEST['date_p']));
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path."/". $old_al_file);
				@unlink($file_path."/thumb/" . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["al_file"]["type"]);
		$file_name=genRandom(5)."-".$ph_cap."-".$lcid;
  
	if(
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($extension){
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
            switch($extension){
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
	
    $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap',lcid=$lcid, al_file='$file_name' ,date_p='$date_p', giscode=$giscode where phid=$phid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	}
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $ph_cap." - Pictorial Analysis Photo updated successfully";
	} else {
		$message= "Error in updating Record";
		$activity= "Error in updating Record";
	}
	
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
	 $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap',lcid=$lcid,date_p='$date_p', giscode=$giscode where phid=$phid";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $ph_cap." - Pictorial Analysis Photo updated successfully";
	} else {
		$message=  "Error in updating Record";
		$activity= "Error in updating Record";
	}
	//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//mysql_query($iSQL);
	}
	 $ph_cap="";
	$lcid="";
	$date_p="";
	$al_file='';

	
	header("Location: pictorial_form.php");
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
  <title>Pictorial form</title>
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
   /* .col-sm-8{
      text-align: center;
      background-color:lavender;
      display: block;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
    } */

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

    thead {
		text-align: center;	
	}

	tbody {
		text-align: center;	
	}

  button.hidden {
		display: none;
	}
  table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }

    /* form{
      text-align: center;
    } */
</style>
<script type="text/javascript">
	
   $(function() {
    $( "#date_p" ).datepicker();
  });

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
	

function getCanals(lid)
{
	
	if (lid!=0) {
			var strURL="<?php echo SITE_URL; ?>findcanal_p.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("canal_div").innerHTML=req.responseText;						
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
  
  
  
  
  
  function required(){
	
	var x =document.getElementById("ph_cap").value;
	var y=document.getElementById("canal_name").value;
	var z=document.getElementById("date_p").value;
	var al_file=document.getElementById("al_file").value;
	var al_file_old=document.getElementById("al_file_old").value;
	
	 if (x == 0) {
    alert("Select Component First");
    return false;
  		}
		 if (y == 0) {
    alert("Select Sub Component First");
    return false;
  		}
		if (z == "") {
    alert("Select Date first");
    return false;
  		}
		if (al_file == "" && al_file_old=="") {
    alert("Select file first");
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

<div class="container-fluid">
<div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #fff, #c9c9f5);">
                <div class="card-body text-center">
                  <h4 class="card-title">Upload Photos/Videos</h4>

                  <form class="forms-sample" action="#" method="post" id="frm" enctype="multipart/form-data" onsubmit="return required();" >
                    <div class="form-group row">
                        <div class="text-center col-sm-4"><?php echo $message; ?> </div>
                          <div class="text-center col-sm-4">
                          <label for="exampleSelectGender" style="font-weight: bold;margin-top:25px">Select Component</label>
                          <?php echo $message;?>
                          <select id="ph_cap" name="ph_cap" onchange="getCanals(this.value)" style="font-size: 14px; color: #000;background-color: #fff;"  class="form-control">
     <option value="0"><?php echo "SelectComponent"; ?></option>
  		<?php $pdSQL = "SELECT lid, pid, album_name, user_right, user_ids FROM  t031project_albums WHERE parent_album=0 and pid=".$pid." order by lid";
						 $pdSQLResult = $objDb1->dbQuery($pdSQL);
						$i=0;
							  if($objDb1-> totalRecords()>=1)
							  {
							  while($pdData = $objDb1->dbFetchArray())
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["album_name"];?></option>
   <?php }
   else
   {
	   
								$u_rightr=$pdData['user_right'];			
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
                                  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["album_name"];?></option>
                                  <?php
								  }
						}
				}
							
	   
   }} 
   }?>
  </select>
                          
                            
                          </div>
                          <div class="text-center col-sm-4"></div>
                    </div>

                    <div class="form-group row">
                        <div class="text-center col-sm-4"> </div>
                          <div class="text-center col-sm-4">
                          <label  style="font-weight: bold;margin-top:25px">Select Sub Component</label>
                            <div id="canal_div">
                          <select id="canal_name" name="canal_name" style="font-size: 14px; color: #000;background-color: #fff;"  class="form-control" >
     	<option value="0"><?php echo "Select Sub Component"; ?></option>
  		<?php
		//echo "jfdghjdfh".$lcid; 
		 if(isset($lcid) )
	 {
		
		
		echo $pdSQL = "SELECT lid,lcid,title FROM  locations_component  WHERE pid=".$pid." and lid=".$ph_cap;
	
	 
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb-> totalRecords()>=1)
							  {
							  while($pdData =  $objDb->dbFetchArray())
							  { 
							  $i++;
							  
							  ?>
                              
  <option value="<?php echo $pdData["lcid"];?>" <?php if($lcid==$pdData["lcid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php
   } 
 }
   }
   else
   {
   }?>
  </select>
                            </div>
                          </div>
                          <div class="text-center col-sm-4"></div>
                    </div>


                    <div class="form-group row">
                        <div class="text-center col-sm-4"> </div>
                          <div class="text-center col-sm-4">
                          <label for="" style="font-weight: bold;margin-top:25px">Select Date</label>
                        <input type="date" name="date_p" id="date_p"  class="form-control" value="<?php 
  if(isset($date_p)&&$date_p!=""&&$$date_p!="0000-00-00"&&$date_p!="1970-01-01")
						  {
							  echo date('Y-m-d',strtotime($date_p));
						  }
						  else
						  {
						  }?>"/>
                          </div>
                          <div class="text-center col-sm-4"></div>
                    </div>

                    <div class="form-group row">
                        <div class="text-center col-sm-3"> </div>
                          <div class="text-center col-sm-6">
                          <label for="" style="font-weight: bold;margin-top:25px">Choose File</label>
                          <input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>"  class="form-control custom-file"/>
  <input  type="hidden" name="al_file_old" id="al_file_old" value="<?php echo $al_file; ?>" />
                      <!--<input type="file"  class="form-control custom-file" id="al_file" name="al_file" required>-->
                          </div>
                          <div class="text-center col-sm-3"></div>
                    </div>
                    <input type="hidden" class="form-control" name="pvid" id='pvid' required value='0' placeholder="">
					<?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />

     <button type="submit" class="btn btn-primary me-2" name="update" id="update" style="width:20%"><?php echo UPDATE;?></button> 
	 <?php
	 }
	 else
	 {
	 ?>
	<button type="submit" class="btn btn-primary me-2" name="save" id="save" style="width:20%"><?php echo SAVE;?></button> 
	 <?php
	 }
	 ?>  
                    <button class="btn btn-light" type="button" style="width:20%" onclick="javascript:window.close()">Cancel</button>
                  </form>
                </div>
              </div>
            </div> <!--grid-margin stretch-card  -->
            
  <div class="row">

    <div class="col-sm-12" style="" id="tworow">
    <table class="table table-hover" id='table'>
     <thead>
                                   <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th  style="text-align:center; vertical-align:middle">#</th>
                                  <th  width="20%" style="text-align:left"><?php echo "Component";?></th>
                                 <th  width="30%" style="text-align:left"><?php echo "Sub Component";?></th>
                                  <th  style="text-align:center"><?php echo PHOTO;?></th>
								 <th  style="text-align:left"><?php echo DATE;?></th>
								  <th  style="text-align:center"><?php echo ACTION;?></th>
								
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							$pdSQL_r = "SELECT lid, pid, album_name, user_right, user_ids FROM  t031project_albums  WHERE parent_album=0 order by lid";
						 $pdSQLResult_r = $objDb->dbQuery($pdSQL_r);
						$j=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData_r = $objDb->dbFetchArray())
							  { 
							  $lid=$pdData_r['lid'];
							  $j++;
							  if($_SESSION['ne_user_type']==1)
			{
							
						$pdSQL = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.lid FROM  project_photos a inner join locations_component b 
						on(a.lcid=b.lcid) WHERE a.pid=".$pid." and a.ph_cap=".$lid." order by phid";
						 $pdSQLResult =$objDb1->dbQuery($pdSQL);
						$i=0;
							  if($objDb1->totalRecords()>=1)
							  {
							  while($pdData = $objDb1->dbFetchArray())
							  { 
							  $i++;
							  
							
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData_r['album_name'];?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path."/thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                       
						   <td align="right">
                           <span style="float:left">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form>
                           </span>
                           <span style="float:right">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo 'Are you sure, you want to delete this photo';?>')" /></form>
						   
						   </span></td>
                        </tr>
						<?php
							  }
							  }
			}
			
			else
			{
				$u_rightr=$pdData_r['user_right'];			
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
							
						$pdSQL = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.lid FROM  project_photos a inner join locations_component b 
						on(a.lcid=b.lcid) WHERE a.pid=".$pid." and a.ph_cap=".$lid." order by phid";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  $i++;
							
							?>
                            <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData_r['title'];?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path."/thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                          <td align="right">
                          <?php  if($read_right==1 || $read_right==3)
								  {
								   ?>
                           <span style="float:left">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form>
                           </span>
                           <?php
								  }
								  ?>
                                  <?php  if($read_right==3)
								  {
								   ?>
                           <span style="float:right">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo DEL;?>')" /></form>
						   
						   </span>
                           <?php
								  }
								  ?></td>
                       
						   
                        </tr>
                            <?php
							  }
							  }
						}
				}
							
			}
							  
						}
						}else
						{
						?>
						<tr>
                          <td colspan="6" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
</table>

</div>
  </div>
</div>





<?php /*?><div id="content" style="width:650px; background-color:#E0E0E0">
<!--<h1> Pictorial Analysis Control Panel</h1>-->
<table align="center">
  <tr >
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo PHOTO_VIDEO;?></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <div id="LoginBox" class="borderRound borderShadow" >
  <form action="pictorial_form.php" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required();">

  <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo "Component".$lcid;?>:</label></td>
  <td>
  <select id="ph_cap" name="ph_cap" onchange="getCanals(this.value)">
     <option value="0"><?php echo "SelectComponent"; ?></option>
  		<?php $pdSQL = "SELECT lid, pid, title, user_right, user_ids FROM  locations WHERE pid=".$pid." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php }
   else
   {
	   
								$u_rightr=$pdData['user_right'];			
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
                                  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                                  <?php
								  }
						}
				}
							
	   
   }} 
   }?>
  </select> 
   <?php if($_SESSION['ne_user_type']==1)
							{
								?>
<a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('component_form.php', '<?php echo PLOAD_PHOTO_BTN;?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo "Add Component";?></a>
							<?php
							}
							?></td>
  </tr>
  <tr><td><label>Sub Component: </label></td>
  <td>
  <div id="canal_div" >
  <select id="canal_name" name="canal_name" >
     	<option value="0"><?php echo "Select Sub Component"; ?></option>
  		<?php
		echo "jfdghjdfh".$lcid; 
		 if(isset($lcid) )
	 {
		
		
		echo $pdSQL = "SELECT lid,lcid,title FROM  locations_component  WHERE pid=".$pid." and lid=".$ph_cap;
	
	 
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  
							  ?>
                              
  <option value="<?php echo $pdData["lcid"];?>" <?php if($lcid==$pdData["lcid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php
   } 
 }
   }?>
  </select>
  &nbsp;
  <?php if($_SESSION['ne_user_type']==1)
							{
								?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('location_form.php', '<?php echo PLOAD_PHOTO_BTN;?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo "Add Sub Component";?></a>
  <?php
							}
							?>
                          
                          
  </div>
  </td></tr>
  <tr><td><label><?php echo DATE;?>:</label></td>
  <td><input type="text" name="date_p" id="date_p" value="<?php 
  if(isset($date_p)&&$date_p!=""&&$$date_p!="0000-00-00"&&$date_p!="1970-01-01")
						  {
							  echo date('d-m-Y',strtotime($date_p));
						  }?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo PHOTO;?>:</label></td>
  <td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" />
  <input  type="hidden" name="al_file_old" id="al_file_old" value="<?php echo $al_file; ?>" /></td>
  </tr>
  <tr><td colspan="2"> <?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />
     <input  type="submit" name="update" id="update" value="<?php echo UPDATE;?>" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />
	 <?php
	 }
	 ?>  <input  type="button" name="cancel" id="cancel" value="<?php echo CANCEL?>"   onclick="cancelButton();"/></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
  <table style="width:100%">
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table class="reference" style="width:100%" > 

    
                              <thead>
                                   <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th  style="text-align:center; vertical-align:middle">#</th>
                                  <th  width="20%" style="text-align:left"><?php echo "Component";?></th>
                                 <th  width="30%" style="text-align:left"><?php echo "Sub Component";?></th>
                                  <th  style="text-align:center"><?php echo PHOTO;?></th>
								 <th  style="text-align:left"><?php echo DATE;?></th>
								  <th  style="text-align:center"><?php echo ACTION;?></th>
								
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							$pdSQL_r = "SELECT lid,title,user_ids,user_right FROM  locations where	pid=".$pid;
						 $pdSQLResult_r = mysql_query($pdSQL_r);
						$j=0;
							  if(mysql_num_rows($pdSQLResult_r)>=1)
							  {
							  while($pdData_r = mysql_fetch_array($pdSQLResult_r))
							  { 
							  $lid=$pdData_r['lid'];
							  $j++;
							  if($_SESSION['ne_user_type']==1)
			{
							
						$pdSQL = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.lid FROM  project_photos a inner join locations_component b 
						on(a.lcid=b.lcid) WHERE a.pid=".$pid." and a.ph_cap=".$lid." order by phid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  
							
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData_r['title'];?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path."/thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                       
						   <td align="right">
                           <span style="float:left">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form>
                           </span>
                           <span style="float:right">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo 'Are you sure, you want to delete this photo';?>')" /></form>
						   
						   </span></td>
                        </tr>
						<?php
							  }
							  }
			}
			
			else
			{
				$u_rightr=$pdData_r['user_right'];			
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
							
						$pdSQL = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.lid FROM  project_photos a inner join locations_component b 
						on(a.lcid=b.lcid) WHERE a.pid=".$pid." and a.ph_cap=".$lid." order by phid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							
							?>
                            <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData_r['title'];?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path."/thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                          <td align="right">
                          <?php  if($read_right==1 || $read_right==3)
								  {
								   ?>
                           <span style="float:left">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form>
                           </span>
                           <?php
								  }
								  ?>
                                  <?php  if($read_right==3)
								  {
								   ?>
                           <span style="float:right">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo DEL;?>')" /></form>
						   
						   </span>
                           <?php
								  }
								  ?></td>
                       
						   
                        </tr>
                            <?php
							  }
							  }
						}
				}
							
			}
							  
						}
						}else
						{
						?>
						<tr>
                          <td colspan="6" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                        </div>
                        </td>
                        </tr>
  </table>
</div><?php */?>
</body>
</html>
<?php
	//$objDb  -> close( );
?>
