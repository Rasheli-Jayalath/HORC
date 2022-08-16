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
$db->query ("Delete from t016project_monthwisecashflow where pm_cf=".$_REQUEST['pm_cf']);
}
 } else {
	header("Location: index.php?msg=0");
}

//===============================================

$pdSQL = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2016' order by pm_month asc";
$pdSQLResult = $db->query ($pdSQL);
 

$pdSQL1 = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2017' order by pm_month asc";
$pdSQLResult1 = $db->query ($pdSQL1);

$pdSQL2 = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2018' order by pm_month asc";
$pdSQLResult2 = $db->query ($pdSQL2);

$pdSQL3 = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2019' order by pm_month asc";
$pdSQLResult3 = $db->query ($pdSQL3);

 /*$pdSQL2 = "SELECT compid, comp1, comp2 FROM t0261qaqc_comp where pid = ".$pid;
$pdSQLResult2 = $db->query ($pdSQL2);
$compdata = mysql_fetch_array($pdSQLResult2);
$comp1 = "".$compdata['comp1'];
$comp2 = "".$compdata['comp2'];*/
$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult = $db->query ($pcrSQL);
$pcrData = $pcrSQLResult->fetch_array();
$proj_cur=$pcrData["proj_cur"];
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
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> Cash Flow Requirement </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end" >  
  <?php if($adminflag==1)
	{
	 ?>

<button type="button" class="col-sm-2 button-33" onclick="location.href='sp_cashflow_input.php';" > Add New Record </button>
<?php } 

?>
<button type="button" class="col-sm-2 button-33" onclick="location.href='chart1.php';" >  Back </button>

	</div>
</div>
<!--  -->


<div style="">
	
<div class="row">
  <div style="" class="col-6 table-responsive" >
  <table  class="table table-striped table-bordered"  width="">
                              <thead class=" 	" style="background-color: #d1dae8; ">
                                <tr style="">
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2016</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2016</th>
								   <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if($pdSQLResult ->num_rows>=1)
							  {
							  while($pdData = $pdSQLResult->fetch_array())
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('M, Y',strtotime($pdData["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>                       </tbody>
                        </table>
						</div>
						
						<div style="" class="col-6 table-responsive" >
  <table  class="table table-striped table-bordered"  width="">
                              <thead class=" 	" style="background-color: #d1dae8; ">
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2017</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2017</th>
								    <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if($pdSQLResult1 ->num_rows>=1)
							  {
							  while($pdData1 = $pdSQLResult1->fetch_array())
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('d M, Y',strtotime($pdData1["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData1["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData1["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData1['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData1['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
        						 
                                
                                                      </tbody>
                        </table>
						
						</div>

					</div>
					
<div class="row pt-3">
<div style="" class="col-6 table-responsive" >
  <table  class="table table-striped table-bordered"  width="">
                              <thead class=" 	" style="background-color: #d1dae8; ">
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2018</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2018</th>
								    <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if($pdSQLResult2 ->num_rows>=1)
							  {
							  while($pdData2 = $pdSQLResult2->fetch_array())
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('d M, Y',strtotime($pdData2["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData2["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData2["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData2['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData2['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
        						 
                                
                                                      </tbody>
                        </table>
						</div>
						<div style="" class="col-6 table-responsive" >
  <table  class="table table-striped table-bordered"  width="">
                              <thead class=" 	" style="background-color: #d1dae8; ">
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2019</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2019</th>
								    <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if($pdSQLResult3 ->num_rows>=1)
							  {
							  while($pdData3 = $pdSQLResult3->fetch_array())
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('d M, Y',strtotime($pdData3["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData3["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData3["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData3['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData3['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
        						 
                                
                                                      </tbody>
                        </table>
						</div>           
						</div> 
						          <!-- end of 2nd row div  -->
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

