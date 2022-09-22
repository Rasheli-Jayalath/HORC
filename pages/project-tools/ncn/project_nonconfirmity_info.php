<?php
/*error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Non Confirmity Notices";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($ncf_flag==0)
{
	header("Location: index.php?init=3");
}
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
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
$user_cd=$uid;
$pSQL = "SELECT max(pid) as pid from project";
$pSQLResult = mysql_query($pSQL);
$pData = mysql_fetch_array($pSQLResult);
$pid=$pData["pid"];*/
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
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );

//@require_once("get_url.php");
//$user_cd=$uid;
$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
//$pData = mysql_fetch_array($pSQLResult);
 $pid=$pData["pid"];
//$edit			= $_GET['edit'];
//$objDb  		= new Database( );
//@require_once("get_url.php");
$file_path="ncn_files/";
if(isset($_REQUEST['delete']))
{
	$nos_id=$_REQUEST['nos_id'];
	$sql="select attachment from t013nonconformitynotice where nos_id=".$_REQUEST['nos_id'];
	$objDb->dbQuery($sql);
	$res=$objDb->dbFetchArray();
	$al_file=$res['attachment'];
	@unlink($file_path.$al_file);
$objSDb->dbQuery("Delete from t013nonconformitynotice where nos_id=".$_REQUEST['nos_id']);
 $activity="Non Confirmity Record -".$_REQUEST['nos_id']."-  Deleted Successfully";
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('1','$activity')");
$objVSDb->dbQuery($iSQL);

}

//===============================================

 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.lid.value != ""){
		qString += 'lid=' + escape(frm.lid.value);
	}
	if(frm.iss_status.value != ""){
		qString += '&iss_status=' + escape(frm.iss_status.value);
	}
	
	document.location = 'project_issues_info.php?' + qString;
}


</script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Non Conformity Notices</title>
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
table{
   
	  border:  double ;
    }
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
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



<?php //include ('includes/metatag.php'); ?>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.lid.value != ""){
		qString += 'lid=' + escape(frm.lid.value);
	}
	if(frm.iss_status.value != ""){
		qString += '&iss_status=' + escape(frm.iss_status.value);
	}
	
	document.location = 'project_nonconfirmity_info.php?' + qString;
}


</script>
<!--<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>-->
</head>
<body>
  <div class="container-scroller">
     <!-- partial:partials/_navbar.html --><div id="partials-navbar"></div> <!-- partial -->
     <div class=" page-body-wrapper" id="pagebodywraper">
       <!-- partial:partials/_sidebar.html --> <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div><!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">
           <h4 class="text-center text-34" style="  letter-spacing: 4px"> Non Conformity Notices </h4> 

		   <!-- <div class="row pt-4 pb-4" >
					<div class="col-sm-2 " style="  font-weight: 600;">  </div>
					<div class="col-sm-10 text-end" >  
					<?php if($pid != ""&&$pid!=0){?>

				<button type="button" class="col-sm-2 button-33" onclick="window.open('project_nonconfirmity_input.php', 'newwindow', 'left=600,top=60,width=1000,height=800');return false;"> <?php echo ADD_NEW_REC;?> </button>
     			<?php } 

				?>
					</div>
		  </div> -->

      <div class="row pb-4 pt-5 text-end" >
      <form action="" target="_self" method="post"  enctype="multipart/form-data">
      <?php echo COMP; ?>:  <select id="lid" name="lid" onchange="getDates(this.value)" style="width:15%; margin-right: 1%;">
     	<option value=""><?php echo COMP ?></option>
  		<?php $pdSQLc = "SELECT * FROM  structures WHERE pid=".$pid." order by lid";
						 $objDb->dbQuery($pdSQLc);
						$i=0;
							   if($objDb-> totalRecords()>= 1)
							  {
							  while($pdDatac=$objDb->dbFetchArray())
							  { 
							  $i++;
							    if($_SESSION['ne_user_type']==1)
							{?>
  <option value="<?php echo $pdDatac["lid"];?>" <?php if($_REQUEST['lid']==$pdDatac["lid"]) {?> selected="selected" <?php }?>><?php echo $pdDatac["title"];?></option>
   <?php }
   else
   {
	   
			$u_rightr=$pdDatac['user_right'];			
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
                                   <option value="<?php echo $pdDatac["lid"];?>" <?php if($_REQUEST['lid']==$pdDatac["lid"]) {?> selected="selected" <?php }?>><?php echo $pdDatac["title"];?></option>
                                  <?php
								  
						}
				}
							
   }} 
   }?>
  </select> Status : <select id="iss_status" name="iss_status" style="width:15%;margin-right: 1%; ">>
  <option value="">Select Status</option>
  <option value="1" <?php if($_REQUEST["iss_status"]==1) {?> selected="selected" <?php }?>>Pending</option>
  <option value="2" <?php if($_REQUEST["iss_status"]==2) {?> selected="selected" <?php }?>>Closed</option>
  
  </select>
  
  <button type="button"  class=" col-sm-1 button-33 " style="background-color: Green;   border-radius: 4px; margin-right: 2%;"  onclick="doFilter(this.form);"  name="Submit" id="Submit" value=" <?php echo VIEW; ?> " > <?php echo VIEW; ?> </button>
          
  <?php if($pid != ""&&$pid!=0){?>

<button type="button" class="col-sm-2 button-33" onclick="window.open('project_nonconfirmity_input.php', 'newwindow', 'left=600,top=60,width=1200,height=650');return false;"> <?php echo ADD_NEW_REC;?> </button>
   <?php } 

