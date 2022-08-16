<?php 
include_once("config/config.php");
include_once("rs_lang.admin.php");
$objSDb  		= new Database();
$objSDbCount  		= new Database();
$objSDb1 		= new Database();
$objMDb 		= new Database();
$objPDb 		= new Database();
$objBDb 		= new Database();
$objIDb 		= new Database();
$objIIDb 		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
$objDb  		= new ProjectSetup();
$objPD  		= new ProjectSetup();
$objDbc  		= new ProjectSetup();
$objDdb  		= new ProjectSetup();
$objNews 		= new News();
$objLog 		= new Log();
 if($objAdminUser->ne_is_login != true){
	 header("Location:pages/user-access-manage/signin.php");
  }
  else
  {
  $eSql = "Select * from project";
$objSDb->dbQuery($eSql);
$eCount = $objSDb->totalRecords();
if($eCount == 0)
{
header("location:pages/Administration/Data_Updation/project_details.php");
}
  }
  //  require_once("pages/Administration/Data_Updation/get_url.php");
 $objPD->getProject();
  $PCount=$objPD->totalRecords();
  $data_url="pages/project-tools/pictorial_analysis/photos/";
  if($PCount==1)
  {
	   while ($prows = $objPD->dbFetchArray()) {
	  $pid 						= $prows['pid'];
	  $pcode 					= $prows['pcode'];
	 // $pname	 				= $prows['pname'];
	  $pdetail					= $prows['pdetail'];
	  $ptype					= $prows['ptype'];
	  $pstart 					= $prows['pstart'];
	  $pend 					= $prows['pend'];
	  $client					= $prows['client'];
	  $funding_agency			= $prows['funding_agency'];
	  $contractor				= $prows['contractor'];
	  $pcost					= $prows['pcost'];
	  $ssector_id				= $prows['sector_id'];
	  if($ssector_id!=0)
	  {
		 $objDb->setProperty("sector_id",$ssector_id);
		 $objDb->getSector();
		 $secrows = $objDb->dbFetchArray();
		 $sector_name = $secrows['sector_name'];
			
	  }
	  $scountry_id				= $prows['country_id'];
	  if($scountry_id!=0)
	  {
		  $objDb->setProperty("country_id",$scountry_id);
		  $objDb->getCountry();
		   $crows = $objDb->dbFetchArray();
		  $country_name = $crows['country_name'];
	  }
	  $consultant				=$prows['consultant'];
	  $location				    =$prows['location'];
	  $smec_code				=$prows['smec_code'];
	}
	$objDbc->getCurrency();
				 $cur_rows=$objDbc->dbFetchArray();
				  $pcid 					= $cur_rows['pcid'];
			    $cur_1_rate 					= $cur_rows['cur_1_rate'];
			    $cur_2_rate 					= $cur_rows['cur_2_rate'];
				$cur_3_rate 					= $cur_rows['cur_3_rate'];
			    $cur_1 					= $cur_rows['cur_1'];
			    $cur_2 					= $cur_rows['cur_2'];
				$cur_3 					= $cur_rows['cur_3'];
			    $base_cur 				= $cur_rows['base_cur'];
  } 
  $mSql="SELECT max(progressmonth) as progress_month from activity";
  $objMDb->dbQuery($mSql);
 $mCount = $objMDb->totalRecords();
if($mCount>0)
{
	$mrows=$objMDb->dbFetchArray();
	if(isset($mrows["progress_month"])&&$mrows["progress_month"]!=""&&$mrows["progress_month"]!=NULL)
	{
   $SqlP="SELECT * FROM activity_dashboard_graph_main where a_month='".$mrows["progress_month"]."'";
	 $objPDb->dbQuery($SqlP);
$pCount = $objPDb->totalRecords();
if($PCount>0)
{
	$prows=$objPDb->dbFetchArray();
	 $planned=number_format($prows["planned"],2);
	 $actual=number_format($prows["actual"],2);
	 
}
}
}
$BSql="SELECT sum(boqqty*boq_cur_1_rate) as total_boq_amount FROM boq";
  $objBDb->dbQuery($BSql);
