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
$db->query ("Delete from t028dpm_vo2progress where ppt_id=".$_REQUEST['ppt_id']);
}

//===============================================
$gap=0;
 $pdSQL = "SELECT contid, pgid, pid, serial, code, description, weight, start, finish, astart, afinish, tamount, pamount, actamount FROM t028dpm_vo2progress where  pid=$pid  order by contid";
$pdSQLResult = $db->query ($pdSQL);
} else {
	header("Location: index.php?msg=0");
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
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> VO2 Progresss </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end" >  
  <?php if($adminflag==1)
	{
	 ?>

<button type="button" class="col-sm-2 button-33" onclick="location.href='sp_dpm_vo2_input.php';" > Add New Record </button>
<?php } 

?>
<button type="button" class="col-sm-2 button-33" onclick="location.href='chart1.php';" >  Back </button>

	</div>
</div>
<!--  -->


<div style=""  class="table-responsive">
  <table width="100%" class="table table-bordered table-striped">

                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="5%" style="text-align:center">Code</th>
                                  <th width="15%" style="text-align:center">Milestone</th>
                                  <th width="5%" style="text-align:center">Weight</th>
                                  <th width="10%" style="text-align:center">Total Amount</th>
                                  <th width="10%" style="text-align:center">Start Date</th>
                                  <th width="10%" style="text-align:center">End Date</th>
                                  <th width="10%" style="text-align:center">Actual Start Date</th>
                                  <th width="10%" style="text-align:center">Actual End Date</th>
                                  <th width="10%" style="text-align:center">Days Elapsed w.r.t Actual Start Date</th>
                                  <th width="5%" style="text-align:center">Planned Amount</th>
								  <th width="10%" style="text-align:center">Actual Amount</th>
								  <th width="5%" style="text-align:center">Gap</th>
								  <th width="10%" style="text-align:center">Current Rate</th>
								  <th width="10%" style="text-align:center">Projected Date</th>
								  <th width="5%" style="text-align:center">Planned %</th>
								  <th width="5%" style="text-align:center">Actual %</th>
								  <?php if($adminflag==1)
								  {
								   ?>
								  <th width="10%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  $average_rate=0;
							  $projected_days=0;
							  
							  if( $pdSQLResult->num_rows>=1)
							  {
							  $i=0;
							  while($pdData =  $pdSQLResult->fetch_array())
							  {
							  $i=$i+1;
							   $startTimeStamp=strtotime($pdData['astart']);
							   $afinishTimeStamp=strtotime($pdData['afinish']);
							   $current_date=date('Y-m-d');
							   $currentTimeStamp=strtotime($current_date);
							   $timeElapsedDiff= abs($currentTimeStamp - $startTimeStamp);
							   $numberDaysElapsed = ceil($timeElapsedDiff/86400);
							   $numberDaysElapsed = intval($numberDaysElapsed);
							   $gap=$pdData['pamount']-$pdData['actamount'];
							   $ActualtimeElapsedDiff= abs($afinishTimeStamp - $startTimeStamp);
							   $ActualnumberDays=ceil($ActualtimeElapsedDiff/86400);
							   $ActualnumberDays= intval($ActualnumberDays);
							   	if($ActualnumberDays!=0&&$ActualnumberDays!="")
							   	{
							   	$current_daily_rate=$pdData['actamount']/$ActualnumberDays;
							   	}
							   	else
							   	{
							  	$current_daily_rate=0;
							 	}
								$remaining=$pdData['tamount']-$pdData['actamount'];
								if($numberDaysElapsed!=0)
								{
								$average_rate=$pdData['actamount']/($numberDaysElapsed-1);
								}
								if($average_rate!=0)
								{
									 $projected_days=$remaining/$average_rate;
								}
								 $projected_days=intval($projected_days);
								
								if($projected_days!=0)
								{
								 $projected_date=date("Y-m-d", strtotime( "+".$projected_days." days" ));
								}
								else
								{
								$projected_date="";
								}
								if($pdData['tamount']!=0&&$pdData['tamount']!="")
								{
								$palanned_per=$pdData['pamount']/$pdData['tamount']*100;
								}
								else
								{
								$palanned_per=0;
								}
								
								if($pdData['tamount']!=0&&$pdData['tamount']!="")
								{
								$actual_per=$pdData['actamount']/$pdData['tamount']*100;
								}
								else
								{
								$actual_per=0;
								}
				
							   ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData['code'];?></td>
                          <td align="left"><?php echo $pdData['description'];?></td>
                          <td align="left"><?php echo $pdData['weight'];?></td>
                          <td align="left"><?php echo $pdData['tamount'];?></td>
                          <td align="left"><?php echo $pdData['start'];?></td>
                          <td align="left" ><?php echo $pdData['finish'];?></td>
                          <td align="left"><?php echo $pdData['astart'];?></td>
                          <td align="left"><?php echo $pdData['afinish'];?></td>
                          <td align="left"><?php echo $numberDaysElapsed;?></td>
                          <td align="right"><?php echo number_format($pdData['pamount'],2);?></td>
                          <td align="right"><?php echo number_format($pdData['actamount'],2);?></td>
                          <td align="right"><?php echo number_format($gap,2);?></td>
                          <td align="right"><?php echo  number_format($current_daily_rate,2);?></td>
                          <td align="right"><?php echo $projected_date;?></td>
                          <td align="right"><?php echo number_format($palanned_per,2);?></td>
                          <td align="right"><?php echo number_format($actual_per,2);?></td>
                          <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="sp_dpm_vo2_input.php?contid=<?php echo $pdData['contid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><!--<span style="float:right"><form action="sp_major_items.php?ppt_id=<?php //echo $pdData['ppt_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>--></td>
						   <?php
						   }
						   ?>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="19" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table></div>
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

