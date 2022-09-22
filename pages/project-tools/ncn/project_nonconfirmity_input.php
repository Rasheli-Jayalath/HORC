<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
//$log_id = $_SESSION['log_id'];
$log_id = 1;
$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$objCSDb  		= new Database( );

$_SESSION['ne_user_type']=1;
$user_cd=1;
$msg						= "";
 $pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
$pid=$pData["pid"];
$file_path="ncn_files/";
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
function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);

    return $res;
}

if(isset($_REQUEST['save']))
{
	
	$iss_no=$_REQUEST['iss_no'];
	$iss_title=	RemoveSpecialChar($_REQUEST['iss_title']);
	$iss_detail=RemoveSpecialChar($_REQUEST['iss_detail']);
	$iss_status=$_REQUEST['iss_status'];
	$iss_action=RemoveSpecialChar($_REQUEST['iss_action']);
	$iss_remarks=RemoveSpecialChar($_REQUEST['iss_remarks']);
	$lid=$_REQUEST['lid'];
	$message="";
	$pgid=1;
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	 $file_name=genRandom(5)."-".$lid;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$flink=$file_name.".".$extension;
	  $target_file=$file_path.$flink;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['al_file']['tmp_name'], $target_file);	
	
	
	}
	}
	 $sql_r="INSERT INTO t013nonconformitynotice (pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks,attachment,lid) Values(".$pid.",'".$iss_no."', '".$iss_title."', '".$iss_detail."', '".$iss_status."', '".$iss_action."', '".$iss_remarks."', '".$flink."', '".$lid."')";
  $sql_pro=$objDb->dbQuery($sql_r);
  $insertid=$con->lastInsertId();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=$insertid." - New record for non confirmity added successfully";
} else {
    $message= "Error in adding record";
	$activity="Error in adding record";
	
}
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$objSDb->dbQuery($iSQL);
print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
	
	$iss_no='';
	$iss_title='';
	$iss_detail='';
	$iss_status='';
	$iss_action='';
	$iss_remarks='';
	$al_file='';
}
if(isset($_REQUEST['nos_id']))
{
$nos_id=$_REQUEST['nos_id'];

$pdSQL1="SELECT nos_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks, attachment, lid FROM t013nonconformitynotice  where pid = ".$pid." and  nos_id = ".$nos_id;

$objDb->dbQuery($pdSQL1);
$pdData1 = $objDb->dbFetchArray();

	$iss_no=$pdData1['iss_no'];
	$iss_title=$pdData1['iss_title'];
	$iss_detail=$pdData1['iss_detail'];
	$iss_status=$pdData1['iss_status'];
	$iss_action=$pdData1['iss_action'];
	$iss_remarks=$pdData1['iss_remarks'];
	$lid=$pdData1['lid'];
	$old_attachment=$pdData1['attachment'];
}
if(isset($_REQUEST['update']))
{
	
	$nos_id=$_REQUEST['nos_id'];
	$iss_no=$_REQUEST['iss_no'];
	$iss_title=RemoveSpecialChar($_REQUEST['iss_title']);
	$iss_detail=RemoveSpecialChar($_REQUEST['iss_detail']);
	$iss_status=$_REQUEST['iss_status'];
	$iss_action=RemoveSpecialChar($_REQUEST['iss_action']);
	$iss_remarks=RemoveSpecialChar($_REQUEST['iss_remarks']);
	$lid=$_REQUEST['lid'];
	$message="";
	$pgid=1;
	if($old_attachment){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path.$old_attachment);
				
			}
					
				}
				if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	 $file_name=genRandom(5)."-".$lid;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$flink=$file_name.".".$extension;
	 $target_file=$file_path.$flink;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['al_file']['tmp_name'], $target_file);	
	
	
	
	}
	$sql_pro="UPDATE t013nonconformitynotice SET iss_no='$iss_no', iss_title='$iss_title', iss_detail='$iss_detail',  iss_status='$iss_status',  iss_action='$iss_action', iss_remarks='$iss_remarks' , attachment='$flink' , lid='$lid'  where nos_id=$nos_id";
	}
	else
	{
$sql_pro="UPDATE t013nonconformitynotice SET iss_no='$iss_no', iss_title='$iss_title', iss_detail='$iss_detail',  iss_status='$iss_status',  iss_action='$iss_action', iss_remarks='$iss_remarks' , lid='$lid'  where nos_id=$nos_id";
	}
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Non Confirmity Record updated successfully";
	$activity=  $nos_id." - Photo Record updated successfully";
} else {
    $message= "Error in updating record";
	$activity= "Error in updating record";
}
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$objSDb->dbQuery($iSQL);
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Input - Non Conformity Notices</title>
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
table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 10px;
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




  <script>
  function required(){
	
	var x =document.getElementById("lid").value;
	
	var iss_no =document.getElementById("iss_no").value;
	var file =document.getElementById("al_file").value;
	var old_file =document.getElementById("old_al_file").value;
	
	 if (x == 0) {
    alert("Select Component First");
    return false;
  		}
		 if (iss_no == "") {
    alert("Add Notice Number");
    return false;
  		}
		if (file == "" && old_file=="" ) {
    alert("Please Upload file");
    return false;
  		}
  
  }
  </script>
