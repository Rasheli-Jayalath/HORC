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
header("Location: ../../index.php?init=3");
}
if($_GET['mode'] == 'Delete')
{
	$user_cd = $_GET['user_cd'];
	
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->actAdminUser('D');
	$objCommon->setMessage('User\'s account deleted successfully.', 'Error');
	redirect('./?p=user_mgmt');
	
}
if($_GET['mode'] == 'Suspend'){

	$user_cd = $_GET['user_cd'];
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->setProperty("is_active", "0");
	if($objAdminUser->actAdminUser("U")){
		$objAdminUserN = new AdminUser;
		$objAdminUserN->setProperty("user_cd", $user_cd);
		$objAdminUserN->lstAdminUser();
		$rows_c = $objAdminUserN->dbFetchArray();
		
		# Send mail to customer
		$content 		= $objTemplate->getTemplate('account_suspend','EN');
		$sender_name 	= $content['sender_name'];
		$sender_email 	= $content['sender_email'];
		$subject 		= $content['template_subject'];
		$content 		= $content['template_detail'];
		
		$content		= str_replace("[USER_NAME]", $rows_c['fullname'], $content);
		$content		= str_replace("[REASON]", '', $content);
		$content		= str_replace("[SITENAME]", SITE_NAME, $content);
		$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
		$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
		
		$body 			= file_get_contents(TEMPLATE_URL . "template.php");
		$body			= str_replace("[BODY]", $content, $body);
		
		$objMail		= new Mail;
		$objMail->IsHTML(true);
		$objMail->setSender($sender_email, $sender_name);
		$objMail->AddEmbeddedImage(TEMPLATE_PATH . "agro_email.jpg", 1, 'agro_email.jpg');
		$objMail->setSubject($subject);
		$objMail->setReciever($rows_c['email'], $rows_c['fullname']);
		$objMail->setBody($body);
		//$objMail->Send();
	
		$objCommon->setMessage('User\'s account suspended successfully.', 'Error');
		redirect('./?p=user_mgmt');
	}
}

if($_GET['mode'] == 'Activate'){
	$user_cd = $_GET['user_cd'];
	$newpwd = $objCommon->genPassword();
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->setProperty("password", md5($newpwd));
	$objAdminUser->setProperty("is_active", "1");
	if($objAdminUser->actAdminUser("U")){
		$objAdminUserN = new AdminUser;
		$objAdminUserN->setProperty("user_cd", $user_cd);
		$objAdminUserN->lstAdminUser();
		$rows_c = $objAdminUserN->dbFetchArray();
		
		# Send mail to customer
		$content 		= $objTemplate->getTemplate('account_activate','EN');
		$sender_name 	= $content['sender_name'];
		$sender_email 	= $content['sender_email'];
		$subject 		= $content['template_subject'];
		$content 		= $content['template_detail'];
		
		$content		= str_replace("[USER_NAME]", $rows_c['fullname'], $content);
		$content		= str_replace("[EMAIL_ADD]", $rows_c['email'], $content);
		$content		= str_replace("[PASSWORD]", $newpwd, $content);
		$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
		$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
		
		$body 			= file_get_contents(TEMPLATE_URL . "template.php");
		$body			= str_replace("[BODY]", $content, $body);
		
		$objMail		= new Mail;
		$objMail->IsHTML(true);
		$objMail->setSender($sender_email, $sender_name);
		$objMail->AddEmbeddedImage(TEMPLATE_PATH . "agro_email.jpg", 1, 'agro_email.jpg');
		$objMail->setSubject($subject);
		$objMail->setReciever($rows_c['email'], $rows_c['fullname']);
		$objMail->setBody($body);
		//$objMail->Send();
		
		
		$objCommon->setMessage('User\'s account activated successfully.', 'Info');
		redirect('./?p=user_mgmt');
	}
}