$bCount = $objBDb->totalRecords();
if($bCount>0)
{
	$brows=$objBDb->dbFetchArray();
	$total_amount=$brows["total_boq_amount"];
	if($total_amount>0)
	{
	$amount_million=number_format($total_amount/1000000,2);
	}
	
}
    $SqlI="SELECT ipcid FROM ipc where ipcmonth = (SELECT max(ipcmonth) as ipcmonth from ipc)";
	$objIDb->dbQuery($SqlI);
$ICount = $objIDb->totalRecords();
if($ICount>0)
{
	$iprows=$objIDb->dbFetchArray();
	 $this_ipc_id=$iprows["ipcid"];
	$SqlII="SELECT sum(b.boq_cur_1_rate*a.ipcqty) as this_amount FROM ipcv a inner join boq b on(a.boqid=b.boqid) where  a.ipcid=".$this_ipc_id;
	$objIIDb->dbQuery($SqlII);
$IICount = $objIIDb->totalRecords();
if($IICount>0)
{
	$iiprows=$objIIDb->dbFetchArray();
	 $this_amount=$iiprows["this_amount"];
	 $this_amount_million=number_format($this_amount/1000000,2);
}
if($total_amount!=0)
{
	$financial_progress=$this_amount/$total_amount;
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PMIS</title>
  <!-- plugins:css -->
 <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
   <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
  <!-- <link rel="stylesheet" href="js/select.dataTables.min.css"> -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="css/basic-styles.css">
 <!-- endinject -->
 
<link rel="stylesheet" type="text/css" href="engine1/style.css" />
<!--/*<script type="text/javascript" src="engine1/jquery.js"></script>*/-->

    <script src="js/jquery.min.js"></script>
  <script type="text/javascript" src="../../datepickercode/jquery-ui.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
.highcharts-figure,
.highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}</style>
<link rel="shortcut icon" href="images/favicon.png" />
  
<script type="text/javascript">
 var chart;
			  var options = {
        chart: {
           renderTo: 'container1',
           type: 'line',
        },
        title: {  text: 'Planned Vs. Actual Progress'
        },
        xAxis: {
           type: 'datetime'
        },
         subtitle: {
        text: 'Progress To-Date'
    },

    yAxis: {
        title: {
            text: '% Done'
        }
    },
		 legend: {
            layout: 'vertical',
            align: 'left',
            x: 50,
            verticalAlign: 'top',
            y: 50,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor)
        },
        series: [{
           name: 'Planned',
           data: []
       }, {
           name: 'Actual',
           data: []
        }]
     };
     $.getJSON('act_main_graph.php', function(json) {
		
        val1 = [];
        val2 = [];
        $.each(json, function(key,value) {
        val1.push([value[0], value[1]]);
		if(value[2]!=0)
		{
		
		val2.push([value[0], value[2]]);
		}
		
        });

        options.series[0].data = val1;
        options.series[1].data = val2;
        chart = new Highcharts.Chart(options);
     });


    

		</script>
 <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
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
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Project Overview</a>
                    </li>
                      <li class="nav-item">
                      <a class="nav-link border-0" id="logs-tab" data-bs-toggle="tab" href="#logs" role="tab" aria-selected="false">Logs
                      </a>
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
                      <div class="col-sm-12" style="height:90px">
                        <div class="statistics-details d-flex align-items-center justify-content-between">
                        <div class="d-none d-md-block">
                            <p class="statistics-title" style="color:#006"><strong>Planned Progress</strong></p>
                            <h3 class="rate-percentage"><?php if($planned!=0) echo $planned; else echo "0"; ?>%</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>This Month: 0%</span></p>
                          </div>
                        <div>
                            <p class="statistics-title" style="color:#006"><strong>Physical Progress</strong></p>
                            <h3 class="rate-percentage"><?php if($actual!=0) echo $actual; else echo "0"; ?>%</h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>Gap: <?php echo $planned-$actual;?>%</span></p>
                          </div>
                          
                          <div>
                            <p class="statistics-title" style="color:#006"><strong>Financial Progress</strong></p>
                            <h3 class="rate-percentage" ><?php echo number_format($financial_progress,2);?> %</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>0%</span></p>
                          </div>

                        <div>
                            <p class="statistics-title" style="color:#006"><strong>Total Value of Contract Awarded</strong></p>
                            <h3 class="rate-percentage"><?php //echo $amount_million. " M";?>348.5 Cr.</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title" style="color:#006"><strong>Total Payment</strong></p>
                            <h3 class="rate-percentage"><?php //echo $this_amount_million. " M";?> 17.43 Cr. </h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title" style="color:#006"><strong>Last Updated</strong></p>
                            <h3 class="rate-percentage"><?php echo date('d, F, Y');?> </h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          
                                                    
                          
                        </div>
                      </div>
                    </div> 
                    <div class="row">
                      <!--<div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-12 grid-margin grid-margin-md-1 stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                               
                                  <div id="container1"></div>
                                 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>-->
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                
                                <div >
                                 <div id="container1" style="min-width: 300px; height: 200px; margin: 0 auto"></div> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                      <div>
                                        <h4 class="card-title card-title-dash">Videos</h4>
                                      </div>
                                      <div>
                                        
                                      </div>
                                    </div>
                                    <div class="mt-3">
                                  
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <!--<div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Financial Progress </h4>
                                   <p class="card-subtitle card-subtitle-dash">Total Financial Dispursement Todate</p>
                                  </div>
                                  <div>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <h6 class="dropdown-header">Settings</h6>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                  <div class="d-sm-flex align-items-center mt-4 justify-content-between"><h2 class="me-2 fw-bold">0</h2><h4 class="me-2"></h4><h4 class="text-success"></h4></div>
                                  <div class="me-3"><div id="marketing-overview-legend"></div></div>
                                </div>
                                <div class="chartjs-bar-wrapper mt-3">
                                  <canvas id="marketingOverview"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>-->
                        <div class="row flex-grow" >
                         <div class="col-12 grid-margin stretch-card">
                          <!-- Start WOWSlider.com BODY section -->
