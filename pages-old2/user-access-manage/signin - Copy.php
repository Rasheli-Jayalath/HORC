<?php
include_once("../../config/config.php");
include_once("../../rs_lang.admin.php");
$objSDb  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
$objValidate 	= new Validate();
$objDb  		= new ProjectSetup();
$objPD  		= new ProjectSetup();
$objLog 		= new Log();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	 $username 	= trim($_POST['username']);
	 $passwd 	= trim($_POST['password']);
	 $user_type	= trim($_POST['user_type']);
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("username", LOGIN_FLD_VAL_USERNAME, "S");
	$objValidate->setCheckField("password", LOGIN_FLD_VAL_PASSWD, "S");
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
			$objAdminUser->setProperty("email", $rows['email']);
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
		 $request_uri = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			doLog($log_module, $log_title, $log_desc,$rows['user_cd'], $request_uri);
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
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sign in - PMIS</title>
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.2" rel="stylesheet" />
</head>

<body class="g-sidenav-show">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      <nav class="navbar navbar-expand-lg  blur blur-rounded top-0  z-index-3  shadow-lg position-absolute my-3 py-2 start-0 end-0 mx-4">
      <img src="../assets/img/logo-ct.png" class="  pl-3" style=" width: 160px ; margin: 0.8%; padding-left: 20px;" alt="...">
        
        <div style = "margin: 0 auto; ">
       <span class="text-dark font-weight-bold ml-5 "><strong>Project Monitoring and Management Information System (PMIS)</strong></span>
       </div>
      
       <div style=" width: 150px ;  margin: 0.8%;" > </div>
        </nav>
      </div>
    </div>
  </div>
  <section>
    <div class="page-header section-height-75 " style="padding-bottom: 3%;">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto " >
            <div class="card card-plain mt-8 shadow ">
              <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-dark text-gradient">Welcome back</h3>
                <p class="mb-0">Enter your username and password to sign in</p>
              </div>
              <div class="card-body">
                		
        <!-- alert -->


                <form  action="signin.php"  method="post"  enctype="multipart/form-data" autocomplete="off" role="form text-left">
                  <label >Username</label>
                  <div class="mb-2">
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="username" aria-describedby="username-addon">
                  </div>
                  <label>Password</label>
                  <div class="mb-2">
                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" name="password" aria-describedby="password-addon">
                  </div>

                  <div class="text-center">
                    <button type="submit" name="submit" class="btn bg-gradient-secondary w-100 mt-1 mb-0">Sign in</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <p class="mb-4 text-sm mx-auto">
                  Don't have an account?
                  <a href="signUp.php" class="text-dark text-gradient font-weight-bold">Sign up</a>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
              <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style=" background-image: linear-gradient(rgba(36, 127, 224,0.6), rgba(168, 184, 216,0.1)), url('../assets/img/home.jpg')"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- -------- START  ------- -->
  <footer class="footer py-4 fixed-bottom">
    <div class="container-fluid">
    <div class="row">
        <div class="   " style="">
          <p class="mb-0  text-secondary">
          <?php include("../../partials/_footer.php");?>
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.2"></script>
</body>

</html>