if(!empty($_GET['user_name'])){
	$user_name = urldecode($_GET['user_name']);
	$objAdminUser->setProperty("user_name", strtolower($user_name));
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

<div class="row" >
	<div class="col-sm-2 " style="  font-weight: 600;">  
	
	</div>
	<div class="col-sm-10 text-end" >  
	

<button type="button" class="col-sm-2 button-33" onclick="location.href='update_profile.php';" >  <?php echo "Add New User";?> </button>

	</div>
</div>

<div class="row pb-4 pt-3 text-end" >
<form action="" target="_self" method="post"  enctype="multipart/form-data">
<label>User Name</label>
			<input type="text" size="40" name="user_name" id="user_name" value="<?php echo $_GET['user_name'];?>" />
 
  <button type="button" class=" col-sm-1 button-33 " style="background-color: Green;   border-radius: 4px;" onClick="doFilter(this.form);"  name="Submit" id="Submit" value=" GO " > Go</button>
 
  

  </form>
</div>

	


 	<span style="color:green; font-weight:bold; font-size:20px"> <?php echo $objCommon->displayMessage();?></span>                                
<div class="table-responsive">
  <table class="table table-striped">
                              <thead>
                                <tr class="bg-form" style="font-size:12px; color:#CCC;">
                                  <th  style="text-align:center"><?php echo "Actions";?></th>
                                   <th ><?php echo "UID";?></th>
                                   <th ><?php echo "Name";?></th>
		<th ><?php echo "Designation";?></th>
        <th ><?php echo "User Name";?></th>
		<th ><?php echo "News";?></th>
		<th ><?php echo "NewsA";?></th>
		<th ><?php echo "NewsE";?></th>
		<th ><?php echo "ADDP";?></th>
		<th ><?php echo "Res";?></th>
		<th ><?php echo "ResA";?></th>
		<th ><?php echo "ResE";?></th>
		<th ><?php echo "Mdata";?></th>
		<th ><?php echo "MdataA";?></th>
		<th ><?php echo "MdataE";?></th>
		<th ><?php echo "Act-D";?></th>
		<th ><?php echo "Mile";?></th>
		<th ><?php echo "MileA";?></th>
		<th ><?php echo "MileE";?></th>
		<th ><?php echo "Mile-D";?></th>
		<th ><?php echo "Sprogress";?></th>
		<th ><?php echo "SprogressA";?></th>
		<th ><?php echo "SprogressE";?></th>
		<th ><?php echo "Splanned";?></th>
		<th ><?php echo "SplannedA";?></th>
		<th ><?php echo "SplannedE";?></th>
		<th ><?php echo "KPI";?></th>
		<th ><?php echo "KPIA";?></th>
		<th ><?php echo "KPIE";?></th>
		<th ><?php echo "KPI-D";?></th>
		<th ><?php echo "CAM";?></th>
		<th ><?php echo "CAMA";?></th>
		<th ><?php echo "CAME";?></th>
		<th ><?php echo "CAM-D";?></th>
		<th ><?php echo "BOQ";?></th>
		<th ><?php echo "BOQA";?></th>
		<th ><?php echo "BOQE";?></th>
		<th ><?php echo "IPC";?></th>
		<th ><?php echo "IPCA";?></th>
		<th ><?php echo "IPCE";?></th>
		<th ><?php echo "KFI-D";?></th>
		<th ><?php echo "EVA";?></th>
		<th ><?php echo "EVAA";?></th>
		<th ><?php echo "EVAE";?></th>
		<th ><?php echo "EVA-D";?></th>
		

                                 
								
                                </tr>
                              </thead>
                            
                              <tbody>
							 		<?php
	//$objAdminUser->setProperty("ORDER BY", "a.first_name");
	//$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "b.user_cd");
	$objAdminUser->setProperty("GROUP BY", "b.user_cd");
	$objAdminUser->lstAdminUser();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<!-- Start Your Php Code her For Display Record's -->
			<tr >
            	<td align="center">
					<?php 
					if($rows['user_type']==1)
					{ 
					echo "Full Rights";
					}
					else
					{?>
                    <a  href="update_rights.php?user_cd=<?php echo $rows['user_cd'];?>"  title="Manage Rights"  class="btn btn-outline-danger btn-fw px-1 py-1 m-0"  >
                             <img src="../../images/right.png" border="0"  style="width:16px; height:16px" />
                              </a>  
                              <a  class="btn btn-outline-danger btn-fw px-1 py-1 m-0 "  style="margin-top: 0; margin-bottom: 0; " href="update_profile.php?user_cd=<?php echo $rows['user_cd'];?>" title="Edit">
                             <i class="ti-pencil btn-icon-prepend" ></i>
                              </a>
                            
                   
			<?php } ?></td>
				<td ><?php echo $rows['user_cd'];?></td>
				<td><?php echo $rows['fullname'];?></td>
                <td><?php echo wordwrap($rows['designation'],30,"<br>\n");?></td>
				<td><?php echo $rows['username'];?></td>
				<td><?php echo $rows['news'];?></td>
				<td><?php echo $rows['newsadm'];?></td>
				<td><?php echo $rows['newsentry'];?></td>
				<td><?php echo $rows['padm'];?></td>
				<td><?php echo $rows['res'];?></td>
				<td><?php echo $rows['resadm'];?></td>
				<td><?php echo $rows['resentry'];?></td>
				<td><?php echo $rows['mdata'];?></td>
				<td><?php echo $rows['mdataadm'];?></td>
				<td><?php echo $rows['mdataentry'];?></td>
				<td><?php echo $rows['actd'];?></td>
				<td><?php echo $rows['mile'];?></td>
				<td><?php echo $rows['mileadm'];?></td>
				<td><?php echo $rows['mileentry'];?></td>
				<td><?php echo $rows['miled'];?></td>
				<td><?php echo $rows['spg'];?></td>
				<td><?php echo $rows['spgadm'];?></td>
				<td><?php echo $rows['spgentry'];?></td>
				<td><?php echo $rows['spln'];?></td>
				<td><?php echo $rows['splnadm'];?></td>
				<td><?php echo $rows['splnentry'];?></td>
				<td><?php echo $rows['kpi'];?></td>
				<td><?php echo $rows['kpiadm'];?></td>
				<td><?php echo $rows['kpientry'];?></td>
				<td><?php echo $rows['kpid'];?></td>
				<td><?php echo $rows['cam'];?></td>
				<td><?php echo $rows['camadm'];?></td>
				<td><?php echo $rows['camentry'];?></td>
				<td><?php echo $rows['camd'];?></td>
				<td><?php echo $rows['boq'];?></td>
				<td><?php echo $rows['boqadm'];?></td>
				<td><?php echo $rows['boqentry'];?></td>
				<td><?php echo $rows['ipc'];?></td>
				<td><?php echo $rows['ipcadm'];?></td>
				<td><?php echo $rows['ipcentry'];?></td>
				<td><?php echo $rows['kfid'];?></td>
				<td><?php echo $rows['eva'];?></td>
				<td><?php echo $rows['evaadm'];?></td>
				<td><?php echo $rows['evaentry'];?></td>
				<td><?php echo $rows['evad'];?></td>
				
			
				</tr>
			<?php
			
		}
    }
	else{
	?>
	<tr>
	<td colspan="59" style="border-left:1px solid #000000;">
  <div align="center" style="padding:5px 5px 5px 5px"> <?php echo NOT_FOUND_CUST;?></div>
   </td></tr>
    <?php
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



</script>

</body>
</html>