?>
  </form>
      </div>
	  <div class="table-responsive shadow_table">  
      <table class="table issues_info table" width="100%" style="background-color:#FFF" cellspacing="0">
                              <thead>
                                <tr >
                                  <th width="5%" style="font-weight: 700; text-align:center; font-size:14px;"><?php echo "Serial No.";?></th>                                
                                  <th width="5%" style="font-weight: 700; text-align:center; font-size:14px;"><?php echo COMP;?></th>
                                  <th width="2%" style="font-weight: 700; text-align:center; font-size:14px; vertical-align:middle"> #</th>
                                  <th width="15%" style="font-weight: 700; text-align:center; font-size:14px;"><?php echo TITLE;?></th>
                                  <th width="28%" style="font-weight: 700; text-align:center;font-size:14px;"><?php echo DETAIL;?></th>
                                  <th width="10%" style="font-weight: 700; text-align:center;font-size:14px;"><?php echo ATTACH;?></th>
								  <th width="10%" style="font-weight: 700; text-align:center;font-size:14px;"><?php echo STATUS;?></th>
								    <th width="10%" style="font-weight: 700; text-align:center;font-size:14px;"><?php echo ACTION;?></th>
								  <th width="10%" style="font-weight: 700; text-align:center;font-size:14px;"><?php echo REMARKS;?></th>
								  <th width="10%" style="font-weight: 700; text-align:center;font-size:14px;" class="text-center"colspan="2"><?php echo ACTION;?></th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							     if(isset($_REQUEST['lid']) && $_REQUEST['lid']!="")
							 {
								  $compid=$_REQUEST['lid'];
								 $pdSQLcn = "SELECT * FROM  structures where lid=$compid";
							 }
							 else
							 {
								  $pdSQLcn = "SELECT * FROM  structures order by lid";
							 }
							 
						      $objDb->dbQuery($pdSQLcn);
							  $i=1;
							  while($compdata =$objDb->dbFetchArray())
							  {
								  
								 $cmpid= $compdata['lid'];
									 if($_SESSION['ne_user_type']==1)
									{
								  ?>
                                  <tr>
                          		<td colspan="11"  style="font-weight:bold; font-size:14; background: #b5b5f7"><?php echo $compdata["title"];?></td>
                        		</tr>
                                  <?php
									}
									else
									{
										
			$u_rightr=$compdata['user_right'];			
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
                                      <tr>
                          		<td colspan="11"  style="font-weight:bold; font-size:14; background: #b5b5f7"><?php echo $compdata["title"];?></td>
                        		</tr>
                           <?php
						   
						}
						 
				}
						   
									}
						
								 if(isset($_REQUEST['iss_status']) && $_REQUEST['iss_status']!="")
							 {
								  $status=$_REQUEST['iss_status'];
								  $pdSQL = "SELECT nos_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks, attachment, lid FROM t013nonconformitynotice where pid=$pid and lid=$cmpid and iss_status=$status";
							 }
							 else
							 { 
							 $pdSQL = "SELECT nos_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks, attachment, lid FROM t013nonconformitynotice where pid=$pid and lid=$cmpid";
							 }
							   $pdSQL .= " order by iss_no desc";
							$objSDb->dbQuery($pdSQL);
							  
							  
							  
							 if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData =$objSDb->dbFetchArray())
							  { 
							 
							  ?>
                              <?php  
							
                          if($_SESSION['ne_user_type']==1)
							{
				
							
								   ?>
                        <tr>
                        <td align="center" style="font-size:13px"><?php echo ++$counter; ?></td>                        
                        <td align="center" style="font-size:13px"><?php  echo $compdata["title"];
							  ?></td>
                          <td align="center" style="font-size:13px"><?php echo $pdData['iss_no'];?></td>
                          <td align="left" style="font-size:13px"><?php echo wordwrap($pdData['iss_title'],30,"<br>\n") ;?></td>
                          <td align="left" style="font-size:13px"><?php echo wordwrap($pdData['iss_detail'],30,"<br>\n") ;?></td>
                          <td align="center" style="text-align:center">
 <?php if($pdData['attachment']!="")
						  {
							  ?>
                          <a href="<?php echo "ncn_files/".$pdData['attachment'];?>" target="_blank">
                          <img src="../../../images/pdf.png" width="50" height="50"/></a>
<?php
}
?></td>
                          <td align="center" style="font-size:13px"><?php if($pdData['iss_status']==1) echo "Pending"; else echo "Closed";?></td>
                          <td align="left" style="font-size:13px"><?php echo wordwrap($pdData['iss_action'],30,"<br>\n") ; ?></td>
						  <td align="left" style="font-size:13px"><?php echo wordwrap($pdData['iss_remarks'],30,"<br>\n") ;?></td>						 
						    
						   <td align="center" style="font-size:13px; text-align:center">
						    <span style="float:right">
                            
                            
                             <button class="btn btn-outline-warning btn-fw px-1 py-1 "  href="javascript:void(null);" onClick="window.open('project_nonconfirmity_input.php?nos_id=<?php echo $pdData['nos_id'] ?>', 'Manage notices ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=""> <i class="ti-pencil btn-icon-prepend" ></i> </button>
                            </span>
						  
						   </td>					  
								    <td align="right">
						   <span style="float:right">
                           
                           
                           <form action="project_nonconfirmity_info.php?nos_id=<?php echo $pdData['nos_id'] ?>" method="post">
               <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw px-1 py-1 m-0" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" >
               <i class="ti-trash btn-icon-prepend" ></i> 
        					</button></form></span>
						    </td>
                            </tr>
						   <?php
						   
						  
						   }
						   else
						   {
			$u_rightr=$compdata['user_right'];			
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
                                      <tr>
                        <td align="center" style="font-size:13px"><?php echo ++$counter; ?></td>                        
                        <td align="center" style="font-size:13px"><?php  echo $compdata['title'];
							  ?></td>
                          <td align="center" style="font-size:13px"><?php echo $pdData['iss_no'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_title'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_detail'];?></td>
                          <td align="center" style="text-align:center">
 			  <?php if($pdData['attachment']!="")
						  {
							  ?>
                          <a href="<?php echo "ncn_files/".$pdData['attachment'];?>" target="_blank">
                          <img src="../../../images/pdf.png" width="50" height="50"/></a>
<?php }
?></td>
                          <td align="center" style="font-size:13px"><?php if($pdData['iss_status']==1) echo "Pending"; else echo "Closed";?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['iss_action'];?></td>
						  <td align="left" style="font-size:13px"><?php echo $pdData['iss_remarks'];?></td>
                         <?php if($read_right==1 || $read_right==3)
								  {	
								  ?>
                                      <td align="center" style="font-size:13px; text-align:center">
						    <span style="float:right">
 <button class="btn btn-outline-warning btn-fw px-1 py-1 "  href="javascript:void(null);" onClick="window.open('project_nonconfirmity_input.php?nos_id=<?php echo $pdData['nos_id'] ?>', 'Manage notices ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=""> <i class="ti-pencil btn-icon-prepend" ></i> </button>
</span>
						  
						   </td>				
                           <?php
								  }
								  if($read_right==3)
								  {
								   ?>
                                   <td align="right">
						   <span style="float:right"><form action="project_nonconfirmity_info.php?nos_id=<?php echo $pdData['nos_id'] ?>" method="post">
               <button type="submit" title = "Delete"  class="btn btn-outline-danger btn-fw px-1 py-1 " name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" >   <i class="ti-trash btn-icon-prepend" ></i> 
        					</button></form></span>
						    </td>
                            <?php							   
						   }
						   ?>
                           </tr>
                           <?php
						   
						}
						 
				}
						   }
						   ?>
						  
                        
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="11" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						$i=$i+1;
						}
						?>
                            
                              </tbody>
        </table>
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


  <!-- plugins:js -->
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


<script language="javascript" type="text/javascript"></script>

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
						} 
						// else {
						// 	alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						// }
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
							document.getElementById("canal_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.status);
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
						} 
						// else {
						// 	alert("There was a problem while using XMLHTTP:\n" + req.status);
						// }
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}
</script>


</body>
</html>
<?php
	//$objDb  -> close( );
?>
