<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objAdminUser 	= new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$_SESSION['ne_user_type'];

	$log_id=1;
 $comp_id = $_REQUEST['comp_id'];
$contract_id = $_REQUEST['contract_id'];

		
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Drawings Register</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
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
.rl-p0{
  padding-left:0;
  padding-right:0;
  padding-bottom: 0;
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
.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:2%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 1% 3%;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  float: right;
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

#u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145, 0.6 );

  border-radius:10px 30px;
  padding:3.8px;
}
 
    </style>

<script>
function doFilter(frm){
	var qString = '';
	if(frm.comp_id.value != ""){
		qString += 'comp_id=' + escape(frm.comp_id.value);
	}
	if(frm.contract_id.value != ""){
		qString += '&contract_id=' + escape(frm.contract_id.value);
	}
	
	document.location = 'drawing_reg.php?' + qString;
}

</script>



  

<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>
<!--<div id="wrap">
  <?php //include 'includes/header.php'; ?>
<div id="content">-->
<div class="container-scroller">
     <!-- partial:partials/_navbar.html --><div id="partials-navbar"></div> <!-- partial -->
     <div class=" page-body-wrapper" id="pagebodywraper">
       <!-- partial:partials/_sidebar.html --> <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div><!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">
           <h4 class="text-center text-34" style="  letter-spacing: 4px"> Drawing Register</h4> 

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
<div class="search_box">
<strong>Component:</strong> 
<select id="comp_id" name="comp_id" >
<option value="">Select Component</option>
<option value="1" <?php if($comp_id==1) echo "selected='selected'";?> >Civil</option>
<option value="2" <?php if($comp_id==2) echo "selected='selected'";?> >Electrical</option>
</select>
&nbsp;&nbsp;
 <strong>Contractor:</strong> <select id="contract_id" name="contract_id" >
  <option value=""> Select Contractor</option>
  <option value="1" <?php if($contract_id==1) echo "selected='selected'";?> > Ashoka Buildcon</option>
  <option value="2" <?php if($contract_id==2) echo "selected='selected'";?> > Sri Gopikrishna Infrastructures</option>
  <option value="3" <?php if($contract_id==3) echo "selected='selected'";?> > Laser Power & Infra</option>
  <option value="4" <?php if($contract_id==4) echo "selected='selected'";?> > Shalaka Infra Tech Pvt. Ltd.</option>
  <option value="5" <?php if($contract_id==5) echo "selected='selected'";?> > Vikran & Exim Pvt. Ltd.</option>
  
  </select>
  <input type="button"  onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" <?php echo VIEW; ?> " />
</div>
</form>
<div id="result1" style="margin-top:10px">
<?php
if ($comp_id == 1 && $contract_id == 1)
{
	$filename_civil =   "civil-Ashoka.htm";
	}
else if($comp_id == 1 && $contract_id == 2)
{
	$filename_civil =  "civil-SriGopikrishna.htm";
	}
else if($comp_id == 1 && $contract_id == 3)
{
	$filename_civil =   "civil-LaserPower.htm";
	}
else if($comp_id == 1 && $contract_id == 4)
{
	$filename_civil =   "civil-ShalakaInfra.htm";
	}
else if($comp_id == 1 && $contract_id == 5)
{
	$filename_civil =   "civil-VikranExim.htm";
	}



if ($comp_id == 2 && $contract_id == 1)
{
	$filename_electrical =   "electrical-Ashoka.htm";
	}
else if($comp_id == 2 && $contract_id == 2)
{
	$filename_electrical =  "electrical-SriGopikrishna.htm";
	}
else if($comp_id == 2 && $contract_id == 3)
{
	$filename_electrical =   "electrical-LaserPower.htm";
	}
else if($comp_id == 2 && $contract_id == 4)
{
	$filename_electrical =   "electrical-ShalakaInfra.htm";
	}
else if($comp_id == 2 && $contract_id == 5)
{
	$filename_electrical =   "electrical-VikranExim.htm";
	}
	?>
    
    <?php if (isset($filename_civil)) {?>

<iframe style="min-height:300px;  " src="civil/<?php echo $filename_civil; ?>" title="description" frameborder="0" min-height="300px" width="100%" 
scrolling="auto" id="frame1"></iframe> 
<?php }
else if (isset($filename_electrical)){?>
<iframe style="min-height:300px" src="electrical/<?php echo $filename_electrical; ?>" title="description" min-height="300px" width="100%" 
scrolling="auto" frameborder="0" scrolling="auto"  ></iframe>
<?php } ?>
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
<!--</div>
 
</div>-->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../../js/chart.js"></script>
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
</body>
</html>
<?php
	//$objDb  -> close( );
?>