<div id="wowslider-container1" sty>

  

<div class="ws_images" style="padding-bottom:10px"><ul>
<?php  
$pdSQL11="SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and status=1 order by albumid desc limit 0,1";
$pdSQLResult11 = $objSDb->dbQuery($pdSQL11);
$pdData11 = $objSDb->dbFetchArray();
$albumid=$pdData11['albumid'];
		if($albumid!=0 && $albumid!="")
		{
$pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$albumid." order by phid limit 0,10";
			 $pdSQLResult = $objDb->dbQuery($pdSQL);
			if($objDb->totalRecords() >= 1){
				while($result = $objDb->dbFetchArray()){
					?>
		<li><img src="<?php echo $data_url.$result['al_file'];?>" alt="<?php echo $result['al_file'];?>" title="<?php echo $result['al_file'];?>" id="wows1_0"/></li>
        <?php
				}
			}
		}
				?>
		
		<!-- <li><img src="data1/images/banner1.jpg" alt="banner1" title="banner1" id="wows1_3"/></li>
		<li><a href="http://wowslider.net"><img src="data1/images/banner1a.jpg" alt="responsive slider" title="banner1a" id="wows1_4"/></a></li>
		<li><img src="data1/images/banner3.jpg" alt="banner3" title="banner3" id="wows1_5"/></li>
   -->
	</ul>

</div>
	<div class="ws_bullets"><div>
	<!--	<a href="#" title="1"><span><img src="data1/tooltips/1.jpg" alt="1"/>1</span></a>-->
		
		<!-- <a href="#" title="banner1"><span><img src="data1/tooltips/banner1.jpg" alt="banner1"/>4</span></a>
		<a href="#" title="banner1a"><span><img src="data1/tooltips/banner1a.jpg" alt="banner1a"/>5</span></a>
		<a href="#" title="banner3"><span><img src="data1/tooltips/banner3.jpg" alt="banner3"/>6</span></a> -->

	</div>
</div>
<!-- <div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">slider html</a> by WOWSlider.com v9.0</div> -->

<!-- <div class="ws_shadow"></div> -->

</div>	
<script type="text/javascript" src="engine1/wowslider.js"></script>
<script type="text/javascript" src="engine1/script.js"></script>

