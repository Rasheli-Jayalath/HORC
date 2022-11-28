<?php 
include_once("config/config.php");
include_once("rs_lang.admin.php");
$objSDb  		= new Database();
$objDbB  		= new Database();
$objSDbCount  		= new Database();
$objSDb1 		= new Database();
$objMDb 		= new Database();
$objMDbb 		= new Database();
$objMDbbp 		= new Database();
$objMDbp 		= new Database();
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
$current_date=date('Y-m-d');
$bSql="SELECT sum(baseline) as total_baseline from activity";
$objMDbb->dbQuery($bSql);
$bCount = $objMDbb->totalRecords();
$brows=$objMDbb->dbFetchArray();
$total_baseline=$brows["total_baseline"];
$bpSql="SELECT sum(budgetqty) as total_planned from planned where budgetdate<='$current_date'";
$objMDbbp->dbQuery($bpSql);
$bpCount = $objMDbbp->totalRecords();
$bprows=$objMDbbp->dbFetchArray();
$total_planned=$bprows["total_planned"];
$pSql="SELECT sum(total_progress) as total_progress from activity";
$objMDbp->dbQuery($pSql);
$pCount = $objMDbp->totalRecords();
$prows=$objMDbp->dbFetchArray();
$total_progress=$prows["total_progress"];
if($total_baseline!=0)
{
$physical_progress=$total_progress/$total_baseline*100;
$planned_progress=$total_planned/$total_baseline*100;
}
else
{
	$physical_progress=0;
	$planned_progress=0;
}
  $mSql="SELECT max(progressmonth) as progress_month from activity";
  $objMDb->dbQuery($mSql);
$mCount = $objMDb->totalRecords();
$mrows=$objMDb->dbFetchArray();
if($mCount>0 && $mrows["progress_month"]!="" && $mrows["progress_month"]!=NULL)
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
	 $SqlII="SELECT sum(b.boq_cur_1_rate*a.ipcqty) as this_amount FROM ipcv a inner join boq b on(a.boqid=b.boqid) ";
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
	$financial_progress=$this_amount/$total_amount*100;
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
}
#progress_table
{
	max-height: 400px;
    overflow: auto;
}
</style>
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
      <!-- <div id="partials-theme-setting-wrapper"></div> -->
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
                      <a class="nav-link border-0" id="logs-tab" data-bs-toggle="tab" href="#logs" role="tab" aria-selected="false">Procurement Plan
                      </a>
                    </li>
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                      <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                      <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                      
                      <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuSizeButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFF">
                        Progress Month
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton1">
	   <a href="<?php echo SITE_URL;?>index.php?progressmonth=<?php echo date('Y-m-d',strtotime('2022-10-31')); ?>"class="dropdown-item" ><?php echo date('Y-m-d',strtotime('2022-10-31')); ?></a>
                        <a href="<?php echo SITE_URL;?>index.php?progressmonth=<?php echo date('Y-m-d',strtotime('2022-09-30')); ?> "class="dropdown-item" ><?php echo date('Y-m-d',strtotime('2022-09-30')); ?></a>
                       
                        
                    </div>
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
                            <h3 class="rate-percentage"><?php //if($planned_progress!=0) echo number_format($planned_progress,2); else echo "0"; ?> 25 %</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>This Month: 4.17%</span></p>
                          </div>
                        <div>
                            <p class="statistics-title" style="color:#006"><strong>Physical Progress</strong></p>
                            <h3 class="rate-percentage"><?php //if($physical_progress!=0) echo number_format($physical_progress,2); else echo "0"; ?>8.87%</h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>Gap: <?php 
							//echo number_format($planned_progress-$physical_progress,2);?>16.13%</span></p>
                          </div>
                          
                          <div>
                            <p class="statistics-title" style="color:#006"><strong>Financial Progress</strong></p>
                            <h3 class="rate-percentage" ><?php //echo number_format($financial_progress,2);?> 10.62%</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>0%</span></p>
                          </div>

                        <div>
                            <p class="statistics-title" style="color:#006"><strong>Total Contract Cost</strong></p>
                            <h3 class="rate-percentage"><?php echo $amount_million. " M";?></h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title" style="color:#006"><strong>TOTAL PAYMENT (Gross Amt ) </strong></p>
                            <h3 class="rate-percentage"><?php //echo $this_amount_million. " M";?>689.82 M</h3>
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
                    <div class="col-lg-12 d-flex flex-column">
                        <div class="row flex-grow" >
                         <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                                 <div class="table-responsive pt-1">
