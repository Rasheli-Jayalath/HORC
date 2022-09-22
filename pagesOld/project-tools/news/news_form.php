<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
$objNews 		= new News();
/*if ($strusername==null  )
	{
		header("Location: ../../../index.php?init=3");
	}
else if ($newsadm_flag==0  and $newsentry_flag==0)
	{
		header("Location: ../../../index.php?init=3");
	}*/


//include("./fckeditor/fckeditor.php");
$news_path=NEWS_PATH;
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST")
{

		 $title 		= trim($_POST['title1']);
		 $newsdate 		= date('Y-m-d',strtotime($_POST['newsdate']));
		 $details 		= trim($_POST['details']);
		 $status 		= trim($_POST['status']);
		 $newsfile      = $_FILES['newsfile'];
		 $old_news_file =trim($_POST['old_news_file']);
		 $newsfile1		=$_FILES['newsfile1'];
		 $old_news_file1=trim($_POST['old_news_file1']);
		  $newsfile2	=$_FILES['newsfile2'];
		 $old_news_file2=trim($_POST['old_news_file2']);
		 $newsfile3	=$_FILES['newsfile3'];
		 $old_news_file3=trim($_POST['old_news_file3']);
		 $newsfile4	=$_FILES['newsfile4'];
		 $old_news_file4=trim($_POST['old_news_file4']);
		$news_cd = ($_POST['mode'] == "U") ? $_POST['news_cd'] : $objAdminUser->genCode("rs_tbl_news", "news_cd");		
		$objNews->setProperty("news_cd", $news_cd);
		$objNews->setProperty("title", $title);
		$objNews->setProperty("details", $details);
		$objNews->setProperty("newsdate", $newsdate);
		$objNews->setProperty("ordering", 1);		
		if(isset($_FILES["newsfile"]["name"])&&$_FILES["newsfile"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile);
		if(($_FILES["newsfile"]["type"] == "image/jpg")|| 
		($_FILES["newsfile"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile"]["type"] == "image/gif") || 
		($_FILES["newsfile"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file){
					@unlink(NEWS_PATH . $old_news_file);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile = $objImage->filename;
					$objNews->setProperty("newsfile",$newsfile);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if(isset($_FILES["newsfile1"]["name"])&&$_FILES["newsfile1"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile1);
		if(($_FILES["newsfile1"]["type"] == "image/jpg")|| 
		($_FILES["newsfile1"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile1"]["type"] == "image/gif") || 
		($_FILES["newsfile1"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file1){
					@unlink(NEWS_PATH . $old_news_file1);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile1 = $objImage->filename;
					$objNews->setProperty("newsfile1",$newsfile1);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if(isset($_FILES["newsfile2"]["name"])&&$_FILES["newsfile2"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile2);
		if(($_FILES["newsfile2"]["type"] == "image/jpg")|| 
		($_FILES["newsfile2"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile2"]["type"] == "image/gif") || 
		($_FILES["newsfile2"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file2){
					@unlink(NEWS_PATH . $old_news_file2);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile2 = $objImage->filename;
					$objNews->setProperty("newsfile2",$newsfile2);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if(isset($_FILES["newsfile3"]["name"])&&$_FILES["newsfile3"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile3);
		if(($_FILES["newsfile3"]["type"] == "image/jpg")|| 
		($_FILES["newsfile3"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile3"]["type"] == "image/gif") || 
		($_FILES["newsfile3"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file3){
					@unlink(NEWS_PATH . $old_news_file3);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile3 = $objImage->filename;
					$objNews->setProperty("newsfile3",$newsfile3);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		
		if(isset($_FILES["newsfile4"]["name"])&&$_FILES["newsfile4"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($news_path);
		$objImage->setImage($newsfile4);
		if(($_FILES["newsfile4"]["type"] == "image/jpg")|| 
		($_FILES["newsfile4"]["type"] == "image/jpeg")|| 
		($_FILES["newsfile4"]["type"] == "image/gif") || 
		($_FILES["newsfile4"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_news_file4){
					@unlink(NEWS_PATH . $old_news_file4);
						
					}
			if($objImage->uploadImage($news_cd)){
				
					$newsfile4 = $objImage->filename;
					$objNews->setProperty("newsfile4",$newsfile4);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		
	$objNews->setProperty("status", $status);	
		if($objNews->actNews($_POST['mode'])){
			if($_POST['mode']=='U')
			{
				$objCommon->setMessage('News item is updated successfully.','Info');
			}
			else
			{
			$objCommon->setMessage('News item is saved successfully.','Info');
			}
			print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";	
		}
	
	extract($_POST);
}
else
{
	if(isset($_GET['news_cd']) && !empty($_GET['news_cd']))
		$news_cd = $_GET['news_cd'];
	else if(isset($_POST['news_cd']) && !empty($_POST['news_cd']))
		$news_cd = $_POST['news_cd'];
	if(isset($news_cd) && !empty($news_cd))
	{
		$objNews->setProperty("news_cd", $news_cd);
		$objNews->lstNews();
		$data = $objNews->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <!-- <script>
  function required(){
	
	var x =document.getElementById("lid").value;
	var title =document.getElementById("title").value;
	var iss_no =document.getElementById("iss_no").value;
	var file =document.getElementById("newsfile").value;
	var old_file =document.getElementById("old_newsfile").value;
	
	 if (x == 0) {
    alert("Select Component First");
    return false;
  		}
		else if (title == '') {
    alert("Please Add Title!");
    return false;
  		}
		else if (iss_no == '') {
    alert("Please Add Issue Number!");
    return false;
  		}
		
  
  }
  </script> -->


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Input - Project News & Events </title>
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

 

    </style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.2/jquery-ui.min.js"></script>

  <script> 
$(document).ready(function () {
    var date = new Date();
    $('#date_input').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script> 



<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	/*var invid=frm.invid.value;
	var id_inv='paymentdate_'+invid;
	alert(id_inv);
	alert(invid);*/
	if(frm.title1.value == ""){
		msg = msg + "\r\n<?php echo "News Title is required field";?>";
		flag = false;
	}
	if(frm.newsdate.value == ""){
		msg = msg + "\r\n<?php echo "Date is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<script language="javascript" type="text/javascript">
function getXMLHTTP2() { //fuction to return the xml http object
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
function doDeleteNewsFile(news_cd,image,name) {

		
			var strURL="<?php echo SITE_URL; ?>delete_image.php?news_cd="+news_cd+"&image="+image+"&name="+name;
		alert(strURL);
			var req = getXMLHTTP2();
				
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
						    document.getElementById('delete_'+name).innerHTML=req.responseText;	
						   						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
		
	}
</script>
</head>
<body>
<div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">

                <div class="row">
                      <div class="col-sm-4">       </div>
                      <div class="col-sm-4 text-end">     <h4 class="card-title ">  <?php echo ($mode == "U") ? 'News Edit' : 'News Add';?> </h4>   </div>
                      <div class=" col-sm-4">     </div>
                </div>
                
                 
				  <?php echo $message; ?>
          <form class="forms-sample pt-3" action=""  name="frmNews" id="frmNews" target="_self" method="post"  enctype="multipart/form-data" onSubmit="return frmValidate(this);" >
<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        	<input type="hidden" name="news_cd" id="news_cd" value="<?php echo $news_cd;?>" />
            <div class="row  pt-2 ">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  Title: </label>
                            <div class="col-sm-8 text-start"> 
                            <input class=" form-control"  type="text" name="title1" id="title1" value="<?php echo $title;?>" />
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> News Date : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control"  type="text" name="newsdate" id="date_input" value="<?php if($newsdate!="")
			echo date('Y-m-d',strtotime($newsdate));?>" autocomplete="off"/>
                            </div>
                          </div>
                        </div>
            </div>
         
            <div class="row pt-2 pb-3">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> Details  : </label>
                            <div class="col-sm-8 text-start">
                            <textarea class="form-control" rows="4" style=" height: 100px; "  name="details"> <?php echo $details; ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> Status : </label>
                            <div class="col-sm-8 text-start">
                            <label class="form-check-label" style="padding-left: 1%;">
                                  <input  type="radio" class="form-check-input"  id="" name="status" value="Y"  checked="checked"/> Active
                            </label>
                            <label class="form-check-label " style="padding-left: 10%;">
                                   <input  type="radio" class="form-check-input" id="" name="status" value="N"  <?php echo ($status == "N") ? "checked" : "";?> /> Inactive
                            </label>

                            </div>
                          </div>
                        </div>
            </div>

            <div class="row  pt-2 ">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  Upload Image 1 : </label>
                            <div class="col-sm-8 text-start">
                            <input type="file" name="newsfile" id="newsfile" class=" form-control  bg-light text-dark " />
            				<input type="hidden" name="old_news_file" value="<?php echo $newsfile;?>" />
                       
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> </label>
                            <div class="col-sm-8 text-start">
                            <div id="delete_newsfile">
                           <?php if($newsfile!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile;?>','newsfile');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }?>
                       </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  Upload Image 2 : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control  bg-light text-dark "  type="file" name="newsfile1" id="newsfile1"  />
                            <input type="hidden" name="old_news_file1" value="<?php echo $newsfile1;?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> </label>
                            <div class="col-sm-8 text-start">
                            <div id="delete_newsfile1">
                           <?php if($newsfile1!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile1 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile1 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile1;?>','newsfile1');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
                        </div>
                       
                            </div>
                          </div>
                        </div>
            </div>
            <div class="row  pt-2 ">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  Upload Image 3 : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control  bg-light text-dark "  type="file" name="newsfile2" id="newsfile2"  />
                              <input type="hidden" name="old_news_file2" value="<?php echo $newsfile2;?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"></label>
                            <div class="col-sm-8 text-start">
                            <div id="delete_newsfile2">
                             <?php if($newsfile2!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile2 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile2 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile2;?>','newsfile2');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
                        </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  Upload Image 4 : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control  bg-light text-dark "  type="file" name="newsfile3" id="newsfile3"  />
                             <input type="hidden" name="old_news_file3" value="<?php echo $newsfile3;?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  </label>
                            <div class="col-sm-8 text-start">
                            <div id="delete_newsfile3">
                          <?php if($newsfile3!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile3 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile3 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile3;?>','newsfile3');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
                        </div>
                            </div>
                          </div>
                        </div>
            </div>
            <div class="row pt-2">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  Upload Image 5 : </label>
                            <div class="col-sm-8 text-start">
                            
                            <input class=" form-control bg-light text-dark "  type="file" name="newsfile4" id="newsfile4"  />
                             <input type="hidden" name="old_news_file4" value="<?php echo $newsfile4;?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  </label>
                            <div class="col-sm-8 text-start">
                            <div id="delete_newsfile4">
                           <?php if($newsfile4!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile4 ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile4 ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile4;?>','newsfile4');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }
						?>
                        </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  </label>
                            <div class="col-sm-8 text-start">
                       
                            </div>
                          </div>
                        </div>
            </div>
               
   <button  type="submit" name="save" id="save" class="btn btn-primary me-2"  value="Save" style="width:20%"> Save </button>
   <button class="btn btn-primary me-2" type="button" style="width:20%" onclick="javascript:window.close()" > Cancel </button>

          </form>
                </div>
              </div>
            </div>

				
			<div id="search"></div>
			<div id="without_search"></div>
</div>


</body>
</html>