<!-- End WOWSlider.com BODY section -->
						</div>
                        </div>
                       
                      </div>
                      
                      <div class="col-lg-4 d-flex flex-column">
                            
                          <?php /*?><div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                      <div class="circle-progress-width">
                                        <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2"><strong>CPI</strong></p>
                                        <h4 class="mb-0 fw-bold">0</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="circle-progress-width">
                                        <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2"><strong>SPI</strong></p>
                                        <h4 class="mb-0 fw-bold">0</h4>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div><?php */?>
                          <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                      <h4 class="card-title card-title-dash">Contract Status(Phase 1)</h4>
                                    </div>
                                    <canvas class="my-auto" id="doughnutChart" height="200"></canvas>
                                    <div id="doughnut-chart-legend" class="mt-5 text-center"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                         <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <h4 class="card-title  card-title-dash">Recent Events</h4>
                                <?php
 	$objNews->setProperty("status", "Y");
	$objNews->setProperty("orderby", "newsdate desc");
	$objNews->setProperty("limit", 6);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			
			?>
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                      <a href="pages/project-tools/news/news_detail.php?news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none; color:#000"> <?php echo $rows['title'];?></a>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted"> <a href="pages/project-tools/news/news_detail.php?news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none;color:#000"><?php echo $rows['newsdate'];?></a></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php } }?>
                                                                <div class="list align-items-center pt-3">
                                  <div class="wrapper w-100">
                                    <p class="mb-0">
                                      <a href="pages/project-tools/news/news_info.php" class="fw-bold text-primary">Show all <i class="mdi mdi-arrow-right ms-2"></i></a>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div> 
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences"> 
                     
                    <div class="row">
            
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Project Details</h4>
                 
                  <div class="template-demo">
                   <div class="chartjs-bar-wrapper mt-3">
                                <table class="table table-striped">
                                   <tr>
              <td width="16%" ><strong>Project code:</strong></td>
              <td ><?php echo $pcode; ?></td>
        </tr>
           <tr>
              <td ><strong>SMEC Code:</strong></td>
              <td ><?php echo $smec_code; ?></td>
             </tr>
             <tr>
              <td  ><strong>Project Type:</strong></td>
              <td ><?php if($ptype==1) echo "Time-Based";
			  elseif($ptype==2) echo "Milestone"; ?></td>
            </tr>
           
             <tr>
              <td ><strong>Contract Value:</strong></td>
              <td ><?php echo number_format($pcost,0); ?></td>
             </tr>
             <tr>
              <td ><strong>Sector:</strong></td>
              <td ><?php echo $sector_name; ?></td>
             </tr>
             <tr>
              <td ><strong>Country:</strong></td>
              <td ><?php echo $country_name; ?></td>
             </tr>
             <tr>
              <td ><strong>Location:</strong></td>
              <td ><?php echo $location; ?></td>
             </tr>
             
            <?php /*?><tr>
              <td ><strong>Project Currencies:</strong></td>
              <td ><table class="table table-striped"><tr><td colspan="2"><?php echo "<strong>Base Currency:</strong> ".$base_cur;?></td></tr>
              <tr><td><?php echo "<strong>Currency 1:</strong> ".$cur_1;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_1_rate;?></td></tr>
              <?php if($cur_2!="")
			  {?>
              <tr><td><?php echo "<strong>Currency 2:</strong> ".$cur_2;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_2_rate;?></td></tr>
              <?php }?>
              <?php if($cur_3!="")
			  {?>
              <tr><td><?php echo "<strong>Currency 3:</strong> ".$cur_3;?></td>
              <td><?php echo "<strong>Rate:</strong> ".$cur_3_rate;?></td></tr>
              <?php }?>
              </table></td>
             </tr><?php */?>
             </table>
             
                                </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-stretch">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Timeline</h4>
                       <table class="table table-striped">
                                   
                      <tr>
              <td ><strong>Start Date:</strong></td>
              <td ><?php echo date("d-m-Y", strtotime($pstart)); ?></td>
        </tr>
			 <tr>
              <td ><strong>End Date:</strong></td>
              <td ><?php echo date("d-m-Y", strtotime($pend)); ?></td>
             </tr>
              
             </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Stakeholders</h4>
                     
                      <div class="row">
                        <div class="col-md-4 d-flex align-items-center">
                          <div class="d-flex flex-row align-items-center">
                            <i class="ti-package icon-lg text-warning"></i>
                            <p class="mb-0 ms-1">
                             Client
                            </p>
                          </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                          <div class="d-flex flex-row align-items-center">
                            <i class="ti-package icon-md text-success"></i>
                            <p class="mb-0 ms-1">
                            Fundding Agency
                            </p>
                          </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                          <div class="d-flex flex-row align-items-center">
                            <i class="ti-package icon-sm text-danger"></i>
                            <p class="mb-0 ms-1">
                             Consultant
                            </p>
                          </div>
                        </div>
                        <table class="table table-striped">
                     
              <tr>
              <td ><strong>Client:</strong></td>
              <td ><?php echo $client; ?></td>
             </tr>
               <tr>
              <td ><strong>Consultant:</strong></td>
              <td ><?php echo $consultant; ?></td>
             </tr>
             <tr>
              <td ><strong>Funding Agency:</strong></td>
              <td ><?php echo $funding_agency; ?></td>
             </tr>
             <tr>
              <td ><strong>Contractor:</strong></td>
              <td ><?php echo $contractor; ?></td>
             </tr>
             </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
                  </div>
                  <div class="tab-pane fade show" id="logs" role="tabpanel" aria-labelledby="logs"> 
                     
                    <div class="row">
            
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <!-- <h4 class="card-title">User Logs</h4> -->
                 
                  <div class="template-demo">
                   <div class="chartjs-bar-wrapper mt-3">
                                
                    <!-- logs -->
                    <div>