<?php if(isset($_REQUEST['progressmonth'])&&$_REQUEST['progressmonth']!=''&&$_REQUEST['progressmonth']!=NULL&&$_REQUEST['progressmonth']=='2022-09-30')
{?>
                    <table class="table table-bordered" width="100%" align="center">
                      <thead style="text-align:center; background-color:#A9D2F8">


                                  <tr>
                                    <th colspan="11"><a>Progress as of September 2022</a></th>
                                  </tr>
                                  <tr>
                                    <th rowspan="4" align="center">Contractor</th>
                                    <th rowspan="4">PKG</th>
                                    <th rowspan="4">Lot</th>
                                    <th rowspan="4" >Original<br>
                                      Contract<br/>Amount<br>
                                      (INR)</th>
                                    <th rowspan="4" >Effective<br>
                                      Date</th>
                                    <th rowspan="2" >Closing<br>
                                      Date</th>
                                    <th colspan="3">Physical Progress (%)</th>
                                    <th colspan="2" rowspan="2" >Financial Progress (%)</th>
                                  </tr>
                                  <tr>
                                    <th rowspan="3" >Cum.<br/>Progress</th>
                                    <th>Target*</th>
                                    <th rowspan="3" >This <br>Month<br/>Progress</th>
                                  </tr>
                                  <tr>
                                    <th>Original</th>
                                    <th>Original</th>
                                    <th rowspan="2" >Actual.<br/>Expndit.</th>
                                    <th rowspan="2" >Disb.</th>
                                  </tr>
                                  <tr>
                                    <th>Revised</th>
                                    <th>Revised</th>
                                  </tr>
                                  </thead>
                                    <tbody>
                                  <tr>
                                    <td rowspan="6" > <strong>Ashoka</strong></td>
                                    <td rowspan="6" >1</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2" >485,094,194</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">29.28%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">1.77%</td>
                                    <td rowspan="2">30.95%</td>
                                    <td rowspan="2">17.36%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2">Lot-II</td>
                                    <td rowspan="2">596,600,502</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">23.02%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">1.91%</td>
                                    <td rowspan="2">24.95%</td>
                                    <td rowspan="2">13.88%</td>
                                  </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 558,239,103</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">24.27%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">2.87%</td>
                                    <td rowspan="2">24.11%</td>
                                    <td rowspan="2">13.20%</td>
                                  </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="16" ><strong>Laser</strong></td>
                                    <td rowspan="2" >2</td>
                                    <td rowspan="2" ></td>
                                    <td rowspan="2">123,90,56,679</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">0.30%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.15%</td>
                                    <td rowspan="2">3.86%</td>
                                    <td rowspan="2">3.73%</td>
                                  </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="6" >4</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 280,175,987</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">0.29%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.09%</td>
                                    <td rowspan="2">3.74%</td>
                                    <td rowspan="2">3.61%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 474,749,935</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>4/30/2024</td>
                                    <td rowspan="2">0.90%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.12%</td>
                                    <td rowspan="2">3.83%</td>
                                    <td rowspan="2">3.70%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 349,221,749</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>4/30/2024</td>
                                    <td rowspan="2">0.12%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.03%</td>
                                    <td rowspan="2">3.90%</td>
                                    <td rowspan="2">3.76%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="4" >5</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 512,370,510 </td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.12%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.01%</td>
                                    <td rowspan="2">3.91%</td>
                                    <td rowspan="2">3.78%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 393,740,371</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.21%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">3.86%</td>
                                    <td rowspan="2">3.73%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >13</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 201,008,302</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.32%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.04%</td>
                                    <td rowspan="2">3.95%</td>
                                    <td rowspan="2">3.82%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >14</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 194,906,599</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.56%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">3.94%</td>
                                    <td rowspan="2">3.81%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="26" ><strong>Gopi</strong></td>
                                    <td rowspan="2" >7</td>
                                    <td rowspan="2" ></td>
                                    <td rowspan="2"> 1,134,908,934</td>
                                    <td rowspan="2">01-05-2022</td>

                                    <td>30-04-2024</td>
                                    <td rowspan="2">3.96%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">1.68%</td>
                                    <td rowspan="2">4.68%</td>
                                    <td rowspan="2">4.52%</td>
                                  </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >12</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 196,016,554</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.59%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">8.47%</td>
                                    <td rowspan="2">19.48%</td>
                                    <td rowspan="2">9.12%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="4" >13</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 170,970,906</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">3.76%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.67%</td>
                                    <td rowspan="2">4.51%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 186,886,478</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.37%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.65%</td>
                                    <td rowspan="2">4.49%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >14</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 163,731,784</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.22%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">1.11%</td>
                                    <td rowspan="2">4.70%</td>
                                    <td rowspan="2">4.54%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="4" >16</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2">    194,326,203</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">5.86%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.62%</td>
                                    <td rowspan="2">4.74%</td>
                                    <td rowspan="2">4.58%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 197,654,519</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.03%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.74%</td>
                                    <td rowspan="2">4.58%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="4" >17</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 169,029,943</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">6.41%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">4.88%</td>
                                    <td rowspan="2">4.76%</td>
                                    <td rowspan="2">4.59%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 221,144,387</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">5.38%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">3.42%</td>
                                    <td rowspan="2">4.77%</td>
                                    <td rowspan="2">4.61%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="6" >18</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 156,769,533</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.25%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">7.94%</td>
                                    <td rowspan="2">23.21%</td>
                                    <td rowspan="2">13.10%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 152,843,511</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">19.32%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">13.30%</td>
                                    <td rowspan="2">21.55%</td>
                                    <td rowspan="2">12.11%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 133,017,510</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">6.57%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">2.22%</td>
                                    <td rowspan="2">4.63%</td>
                                    <td rowspan="2">4.47%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >19</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 132,936,514</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">5.29%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">2.39%</td>
                                    <td rowspan="2">17.46%</td>
                                    <td rowspan="2">7.91%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="6" ><strong>P&amp;I</strong></td>
                                    <td rowspan="4" >11</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2">150,931,450</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">0.04%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2" width="74">4.67%</td>
                                    <td rowspan="2" width="73">4.52%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 130,375,103</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.05%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.63%</td>
                                    <td rowspan="2">4.47%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >12</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 158,591,284</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.04%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">0.00%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="6" ><strong>Vikran</strong></td>
                                    <td rowspan="4" >15</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 185,688,278</td>
                                    <td rowspan="2">02-05-2022</td>
                                    <td>01-05-2024</td>
                                    <td rowspan="2">1.86%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">1.16%</td>
                                    <td rowspan="2">0.14%</td>
                                    <td rowspan="2">0.12%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 201,632,639</td>
                                    <td rowspan="2">02-05-2022</td>
                                    <td>01-05-2024</td>
                                    <td rowspan="2">0.09%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">0.07%</td>
                                    <td rowspan="2">0.06%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" >19</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2">139,896,864</td>
                                    <td rowspan="2">02-05-2022</td>
                                    <td>01-05-2024</td>
                                    <td rowspan="2">0.26%</td>
                                    <td>20.83%</td>
                                    <td rowspan="2">0.15%</td>
                                    <td rowspan="2">0.07%</td>
                                    <td rowspan="2">0.06%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>20.83%</td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" ><strong>SMEC</strong></td>
                                    <td rowspan="2" >PMC</td>
                                    <td rowspan="2">N/A</td>
                                    <td rowspan="2">157,500,000</td>
                                    <td rowspan="2">01-09-2021</td>
                                    <td>31-08-2026</td>
                                    <td rowspan="2">19.50%</td>
                                    <td>21.66%</td>
                                    <td rowspan="2">1.62%</td>
                                    <td rowspan="2">27.38%</td>
                                    <td rowspan="2">18.94%</td>
                                  </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>21.66%</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><strong>TOTAL</strong> <strong>PROGRESS</strong></td>
                                    <td>8.35%</td>
                                    <td></td>
                                    <td>0.26%</td>
                                    <td>9.18%</td>
                                    <td>6.28%</td>
                                  </tr>
                                  </tbody>
                                </table>
                                <?php }
								else
								{?>
                                <table class="table table-bordered" width="100%" align="center" style="position:relative; min-height:100px; overflow:auto">
                      <thead style="text-align:center; background-color:#A9D2F8">


                                  <tr>
                                    <th colspan="11" style="position:sticky;top:0;"><a>Progress as of October 2022</a></th>
                                  </tr>
                                  <tr>
                                    <th style="position:sticky;top:0;"  rowspan="4" align="center">Contractor</th>
                                    <th style="position:sticky;top:0;"  rowspan="4">PKG</th>
                                    <th style="position:sticky;top:0;"  rowspan="4">Lot</th>
                                    <th style="position:sticky;top:0;"  rowspan="4" >Original<br>
                                      Contract<br/>Amount<br>
                                      (INR)</th>
                                    <th style="position:sticky;top:0;"  rowspan="4" >Effective<br>
                                      Date</th>
                                    <th style="position:sticky;top:0;"  rowspan="2" >Closing<br>
                                      Date</th>
                                    <th style="position:sticky;top:0;"  colspan="3">Physical Progress (%)</th>
                                    <th style="position:sticky;top:0;"  colspan="2" rowspan="2" >Financial Progress (%)</th>
                                  </tr>
                                  <tr>
                                    <th style="position:sticky;top:0;"  rowspan="3" >Cum.<br/>Progress</th>
                                    <th style="position:sticky;top:0;" >Target*</th>
                                    <th style="position:sticky;top:0;"  rowspan="3" >This <br>Month<br/>Progress</th>
                                  </tr>
                                  <tr>
                                    <th style="position:sticky;top:0;" >Original</th>
                                    <th style="position:sticky;top:0;" >Original</th>
                                    <th style="position:sticky;top:0;"  rowspan="2" >Actual.<br/>Expndit.</th>
                                    <th style="position:sticky;top:0;"  rowspan="2" >Disb.</th>
                                  </tr>
                                  <tr>
                                    <th style="position:sticky;top:0;" >Revised</th>
                                    <th style="position:sticky;top:0;" >Revised</th>
                                  </tr>
                                  </thead>
                                    <tbody>
                                  <tr>
                                    <td rowspan="6" > <strong>Ashoka</strong></td>
                                    <td rowspan="6" >1</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2" >485,094,194</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2" width="71">33.45%</td>
                                    <td width="83">25.00%</td>
                                    <td rowspan="2" width="85">4.17%</td>
                                    <td rowspan="2" width="75">30.95%</td>
                                    <td rowspan="2" width="72">17.36%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2">Lot-II</td>
                                    <td rowspan="2">596,600,502</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">31.51%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">8.49%</td>
                                    <td rowspan="2">24.95%</td>
                                    <td rowspan="2">13.88%</td>
                                    </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 558,239,103</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">26.25%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">1.98%</td>
                                    <td rowspan="2">24.11%</td>
                                    <td rowspan="2">13.20%</td>
                                    </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="16" ><strong>Laser</strong></td>
                                    <td rowspan="2" >2</td>
                                    <td rowspan="2" ></td>
                                    <td rowspan="2">123,90,56,679</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">0.68%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.38%</td>
                                    <td rowspan="2">3.86%</td>
                                    <td rowspan="2">3.73%</td>
                                    </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="6" >4</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 280,175,987</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">0.40%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.11%</td>
                                    <td rowspan="2">3.74%</td>
                                    <td rowspan="2">3.61%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 474,749,935</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>4/30/2024</td>
                                    <td rowspan="2">1.01%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.11%</td>
                                    <td rowspan="2">3.83%</td>
                                    <td rowspan="2">3.70%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 349,221,749</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>4/30/2024</td>
                                    <td rowspan="2">0.12%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">3.90%</td>
                                    <td rowspan="2">3.76%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="4" >5</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 512,370,510 </td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.18%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.06%</td>
                                    <td rowspan="2">3.91%</td>
                                    <td rowspan="2">3.78%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 393,740,371</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.21%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">3.86%</td>
                                    <td rowspan="2">3.73%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >13</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 201,008,302</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.71%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.39%</td>
                                    <td rowspan="2">3.95%</td>
                                    <td rowspan="2">3.82%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >14</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 194,906,599</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.40%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.13%</td>
                                    <td rowspan="2">3.94%</td>
                                    <td rowspan="2">3.81%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="26" ><strong>Gopi</strong></td>
                                    <td rowspan="2" >7</td>
                                    <td rowspan="2" ></td>
                                    <td rowspan="2"> 1,134,908,934</td>
                                    <td rowspan="2">01-05-2022</td>

                                    <td>30-04-2024</td>
                                    <td rowspan="2">3.97%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.68%</td>
                                    <td rowspan="2">4.52%</td>
                                    </tr>
                                  <tr>
                                    <td >N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >12</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 196,016,554</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.68%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.09%</td>
                                    <td rowspan="2">19.48%</td>
                                    <td rowspan="2">9.12%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="4" >13</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 170,970,906</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">6.23%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">2.47%</td>
                                    <td rowspan="2">4.67%</td>
                                    <td rowspan="2">4.51%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 186,886,478</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.98%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.61%</td>
                                    <td rowspan="2">4.65%</td>
                                    <td rowspan="2">4.49%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >14</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 163,731,784</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">17.26%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.04%</td>
                                    <td rowspan="2">4.70%</td>
                                    <td rowspan="2">4.54%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="4" >16</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2">    194,326,203</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">6.95%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">1.09%</td>
                                    <td rowspan="2">4.74%</td>
                                    <td rowspan="2">4.58%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 197,654,519</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.03%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.74%</td>
                                    <td rowspan="2">4.58%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="4" >17</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 169,029,943</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">18.72%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">12.31%</td>
                                    <td rowspan="2">4.76%</td>
                                    <td rowspan="2">4.59%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 221,144,387</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">8.24%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">2.86%</td>
                                    <td rowspan="2">4.77%</td>
                                    <td rowspan="2">4.61%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="6" >18</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 156,769,533</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">21.86%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">4.61%</td>
                                    <td rowspan="2">23.21%</td>
                                    <td rowspan="2">13.10%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 152,843,511</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">21.86%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">2.54%</td>
                                    <td rowspan="2">21.55%</td>
                                    <td rowspan="2">12.11%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-III</td>
                                    <td rowspan="2"> 133,017,510</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">6.71%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.14%</td>
                                    <td rowspan="2">4.63%</td>
                                    <td rowspan="2">4.47%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >19</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 132,936,514</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">6.71%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">1.42%</td>
                                    <td rowspan="2">17.46%</td>
                                    <td rowspan="2">7.91%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="6" ><strong>P&amp;I</strong></td>
                                    <td rowspan="4" >11</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2">150,931,450</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td >30-04-2024</td>
                                    <td rowspan="2">0.04%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2" width="75">4.67%</td>
                                    <td rowspan="2" width="72">4.52%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 130,375,103</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.05%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">4.63%</td>
                                    <td rowspan="2">4.47%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >12</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 158,591,284</td>
                                    <td rowspan="2">01-05-2022</td>
                                    <td>30-04-2024</td>
                                    <td rowspan="2">0.04%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    <td rowspan="2">0.00%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="6" ><strong>Vikran</strong></td>
                                    <td rowspan="4" >15</td>
                                    <td rowspan="2" >Lot-I</td>
                                    <td rowspan="2"> 185,688,278</td>
                                    <td rowspan="2">02-05-2022</td>
                                    <td>01-05-2024</td>
                                    <td rowspan="2">2.81%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">0.95%</td>
                                    <td rowspan="2">0.14%</td>
                                    <td rowspan="2">0.12%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2"> 201,632,639</td>
                                    <td rowspan="2">02-05-2022</td>
                                    <td>01-05-2024</td>
                                    <td rowspan="2">5.42%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">5.33%</td>
                                    <td rowspan="2">0.07%</td>
                                    <td rowspan="2">0.06%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" >19</td>
                                    <td rowspan="2" >Lot-II</td>
                                    <td rowspan="2">139,896,864</td>
                                    <td rowspan="2">02-05-2022</td>
                                    <td>01-05-2024</td>
                                    <td rowspan="2">6.79%</td>
                                    <td>25.00%</td>
                                    <td rowspan="2">6.53%</td>
                                    <td rowspan="2">0.07%</td>
                                    <td rowspan="2">0.06%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>25.00%</td>
                                    </tr>
                                  <tr>
                                    <td rowspan="2" ><strong>SMEC</strong></td>
                                    <td rowspan="2" >PMC</td>
                                    <td rowspan="2">N/A</td>
                                    <td rowspan="2">157,500,000</td>
                                    <td rowspan="2">01-09-2021</td>
                                    <td>31-08-2026</td>
                                    <td rowspan="2">20.96%</td>
                                    <td>23.33%</td>
                                    <td rowspan="2">1.46%</td>
                                    <td rowspan="2">27.38%</td>
                                    <td rowspan="2">18.94%</td>
                                    </tr>
                                  <tr>
                                    <td>N/A</td>
                                    <td>23.33%</td>
                                    </tr>
                                  <tr>
                                    <td colspan="6"><strong>TOTAL</strong> <strong>PROGRESS</strong></td>
                                    <td>8.87%</td>
                                    <td></td>
                                    <td>0.52%</td>
                                    <td>10.62%</td>
                                    <td>7.29%</td>
                                    </tr>
                                  </tbody>
                                </table>
                                <?php }?>
                                </div>
                            </div>
                        </div>
						</div>
                        </div>
                       
                      </div>
                      <?php /*?><div class="col-lg-8 d-flex flex-column">
                        
                        <div class="row flex-grow" >
                         <div class="col-12 grid-margin stretch-card">

                         <!-- %%%%%%%%%%%%%%%% -->

                          <!-- Start  BODY section -->
                          <div id="wowslider-container1">

                          <div class="ws_images" style="width:1200px">
                          <ul>
                         
                          <?php
                                
                          $SqlB="SELECT * FROM banner where visible_status = 1";
	                      $objDbB->dbQuery($SqlB);
                          $ICount = $objDbB->totalRecords();
                          if($ICount>0)
                          {
	                      while($brows=$objDbB->dbFetchArray()) 
                              {  
                               
                          ?>
                          <div >
                          <li><img src="pages/project-tools/photo_slider/<?php echo 'banner/'.$brows['banner_image'];?>"  />
                          <div class="centered">
                          <!-- <h3>
                            <?php 
                          echo $brows['banner_title']; 
                          ?>
                          </h3> -->
                          </div>
                           </li>
                          </div>
                         
                            
                            <?php  
                                
                                  }
                                  } 
                          ?>

                          </ul>
                          </div> 

                          <div class="ws_bullets">
                            
                            
                          </div>


                          </div>	
                        


<!-- <div class="ws_shadow"></div> -->
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet"> 
</div>	

<!-- End WOWSlider.com BODY section -->
						</div>
                       
                      </div><?php */?>
                     <!-- <div class="col-lg-4 d-flex flex-column">-->
                            
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
                         <?php /*?><div class="col-md-6 col-lg-12 grid-margin stretch-card">
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
                                      <?php echo $rows['title'];?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted"><?php echo $rows['newsdate'];?></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php } }?>
                                                                <div class="list align-items-center pt-3">
                                  <div class="wrapper w-100">
                                    <p class="mb-0">
                                      <a href="#" class="fw-bold text-primary">Show all <i class="mdi mdi-arrow-right ms-2"></i></a>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div><?php */?> 
                     <!-- </div>-->
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



