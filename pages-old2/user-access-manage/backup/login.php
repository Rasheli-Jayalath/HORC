<?php
include_once("../../config/config.php");
$objAdminUser = new AdminUser();
$objValidate = new Validate();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	 $username 	= trim($_POST['username']);
	 $passwd 	= trim($_POST['password']);
	 $user_type	= trim($_POST['user_type']);
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("username", "LOGIN_FLD_VAL_USERNAME", "S");
	$objValidate->setCheckField("password", "LOGIN_FLD_VAL_PASSWD", "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$objAdminUser->setProperty("username", $username);
//		$objAdminUser->setProperty("passwd", md5($passwd));
		$objAdminUser->setProperty("passwd", $passwd);
		
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){
		
		
		/*$objAdminUser->setProperty("user_type", $user_type);
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){*/
			$rows = $objAdminUser->dbFetchArray(1);
			$fullname = $rows['first_name'] . " " . $rows['last_name'];
			$objAdminUser->setProperty("user_cd", $rows['user_cd']);
			$objAdminUser->setProperty("username", $rows['username']);
			$objAdminUser->setProperty("fullname_name", $fullname);
			$objAdminUser->setProperty("user_type", $rows['user_type']);
			$log_time= date('Y-m-d H:i:s');
			$objAdminUser->setProperty("logged_in_time", date('Y-m-d H:i:s'));
			$objAdminUser->setProperty("member_cd", $rows['member_cd']);
			$objAdminUser->setProperty("designation", $rows['designation']);
			$objAdminUser->setProperty("sadmin", $rows['sadmin']);
			$objAdminUser->setProperty("news", $rows['news']);
			$objAdminUser->setProperty("newsadm", $rows['newsadm']);
			$objAdminUser->setProperty("newsentry", $rows['newsentry']);
			
			$objAdminUser->setProperty("res", $rows['res']);
			$objAdminUser->setProperty("resadm",$rows['resadm']);
			$objAdminUser->setProperty("resentry",$rows['resentry']);
			
			$objAdminUser->setProperty("mdata", $rows['mdata']);
			$objAdminUser->setProperty("mdataadm", $rows['mdataadm']);
			$objAdminUser->setProperty("mdataentry", $rows['mdataentry']);
			$objAdminUser->setProperty("mile", $rows['mile']);
			$objAdminUser->setProperty("mileadm", $rows['mileadm']);
			$objAdminUser->setProperty("mileentry", $rows['mileentry']);
			$objAdminUser->setProperty("spg", $rows['spg']);
			$objAdminUser->setProperty("spgadm", $rows['spgadm']);
			$objAdminUser->setProperty("spgentry", $rows['spgentry']);
			
			$objAdminUser->setProperty("spln", $rows['spln']);
			$objAdminUser->setProperty("splnadm", $rows['splnadm']);
			$objAdminUser->setProperty("splnentry", $rows['splnentry']);
			
			$objAdminUser->setProperty("kpi", $rows['kpi']);
			$objAdminUser->setProperty("kpiadm", $rows['kpiadm']);
			$objAdminUser->setProperty("kpientry", $rows['kpientry']);
			
			$objAdminUser->setProperty("cam", $rows['cam']);
			$objAdminUser->setProperty("camadm", $rows['camadm']);
			$objAdminUser->setProperty("camentry", $rows['camentry']);
			
			$objAdminUser->setProperty("boq", $rows['boq']);
			$objAdminUser->setProperty("boqadm", $rows['boqadm']);
			$objAdminUser->setProperty("boqentry", $rows['boqentry']);
			
			$objAdminUser->setProperty("ipc", $rows['ipc']);
			$objAdminUser->setProperty("ipcadm", $rows['ipcadm']);
			$objAdminUser->setProperty("ipcentry", $rows['ipcentry']);
			
			$objAdminUser->setProperty("eva", $rows['eva']);
			$objAdminUser->setProperty("evaadm", $rows['evaadm']);
			$objAdminUser->setProperty("evaentry", $rows['evaentry']);
			
			$objAdminUser->setProperty("padm", $rows['padm']);
			$objAdminUser->setProperty("issueAdm", $rows['issueAdm']);
		
			$objAdminUser->setProperty("actd", $rows['actd']);
			
			$objAdminUser->setProperty("miled", $rows['miled']);
			
			$objAdminUser->setProperty("kpid", $rows['kpid']);
			
			$objAdminUser->setProperty("camd", $rows['camd']);
			
			$objAdminUser->setProperty("kfid", $rows['kfid']);
			
			$objAdminUser->setProperty("evad", $rows['evad']);
			
			$objAdminUser->setProperty("pic", $rows['pic']);
			$objAdminUser->setProperty("picadm", $rows['picadm']);
			$objAdminUser->setProperty("picentry", $rows['picentry']);
			
			$objAdminUser->setProperty("draw", $rows['draw']);
			$objAdminUser->setProperty("drawadm", $rows['drawadm']);
			$objAdminUser->setProperty("drawentry", $rows['drawentry']);
			
			$objAdminUser->setProperty("ncf", $rows['ncf']);
			$objAdminUser->setProperty("ncfadm", $rows['ncfadm']);
			$objAdminUser->setProperty("ncfentry", $rows['ncfentry']);
			
			$objAdminUser->setProperty("dp", $rows['dp']);
			$objAdminUser->setProperty("dpadm", $rows['dpadm']);
			$objAdminUser->setProperty("dpentry", $rows['dpentry']);
			
			$objAdminUser->setProperty("process", $rows['process']);
			$_SESSION['login_count']=1;
			$_SESSION['user_pasword']=$passwd;
			$objAdminUser->setAdminLogin();
		/***** Log Entry *****/
		$log_desc 	= "User <strong>" . $fullname . "</strong> is login at.". $log_time;
			$log_module = "Login";
			$log_title 	= "User Login";
			doLog($log_module, $log_title, $log_desc,$rows['user_cd']);
			header("location: ../../index.php");
			
		/*}
		else
		{
			$objCommon->setMessage("Invalid User Accesss Rights! Please try again", 'Error');
		}*/
		}
		else{
			$objCommon->setMessage(LOGIN_FLD_INVALID, 'Error');
		}
	}
}
?>
<script>
function frmValidate(frm){
	var msg = "<?php echo "_JS_FORM_ERROR";?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.username.value == ""){
		msg = msg + "\r\n<?php echo "LOGIN_FLD_VAL_USERNAME";?>";
		flag = false;
	}
	if(frm.password.value == ""){
		msg = msg + "\r\n<?php echo "LOGIN_FLD_VAL_PASSWD";?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
	
}
</script>
<script type="text/javascript">
function toggleDiv(divId) {
 /*  $("#"+divId).toggle();*/
   $("#"+divId).hide(800);
/*   $("p").hide("slow");*/

}
</script>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PMIS</title>
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
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="/PMIS/images/smec-logo.png" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="fw-light">Sign in to continue.</h6>
              <form class="pt-3" name="frmlogin" onsubmit="return frmValidate(this);" method="post" action="">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                </div>
                <div class="mt-3">
                <input class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="Submit" value="Login" id="uLogin" /> 
                <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN IN</a> -->
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook me-2"></i>Connect using facebook
                  </button>
                </div>
                <div class="text-center mt-4 fw-light">
                  Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