<h4><?php echo "Log Info"?> <span style="text-align:right; float:right"><a href="<?php echo "index.php"; ?>">Back</a></span></h4>
<table class="table table-hover" width="100%" align="center" cellpadding="1" cellspacing="0" border="0"  >
<tr><td><strong>Name<strong/></td><td><strong>Counter<strong/></td></tr>

<?php
$ne_sadmin 		= $_SESSION['ne_sadmin'];
if($ne_sadmin==1)
{
  $sSQL = "SELECT distinct user_cd FROM mis_tbl_log";
   $objSDb->dbQuery($sSQL);
   $iCount = $objSDb->totalRecords();

// echo "Number of logged in users".$iCount;
if($iCount>0)
{
  while ($prows = $objSDb->dbFetchArray()) {

    $uid = $prows['user_cd'];
	 $sSQL1 = "SELECT * FROM mis_tbl_log where user_cd='$uid'";
    $objSDbCount->dbQuery($sSQL1);
	
	
   // $uname = $prows['user_name'];
    $sSQL1 = "SELECT username FROM mis_tbl_users where user_cd='$uid'";
    $objSDb1->dbQuery($sSQL1);
	$res_name = $objSDb1->dbFetchArray();
	$user_name=$res_name['username'];
	
    $logsCount = $objSDbCount->totalRecords();
    ?>
       <tr><td><?php echo $user_name;?></td>
       <td>
       
  <a href="login_times.php?uidd=<?php echo $uid ;?>&name=<?php echo $user_name;?>" >
  
  
  <?php echo $logsCount.""?></td></tr>


  <?php
   }
}
else
{
?>
<tr><td colspan="11">No Record Found</td></tr>
<?php
}
}
  else
  {
  
  $logSQL = "SELECT * , count(user_cd) as counter FROM mis_tbl_log where user_cd='$uid'";
  $objDb2->dbQuery($logSQL);
  $logsCount = $objDb2->totalRecords();
 	
  while ($prows = $objDb2->dbFetchArray()) {
    $uid = $prows['user_cd'];
	$sSQL1 = "SELECT username FROM mis_tbl_users where user_cd='$uid'";
    $objSDb1->dbQuery($sSQL1);
	$res_name = $objSDb1->dbFetchArray();
	$user_name=$res_name['username'];
  //  $uname = $prows['user_name'];
    $counter					=	$prows['counter'];
    
  
  
  ?>
  <tr>
  <td><?php echo $user_name;?></td>
  <td><a href="login_times.php"><?php echo $counter.""?></td>
</tr>
  <?php
  }
  } 
?>
  
  </table>
 
  
</div>  
                    <!-- logs -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="col-md-6 d-flex align-items-stretch">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Dashbaord Logs</h4>
                       
                    </div>
                  </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Project Tools Logs</h4>
                     
                      <div class="row">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            
            
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

   <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- <script src="js/navtype_session.js"></script> -->
  <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


  <script>
      $(function(){
        $("#partials-navbar").load("partials/_navbar.php");
      });
  </script>

  <script>
    $(function(){
      $("#partials-theme-setting-wrapper").load("partials/_settings-panel.php");
    });
  </script>

  <script>
    $(function(){
      $("#partials-sidebar-offcanvas").load("partials/_sidebar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-footer").load("partials/_footer.php");
  });
</script>



</body>

</html>

