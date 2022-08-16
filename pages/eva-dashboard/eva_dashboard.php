<?php 
include_once("../../config/config.php");
$objDb  		= new Database();
$objEva  		= new EVADashboard();
//@require_once("get_url.php");
$msg	= "";
?><?php 

$msgFlag=false;
$graphflag=false;
$data=NULL;
$subactivityflag2=0;
$from_date = date('Y-m-d',strtotime($_REQUEST['from_date']));
$activityid = $_REQUEST['activityid'];
if($activityid == 0 || $activityid =='') {
	$activityflag=0;
} else {
	$activityflag=1;
}
$subactivityid = $_REQUEST['subactivityid'];
if($subactivityid == 0 || $subactivityid =='') {
	$subactivityflag=0;
} else {
	$subactivityflag=1;
}
?>
<?php 
function dateDiff($start, $end) 
{   
$start_ts = strtotime($start);  
$end_ts = strtotime($end);  
$diff = $end_ts - $start_ts;  
return round($diff / 86400); 
}?>
<?php include("includes/functions_eva.php");?>
<?php 
	$psql = "select max(emonth) as lastProgressMonth, min(emonth) as firstProgressMonth from `s007-eva-earned`";
	$objDb->dbQuery($psql);
	 $liCount = $objDb->totalRecords();
	 if($liCount>0)
	 {
		$prows = $objDb->dbFetchArray();
	 }

$lastProgressMonth=$prows['lastProgressMonth'];
$firstProgressMonth=$prows['firstProgressMonth'];
$start=$firstProgressMonth;
$end=$lastProgressMonth;
$last=$lastProgressMonth;
?>

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
   <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../css/basic-styles.css">
 <!-- endinject -->
 
  <script src="datepickercode/jquery.min.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
 <script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<script src="highcharts/js/highcharts-more.js"></script>
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller"> 
    
    <!-- partial:partials/_navbar.html -->
    <div id="partials-navbar"></div>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper" id="pagebodywraper">

      <!-- partial:partials/_settings-panel.html -->
      <div id="partials-theme-setting-wrapper"></div>
      <!-- partial -->

      <!-- partial:partials/_sidebar.html -->
      <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
      <!-- partial -->

      <!-- Main Panel Starts -->

      <div class="main-panel" id="mainpanel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true"> Overview</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="indicators-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Indicators</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">EVA Graphs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">EVA Tabular Data</a>
                    </li>
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                      <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                      <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                    </div>
                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                    <div class="row">
            <div class="col-lg-4 grid-margin ">
              <div class="card">
                <div class="card-body">
                <?php include("includes/eva_cpi_speedometer_graph.php");?>
                </div>
              </div>
            </div>
            <div class="col-lg-4 grid-margin ">
              <div class="card">
                <div class="card-body">
                  
                 <?php include("includes/eva_spi_speedometer_graph.php");?>
                </div>
              </div>
            </div>
            <div class="col-lg-4 grid-margin">
              <div class="card">
                <div class="card-body">
                 <?php include("includes/eva_tcpi1_speedometer_graph.php");?>
                </div>
              </div>
            </div>
          </div>
          
                  </div>
                  <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences"> 
                     <div class="row">
            <div class="col-lg-6 grid-margin ">
              <div class="card">
                <div class="card-body">
                <?php include("includes/eva_latest_indicator_value_text.php");?>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin ">
              <div class="card">
                <div class="card-body">
                  
                 <?php include("includes/eva_latest_indicator_value.php");?>
                </div>
              </div>
            </div>
            
          </div>
                  </div>
                  
                  <div class="tab-pane fade show" id="demographics" role="tabpanel" aria-labelledby="demographics"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                    
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin">
                               <?php include("includes/eva_main_graph.php");?>
                           
                          </div>
                        </div>
                      </div>
                
                </div>
              </div>
              
              		<div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin">
                               <?php include("includes/eva_spi_cpi_graph.php");?>
                          </div>
                        </div>
                      </div>
                
                </div>
              </div>
              
              		<div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin">
                               <?php include("includes/eva_cost_var_graph.php");?>
                          </div>
                        </div>
                      </div>
                
                </div>
              </div>
              
              		<div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin">
                               <?php include("includes/eva_schedule_var_graph.php");?>
                          </div>
                        </div>
                      </div>
                
                </div>
              </div>
            </div>
            		
                   <div class="tab-pane fade show" id="more" role="tabpanel" aria-labelledby="more"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                    
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin">
                               <?php include("includes/eva_monthly_indicator_data.php");?>
                           
                          </div>
                        </div>
                      </div>
                
                </div>
              </div>
              
              		<div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin">
                               <?php include("includes/eva_monthly_forecast_data.php");?>
                          </div>
                        </div>
                      </div>
                
                </div>
              </div>
              
            </div>
            
          </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
 
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <script src="../../js/Chart.roundedBarCharts.js"></script>
  <!-- <script src="js/navtype_session.js"></script> -->
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




</body>

</html>

