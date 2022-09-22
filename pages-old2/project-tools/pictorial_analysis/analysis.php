<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
$module		= "Pictorial Analysis";

$pic_flag			= $_SESSION['ne_pic'];
	$picadm_flag		= $_SESSION['ne_picadm'];
	$picentry_flag		=$_SESSION['ne_picentry'];
	$uid				= $_SESSION['ne_user_cd']; 
	$uname				= $_SESSION['ne_username'];
	$superadmin_flag 		= $_SESSION['ne_sadmin'];
if ($uname==null  ) {
header("Location: ../../../index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: ../../../index.php?init=3");
}	
$user_cd=$uid;


$defaultLang = 'en';


$edit			= $_GET['edit'];

$objDb  		= new Database( );
$objDb1  		= new Database( );
$objDb2  		= new Database( );

//@require_once("get_url.php");

$file_path="pictorial_data";
$data_url="photos/";
$user_cd=$uid;
$album_idd=$_REQUEST['album_id'];


 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = $objDb->dbQuery($pSQL);
						 $pData = $objDb->dbFetchArray();
						 $pid=$pData["pid"];

 $album_id=$_REQUEST['album_id'];
 if(isset($album_id)&&!empty( $album_id))
 {
  $pdSQL11="SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and  albumid = ".$album_id;
$pdSQLResult11 = $objDb1->dbQuery($pdSQL11);
$pdData11 = $objDb1->dbFetchArray();
$status=$pdData11['status'];
$album_name=$pdData11['album_name'];
 }
if(isset($_REQUEST['lid']))
{
$lid=$_REQUEST['lid'];

$pdSQL1="SELECT lid, pid, title FROM  locations  WHERE  lid = ".$lid;
$pdSQLResult1 = $objDb->dbQuery($pdSQL1);
$pdData1 = $objDb->dbFetchArray();

$title=$pdData1['title'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['lid'])&$_REQUEST['lid']!="")
{

 $objDb->dbQuery("Delete from  locations where lid=".$_REQUEST['lid']);
 header("Location: location_form.php");
}


 if($_REQUEST['date_p']!=0 && $_REQUEST['location']!=0 && $_REQUEST['canal_name']!=0 && $_REQUEST['date_p2']!=0)
  {
	 $lid= $_REQUEST['location'];
$pdSQLq = "SELECT a.phid, a.lcid,a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.lcid,b.lid FROM  project_photos a inner join locations_component b on(a.lcid=b.lcid) WHERE a.pid=".$pid;
		
		if(!empty($_REQUEST['location'])){
			$location = urldecode($_REQUEST['location']);
			$pdSQLq .=" AND ph_cap='".$location."'";
		}
		if(!empty($_REQUEST['canal_name'])){
			$canal = urldecode($_REQUEST['canal_name']);
			$pdSQLq .=" AND a.lcid='".$canal."'";
		}
		if(!empty($_REQUEST['date_p'])){
			$date_p = urldecode($_REQUEST['date_p']);
			$pdSQLq .=" AND (date_p='".$date_p."'";
		}
		if(!empty($_REQUEST['date_p2'])){
			$date_p2 = urldecode($_REQUEST['date_p2']);
			$pdSQLq .=" OR date_p='".$date_p2."' ) order by date_p DESC";
		}
		
  }



	//	echo $pdSQLq;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_submit"])){

	 	$files_download =$_POST['file_download'];
		
		$category=$_GET['album_id'];
		 if(isset($files_download)){ 
		$files_count=count($files_download); 
		 for($i=0;$i<$files_count;$i++)
		 {
		 $all_download[]=$files_download[$i];		
		 }
		 $out = '';
   $out .="album_name".",";
   $out .="ph_cap".",";
   $out .="al_file".",";
   $out .="\n";
		foreach ($all_download as $selected_file_id) {

 $getquery="SELECT album_id,album_name,ph_cap,al_file FROM  t027project_photos INNER JOIN  t031project_albums ON 
 (t027project_photos.album_id = t031project_albums.albumid) where album_id=$category and phid=$selected_file_id";
 $result=$objDb->dbQuery($getquery);
 $num_rows = $objDb-> totalRecords();

  $l = $objDb->dbFetchArray();
  
	$results[] = $l['al_file'];
   echo  $cat_name=preg_replace('/\s+/','_',$l['album_name']);
   echo $l['album_name'];
    $out.=$l['album_name'].",";
    $out.=str_replace(',','',$l['ph_cap']).",";	
	$out.="<a href='" .$l['al_file'] . "'>".$l['al_file']."</a> ,";
   
    $out .="\n";
 

}
}
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
$cat_name = str_replace(",", "_", $cat_name);
$cat_name = str_replace("*", "", $cat_name);
 $td = date('Y-m-d-h-m-s',time());
 $fname=genRandom(5).$td;
 $filename1 =$fname.".zip";
 // $f = fopen ("data/".$filename,'w+');
 // fputs($f, $out);
  //fclose($f);
  
  
  $zip = new ZipArchive();
   $filename = $site_path1."Zip/".$filename1;

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

