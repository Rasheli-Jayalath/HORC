<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include_once("connect.php");
include_once("functions.php");

if(isset($_REQUEST['delete']))
{
  $db->query("Delete from t0211eva where rcid=".$_REQUEST['rcid']);
}

//===============================================

 $pdSQL = "SELECT rcid, pgid, pid, serial, description, nolines FROM t0211eva where pid = ".$pid." order by serial";
$pdSQLResult =   $db->query($pdSQL);
} else {
	header("Location: index.php?msg=0");
}

$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult =   $db->query($pcrSQL);
$pcrData = $pcrSQLResult->fetch_array();
$proj_cur=$pcrData["proj_cur"];
$evaSQL1 ="SELECT min(ppg_date) as start from t0211eva_progress_graph where pid =".$pid;
$evaSQLResult1 =   $db->query($evaSQL1);
$evaData1 = $evaSQLResult1->fetch_array();
$evaSQL ="SELECT ppg_date, cpi,spi,tcpi from t0211eva_progress_graph where pid=".$pid." AND ppg_date = (SELECT max(ppg_date) from t0211eva_progress_graph)";
$evaSQLResult =   $db->query($evaSQL);
$evaData = $evaSQLResult->fetch_array();
$ppg_date=$evaData["ppg_date"];
$cpi=$evaData["cpi"];
$spi=$evaData["spi"];
$tcpi=$evaData["tcpi"];
$end=$ppg_date;
$start=$evaData1["start"];
function GetPlannedData($start,$end)
{
	$reportquery ="SELECT * FROM  t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult =   $db->query($reportquery);
				if($reportresult!=0)
				{
				$num=$reportresult ->num_rows;
				}
				$ii=0;
			
				while ($reportdata = $reportresult->fetch_array()) {
					
					$ii++;
		if($reportdata["planned"]!=0&&$reportdata["planned"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".round($reportdata["planned"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetActualData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult =   $db->query($reportquery);
				if($reportresult!=0)
				{
				$num=$reportresult ->num_rows;
				}
				$ii=0;
			
				while ($reportdata = $reportresult->fetch_array()) {
					
					$ii++;
		if($reportdata["actual"]!=0&&$reportdata["actual"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".round($reportdata["actual"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetEarnedData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult =   $db->query($reportquery);
				if($reportresult!=0)
				{
				$num=$reportresult ->num_rows;
				}
				$ii=0;
			
				while ($reportdata = $reportresult->fetch_array()) {
					
					$ii++;
		if($reportdata["earned"]!=0&&$reportdata["earned"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".round($reportdata["earned"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}

function GetCPIData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult =   $db->query($reportquery);
				if($reportresult!=0)
				{
				$num=$reportresult->num_rows;
				}
				$ii=0;
			
				while ($reportdata = $reportresult->fetch_array()) {
					
					$ii++;
		if($reportdata["cpi"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".number_format($reportdata["cpi"],2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetSPIData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult =   $db->query($reportquery);
				if($reportresult!=0)
				{
				$num=$reportresult ->num_rows;
				}
				$ii=0;
			
				while ($reportdata = $reportresult->fetch_array()) {
					
					$ii++;
		if($reportdata["spi"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".number_format($reportdata["spi"],2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Strategic Dashboard </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
    <style>
      .btn-37 {
        padding: 10px;
        box-shadow: 5px 6px 8px #888888;
      } 
      .btn-37:hover {
        padding: 10px;
        box-shadow: 5px 3px 8px #888888;
      } 
      .text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 10px 10px;
  color: white;
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
      </style>
      </style>



</head>
<body>
<div class="container-scroller" >
    <div class="container-fluid page-body-wrapper full-page-wrapper " >
      <div class="content-wrapper " style="padding-top: 100px; padding-bottom: 100px;">
    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar.php';?>  <!-- partial -->
   

<!-- Page content  -->
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> Earned Value Analysis </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end" >  
	<button type="button" class="col-sm-2 button-33" onclick="location.href='sp_eva.php';" > View Tabular Data </button>

  <?php if($adminflag==1)
	{
	 ?>

<button type="button" class="col-sm-2 button-33" onclick="location.href='sp_evaprogress_graph.php';" > Manage Graphic Data </button>
<?php } 

?>
<button type="button" class="col-sm-2 button-33" onclick="location.href='chart1.php';" >  Back </button>

	</div>
</div>
<!--  -->


<div style=""  class="table-responsive">
  <table width="100%" class="table table-bordered table-striped">

									
									  <tbody>
									  <tr >
									  <td >
									  
					   <?php  $CPI=$cpi;
					   $CPI=number_format($CPI,2);
					   $mi=date('m',strtotime($ppg_date));
					$yi=date('Y',strtotime($ppg_date));
					$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
					$last_date=$yi."-".$mi."-".$days;
					
						?>
						<script type="text/javascript">
				$(function () {
					
					$('#container_cpi').highcharts({
					
						chart: {
							type: 'gauge',
							plotBackgroundColor: null,
							plotBackgroundImage: null,
							plotBorderWidth: 0,
							plotShadow: false
						},
						
						title: {
							text: 'Cost Performance Index'
						},
						subtitle: {
								text: 'as on <?php echo date('M, d, Y',strtotime($last_date));?>'
							},
						pane: {
							startAngle: -150,
							endAngle: 150,
							background: [{
								backgroundColor: {
									linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
									stops: [
										[0, '#FFF'],
										[1, '#333']
									]
								},
								borderWidth: 0,
								outerRadius: '109%'
							}, {
								backgroundColor: {
									linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
									stops: [
										[0, '#333'],
										[1, '#FFF']
									]
								},
								borderWidth: 1,
								outerRadius: '107%'
							}, {
								// default background
							}, {
								backgroundColor: '#DDD',
								borderWidth: 0,
								outerRadius: '105%',
								innerRadius: '103%'
							}]
						},
						   
						// the value axis
						yAxis: {
							min: 0,
							max: 2,
							
							minorTickInterval: 'auto',
							minorTickWidth: 1,
							minorTickLength: 10,
							minorTickPosition: 'inside',
							minorTickColor: '#666',
					
							tickPixelInterval: 30,
							tickWidth: 2,
							tickPosition: 'inside',
							tickLength: 10,
							tickColor: '#666',
							labels: {
								step: 2,
								rotation: 'auto'
							},
							title: {
								text: 'CPI'
							},
							plotBands: [{
								from: 0,
								to: 0.8,
								color: '#DF5353' // red
							}, {
								from: 0.8,
								to: 2,
								color: '#55BF3B' // yellow
							}]        
						},
					
						series: [{
							name: 'CPI',
							data: [<?php echo $CPI;?>],
							tooltip: {
								valueSuffix: ' '
							}
						}]
					
					}
					);
				});
						</script>
						 <div id="container_cpi" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
			
									  </td>
									   <td >
									   
		
			   <?php  
				$SPI=$spi;
			
			?>
				<script type="text/javascript">
		$(function () {
			
			$('#container_spi').highcharts({
			
				chart: {
					type: 'gauge',
					plotBackgroundColor: null,
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotShadow: false
				},
				
				title: {
					text: 'Schedule Performance Index'
				},
				
				subtitle: {
						text: 'as on <?php echo date('M, d, Y',strtotime($last_date));?>'
					},
				pane: {
					startAngle: -150,
					endAngle: 150,
					background: [{
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#FFF'],
								[1, '#333']
							]
						},
						borderWidth: 0,
						outerRadius: '109%'
					}, {
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#333'],
								[1, '#FFF']
							]
						},
						borderWidth: 1,
						outerRadius: '107%'
					}, {
						// default background
					}, {
						backgroundColor: '#DDD',
						borderWidth: 0,
						outerRadius: '105%',
						innerRadius: '103%'
					}]
				},
				   
				// the value axis
				yAxis: {
					min: 0,
					max: 2,
					
					minorTickInterval: 'auto',
					minorTickWidth: 1,
					minorTickLength: 10,
					minorTickPosition: 'inside',
					minorTickColor: '#666',
			
					tickPixelInterval: 30,
					tickWidth: 2,
					tickPosition: 'inside',
					tickLength: 10,
					tickColor: '#666',
					labels: {
						step: 2,
						rotation: 'auto'
					},
					title: {
						text: 'SPI'
					},
					plotBands: [{
						from: 0,
						to: 0.8,
						color: '#DF5353' // red
					}, {
						from: 0.8,
						to: 2,
						color: '#55BF3B' // yellow
					}]        
				},
			
				series: [{
					name: 'SPI',
					data: [<?php echo $SPI;?>],
					tooltip: {
						valueSuffix: ' '
					}
				}]
			
			}
			);
		});
				</script>
			 <div id="container_spi" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
			
									  </td>
									   <td>
		
			   <?php  
			$TCPI_1=$tcpi;
			
			?>
				<script type="text/javascript">
		$(function () {
			
			$('#container_tcpi_1').highcharts({
			
				chart: {
					type: 'gauge',
					plotBackgroundColor: null,
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotShadow: false
				},
				
				title: {
					text: 'TCPI-1'
				},
				subtitle: {
						text: 'as on <?php echo date('M, d, Y',strtotime($last_date));?>'
					},
				pane: {
					startAngle: -150,
					endAngle: 150,
					background: [{
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#FFF'],
								[1, '#333']
							]
						},
						borderWidth: 0,
						outerRadius: '109%'
					}, {
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#333'],
								[1, '#FFF']
							]
						},
						borderWidth: 1,
						outerRadius: '107%'
					}, {
						// default background
					}, {
						backgroundColor: '#DDD',
						borderWidth: 0,
						outerRadius: '105%',
						innerRadius: '103%'
					}]
				},
				   
				// the value axis
				yAxis: {
					min: 0,
					max: 2,
					
					minorTickInterval: 'auto',
					minorTickWidth: 1,
					minorTickLength: 10,
					minorTickPosition: 'inside',
					minorTickColor: '#666',
			
					tickPixelInterval: 30,
					tickWidth: 2,
					tickPosition: 'inside',
					tickLength: 10,
					tickColor: '#666',
					labels: {
						step: 2,
						rotation: 'auto'
					},
					title: {
						text: 'TCPI-1'
					},
					plotBands: [{
						from: 0,
						to: 1.2,
						color: '#55BF3B' // green
					}, {
						from: 1.2,
						to: 1.6,
						color: '#DDDF0D' // yellow
					}, {
						from: 1.6,
						to: 2,
						color: '#DF5353' // red
					}]        
				},
			
				series: [{
					name: 'TCPI-1',
					data: [<?php echo $TCPI_1;?>],
					tooltip: {
						valueSuffix: ' '
					}
				}]
			
			}
			);
		});
				</script>
			   
			 <div id="container_tcpi_1" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
		  
									  </td>
									  </tr>
									  <tr>
									   <td colspan="3"><script type="text/javascript">
				
		$(function () {
			 Highcharts.setOptions({
			  colors: ["#4572A7",'#89A54E',"#DC143C"]
			});
				$('#container').highcharts({
					chart: {
						type: 'spline'
					},
					title: {
						text: 'Earned Value Analysis - Civilworks'
					},
					subtitle: {
						text: 'Period: <?php echo date('M, Y',strtotime($start))." to ".date('M, Y',strtotime($end));?>'
					},
					xAxis: {
						type: 'datetime',
						dateTimeLabelFormats: { // don't display the dummy year
						   month: '%m-%Y',
						year: '%Y'
						}
					},
					yAxis: {
						title: {
							text: '$ Cost'
						},
						min: 0
					},
					tooltip: {
						formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
								Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' $';
						}
					},
					
					series: [
				{
						name: '<?php echo "Planned";?>',
						// Define the data points. All series have a dummy year
						// of 1970/71 in order to be compared on the same x axis. Note
						// that in JavaScript, months start at 0 for January, 1 for February etc.
						data: [
						<?php echo GetPlannedData($start,$end);?>
							
						   
						]
						,
						marker: {
					   
						 radius : 3
					}
					}
					,
					{
						name: '<?php echo "Earned";?>',
						// Define the data points. All series have a dummy year
						// of 1970/71 in order to be compared on the same x axis. Note
						// that in JavaScript, months start at 0 for January, 1 for February etc.
						data: [
						
						<?php echo GetEarnedData($start,$end);?>
							
						   
						]
						,
						marker: {
					   
						 radius : 3
					}
					}
					,
					{
						name: '<?php echo "Actual";?>',
						// Define the data points. All series have a dummy year
						// of 1970/71 in order to be compared on the same x axis. Note
						// that in JavaScript, months start at 0 for January, 1 for February etc.
						data: [
						
						<?php echo GetActualData($start,$end);?>
							
						   
						]
						,
						marker: {
					   
						 radius : 3
					}
					}
					]
				});
			});
			
		
				</script>
										<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
									  </td>
									  </tr>
									  <tr>
									   <td colspan="3">
									   <script type="text/javascript">
				
		$(function () {
			 Highcharts.setOptions({
			  colors: ["#4572A7","#DC143C"]
			});
				$('#container_cpi_spi').highcharts({
					chart: {
						type: 'spline'
					},
					title: {
						text: 'CPI & SPI'
					},
					subtitle: {
						text: 'Period: <?php echo date('M, Y',strtotime($start))." to ".date('M, Y',strtotime($end));?>'
					},
					xAxis: {
						type: 'datetime',
						dateTimeLabelFormats: { // don't display the dummy year
						   month: '%m-%Y',
						year: '%Y'
						}
					},
					yAxis: {
						title: {
							text: 'CPI / SPI'
						},
						min: 0
					},
					tooltip: {
						formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
								Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' ';
						}
					},
					
					series: [
				
					{
						name: '<?php echo "SPI";?>',
						// Define the data points. All series have a dummy year
						// of 1970/71 in order to be compared on the same x axis. Note
						// that in JavaScript, months start at 0 for January, 1 for February etc.
						data: [
						
						<?php echo GetSPIData($start,$end);?>
							
						   
						]
						,
						marker: {
					   
						 radius : 5
					}
					},
					{
						name: '<?php echo "CPI";?>',
						// Define the data points. All series have a dummy year
						// of 1970/71 in order to be compared on the same x axis. Note
						// that in JavaScript, months start at 0 for January, 1 for February etc.
						data: [
						<?php echo GetCPIData($start,$end);?>
							
						   
						]
						,
						marker: {
					   
						 radius : 5
					}
					}
					
					
					]
				});
			});
			
		
				</script>
										 <div id="container_cpi_spi" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
									  </td>
									  </tr>
									 </tbody>
									 </table>
		</div>
<!-- Page content -->

      <!-- partial:partials/_footer.php --> <div class="fixed-bottom">  <?php include '../partials/_footer.php';?> </div><!-- partial -->
  
      </div>

      <!-- content-wrapper ends -->

      
    </div>      

    <!-- page-body-wrapper ends -->
  </div> 
  <!-- container-scroller -->


  <!-- plugins:js -->
  <!-- <script src="../vendors/js/vendor.bundle.base.js"></script> -->
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>


