
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sign up - PMIS</title>
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.2" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">

  <section >
    <div class="page-header align-items-start section-height-50  m-3 border-radius-lg" style="background-image: url('../assets/img/signup.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      
      <div class=" mt-5 " style = "margin: 0 5%;">

        <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
              <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style=" background-image: linear-gradient(rgba(36, 127, 224,0.6), rgba(168, 184, 216,0.1)), url('../assets/img/home.jpg')"></div>
            </div>
          </div>
      </div>

      <nav class="navbar navbar-expand-lg  blur blur-rounded top-0    shadow-lg position-absolute  mt-5" style="width: 90%; margin: 0 5%;">

        
          <img src="../assets/img/logo-ct.png" class="  pl-3" style=" width: 160px ; margin: 0.8%; padding-left: 20px;" alt="...">
        
           <div style = "margin: 0 auto; ">
          <span class="text-dark font-weight-bold ml-5 "><strong>Project Monitoring and Management Information System (PMIS)</strong></span>
          </div>
         
          <div style=" width: 150px ;  margin: 0.8%;" > </div>

        </nav>
      
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0 shadow-lg">
            <div class="card-header text-center pt-0">
            <h2 class="text-gradient text-dark   mt-3">Welcome !</h2>
            <p class="text-lead text-dark">Use these form to register a new user. </p>
            </div>

            <div class="card-body pt-0">
              <form role="form text-left">
                <div class="mb-2">
                  <input type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="username-addon">
                </div>
                <div class="mb-2">
                  <input type="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="username-addon" required>
                </div>
                <div class="mb-2">
                  <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" required>
                </div>
                <div class="form-check form-check-info text-left">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked required>
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                  </label>
                </div>
                <div class="text-center">
                  <button type="button" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="signin.php" class="text-dark font-weight-bolder">Sign in</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
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
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
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