$zip->addFromString("list-".$fname.".csv", $out);
$zip->addFromString("instructions.txt", " The list of downloaded files is provided as csv in this archive.\n");

//print_r($results);
foreach ($results as $file) {
//echo $file
$zip->addFile("photos/".$file,"/".$file);
}

echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();	

header('Content-Type: application/octet-stream');
header('Content-disposition: attachment; filename='.basename($filename1));
header('Content-Length: ' . filesize("Zip/".$filename1));
ob_clean();
flush();
readfile("Zip/".$filename1);
unlink("Zip/".$filename1);			


	
}	
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_submitv"])){

	 	$files_download1 =$_POST['file_downloadv'];
		$files_download=$files_download1[0];
		$category=$_GET['album_id'];
		 if(isset($files_download)){ 
		echo $getquery="SELECT album_id,v_cap,v_al_file FROM   t32project_videos INNER JOIN  t031project_albums ON 
 (t32project_videos.album_id = t031project_albums.albumid) where album_id=$category and vid=$files_download";
 $result=$objDb->dbQuery($getquery);
 $num_rows = $objDb->totalRecords();

  $l = $objDb->dbFetchArray(); 
		$fileName=$l['v_al_file'];
		$file="photos/".$fileName; 
		 if (file_exists($file)) {
			
			 
                    $mime = 'application/force-download';

                    header('Content-Type: '.$mime);

                    header('Content-Description: File Transfer');
                    header('Content-Disposition: attachment; filename='.$fileName);
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    ob_clean();
                    flush();
                    readfile($file);
                    exit;
                }
		 }
}
		
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pictorial Analysis</title>
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
  <style>
        .margintopCSS {
          margin-top:10px;
        }   
        
        .text-34{
  background-color: #151563;
  border-radius: 10px;
  /* box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
  padding-bottom: 12px;
  padding-top: 12px;
  border-radius: 5px 5px;
  color: white;
  font-size: 100%;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


}
.new_div li {
    list-style: outside none none;
}
        
.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("../../../images/images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 130px;
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
.text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 0px 20px;
  color: white;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


}

.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:1%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 5px 2px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-33:hover {
  box-shadow: rgba(22, 22, 51,.35) 0 -25px 18px -14px inset,rgba(22, 22, 51,.25) 0 1px 2px,rgba(22, 22, 51,.25) 0 2px 4px,rgba(22, 22, 51,.25) 0 4px 8px,rgba(22, 22, 51,.25) 0 8px 16px,rgba(22, 22, 51,.25) 0 16px 32px;
  transform: scale(1.1) ;
}
.button-34 {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(26, 26, 125);
  color: #1a1a7d;
  /* box-shadow: rgba(34, 34, 199, .02) 0 -25px 18px -14px inset,rgba(34, 34, 199, .05) 0 1px 2px,rgba(34, 34, 199, .05) 0 2px 4px,rgba(34, 34, 199, .05) 0 4px 8px,rgba(34, 34, 199, .05) 0 8px 16px,rgba(34, 34, 199, .10) 0 16px 32px; */
  box-shadow: none;
  padding: 15px 1px;
  border-radius: 0px;
  font-size: 73%;

  font-weight: 900;
  margin-left:0%;
}
.button-34:hover {
  background-color: #1f1f91;
  color: #fff;
  font-weight: 900;
  font-size: 75%;
  transform: scale(1.05) ;
}
.button-35 {

  padding: 12px 2px;

  font-size: 73%;
  font-weight: 700;
  margin-left:0%;
}
.button-35:hover {
  transform: scale(1.0) ;
  font-size: 85%;
}
.sm-unLine {

  font-weight: 600;
  /* text-decoration-line: underline;
  text-decoration: underline solid #1f1f91 1px;
  text-underline-position: under; */
  
  /* border-bottom: 3px solid #f9dd94; */
 
}