<h4><?php echo "Procurement Plan"?> <span style="text-align:right; float:right"><a href="<?php echo "index.php"; ?>">Back</a></span></h4>
<div class="table-responsive">
                    <table class="table table-bordered" width="100%" >
                      <thead style="text-align:center; background-color:#A9D2F8">

  <tr>
    <td colspan="21"><strong>Project Name: P000315 - India Assam Distribution System    Enhancement</strong></td>
  </tr>
  <tr>
    <td colspan="21"><strong>Procurement Plan</strong></td>
  </tr>
  <tr>
    <td colspan="14"><strong>Project    Implementation Entity: Assam Power Distribution Company Limited</strong></td>
    <td colspan="4"><strong>Revision No:03</strong></td>
    <td colspan="3"><strong>Revision Date: 14/09/2022</strong></td>
  </tr>
  <tr>
    <td colspan="11"><strong>Specific Procurement Arrangements</strong></td>
    <td colspan="2" ><strong>Scheduled Dates</strong></td>
    <td colspan="6" ><strong>Contract Award Details</strong></td>
    <td rowspan="2" ><strong>Contract Implementation Status</strong></td>
    <td rowspan="2" ><strong>Remarks</strong><br>
      <strong>(such as Advance Contracting)</strong></td>
  </tr>
  <tr>
    <td><strong>Sl No.</strong></td>
    <td><strong>Contract    No.</strong></td>
    <td><strong>Package    No</strong></td>
    <td><strong>Description    of Contract</strong></td>
    <td><strong>Cost Estimate in INR crores</strong></td>
    <td><strong>Cost    Estimate in USD (million)</strong></td>
    <td><strong>Funding    Source by AIIB (%)</strong></td>
    <td><strong>Funding    Source by Others (%)</strong></td>
    <td><strong>Procurement    Category</strong></td>
    <td><strong>Procurement    Method</strong></td>
    <td><strong>Review    by Bank</strong><br>
     <strong> (Prior or Post)</strong></td>
    <td><strong>Tender    Invitation (MM/YY)</strong></td>
    <td><strong>Contract    Signing (MM/YY)</strong></td>
    <td ><strong>Contract    Price in Local Currency</strong></td>
    <td ><strong>Contract    Price (US$ millions)</strong></td>
    <td ><strong>Contractor&rsquo;s    Name</strong></td>
    <td><strong>Origin    of Country</strong></td>
    <td ><strong>Contract    Signing Date</strong></td>
    <td ><strong>Contract    Period (Months)</strong></td>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>1</td>
    <td >APDCL/AIIB/PMC/2019</td>
    <td >&nbsp;</td>
    <td>Selection    of Project Management Consultant (PMC)</td>
    <td >76.14</td>
    <td>10.88</td>
    <td >100</td>
    <td >0</td>
    <td >Service</td>
    <td>QCBS</td>
    <td>Prior</td>
    <td>Dec-19</td>
    <td >Aug-21</td>
    <td>15,75,00,000.00</td>
    <td >2.12</td>
    <td >M/S    SMEC International Pty Ltd JV with M/S SMEC India Ltd</td>
    <td >Australia</td>
    <td >20-Aug-21</td>
    <td >60</td>
    <td>Running</td>
    <td >Inception report,    MPR etc submitted..survey of Substation site going on</td>
  </tr>
  <tr>
    <td rowspan="4">2</td>
    <td rowspan="4" >APDCL/DSELR/MGD/02</td>
    <td rowspan="4" >1</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Mangaldoi Electrical Circle on    Turnkey basis",90,"</br></br>");?></td>
    <td >191.67</td>
    <td>27.38</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Prior</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>1,63,99,33,799.00</td>
    <td >23.42</td>
    <td >M/S    Ashoka Buildcon Ltd</td>
    <td >India</td>
    <td >7-Dec-21</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="4" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT - I: Mangaldoi Electrical    Circle &ndash; Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >56.09</td>
    <td>8.01</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Prior</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>48,50,94,194.2</td>
    <td >6.93</td>
    <td >M/S    Ashoka Buildcon Ltd</td>
    <td >India</td>
    <td >7-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT - II: Mangaldoi Electrical    Circle &ndash; Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >69.96</td>
    <td>9.99</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Prior</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>59,66,00,502.51</td>
    <td >8.52</td>
    <td >M/S    Ashoka Buildcon Ltd</td>
    <td >India</td>
    <td >7-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT - III: Mangaldoi Electrical    Circle &ndash; Part III on Turnkey basis",90,"</br></br>");?></td>
    <td >65.62</td>
    <td>9.38</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Prior</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>55,82,39,102.79</td>
    <td >7.97</td>
    <td >M/S    Ashoka Buildcon Ltd</td>
    <td >India</td>
    <td >7-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td>3</td>
    <td >APDCL/DSELR/BNG/02</td>
    <td >2</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Bongaigaon Electrical Circle on    Turnkey basis",90,"</br></br>");?></td>
    <td >147.17</td>
    <td>21.02</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>123,90,56,679.00</td>
    <td >17.7</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
    <td >LOA    issued in 07-11-2021</td>
  </tr>
  <tr>
    <td>4</td>
    <td >APDCL/DSELR/KJH/03</td>
    <td >3</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Kokrajhar Electrical Circle on    Turnkey basis",90,"</br></br>");?></td>
    <td >61.48</td>
    <td>8.78</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>May-22</td>
    <td >Sep-22</td>
    <td>-</td>
    <td >-</td>
    <td >-</td>
    <td >-</td>
    <td >-</td>
    <td >24</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">5</td>
    <td rowspan="4" >APDCL/DSELR/RNG/02</td>
    <td rowspan="4" >4</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Barpeta and Rangia Electrical Circle    on Turnkey basis in LOT- I - Barpeta Electrical Circle &ndash;Part I, LOT- II -    Rangia Electrical Circle- Part I, LOT-III - Rangia Electrical Circle &ndash; Part    II Turnkey basis",90,"</br></br>");?></td>
    <td >131.25</td>
    <td>18.75</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>110,41,47,671.00</td>
    <td >15.77</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="4" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT - I: Barpeta Electrical Circle    on Turnkey basis&nbsp;",90,"</br></br>");?></td>
    <td >33.04</td>
    <td>4.72</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>280175986.70</td>
    <td >4.00</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT - II: Rangia Electrical Circle    - Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >56.57</td>
    <td>8.08</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>474749935.260</td>
    <td >6.78</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT - III: Rangia Electrical    Circle - Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >41.64</td>
    <td>5.95</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>349221749.53</td>
    <td >4.99</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3">6</td>
    <td rowspan="3" >APDCL/DSELR/NLP/02</td>
    <td rowspan="3" >5</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in N. Lakhimpur Electrical Circle on    Turnkey basis in LOT- I &ndash;N. Lakhimpur Electrical Circle &ndash;Part I, LOT- II &ndash;N.    Lakhimpur Electrical Circle- Part II&nbsp;",90,"</br></br>");?></td>
    <td >106.28</td>
    <td>14.28</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Nov-20</td>
    <td >Dec-21</td>
    <td>&nbsp;90,61,10,881.00</td>
    <td >15.18</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;N. Lakhimpur Electrical    Circle &ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >60.37</td>
    <td>8.62</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>&nbsp;</td>
    <td >Dec-21</td>
    <td>51,23,70,510.41</td>
    <td >7.32</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd(in 2 Lots)</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;N. Lakhimpur Electrical    Circle &ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >45.91</td>
    <td>6.56</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>&nbsp;</td>
    <td >Dec-21</td>
    <td>39,37,40,370.97</td>
    <td >5.62</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3">7</td>
    <td rowspan="3" >APDCL/DSELR/TEC 'A'/01</td>
    <td rowspan="3" >11</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Tezpur Electrical Circle A on    Turnkey basis in LOT- I &ndash;Tezpur Electrical Circle B&ndash;Part I, LOT- II &ndash;Tezpur    Electrical Circle B - Part II&nbsp;",90,"</br></br>");?></td>
    <td >33.57</td>
    <td>4.8</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">28,13,06,552.56</td>
    <td >4.02</td>
    <td >Power    Instrumentation(Guj)Ltd JV with Shalaka Infratech(I) Pvt Ltd and M/S B&amp;B    Associates</td>
    <td >India</td>
    <td >2-Dec-21</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Tezpur Electrical Circle    A&ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >18.02</td>
    <td>2.57</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">15,09,31,450.28</td>
    <td >2.16</td>
    <td >Power    Instrumentation(Guj)Ltd JV with Shalaka Infratech(I) Pvt Ltd and M/S B&amp;B    Associates</td>
    <td >India</td>
    <td >2-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;Tezpur Electrical Circle    A - Part II on Turn Key basis",90,"</br></br>");?></td>
    <td >15.55</td>
    <td>2.22</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">13,03,75,102.28</td>
    <td >1.86</td>
    <td >Power    Instrumentation(Guj)Ltd JV with Shalaka Infratech(I) Pvt Ltd and M/S B&amp;B    Associates</td>
    <td >India</td>
    <td >2-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3">7</td>
    <td rowspan="3" >APDCL/DSELR/TEC 'B'/01</td>
    <td rowspan="3" >12</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Tezpur Electrical Circle B on    Turnkey basis in LOT- I &ndash;Tezpur Electrical Circle B&ndash;Part I, LOT- II &ndash;Tezpur    Electrical Circle B - Part II&nbsp;",90,"</br></br>");?></td>
    <td>42.43</td>
    <td>6.06</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">35,46,07,802.00</td>
    <td >5.06</td>
    <td >Two    different firms have secured L1    in separate Lots</td>
    <td >India</td>
    <td >-</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Tezpur Electrical Circle    B&ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td>23.54</td>
    <td>3.36</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">19,60,16,554.00</td>
    <td >2.80</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;Tezpur Electrical Circle    B&ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td>18.89</td>
    <td>2.70</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">15,85,91,248.00</td>
    <td >2.26</td>
    <td >Shalaka    Infratech(I) Pvt Ltd JV with Power Instrumentation(Guj)Ltd&nbsp; and M/S B&amp;B Associates</td>
    <td >India</td>
    <td >Mar-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="4">8</td>
    <td rowspan="4" >APDCL/DSELR/NGN 'A'/01</td>
    <td rowspan="4" >13</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Nagaon Electrical Circle A on    Turnkey basis in LOT- I &ndash;Nagaon Electrical Circle A&ndash;Part I, LOT- II &ndash;Nagaon    Electrical Circle A - Part II, LOT- III &ndash;Nagaon Electrical Circle A - Part    III",90,"</br></br>");?></td>
    <td >67.05</td>
    <td>9.57</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">55,88,65,686.00</td>
    <td >7.98</td>
    <td >Two    different firms have secured L1 in separate Lots</td>
    <td >India</td>
    <td >&nbsp;</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="4" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Nagaon Electrical Circle    A&ndash;Part I Turnkey basis",90,"</br></br>");?></td>
    <td >24.32</td>
    <td>3.47</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">20,10,08,302.00</td>
    <td >2.87</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;Nagaon Electrical Circle    A&ndash;Part II Turnkey basis",90,"</br></br>");?></td>
    <td >20.05</td>
    <td>2.86</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">17,09,70,906.00</td>
    <td >2.44</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-III &ndash;Nagaon Electrical Circle    A&ndash;Part III Turnkey basis",90,"</br></br>");?></td>
    <td >22.68</td>
    <td>3.24</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">18,68,86,478</td>
    <td >2.67</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3">9</td>
    <td rowspan="3" >APDCL/DSELR/NGN 'B'/01</td>
    <td rowspan="3" >14</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Morigaon and Nagaon B&nbsp;    Electrical Circle&nbsp; on Turnkey basis in LOT- I &ndash;Morigaon Electrical Circle &ndash;Part I,    LOT- II &ndash;Nagaon Electrical Circle B - Part II",90,"</br></br>");?></td>
    <td >41.62</td>
    <td>5.94</td>
    <td >80</td>
    <td >20</td>
    <td >EPC</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">356838383</td>
    <td >5.12</td>
    <td >Two    different firms have secured L1 in separate Lots</td>
    <td >India</td>
    <td >-</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Morigaon Electrical Circle    &ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >18.97</td>
    <td>2.7</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">16,37,31,784.00</td>
    <td >2.34</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;Nagaon Electrical Circle    B&ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >22.65</td>
    <td>3.24</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">19,49,06,599.00</td>
    <td >2.78</td>
    <td >M/S    Laser Power &amp; Infra Pvt Ltd</td>
    <td >India</td>
    <td >16-Dec-21</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td>10</td>
    <td >APDCL/DSELR/CNB/01</td>
    <td >7</td>
    <td><?php echo wordwrap("Construction of new 33/11 KV    sub-stations, Construction of 33 KV and 11 KV lines, 33 KV terminal    equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Cachar &amp; Badarpur Electrical    Circle on Turnkey basis",90,"</br></br>");?></td>
    <td >133.54</td>
    <td>19.08</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">113,49,08,934.00</td>
    <td >16.21</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
    <td >LOA    issued in 07-11-2021</td>
  </tr>
  <tr>
    <td rowspan="3">11</td>
    <td rowspan="3" >APDCL/DSELR/DIB/01</td>
    <td rowspan="3" >15</td>
    <td><?php echo wordwrap("Construction of    new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Dibrugarh Electrical Circle on    Turnkey basis in LOT- I &ndash;Dibrugarh Electrical Circle &ndash;Part I, LOT- II    &ndash;Dibrugarh Electrical Circle- Part II",90,"</br></br>");?></td>
    <td >47.32</td>
    <td>6.76</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">38,73,20,918.00</td>
    <td >5.53</td>
    <td >Vikran    Enginerring &amp; Exim Pvt Ltd</td>
    <td >India</td>
    <td >11-Jan-22</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Dibrugarh Electrical    Circle &ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >22.97</td>
    <td>3.28</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">18,56,88,279.00</td>
    <td >2.65</td>
    <td >Vikran    Enginerring &amp; Exim Pvt Ltd</td>
    <td >India</td>
    <td >11-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;Dibrugarh Electrical    Circle &ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >24.35</td>
    <td>3.48</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">20,16,32,639.00</td>
    <td >2.88</td>
    <td >Vikran    Enginerring &amp; Exim Pvt Ltd</td>
    <td >India</td>
    <td >11-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3" width="41">12</td>
    <td rowspan="3" >APDCL/DSELR/JOR/01</td>
    <td rowspan="3" >17</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Jorhat Electrical Circle on Turnkey    basis in LOT- I &ndash;Jorhat Electrical Circle &ndash;Part I, LOT- II &ndash;Jorhat Electrical    Circle- Part II&nbsp;",90,"</br></br>");?></td>
    <td >44.86</td>
    <td>6.40</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">39,01,74,330.00</td>
    <td >5.57</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Jorhat Electrical Circle    &ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >19.98</td>
    <td>2.85</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">16,90,29,943.00</td>
    <td >2.41</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash;Jorhat Electrical Circle    &ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >24.88</td>
    <td>3.55</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Dec-20</td>
    <td >Dec-21</td>
    <td width="143">22,11,44,387.00</td>
    <td >3.16</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3">13</td>
    <td rowspan="3" >APDCL/DSELR/KAN/01</td>
    <td rowspan="3" >16</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Kanch Electrical Circle on Turnkey    basis in LOT- I &ndash;Kanch Electrical Circle &ndash;Part I, LOT- II &ndash;Kanch Electrical    Circle- Part II&nbsp;",90,"</br></br>");?></td>
    <td >45.34</td>
    <td>6.48</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Feb-21</td>
    <td >Dec-21</td>
    <td width="143">39,19,80,723.00</td>
    <td >5.60</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Kanch Electrical Circle    &ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >22.48</td>
    <td>3.21</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Feb-21</td>
    <td >Dec-21</td>
    <td width="143">19,43,26,203.00</td>
    <td >2.78</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash; Kanch Electrical Circle    &ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >22.86</td>
    <td>3.27</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Feb-21</td>
    <td >Dec-21</td>
    <td width="143">19,76,54,520.00</td>
    <td >2.82</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="3" width="41">14</td>
    <td rowspan="3" >APDCL/DSELR/SIB/01</td>
    <td rowspan="3" >19</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Sibasagar Electrical Circle on    Turnkey basis in LOT- I &ndash;Sibasagar Electrical Circle &ndash;Part I, LOT- II    &ndash;Sibasagar Electrical Circle- Part II&nbsp;",90,"</br></br>");?></td>
    <td >32.71</td>
    <td>4.67</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">27,28,33,378.00</td>
    <td >3.90</td>
    <td >Two    different firms have secured L1 in separate Lots</td>
    <td >India</td>
    <td >-</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="3" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I &ndash;Sibasagar Electrical    Circle &ndash;Part I on Turnkey basis",90,"</br></br>");?></td>
    <td >15.29</td>
    <td>2.18</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">13,29,36,514.00</td>
    <td >1.90</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II &ndash; Sibasagar Electrical    Circle &ndash;Part II on Turnkey basis",90,"</br></br>");?></td>
    <td >17.42</td>
    <td>2.49</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">13,98,96,864.00</td>
    <td >2.00</td>
    <td >Vikran    Enginerring &amp; Exim Pvt Ltd</td>
    <td >India</td>
    <td >11-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="4">15</td>
    <td rowspan="4" >APDCL/DSELR/GLG/01</td>
    <td rowspan="4" >18</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Golaghat Electrical Circle on    Turnkey basis in LOT- I - Golaghat Electrical Circle &ndash;Part I, LOT- II -    Golaghat Electrical Circle- Part II, LOT-III - Golaghat Electrical Circle &ndash;    Part III",90,"</br></br>");?></td>
    <td >51.66</td>
    <td>7.38</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">44,26,30,553.00</td>
    <td >6.32</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
    <td rowspan="4" >LOA issued in 07-11-2021</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I - Golaghat Electrical    Circle &ndash;Part I on Trunkey basis",90,"</br></br>");?></td>
    <td >19.00</td>
    <td>2.71</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">156769533.00</td>
    <td >2.24</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- II - Golaghat Electrical    Circle &ndash;Part II on Trunkey basis",90,"</br></br>");?></td>
    <td >17.11</td>
    <td>2.44</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">15,28,43,511.00</td>
    <td >2.18</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- III - Golaghat Electrical    Circle &ndash;Part III on Trunkey basis",90,"</br></br>");?></td>
    <td >15.55</td>
    <td>2.22</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-21</td>
    <td >Dec-21</td>
    <td width="143">13,30,17,509.00</td>
    <td >1.9</td>
    <td >Sri    Gopikrishna Infrastructure Pvt Ltd</td>
    <td >India</td>
    <td >10-Jan-22</td>
    <td >24</td>
    <td >Running</td>
  </tr>
  <tr>
    <td rowspan="4">16</td>
    <td rowspan="4" >APDCL/DSELR/GEC/01</td>
    <td rowspan="4" >6</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Guwahati Electrical Circle-I &amp; Guwahati Electrical    Circle-II on Turnkey basis in LOT- I - Guwahati    Electrical Circle-I &amp; Guwahati Electrical Circle-II &ndash;Part I, LOT- II -    Guwahati Electrical Circle-II - Part II, LOT-III - Guwahati Electrical    Circle-II&nbsp; &ndash; Part III",90,"</br></br>");?></td>
    <td >179</td>
    <td>25.57</td>
    <td rowspan="4" >80</td>
    <td rowspan="4" >20</td>
    <td rowspan="4" >Works</td>
    <td rowspan="4">NOCT</td>
    <td rowspan="4">Prior</td>
    <td rowspan="4">May-22</td>
    <td rowspan="4" >Nov-22</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="4" >NOA to be issued after APDCL, BOD Approval</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT- I - Guwahati Electrical    Circle-I &amp; Guwahati Electrical Circle-II &ndash;Part I",90,"</br></br>");?></td>
    <td >83.62</td>
    <td>10.66</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-II -Guwahati Electrical    Circle-II &ndash;Part II",90,"</br></br>");?></td>
    <td >46.48</td>
    <td>5.65</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-III- Guwahati Electrical    Circle-II &ndash;Part III",90,"</br></br>");?></td>
    <td >48.90</td>
    <td>6.13</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td>17</td>
    <td >APDCL/DSELR/TSK/01</td>
    <td >20</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in    Tinsukia Electrical Circle on    Turnkey basis",90,"</br></br>");?></td>
    <td >51.84</td>
    <td>7.4</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>May-22</td>
    <td >Nov-22</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >NOA    to be issued after APDCL, BOD Approval</td>
  </tr>
  <tr>
    <td>18</td>
    <td >APDCL/DSELR/SMART    METER/01</td>
    <td >34</td>
    <td  style=" word-wrap: break-word;"><?php echo wordwrap("Design    Engineering, Supply, Installation and Integration of Smart Meters (with built    in pluggable communication module) and meter boxes along with setting up of  <br>  communication infrastructure for facilitating two-way communication between <br>   Consumer smart meters and cloud based HES (Head End System) and MDMS (Meter    Data Management System), Maintenance of Meter, Communication Infrastructure  <br>  and cloud-based applications, Leased Line/GPRS Service etc. and providing    FMS/O M <br>for 7 years in LOWER, UPPER <br> CENTRAL    ASSAM REGION",90,"</br></br>"); //echo $act_name;?></td>
    <td >139.71</td>
    <td>19.96</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Prior</td>
    <td>Nov-22</td>
    <td >May-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >Draft    Tender Document under Review&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">19</td>
    <td rowspan="4" >APDCL/DSELR/HVDS/01</td>
    <td rowspan="4" >8</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in Badarpur , Kanch and Cachar Electrical Circles on turnkey basis",90,"</br></br>");?></td>
    <td >88.23</td>
    <td>12.60</td>
    <td rowspan="4" >80</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td rowspan="4">Nov-22</td>
    <td rowspan="4" >May-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="4" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Badarpur    Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >34.26</td>
    <td>4.89</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Kanch    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >19.64</td>
    <td>2.81</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-III - Cachar    Electrical Circle - Part -III",90,"</br></br>");?></td>
    <td >34.37</td>
    <td>4.91</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td rowspan="4">20</td>
    <td rowspan="4" >APDCL/DSELR/HVDS/02</td>
    <td rowspan="4" >9</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in Bongaigaon, Kokrajhar and Barpeta Electrical Circles on turnkey basis",90,"</br></br>");?></td>
    <td >96.78</td>
    <td>13.83</td>
    <td rowspan="4" >80</td>
    <td rowspan="4" >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td rowspan="4">Dec-22</td>
    <td>Jun-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="4" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Bongaigaon    Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >40.66</td>
    <td>5.81</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td>Apr-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Kokrajhar    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >31.36</td>
    <td>4.48</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td>Apr-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Barpeta    Electrical Circle - Part -III",90,"</br></br>");?></td>
    <td >37.40</td>
    <td>5.34</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td>Apr-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td rowspan="3">21</td>
    <td rowspan="3" >APDCL/DSELR/HVDS/03</td>
    <td rowspan="3" >10</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in North Lakhimpur and Tezpur Electrical Circles on turnkey basis",90,"</br></br>");?></td>
    <td >78.33</td>
    <td>11.2</td>
    <td rowspan="3" >80</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td rowspan="3">Dec-22</td>
    <td rowspan="3">Jun-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - North Lakhimpur    Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >38.97</td>
    <td>5.57</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Tezpur    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >39.36</td>
    <td>5.62</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td rowspan="3">22</td>
    <td rowspan="3" >APDCL/DSELR/HVDS/04</td>
    <td rowspan="3" >29</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in GEC-I and GEC II    Electrical Circles on turnkey basis",90,"</br></br>");?></td>
    <td >94.95</td>
    <td>13.56</td>
    <td rowspan="3" >80</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td rowspan="3">Dec-22</td>
    <td>Jun-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Guwahati    Electrical Circle-I&nbsp; - Part -I",90,"</br></br>");?></td>
    <td >44.82</td>
    <td>6.40</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td>Apr-23</td>
    <td width="143">&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Guwahati    Electrical Circle-II&nbsp; - Part -II",90,"</br></br>");?></td>
    <td >50.13</td>
    <td>7.16</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="85">Post</td>
    <td>Apr-23</td>
    <td width="143">&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3">23</td>
    <td rowspan="3" >APDCL/DSELR/HVDS/05</td>
    <td rowspan="3" >30</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in Rangia and Mangaldoi Electrical Circles on turnkey basis&nbsp;",90,"</br></br>");?></td>
    <td >80.07</td>
    <td>11.44</td>
    <td rowspan="3" >80</td>
    <td rowspan="3" >20</td>
    <td rowspan="3" >Works</td>
    <td rowspan="3" width="81">NOCT</td>
    <td rowspan="3" width="85">Post</td>
    <td rowspan="3">Jun-22</td>
    <td>Dec-22</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Rangia&nbsp; Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >39.39</td>
    <td>5.63</td>
    <td>Apr-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Mangaldoi    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >40.67</td>
    <td>5.81</td>
    <td>Apr-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td rowspan="3">24</td>
    <td rowspan="3" >APDCL/DSELR/HVDS/06</td>
    <td rowspan="3" >31</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in Nagaon and Morigaon    Electrical Circles on turnkey basis",90,"</br></br>");?></td>
    <td >81.54</td>
    <td>11.65</td>
    <td rowspan="3" >80</td>
    <td >20</td>
    <td >Works</td>
    <td rowspan="3">NOCT</td>
    <td>:Post</td>
    <td rowspan="3">Jun-22</td>
    <td rowspan="3">Oct-22</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Nagaon    Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >40.74</td>
    <td>5.82</td>
    <td >20</td>
    <td >Works</td>
    <td>Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Morigaon    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >40.80</td>
    <td>5.83</td>
    <td >20</td>
    <td >Works</td>
    <td>Post</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td rowspan="4">25</td>
    <td rowspan="4" >APDCL/DSELR/HVDS/07</td>
    <td rowspan="4" >32</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in Jorhat , Golaghat and Sivsagar Electrical Circles on turnkey basis",90,"</br></br>");?></td>
    <td >104.5</td>
    <td>14.93</td>
    <td rowspan="4" >80</td>
    <td rowspan="4" >20</td>
    <td rowspan="4" >Works</td>
    <td rowspan="4" width="81">NOCT</td>
    <td rowspan="4" width="85">Prior</td>
    <td rowspan="4">Jun-22</td>
    <td rowspan="4">Oct-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="4" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Jorthat&nbsp; Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >40.66</td>
    <td>5.81</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Golaghat    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >31.36</td>
    <td>4.48</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Sivasagar    Electrical Circle - Part -III",90,"</br></br>");?></td>
    <td >37.40</td>
    <td>5.34</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td rowspan="3">26</td>
    <td rowspan="3" >APDCL/DSELR/HVDS/08</td>
    <td rowspan="3" >33</td>
    <td><?php echo wordwrap("Construction    of HVDS System replacing existing LT Network at selected location for Loss    Reduction in Dibrugarh and Tinsukia&nbsp; Electrical Circles on    turnkey basis",90,"</br></br>");?></td>
    <td >80.23</td>
    <td>11.47</td>
    <td rowspan="3" >80</td>
    <td rowspan="3" >20</td>
    <td rowspan="3" >Works</td>
    <td rowspan="3" width="81">NOCT</td>
    <td rowspan="3" width="85">Post</td>
    <td rowspan="3">Dec-22</td>
    <td rowspan="3">Jun-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-I - Dibrugah&nbsp; Electrical Circle - Part -I",90,"</br></br>");?></td>
    <td >40.19</td>
    <td>5.74</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of HVDS System replacing existing    LT Network at selected location for Loss Reduction in LOT-II - Tinsukia    Electrical Circle - Part -II",90,"</br></br>");?></td>
    <td >40.10</td>
    <td>5.73</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td>27</td>
    <td >APDCL/DSELR/KJH(DHB)/01</td>
    <td >28</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in    Kokrajhar Electrical Circle on    Turnkey basis",90,"</br></br>");?></td>
    <td >93.69</td>
    <td>13.38</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-23</td>
    <td >Jul-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >NOA    to be issued after APDCL, BOD Approval</td>
  </tr>
  <tr>
    <td>28</td>
    <td >APDCL/DSELR/CAB/01</td>
    <td >24</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in    Cachar and Bandarpur Electrical Circle on Turnkey basis",90,"</br></br>");?></td>
    <td >35.73</td>
    <td>5.1</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jan-23</td>
    <td >Jul-22</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >--</td>
  </tr>
  <tr>
    <td rowspan="4">29</td>
    <td rowspan="4" >APDCL/DSELR/GSJ/01</td>
    <td rowspan="4" >21</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Golaghat, Jorhat &amp; Sibasagar Electrical    Circle on Turnkey basis",90,"</br></br>");?></td>
    <td >158.72</td>
    <td>22.67</td>
    <td rowspan="4" >80</td>
    <td rowspan="4" >20</td>
    <td rowspan="4" >Works</td>
    <td rowspan="4" width="81">NOCT</td>
    <td rowspan="4" width="85">Prior</td>
    <td rowspan="4">Jan-23</td>
    <td rowspan="4">Jul-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >NOA to be issued after APDCL, BOD Approval</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-I - Golaghat&nbsp; Electrical Circle - Part-I",90,"</br></br>");?></td>
    <td >43.18</td>
    <td>6.16</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-II - Jorhat&nbsp; Electrical Circle-    Part-II",90,"</br></br>");?></td>
    <td >46.19</td>
    <td>6.6</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-III - Sibasagar&nbsp; Electrical Circle - Part-III",90,"</br></br>");?></td>
    <td >69.35</td>
    <td>9.9</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >No    Bids Received, Re tendering to be initiated</td>
  </tr>
  <tr>
    <td rowspan="3">30</td>
    <td rowspan="3" >APDCL/DSELR/BZN/01</td>
    <td rowspan="3" >27</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in &nbsp;Bongaingaon &amp;    Barpeta Electrical Circle    on Turnkey basis",90,"</br></br>");?></td>
    <td >99.36</td>
    <td>14.19</td>
    <td rowspan="3" >80</td>
    <td rowspan="3" >20</td>
    <td rowspan="3" >Works</td>
    <td rowspan="3" width="81">NOCT</td>
    <td rowspan="3" width="85">Post</td>
    <td rowspan="3">Feb-23</td>
    <td rowspan="3">Aug-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="3" >Financial Bid to be opened on 16.09.2022</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-I -&nbsp; Bongaingaon Electrical Circle- Part-I",90,"</br></br>");?></td>
    <td >42.79</td>
    <td>6.11</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-II -&nbsp; Barpeta Electrical Circle- Part-II",90,"</br></br>");?></td>
    <td >56.56</td>
    <td>8.07</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td>31</td>
    <td >APDCL/DSELR/NLK/01</td>
    <td >25</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in North Lakhimpur &amp; Tezpur    Electrical Circle on    Turnkey basis",90,"</br></br>");?></td>
    <td >76.26</td>
    <td>10.89</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Mar-23</td>
    <td >Sep-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >Financial    Bid to be opened on 16.09.2022</td>
  </tr>
  <tr>
    <td rowspan="4">32</td>
    <td rowspan="4" >APDCL/DSELR/NGZ/01</td>
    <td rowspan="4" >22</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Nagaon &amp; Morigaon Electrical Circle on Turnkey basis",90,"</br></br>");?></td>
    <td >181.58</td>
    <td>25.94</td>
    <td rowspan="4" >80</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td rowspan="4" width="85">Prior</td>
    <td rowspan="4">Apr-23</td>
    <td rowspan="4" >Oct-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td rowspan="4" >Draft Bid Document submitted for review and    approval by AIIB</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-I - Nagaon Electrical Circle- Part-I",90,"</br></br>");?></td>
    <td >70.32</td>
    <td>10.05</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in LOT-II - Nagaon Electrical Circle-    Part-II",90,"</br></br>");?></td>
    <td >74.56</td>
    <td>10.65</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td><?php echo wordwrap("Construction of new 33/11 KV sub-stations,    Construction of 33 KV and 11 KV lines, 33 KV terminal equipments &amp; 33 KV    and 11 KV Crossings for Railways/ River in&nbsp;&nbsp;    LOT-III - Morigaon Electrical Circle - Part- III",90,"</br></br>");?></td>
    <td >36.70</td>
    <td>5.24</td>
    <td >20</td>
    <td >Works</td>
    <td width="81">NOCT</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td>33</td>
    <td >APDCL/DSELR/KANCH/01</td>
    <td >23</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Kanch Electrical Circle on Turnkey basis",90,"</br></br>");?></td>
    <td >53.60</td>
    <td>7.66</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>May-23</td>
    <td >Nov-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >Tender    Flaoted on 08.09.2022</td>
  </tr>
  <tr>
    <td>34</td>
    <td >APDCL/DSELR/RZN/01</td>
    <td >26</td>
    <td><?php echo wordwrap("Construction    of new 33/11 KV sub-stations, Construction of 33 KV and 11 KV lines, 33 KV    terminal equipments &amp; 33 KV and 11 KV Crossings for Railways/ River in Rangia &amp; Mangaldoi Electrical    Circle on Turnkey basis",90,"</br></br>");?></td>
    <td >56.55</td>
    <td>8.08</td>
    <td >80</td>
    <td >20</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>May-23</td>
    <td >Nov-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >Financial    Bid to be opened on 16.09.2022</td>
  </tr>
  <tr>
    <td>35</td>
    <td >APDCL/DSELR/TEST    EQP/01</td>
    <td >&nbsp;</td>
    <td><?php echo wordwrap("Procurement    latest Testing Equipments e.g.    Smart Meter Testing bench, Transformer CT/PT test bench etc&nbsp;",90,"</br></br>");?></td>
    <td >12.00</td>
    <td>1.71</td>
    <td >100</td>
    <td >0</td>
    <td >Works</td>
    <td>NOCT</td>
    <td>Post</td>
    <td>Jun-23</td>
    <td >Dec-23</td>
    <td width="143">__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
    <td >__</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td>TOTAL</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>3096.76</td>
    <td>442.39</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table></div>
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

  <!-- <script>
    $(function(){
      $("#partials-theme-setting-wrapper").load("partials/_settings-panel.php");
    });
  </script> -->

  <script>
    $(function(){
      $("#partials-sidebar-offcanvas").load("partials/_sidebar.php?progressmonth=<?php 
	echo $_REQUEST['progressmonth'];?>");
    });
</script>

<script>
  $(function(){
    $("#partials-footer").load("partials/_footer.php");
  });
</script>



</body>

</html>

