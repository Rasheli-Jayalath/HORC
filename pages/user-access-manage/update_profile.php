<?php

include_once("../../config/config.php");
require_once('../../rs_lang.admin.php');
require_once('../../rs_lang.eng.php');
$objDb  		    = new Database();
$objCommon 	  	= new Common();
$objAdminUser 	= new AdminUser();
$objNews 	    	= new News();
$superadmin 	= $_SESSION['ne_sadmin'];
$news_flag 		= $_SESSION['ne_news'];
$newsadm_flag 	= $_SESSION['ne_newsadm'];
$newsentry_flag = $_SESSION['ne_newsentry'];
$strusername 	= $_SESSION['ne_username'];

if($superadmin==0)
{
header("Location: ../../index123.php?init=3");
}
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$flag 			= true;
	$first_name		= trim($_POST['first_name']);
	$username		= trim($_POST['username']);
	$last_name 		= trim($_POST['last_name']);
	$passwd 		= trim($_POST['passwd']);
	$email_old 		= trim($_POST['email_old']);
	$email 			= trim($_POST['email']);
	$designation	= trim($_POST["designation"]);
	$phone 			= trim($_POST['phone']);
	$mode 			= trim($_POST['mode']);
	$sadmin			= $_POST["sadmin"];
	$news			= $_POST["news"];
	$newsadm 		= $_POST['newsadm'];
	$newsentry 		= $_POST['newsentry'];
	
	$res			= $_POST["res"];
	$resadm 		= $_POST['resadm'];
	$resentry 		= $_POST['resentry'];
	
	
	$mdata			= $_POST["mdata"];
	$mdataadm 		= $_POST['mdataadm'];
	$mdataentry 	= $_POST['mdataentry'];
	$mile			= $_POST["mile"];
	$mileadm 		= $_POST['mileadm'];
	$mileentry 		= $_POST['mileentry'];
	$spg			= $_POST["spg"];
	$spgadm 		= $_POST['spgadm'];
	$spgentry 		= $_POST['spgentry'];
	
	$spln			= $_POST["spln"];
	$splnadm 		= $_POST['splnadm'];
	$splnentry 		= $_POST['splnentry'];
	
	$kpi			= $_POST["kpi"];
	$kpiadm 		= $_POST['kpiadm'];
	$kpientry 		= $_POST['kpientry'];
	
	$cam			= $_POST["cam"];
	$camadm 		= $_POST['camadm'];
	$camentry 		= $_POST['camentry'];
	
	$boq			= $_POST["boq"];
	$boqadm 		= $_POST['boqadm'];
	$boqentry 		= $_POST['boqentry'];
	
	$ipc			= $_POST["ipc"];
	$ipcadm 		= $_POST['ipcadm'];
	$ipcentry 		= $_POST['ipcentry'];
	
	$eva			= $_POST["eva"];
	$evaadm 		= $_POST['evaadm'];
	$evaentry 		= $_POST['evaentry'];
	
	$padm			= $_POST["padm"];
	/*$issueAdm		= $_POST["issueAdm"];*/
	
	$actd 			= $_POST['actd'];
	
	$miled 			= $_POST['miled'];
	
	$kpid 			= $_POST['kpid'];
	
	$camd 			= $_POST['camd'];
	
	$kfid 			= $_POST['kfid'];
	
	$evad 			= $_POST['evad'];
	
	
	if($sadmin==1)
	{
		$user_type=1;
	}
	else
	{
		$user_type=2;
	}
	
	
	
	/*$designation= trim($_POST['designation']);*/
	/*if(isset($_POST['user_type'])&&$_POST['user_type']!="")
	 $user_type= trim($_POST['user_type']);*/
	
	if(empty($first_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_FIRSTNAME,'Error');
	}
	if(empty($last_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_LASTNAME,'Error');
	}
	
	if(empty($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_EMAIL,'Error');
	}
	/*if(!$objValidate->checkEmail($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_INVALID_EMAIL,'Error');
	}*/
	# Check whether the email address is changed.
	if($email_old != $email){
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->checkAdminEmailAddress();
		if($objAdminUser->totalRecords() >= 1){
			$flag 	= false;
			$objCommon->setMessage(USER_FLD_MSG_EXISTS_EMAIL,'Error');
		}
	}
	if($flag != false){
		$user_cd = ($mode == "U") ? $_POST['user_cd'] : 
		$objAdminUser->genCode("mis_tbl_users", "user_cd");
		
		$objAdminUser->resetProperty();
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->setProperty("username", $username);
		$objAdminUser->setProperty("passwd", $passwd);
		$objAdminUser->setProperty("first_name", $first_name);
		/*$objAdminUser->setProperty("middle_name", $middle_name);*/
		$objAdminUser->setProperty("last_name", $last_name);
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->setProperty("phone", $phone);
		$objAdminUser->setProperty("designation", $designation);
		if($objAdminUser->ne_sadmin==1)
		{
			 
		$objAdminUser->setProperty("user_type", $user_type);
		$objAdminUser->setProperty("sadmin", $sadmin);
		$objAdminUser->setProperty("news", $news);
		$objAdminUser->setProperty("newsadm", $newsadm);
		$objAdminUser->setProperty("newsentry", $newsentry);
		
		$objAdminUser->setProperty("res", $res);
		$objAdminUser->setProperty("resadm", $resadm);
		$objAdminUser->setProperty("resentry", $resentry);
		
		$objAdminUser->setProperty("mdata", $mdata);
		$objAdminUser->setProperty("mdataadm", $mdataadm);
		$objAdminUser->setProperty("mdataentry", $mdataentry);
		$objAdminUser->setProperty("mile", $mile);
		$objAdminUser->setProperty("mileadm", $mileadm);
		$objAdminUser->setProperty("mileentry", $mileentry);
		
		$objAdminUser->setProperty("spg", $spg);
		$objAdminUser->setProperty("spgadm", $spgadm);
		$objAdminUser->setProperty("spgentry", $spgentry);
		
		$objAdminUser->setProperty("spln", $spln);
		$objAdminUser->setProperty("splnadm", $splnadm);
		$objAdminUser->setProperty("splnentry", $splnentry);
		
		$objAdminUser->setProperty("kpi", $kpi);
		$objAdminUser->setProperty("kpiadm", $kpiadm);
		$objAdminUser->setProperty("kpientry", $kpientry);
		
		$objAdminUser->setProperty("cam", $cam);
		$objAdminUser->setProperty("camadm", $camadm);
		$objAdminUser->setProperty("camentry", $camentry);
		
		$objAdminUser->setProperty("boq", $boq);
		$objAdminUser->setProperty("boqadm", $boqadm);
		$objAdminUser->setProperty("boqentry", $boqentry);
		
		$objAdminUser->setProperty("ipc", $ipc);
		$objAdminUser->setProperty("ipcadm", $ipcadm);
		$objAdminUser->setProperty("ipcentry", $ipcentry);
		
		$objAdminUser->setProperty("eva", $eva);
		$objAdminUser->setProperty("evaadm", $evaadm);
		$objAdminUser->setProperty("evaentry", $evaentry);
		
		$objAdminUser->setProperty("padm", $padm);
		/*$objAdminUser->setProperty("issueAdm", $issueAdm);*/
		
		$objAdminUser->setProperty("actd", $actd);
		
		$objAdminUser->setProperty("miled", $miled);
		
		$objAdminUser->setProperty("kpid", $kpid);
		
		$objAdminUser->setProperty("camd", $camd);
		
		$objAdminUser->setProperty("kfid", $kfid);
		
		$objAdminUser->setProperty("evad", $evad);
		
		}
		
		
		
		//$objAdminUser->setProperty("user_type", $user_type);
		if($objAdminUser->actAdminUser($_POST['mode'])){
			
			if($mode=="U")
			{
			$objCommon->setMessage("User updated successfully",'Update');
			}
			else
			{
			$objCommon->setMessage("New User added successfully",'Info');
			}
			
				/*if($objAdminUser->user_type==1)
				redirect('./?p=user_mgmt');
				else
				redirect('./?p=user_mgmt');*/
				redirect('./user_mangement.php');	

		}
	}
	extract($_POST);
	
}
else{
if(isset($_GET['user_cd']) && !empty($_GET['user_cd']))
	{	
	 $user_cd = $_GET['user_cd'];
	if(isset($user_cd) && !empty($user_cd)){
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->lstAdminUser();
		$data = $objAdminUser->dbFetchArray(1);
		$mode	= "U";
		extract($data);

	}
	}
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.user_name.value != ""){
		qString += '&user_name=' + escape(frm.user_name.value);
	}
	document.location = '?p=user_mgmt' + qString;
}
</script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Management</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  
  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../css/scrollbarStyle.css" rel="stylesheet" />

 <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script language="javascript" type="text/javascript">