/* .sm-unLine::after {
  content: "";
  display: block;

  padding-top: 3px;
  border-bottom: 2px solid #f9dd94;
} */

/* #u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145 );

  border-radius:10px 30px;
  padding:3.8px;
} */
 

    </style>


<script type="text/javascript">
function getGalleryView(month) 
	{
	
		var location=document.getElementById("location").value;  
			
		if (month!="") {
			var strURL="findGalleryView.php?date_p="+month+" &location="+location;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('Gallery_View').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}
function doFilter3(){
	var x = document.forms["forma"]["location"].value;
		var w = document.forms["forma"]["canal_name"].value;
			var y = document.forms["forma"]["date_p"].value;
				var z = document.forms["forma"]["date_p2"].value;

	
	 if (x == 0) {
    alert("Select Component First");
    return false;
  		}
		
		 if (w == 0) {
    alert("Select Sub Component First");
    return false;
  		}
		
	
	
	 if (y == 0) {
    alert("Select Date1");
    return false;
  		}
		
	
	
	 if (z == 0) {
    alert("Select Date2");
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
	
function getDates(lcid,lid)

{
	
	
	if (lcid!=0) {
			var strURL="finddate.php?lid="+lid+"&lcid="+lcid;
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
		else
		{
		
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
			
		}

}

function getCanals(lid)
{
	
	if (lid!=0) {
			var strURL="findcanal.php?lid="+lid;
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
<script>
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function atleast_onecheckboxv(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
  else if($("input[type=checkbox]:checked").length >1) {
      e.preventDefault();
      alert('You can Download only one video at a time');
      return false;
}
}
</script>
<script>
function selectAllUnSelectAll(chkAll, strSelecting, frm){
if(chkAll.checked == true){
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = true;
			}
		}
	}
	else{
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = false;
			}
		}
	}
}
function selectUnSelect_top(value,frm)
{
	
var checkboxes = document.getElementsByClassName("checkbox");
if(value.checked == false){
chkAll.checked =false;
}
if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length)
{
chkAll.checked =true;
}
}
</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>

  
<div class="container-scroller">
    
     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->
 
     <div class=" page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">


  <div class="row">
    <div class="col-sm-4">


    <div style="background-image: linear-gradient(180deg, #c9c9f5, white); padding: 20px ; border-radius: 15px; margin-right: -5px; ">
<?php
							  if($_SESSION['ne_user_type']==1)
							{
								?>
          <div class="row btn-group" style="align-content:center; padding-left: 5px;  padding-right: 2.5%; margin-bottom: 25px; margin-top: 10px; justify-content: center; width: 108%;">
          <button type="button" style="  width: 45%; border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-right: 2.5%; " class=" button-33 button-34" onclick="window.open('pictorial_form.php', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but1">Upload Photos</button>
          <button type="button"  style="  width: 45%; border-bottom-right-radius: 10px; border-top-right-radius: 10px;" class="button-33  button-34" onclick="window.open('location_form.php', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but1">Add Sub Component</button>
          <!-- <button type="button" class="btn btn-warning" onclick="location.href='pictorial_form.php'">Upload Photos</button> -->
          </div>
          <?php }
   else
   {
$pdSQL = "SELECT * FROM  structures WHERE pid=".$pid." order by lid";
						$pdSQLResult = $objDb1->dbQuery($pdSQL);
						
							  if($objDb1-> totalRecords()>=1)
							  {
							  while($pdData =$objDb1->dbFetchArray())
							  { 
							 
	   
	   
			$u_rightr=$pdData['pictorial_user_right'];			
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
							$flagg=1;
								  ?>
                                  <?php
								 								  }
								  
						}
				}
							
   
   }
   if($flagg==1)
   {
	   ?>
       <div class="row btn-group" style="align-content:center; padding-left: 5px;  padding-right: 2.5%; margin-bottom: 25px; margin-top: 10px; justify-content: center; width: 108%;">
          <button type="button" style="  width: 45%; border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-right: 2.5%; " class=" button-33 button-34" onclick="window.open('pictorial_form.php', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but1">Upload Photos</button>
          <button type="button"  style="  width: 45%; border-bottom-right-radius: 10px; border-top-right-radius: 10px;" class="button-33  button-34" onclick="window.open('location_form.php', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but1">Add Sub Component</button>
          <!-- <button type="button" class="btn btn-warning" onclick="location.href='pictorial_form.php'">Upload Photos</button> -->
          </div>
       <?php
   }
   } 
   }?>

  <div class="main">
   <form action="#"> 