</head>
<body>
<div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc); height: 100%;">
                <div class="card-body text-center">

                <div class="row">
                      <div class="col-sm-4">       </div>
                      <div class="col-sm-4 text-end">     <h4 class="card-title ">  Non Conformity Notices</h4>   </div>
                      <div class=" col-sm-4">     </div>
                </div>
                
                 
				  <?php echo $message; ?>
          <form class="forms-sample pt-3" action="project_nonconfirmity_input.php" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required();" >

            <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> <?php echo COMP; ?>: </label>
                            <div class="col-sm-8 text-start">
             <select class="form-control" style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);"  id="lid" name="lid" onchange="getDates(this.value)" >
						<option value="0"><?php echo COMP ?></option>
						<?php $pdSQL = "SELECT * FROM  structures WHERE pid=".$pid." order by lid";
										$objDb->dbQuery($pdSQL);
										$i=0;
											if($objDb-> totalRecords()>= 1)
											{
											while($pdData = $objDb->dbFetchArray())
											{ 
											$i++;
											if($_SESSION['ne_user_type']==1)
											{?>
				<option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
				<?php
											}
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
												<option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
												<?php
												}
										}
								}
											}
											} 
				}?>
				</select>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> <?php echo NON_CON_NOTE_NO;?>: </label>
                            <div class="col-sm-8 text-start">
							<input  type="text" name="iss_no"class="form-control" id="iss_no" value="<?php echo $iss_no; ?>" maxlength="100" />
                            </div>
                          </div>
                        </div>
            </div>
 
            <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo NON_CON_DETAIL;?>:</label>
                            <div class="col-sm-8 text-start">
							<textarea rows="4" style=" height: 100px; "  class="form-control" name="iss_title"><?php echo $iss_title; ?></textarea>
                            </div>
                          </div>
                        </div>

						<div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> <?php echo ACTION;?>: </label>
                            <div class="col-sm-8 text-start">
							<textarea rows="4" style=" height: 100px; "  class="form-control"name="iss_action"><?php echo $iss_action; ?></textarea>
   
                           </div>
                          </div>
                        </div>
                 
            </div>
  
 
            <div class="row">
                       <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> <?php echo RECT;?>:  </label>
                            <div class="col-sm-8 text-start">
							<textarea rows="4" style=" height: 100px; "  class="form-control"  name="iss_detail"><?php echo $iss_detail; ?></textarea>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo REMARKS?>:  </label>
                            <div class="col-sm-8 text-start">
							<textarea rows="4" style=" height: 100px; "  class="form-control" name="iss_remarks"><?php echo $iss_remarks; ?></textarea>
	
                           </div>
                          </div>
                        </div>
            </div>
            
            <div class="row">
                       <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  <?php echo ATTACH;?>:  </label>
                            <div class="col-sm-8 text-start">
							<input class="form-control"  type="file" name="al_file" id="al_file" value="<?php echo $old_attachment; ?>" /><br/>
                           
                            <input  type="hidden" name="old_al_file" id="old_al_file" value="<?php echo $old_attachment; ?>" />

						   </div>
                          </div>
                        </div>
                        
						<div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> <?php echo STATUS;?>: </label>
                            <div class="col-sm-8 text-start">
                            <label class="form-check-label" style="padding-left: 1%;">
                                  <input  type="radio" class="form-check-input"  id="iss_status" name="iss_status" value="1"  checked="checked"/> Pending
                            </label>
                            <label class="form-check-label " style="padding-left: 10%;">
                                   <input  type="radio" class="form-check-input" id="iss_status" name="iss_status" value="2"  <?php if($iss_status==2) echo 'checked="checked"';?> /> Closed
                            </label>
                  
                            </div>
                          </div>
                        </div>
            </div>
  
  

	<?php if(isset($_REQUEST['nos_id']))
	 {
		 
	 ?>
     <input type="hidden" name="nos_id" id="nos_id" value="<?php echo $_REQUEST['nos_id']; ?>" />
     <button  type="submit" name="update" class="btn btn-primary me-2" id="update" value="<?php echo UPDATE?>" style="width:20%"> Update</button>
	 <button class="btn btn-light" type="button" style="width:20%" ><a href="project_nonconfirmity_info.php" style="text-decoration: none; color: inherit">Cancel</a></button>

	 <?php
	 }
	 else
	 {
	 ?>
	 <button  type="submit" name="save" class="btn btn-primary me-2" id="save" value="<?php echo SAVE;?>" style="width:20%"> Save</button>
	 <button class="btn btn-light" type="button" style="width:20%" onclick="javascript:window.close()" >Cancel</button>
	
	<?php
	 }
	 ?>



          </form>
                </div>
              </div>
            </div>

				
			<div id="search"></div>
			<div id="without_search"></div>
</div>



</body>
</html>
<?php
	//$objDb  -> close( );
?>