function frmValidate(frm){
	//alert("dfsf");
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.first_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_FIRSTNAME;?>";
		flag = false;
	}
	if(frm.last_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_LASTNAME;?>";
		flag = false;
	}
	if(frm.username.value == ""){
		msg = msg + "\r\n<?php echo 'User Name is the Required Field';?>";
		flag = false;
	}
	if(frm.passwd.value == ""){
		msg = msg + "\r\n<?php echo 'Password is the Required Field';?>";
		flag = false;
	}

	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
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
    background: rgba(0, 0, 0, 0) url("../../images/images/frame.png") no-repeat scroll 0 0;
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
/*table{
    border:  double ;

    }*/
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
}
	
.text_width_table{
	max-width: 350px;
    word-wrap: initial;
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

 
}


    </style>


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



    
<h4 class="text-center text-34" style="  letter-spacing: 4px"> User Management</h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-5 " style="  font-weight: 600;">  
	<?php echo ($mode == "U") ? USER_UPDATE_BRD : USER_ADD_BRD;?>
	</div>
    <div class="col-sm-7 text-end" >  
	

<!--<button type="button" class="col-sm-2 button-33" onclick="window.open('project_issues_input.php', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"> <?php echo ADD_NEW_REC;?> </button>-->
<button type="button" class="col-sm-2 button-33" onclick="location.href='user_mangement.php';" >  <?php echo "Back";?> </button>

	</div>
    
	