<div class="form-group">
                      <label for="exampleSelectGender" style="font-weight: bold"><?php echo PIC_LOCATION ?>:</label>
                       <select style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);" onchange="getCanals(this.value)" class="form-control" id="location" name="location">
     	<option value="0"><?php echo "Select Component" ?></option>
  		<?php $pdSQL = "SELECT * FROM  structures WHERE pid=".$pid." order by lid";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb-> totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{
							  ?>
                              
  <option value="<?php echo $pdData["lid"];?>" <?php if($_REQUEST['location']==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
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
							
								  ?>
                                   <option value="<?php echo $pdData["lid"];?>" <?php if($location==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                                  <?php
								  
						}
				}
							
   
   }} 
   }?>
  </select>

                        <label for="exampleSelectGender" style="margin-top: 20px;font-weight: bold;">Select Sub Component</label>
                        <div id="canal_div">
                        <select id="canal_name" name="canal_name" onchange="getDates(this.value,<?php echo  $_REQUEST['location']; ?>)" class="form-control" style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);">
     	<option value="0"><?php echo "Select Sub Component"; ?></option>
  		<?php 
		 if(isset($_REQUEST['canal_name']) && isset($_REQUEST['location']))
	 {
		$canal= $_REQUEST['canal_name'];
		$location= $_REQUEST['location'];
		$pdSQL = "SELECT lid,lcid,title FROM  locations_component  WHERE pid=".$pid." and lid=".$location;
	
	 
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb-> totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  $i++;
							  
							  ?>
                              
  <option value="<?php echo $pdData["lcid"];?>" <?php if($canal==$pdData["lcid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php
   } 
 }
   }?>
  </select>
                            
                      

                        </div>
            </div>
            <div class="form-group">
                      <label for="" style="font-weight: bold"><?php echo COMP_DATES;?>:</label>
                      <div id="location_div" class="row" style=" justify-content: center;">
                     <select id="date_p" name="date_p"  class="form-control" style="width: 160px;font-size: 14px; color: #000;background-color: rgba(255, 255, 255);">
     <option value="0"><?php echo "Date1";?> </option>
     <?php 
	if(isset($_REQUEST['canal_name']) && isset($_REQUEST['location']))
	 {
		$canal= $_REQUEST['canal_name'];
		$location= $_REQUEST['location'];
		 $pdSQLdd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid."  and ph_cap=".$location." and lcid=".$canal." order by date_p  ASC";
	
		
  		
						 $pdSQLResultdd = $objDb1->dbQuery($pdSQLdd);
						$i=0;
							  if($objDb1-> totalRecords()>=1)
							  {
							  while($pdDatadd = $objDb1->dbFetchArray())
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatadd["date_p"];?>" <?php if($date_p==$pdDatadd["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatadd["date_p"]));?></option>
   <?php 
							  }} 
   }?>
  </select>
  <select id="date_p2" name="date_p2"   class="form-control" style="width: 160px;font-size: 14px; color: #000;background-color: rgba(255, 255, 255); margin-left: 10px;">
     <option value="0"><?php echo "Date2";?> </option>
     <?php 
	 
	if(isset($_REQUEST['canal_name']) && isset($_REQUEST['location']))
	 {
		$canal= $_REQUEST['canal_name'];
		$location= $_REQUEST['location'];
		 $pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." and ph_cap=".$location." and lcid=".$canal." order by date_p  ASC";

	 
	 
			
		
						 $pdSQLResultd = $objDb->dbQuery($pdSQLd);
						$i=0;
							  if($objDb-> totalRecords()>=1)
							  {
							  while($pdDatad = $objDb->dbFetchArray())
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["date_p"];?>" <?php if($date_p2==$pdDatad["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatad["date_p"]));?></option>
   <?php }
							  }
   }?>
  </select>
                      
                      </div>
                         
            </div>

  <div style="text-align: center;">
              <button type="submit" class="button-33 button-35" name="Submit" id="but2" style="margin-bottom: -25px; width:100%;" >View Results</button>
          </div>

          
          </form>


 
 

  

  <div style="vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px;" id="Gallery_View">

   <?php  if($_REQUEST['date_p']!=0 && $_REQUEST['location']!=0 && $_REQUEST['canal_name']!=0 && $_REQUEST['date_p2']!=0)
 {
	  
			 
			 $pdSQLResult = $objDb1->dbQuery($pdSQLq);
			if($objDb1-> totalRecords() >= 1){
			while($result = $objDb1->dbFetchArray())
			{
				 if($result['al_file']!="")
				{
			
				?>
                <strong><?php echo $result['title']."&nbsp; as on &nbsp;&nbsp;".date('d F, Y',strtotime($result['date_p'])); ?>:</strong>
                <a href="<?php echo $file_path."/".$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none">
                <img src="<?php echo $file_path."/thumb/".$result['al_file']; ?>" title="<?php echo date('d F, Y',strtotime($result['date_p'])); ?>"  style=" border:3px solid #000; border-radius:6px;margin-top:10px;"  width="270px" /></a>
			<br/><br/>
				 <?php 
				}
			}
				}
				
  } ?>       
 