</div>
<div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center" >

              
                 
				<span style="color:red; font-weight:bold; font-size:16px"> <?php echo $objCommon->displayMessage();?></span>
		
		
        <br/>
          <form name="frmProfile" id="frmProfile" action="" method="post" onSubmit="return  frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="user_cd" id="user_cd" value="<?php echo $user_cd;?>" />

            <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo "First Name";?>:</label>
                            <div class="col-sm-8 text-start">
                            <input class="form-control"   autocomplete="off" type="text" name="first_name" id="first_name" value="<?php echo 
			$first_name;?>" maxlength="100"/> 
                           
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo "Last Name";?>: </label>
                            <div class="col-sm-8 text-start">
                            <input class="form-control"   autocomplete="off"  type="text" name="last_name" id=
			"last_name" value="<?php echo $last_name;?>" maxlength="100" />
                          
                           
                            </div>
                          </div>
                        </div>
            </div>
  
 
            <div class="row">
                       <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end">  <?php echo "User Name";?>:</label>
                            <div class="col-sm-8 text-start">
                            <input class="form-control"   autocomplete="off"  type="text" name="username" id="username"
			 value="<?php echo $username;?>" maxlength="100"/>
    
                            </div>
                          </div>
                        </div>
                        <?php
                        if($_SESSION['ne_sadmin']==1){?>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"> <?php echo "Password";?>: </label>
                            <div class="col-sm-8 text-start">
                           <input class="form-control"   autocomplete="off"  ype="text" name="passwd" id="passwd" 
			value="<?php echo $passwd;?>" maxlength="32" />
                            </div>
                          </div>
                        </div>
                        <?php
						}
						else
						{
							?>
							<input  type="hidden" name="passwd" id="passwd" 
			value="<?php echo $passwd;?>" />
            <?php
						}
						?>
            </div>
            <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo USER_FLD_EMAIL;?>:</label>
                            <div class="col-sm-8 text-start">
                            <input type="hidden" name="email_old" id="email_old" value="<?php 
			echo $email;?>" />
                            <input class="form-control"   autocomplete="off" type="text" name="email" id="email" value="<?php echo $email;?>"  maxlength="200"/> 
                           
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo "Designation";?>:</label>
                            <div class="col-sm-8 text-start">
                            <input class="form-control"   autocomplete="off"  name="designation" id="designation" value="<?php echo $designation;?>"   maxlength="255"/>
                          
                           
                            </div>
                          </div>
                        </div>
            </div>
            <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end"><?php echo USER_FLD_PHONE;?>:</label>
                            <div class="col-sm-8 text-start">
                            
                            <input class="form-control"   autocomplete="off" type="text" name="phone" id="phone" value
			="<?php echo $phone;?>"  maxlength="25"/> 
                           
                            </div>
                          </div>
                        </div>
                         <div class="col-md-6">
                        </div>
                        
                        
            </div>
   
            
                    
		
			<?php if($objAdminUser->ne_sadmin==1)
					{
					?>	
                    <div class="table-responsive">	
			 <table class="table table-striped" style="width:50%; margin-left:200px; text-align:left">
			<tr>
			<td >&nbsp;</td>
			<td colspan="7"  ><strong>Superadmin</strong></td>
			 </tr>
			 
		  <tr>
    <td align="right">&nbsp;</td>
    <td  valign="middle">Superadmin</td>
    <td   ><select class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black" name="sadmin" id="sadmin">
      <option value="0" <?php if ($sadmin==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($sadmin==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
  
    <td colspan="5">&nbsp;</td>
    </tr>
			
			 <tr>
			<td align="right">&nbsp;</td>
			<td colspan="7" ><strong>News</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td  valign="middle">News View</td>
    <td  ><select name="news" id="news" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($news==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($news==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td  valign="middle"  >News Admin</td>
    <td  ><select name="newsadm" id="newsadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($newsadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($newsadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td  align="right"  >News Entry</td>
    <td   ><select name="newsentry" id="newsentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($newsentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($newsentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	      <tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Manage Project</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle" >Project Admin</td>
    <td    ><select class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black" name="padm" id="padm">
      <option value="0" <?php if ($padm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($padm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
	</tr>
	
	<?php /*?><tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Manage Issues</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Issues Admin</td>
    <td    ><select name="issueAdm" id="issueAdm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($issueAdm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($issueAdm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
	</tr> <?php */?>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Resources</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Resource</td>
    <td    ><select name="res" id="res" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($res==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($res==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Resource Admin</td>
    <td  ><select name="resadm" id="resadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($resadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($resadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Resource Entry</td>
    <td    ><select name="resentry" id="resentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($resentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($resentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	
	 <tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Maindata</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Maindata </td>
    <td    ><select name="mdata" id="mdata" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($mdata==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mdata==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Maindata Admin</td>
    <td  ><select name="mdataadm" id="mdataadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($mdataadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mdataadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Maindata Entry</td>
    <td    ><select name="mdataentry" id="mdataentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($mdataentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mdataentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Schedule Progress</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Schedule progress</td>
    <td    ><select name="spg" id="spg" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($spg==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spg==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Schedule progress Admin</td>
    <td  ><select name="spgadm" id="spgadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($spgadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spgadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Schedule progress Entry</td>
    <td    ><select name="spgentry" id="spgentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($spgentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spgentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Schedule Planned</strong></td>
			
		  </tr>
	 <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Schedule planned</td>
    <td    ><select name="spln" id="spln" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($spln==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($spln==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Schedule planned Admin</td>
    <td  ><select name="splnadm" id="splnadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($splnadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($splnadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Schedule planned Entry</td>
    <td    ><select name="splnentry" id="splnentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($splnentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($splnentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Activity Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Act-D</td>
    <td    ><select name="actd" id="actd" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($actd==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($actd==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
     </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Milestone Data</strong></td>
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Milestone</td>
    <td    ><select name="mile" id="mile" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($mile==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mile==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Milestone Admin</td>
    <td  ><select name="mileadm" id="mileadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($mileadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mileadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Milestone Entry</td>
    <td    ><select name="mileentry" id="mileentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($mileentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($mileentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Milestone Dashboard</strong></td>
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>

    <td   valign="middle">Milestone-D</td>
    <td    ><select name="miled" id="miled" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($miled==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($miled==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>KPI Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">KPI</td>
    <td    ><select name="kpi" id="kpi" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($kpi==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpi==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >KPI Admin</td>
    <td  ><select name="kpiadm" id="kpiadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($kpiadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpiadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >KPI Entry</td>
    <td    ><select name="kpientry" id="kpientry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($kpientry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpientry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>KPI Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">KPI-D</td>
    <td    ><select name="kpid" id="kpid" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($kpid==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kpid==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>CAM Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">CAM</td>
    <td    ><select name="cam" id="cam" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($cam==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($cam==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >CAM Admin</td>
    <td  ><select name="camadm" id="camadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($camadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($camadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >CAM Entry</td>
    <td    ><select name="camentry" id="camentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($camentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($camentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>CAM Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">CAM-D</td>
    <td    ><select name="camd" id="camd" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($camd==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($camd==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>BOQ Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">BOQ</td>
    <td    ><select name="boq" id="boq" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($boq==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($boq==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >BOQ Admin</td>
    <td  ><select name="boqadm" id="boqadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($boqadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($boqadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >BOQ Entry</td>
    <td    ><select name="boqentry" id="boqentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($boqentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($boqentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>IPC Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">IPC</td>
    <td    ><select name="ipc" id="ipc" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($ipc==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ipc==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >IPC Admin</td>
    <td  ><select name="ipcadm" id="ipcadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($ipcadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ipcadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >IPC Entry</td>
    <td    ><select name="ipcentry" id="ipcentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($ipcentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ipcentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>IPC Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">KFI-D</td>
    <td    ><select name="kfid" id="kfid" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($kfid==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($kfid==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>EVA Data</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">EVA</td>
    <td    ><select name="eva" id="eva" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($eva==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($eva==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >EVA Admin</td>
    <td  ><select name="evaadm" id="evaadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($evaadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($evaadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >EVA Entry</td>
    <td    ><select name="evaentry" id="evaentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($evaentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($evaentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>EVA Dashboard</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">EVA-D</td>
    <td    ><select name="evad" id="evad" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($evad==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($evad==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr>
	
	<?php /*?><tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Pictorial Analysis</strong></td>
			
		  </tr><?php */?>
		  <?php /*?><tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Pictorial Analysis</td>
    <td    ><select name="pic" id="pic" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($pic==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($pic==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    
    </tr><?php */?>
	
	
	
	<!--<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Maps and Drawings</strong></td>
			
		  </tr>-->
		  <?php /*?><tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Drawings</td>
    <td    ><select name="draw" id="draw" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($draw==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($draw==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    
    </tr><?php */?>
	<?php /*?><tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Non Confirmity Notices</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Non Confirmity Notices</td>
    <td    ><select name="ncf" id="ncf" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($ncf==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($ncf==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Design Progress</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Design Progress</td>
    <td    ><select name="dp" id="dp" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($dp==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($dp==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="85" valign="middle"  >Design Progress Admin</td>
    <td  ><select name="dpadm" id="dpadm" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($dpadm==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($dpadm==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    <td width="84" align="right"  >Design Progress Entry</td>
    <td    ><select name="dpentry" id="dpentry" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($dpentry==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($dpentry==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
   
    <td>&nbsp;</td>
    </tr>
	
	<tr>
			<td align="right">&nbsp;</td>
			<td colspan="7"  ><strong>Process</strong></td>
			
		  </tr>
		  <tr>
    <td align="right">&nbsp;</td>
    <td   valign="middle">Process</td>
    <td    ><select name="process" id="process" class="form-control form-control-sm"  style="width:80px; height:35px; background-color:#FFF; color:black">
      <option value="0" <?php if ($process==0) {echo "selected='selected'";} ?>>Deny</option>
      <option value="1" <?php if ($process==1) {echo "selected='selected'";} ?>>Allow</option>
    </select></td>
    </tr><?php */?>
			</table>
            </div>
			<?php
			}
			?>
             <button  type="submit" name="save" id="save" class="btn btn-primary me-2"  value="<?php echo ($mode == "U") ? " Update " : " Save ";?>" style="width:20%"><?php echo ($mode == "U") ? " Update " : " Save ";?> </button>
   <button class="btn btn-primary me-2" type="button"  style="width:20%" onClick="document.location='user_mangement.php';" >Cancel</button>
			
	           
            

               
            

          </form>
                </div>
              </div>
            </div>

</div>






         </div><!-- class="content-wrapper" -->

   
        <!-- partial:../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <!-- <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/chart.js"></script>
  <!-- <script src="../../js/navtype_session.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


  <!-- End custom js for this page-->



  <script>
    $(function(){
      $("#partials-navbar").load("../../partials/_navbar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-theme-setting-wrapper").load("../../partials/_settings-panel.php");
  });
</script>

<script>
  $(function(){
    $("#partials-sidebar-offcanvas").load("../../partials/_sidebar.php");
  });
</script>

<script>
$(function(){
  $("#partials-footer").load("../../partials/_footer.php");
});
</script>


<script language="javascript" type="text/javascript">



</script>



</body>
</html>