</div>
</div>
</div>
</div>
<div class="col-sm-8" >
    <div class="" >
<h4 class="text-center text-34" style="  letter-spacing: 4px"> PHOTO / VIDEO ALBUMS <?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
	{?><button type="button" class="  col-sm-3 button-33" style="background-color:white; color:#151563; float:right; width:100px; margin-right:10px; margin-top:-3px" onclick="location.href='analysis.php'" id="but3"><?php echo VIEW_ALBUM; ?></button><?php } ?></h4> 

</div> 
   
    
    
    <div class="row " style="margin-right: -6%; margin-bottom:10px">
    <?php echo $message; ?>
    <form name="reports_cat" id="reports_cat" method="post" action="" onsubmit="return atleast_onecheckbox(event)"> </form>
   <form name="reports_catv" id="reports_catv" method="post" action="" onsubmit="return atleast_onecheckboxv(event)"> </form>
   <?php 
    if($_REQUEST['album_id']){
    ?>
<div class="row pt-2" style="margin-bottom:10px" >
  
<div class="col-sm-15 " style=" font-size:18px;  font-weight: bold; text-align:center">  
  <?php echo strtoupper($album_name) ;?>
</div>
</div>
<?php
	}
    if($_REQUEST['album_id']){
    ?>
<div class="row pt-2" style="margin-bottom:10px" >
  
<div class="col-sm-4 " style="  font-weight: 600;">  
  <?php //echo strtoupper($album_name) ;?>
</div>
<?php  //if($picentry_flag==1 || $picadm_flag==1)
	//{
			if($_SESSION['ne_user_type']==1)
			{
			
  ?>
<div class="col-sm-8 text-end" >  
    <button type="button" class="  col-sm-3 button-33" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Videos</button>
    <button type="button" class=" col-sm-3 button-33" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Photos</button>
    <button type="button" class="  col-sm-3 button-33" onclick="window.open('sp_subalbum_input.php?cat_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Albums</button>
    </div>
    <?php
   } 
   
else if($_REQUEST['album_id'])
{
	
$cattid=$_REQUEST['album_id'];
			$cqueryd = "select * from  t031project_albums  where albumid='$cattid'";
			$cresultd = $objDb->dbQuery($cqueryd);
			$cdatad = $objDb->dbFetchArray();
			$p_cdd=$cdatad['parent_album'];
			$pp_group=$cdatad['parent_group'];
			$arr_pp_group=explode("_",$pp_group);
			$getalbumid=$arr_pp_group[1];
			
			if($p_cdd==0)
			{
				
			?>
            
            <?php
			}
			else if($p_cdd!=0)
			{
			$cqueryd_r = "select user_right,user_ids from  t031project_albums  where albumid=$getalbumid";
			$cresultd_r = $objDb->dbQuery($cqueryd_r);
			$cdatad_r = $objDb1->dbFetchArray();	
			
			$u_right=$cdatad_r['user_right'];
			$arruright= explode(",",$u_right);
			$arr_right_users=count($arruright);		
			 foreach($arruright as $key => $val) 
			 	{
			   $arruright[$key] = trim($val);
			   $aright= explode("_", $arruright[$key]);
			    if($aright[0]==$user_cd)
						{
							if($aright[1]==1)
							{
							$read_right=1;
							?>
     <div class="col-sm-8 text-end" >  
    <button type="button" class="  col-sm-3 button-33" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Videos</button>
    <button type="button" class=" col-sm-3 button-33" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Photos</button>
    <button type="button" class="  col-sm-3 button-33" onclick="window.open('sp_subalbum_input.php?cat_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Albums</button>
    </div>
     <?php
							}
							else if($aright[1]==3)
							{
							$read_right=3;
							?>
                            <div class="col-sm-8 text-end" >  
    <button type="button" class="  col-sm-3 button-33" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Videos</button>
    <button type="button" class=" col-sm-3 button-33" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Photos</button>
    <button type="button" class="  col-sm-3 button-33" onclick="window.open('sp_subalbum_input.php?cat_id=<?php echo $album_id; ?>', 'newwindow', 'left=600,top=60,width=870,height=800');return false;" id="but3">Manage Albums</button>
    </div>
     
     <?php
							}
							else if($aright[1]==2)
							{
							$read_right=2;
							
							
							}
					     }
				}
			
			}
}
	//}
?>
    </div>
  <div class="row pt-2" style="margin-bottom:10px" >  
<table style=" width:96%; margin-left:20px; border:0px; padding:0px">

			<tbody>
            
              <tr>
              <td style="font-size:18px; font-weight:bold">
    <?php 
	
	$sqlss="select parent_group, status from t031project_albums where albumid=$album_id";
	$sqlrwss=$objDb->dbQuery($sqlss);
	$sqlrw1ss=$objDb->dbFetchArray();
	$par_groups=$sqlrw1ss['parent_group'];
	$status=$sqlrw1ss['status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$album_name_track="";
	/*$album_name_track .='
	<strong><a style="font-size:12px" href="analysis.php">'.PHOTO_VIDEO_ALBUM.'</a></strong>&nbsp;&raquo;&nbsp;	';*/
	for($i=0;$i<$lenns;$i++)
	{
	 $sqlCN="select album_name,parent_album from t031project_albums where albumid='$par_arr[$i]' ";
		
	$sqlrCN=$objDb1->dbQuery($sqlCN);
	$sqlCNrw=$objDb1->dbFetchArray();
	
		$category_name_lang=$sqlCNrw["album_name"];
	
	
	$album_name_track .='<strong><a style="font-size:12px" href="analysis.php?cat_id='.$sqlCNrw["parent_album"].'&album_id='.$par_arr[$i].'">'.$category_name_lang.'</a></strong>';
	
	$album_name_track .="&nbsp;&raquo;&nbsp;";
	
	//$category_name .=$category_name;
	}
   echo $report_category=$album_name_track;
   ?></td>
            </tr>

            <tr>
 <td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
  <?php $cm=0;
			 $pdSQL = "SELECT * FROM t031project_albums  WHERE pid= ".$pid." and status=1 and parent_album=".$album_id." order by album_order asc";
			 $pdSQLResult = $objDb->dbQuery($pdSQL);
		 $objDb->totalRecords();
			if($objDb->totalRecords() >= 1){
				
				while($result = $objDb->dbFetchArray()){
					
				$album_idn=$result['albumid'];
				$p_group=$result['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[1];
			  $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $pdSQLResult_get_right = $objDb1->dbQuery($pdSQL_get_right);
			 $result_get_right = $objDb1->dbFetchArray();
			 
				
				 $pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_idn." limit 0,1";
			 $pdSQLResult_r = $objDb2->dbQuery($pdSQL_r);
			if($objDb2-> totalRecords() >= 1)
			{
			
				$result_r = $objDb2->dbFetchArray();
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.png";
			}
				
				
	if($_SESSION['ne_user_type']==1)
			{
			?>		
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>

            <?php
			$cm++;
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
						
						
					
			
				?>
			<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>
    <?php
			$cm++;
			}
				}
				}
			
			}} ?>
            </td>
            </tr>
             <tr><td style="font-size:18px">&nbsp;</td></tr>
            <tr style="background: #CDCDCD; height:40px">
            <td style="font-size:18px; font-weight:bold; padding-left:3px; text-align:center">Photos
            <?php  $pdSQL1 = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
			 $pdSQLResult1 =$objDb1->dbQuery($pdSQL1);
			if($objDb1-> totalRecords() >= 1){ 
			
			?>
            <span style=" float:left; font-size:12px">
            <input style=" font-size:12px;"  type="checkbox" name="chkAll" id=
          "chkAll" value="1" form="reports_cat" onclick="selectAllUnSelectAll(this,'file_download[]',reports_cat);"/> Select/Unselect All &nbsp;&nbsp;&nbsp;&nbsp;</span><span>
          <input type="submit" name="download_submit" id="download_submit" value="Download Files" form="reports_cat"  class="  col-sm-3 button-33" style=" font-size:12px; float:right; margin-right:5px;width:120px" /></span>
           <?php
			}
			?>
            </td></tr>
  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
          
           <tr>
            <td  align="center" valign="top">
          
 <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
			 $pdSQLResult = $objDb->dbQuery($pdSQL);
			if($objDb-> totalRecords() >= 1){
				while($result = $objDb->dbFetchArray()){
				
				
				?>
				<?php if($result['al_file']!="")
				{
				$file_array=explode(".",$result['al_file']);
				$file_type=$file_array[1];
				if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png") || ($file_type=="JPG")|| ($file_type=="JPEG")|| ($file_type=="PNG") || ($file_type=="GIF")|| ($file_type=="jfif"))
				{
				?>
				<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:198px;margin-right:0px;">

	   <a  href=" <?php echo $data_url.$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" >
       
       
	<div style=" padding: 3px;margin-bottom: 3px;">	
	<img src="<?php //echo $data_url."thumb/".$result['al_file'];
	echo $data_url."thumb/".$result['al_file']; ?>"  border="0" width="150px" height="112px" title="<?php echo $result['al_file'];?>"/>
    </div>
	 	</a>
        <div align="center" class="imageTitle" style="padding-top:2px; font-weight:bold">
     <input type="checkbox" class="checkbox"    name="file_download[]"  value="<?php echo $result['phid'];?>" form="reports_cat" onclick="selectUnSelect_top(this,reports_cat);"/>
		<?php if(strlen($result['ph_cap'])>15)
		{
		echo substr($result['ph_cap'],0,15)."...";
		}
		else
		{
		echo $result['ph_cap'];
		} ?>				     </div>
	</div>

	
	
	
	</li>
	</div>
            <?php
				}
				
				}
				}
			}
			else
			{
			 echo NO_RECORD;?>
			<?php
			}?>
            </td></tr>
             <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
         <tr style="background: #CDCDCD; height:40px">
         <td style="font-size:18px; font-weight:bold; padding-left:3px; text-align:center"><span><?php echo VIDEOS; ?></span> 
         <?php  $pdSQL1 = "SELECT vid, pid,album_id,v_cap,v_al_file FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
			 $pdSQLResult1 = $objDb1->dbQuery($pdSQL1);
			if($objDb1->totalRecords() >= 1){ 
			
			?>
            <span style="float:left; width:120px;margin-top:10px">
	
	</span>
            <span><input type="submit" name="download_submitv" id="download_submitv" value="Download Files" form="reports_catv"  class="  col-sm-3 button-33" style=" font-size:12px; float:right; margin-right:5px;width:120px" />
  </span>
   <?php
			}
			?>
	</td></tr>
     <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
  <tr>
  <td align="center" valign="top">

   <table width="100%" style=" padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
    font-weight: bold;  margin: 0px;">
     <tbody><?php  
			
			 $cm=0;
			 $pdSQL = "SELECT vid, pid,album_id,v_cap,v_al_file FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
			 $pdSQLResult = $objDb->dbQuery($pdSQL);
			if($objDb->totalRecords() >= 1){
				while($result = $objDb->dbFetchArray()){
				
				if($cm==0 || $cm%6==0)
				{
				echo "<tr>";
				}?><td width="26%" style=" padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
    font-weight: bold;  margin: 0px;"><?php if($result['v_al_file']!="")
				{
				$file_array=explode(".",$result['v_al_file']);
				$file_type=$file_array[1];
				/*if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png"))
				{*/
				?>
                <div  style="float:left;width:198px;margin-right:0px;">
				 <a  href="javascript:void(null);" onclick="window.open('sp_video_large.php?video=<?php echo $result['v_al_file'];?>&vid=<?php echo $result['vid'];?>&album_id=<?php echo $album_id;?>', 'View Video ','width=700px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none"  alt="<?php echo $result['v_cap'];?>">
                 <img src="../../../images/video_file_icon.jpg" width="150" height="100" border="0"  title="<?php echo $result['v_al_file'];?>"/></a>
                 <div align="center" class="imageTitle" style="padding-top:2px; font-weight:bold">
       <input type="checkbox" class="checkboxv"    name="file_downloadv[]"  value="<?php echo $result['vid'];?>" form="reports_catv" onclick="selectUnSelect_topv(this,reports_catv);"/>
		<?php if(strlen($result['v_cap'])>15)
		{
		echo substr($result['v_cap'],0,15)."...";
		}
		else
		{
		echo $result['v_cap'];
		} ?>				     </div>
        </div>
			               
                 <?php
				 
				}?></td>
            <?php 
			$cm++;
			if($cm==6 || $cm%6==0)
			{
			echo "</tr>";
			}
			}}
			else
			{
				 echo NO_RECORD;
			}?>
                </tbody>
      </table>
  </td>
  </tr>
  </tbody>
		</table>
        </div>
        <?php
   } 
   else
{
   ?>
   <div class="row pt-2" style="margin-bottom:10px" >
   <table  style=" width:96%;margin:0px; border:0px; padding:0px">
			<tbody>
            <tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and status=1 and parent_album=0 order by album_order asc";
			 $pdSQLResult = $objDb1->dbQuery($pdSQL);
			if($objDb1-> totalRecords() >= 1){
				while($result =$objDb1->dbFetchArray()){
				$album_id=$result['albumid'];
				$pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 $pdSQLResult_r = $objDb->dbQuery($pdSQL_r);
			if($objDb-> totalRecords() >= 1)
			{
			
				$result_r = $objDb->dbFetchArray();
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.png";
			}
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
    <a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?>				     </div>
	</div>
	</li>
	</div>

            <?php 
			$cm++;
			
			}
			}?>
        </td>
		</tr>
		</tbody>
		</table>
        </div>
        <?php }?>
</div>
</div>
</div>
 <div id="partials-footer"></div>
</div>
</div>
</div>
</div>

  
   
 </div>
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <!-- <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- <script src="../../js/navtype_session.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


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

  <?php //include ("includes/footer.php"); ?>

</body>
</html>
<?php

?>
