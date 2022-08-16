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
	$db->query ("Delete from t0081contmob where contid=".$_REQUEST['contid']);
	}
} else {
	header("Location: index.php?msg=0");
}


//===============================================

 $pdSQL = "SELECT contid, pgid, pid, serial, type, description, comp1_foreign, comp1_local, comp2_foreign, comp2_local FROM t0081contmob where pid = ".$pid." and type in ('D', 'C') order by serial, type";
$pdSQLResult = $db->query ($pdSQL);
 

 $pdSQL1 = "SELECT contid, pgid, pid, serial, type, description, comp1_foreign, comp1_local, comp2_foreign, comp2_local FROM t0081contmob where pid = ".$pid." and type = 'E' order by serial, type";
$pdSQLResult1 = $db->query ($pdSQL1);


$pdSQL2 = "SELECT pid, comp1, comp2 FROM t002project where pid = ".$pid;
$pdSQLResult2 = $db->query ($pdSQL2);
$compdata = $pdSQLResult2->fetch_array();
$comp1 = "".$compdata['comp1'];
$comp2 = "".$compdata['comp2'];



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
      <div class="content-wrapper "style="padding-top: 80px; padding-bottom: 20px;">
    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar.php';?>  <!-- partial -->
   

<!-- Page content  -->
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> Contractor's Mobilization </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end" >  
  <?php if($adminflag==1)
	{
	 ?>

<button type="button" class="col-sm-2 button-33" onclick="location.href='sp_contmob_input.php';" > Add New Record </button>
<?php } 

?>
<button type="button" class="col-sm-2 button-33" onclick="location.href='chart1.php';" >  Back </button>

	</div>
</div>
<!--  -->



 <div style=" " class="table-responsive">
  <table width="100%" class="table table-bordered  table-striped">
                              <thead>
                                <tr>
                                  <th width="5%" rowspan="2" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="57%" rowspan="2" style="text-align:center">Description</th>
                                  <th colspan="2" style="text-align:center"><?php echo $comp1; ?></th>
                                  <th colspan="2" style="text-align:center"><?php echo $comp2; ?></th>
								  <?php if($adminflag==1)
								  {
								   ?>
                                  <th style="text-align:center">&nbsp;</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="7%" style="text-align:center">Foreign</th>
								  <th width="7%" style="text-align:center">Local</th>
								  <th width="7%" style="text-align:center">Foreign</th>
								  <th width="7%" style="text-align:center">Local</th>
								   <?php if($adminflag==1)
								  {
								   ?>
								  <th width="8%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
<tr>
                                <td class="py-3" colspan="7" align="left">Personnel</td>
                                </tr>							  <?php
							  
							  if($pdSQLResult ->num_rows>=1)
							  {
							  while($pdData = $pdSQLResult->fetch_array())
							  { ?>
                              
                              <tr>
                          <td class="py-3" align="center"><?php echo $pdData['serial'];?></td>
                          <td class="py-3"  align="left"><?php echo $pdData['description'];?></td>
                          <td class="py-3"  align="right"><?php echo number_format($pdData['comp1_foreign'],0);?></td>
                          <td class="py-3"  align="right"><?php echo number_format($pdData['comp1_local'],0);?></td>
                          <td class="py-3"  align="right"><?php echo number_format($pdData['comp2_foreign'],0);?></td>
                          <td class="py-3"  align="right"><?php echo number_format($pdData['comp2_local'],0);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td class="py-3"  align="right"><span style="float:left"><form action="sp_contmob_input.php?contid=<?php echo $pdData['contid'] ?>" method="post">
               <button type="submit" title="Edit" class="btn btn-outline-primary btn-fw px-1  py-1 " style="margin-top: 0; margin-bottom: 0; " name="edit" id="edit" value="<?php echo EDIT;?>" >    
						       <i class="ti-pencil btn-icon-prepend" style="font-size: 11px;"></i>  
                            </button>
              </form></span><span style="float:right"><form action="sp_contmob.php?contid=<?php echo $pdData['contid'] ?>" method="post">
              <button type="submit" title = "Delete"  class="btn btn-outline-danger btn-fw px-1 py-1 m-0"  style="margin-top: 0; margin-bottom: 0; " name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" style="font-size: 11px;" ></i> 
        					</button>
            </form></span></td>
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
                          <td colspan="7" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
<tr>
                                <td class="py-3" colspan="7" align="left">Equipment</td>
                                </tr>        						  <?php
							  
							  if($pdSQLResult1 ->num_rows>=1)
							  {
							  while($pdData1 = $pdSQLResult1->fetch_array())
							  { ?>
                              
                              <tr>
                          <td class="py-3"  align="center"><?php echo $pdData1['serial'];?></td>
                          <td class="py-3"  align="left"><?php echo $pdData1['description'];?></td>
                          <td class="py-3"  colspan="2" align="right"><?php echo number_format($pdData1['comp1_foreign'],0);?></td>
<?php /*?>                          <td align="right"><?php echo number_format($pdData1['comp1_local'],0);?></td>
<?php */?>                          <td  class="py-2" colspan="2" align="right"><?php echo number_format($pdData1['comp2_foreign'],0);?></td>
<?php /*?>                          <td align="right"><?php echo number_format($pdData1['comp2_local'],0);?></td>
<?php */?>	
								 <?php if($adminflag==1)
								  {
								   ?>					   
<td class="py-3"  align="right"><span style="float:left"><form action="sp_contmob_input.php?contid=<?php echo $pdData1['contid'] ?>" method="post">

<button type="submit" title="Edit" class="btn btn-outline-primary btn-fw px-1  py-1 " style="margin-top: 0; margin-bottom: 0; " name="edit" id="edit" value="<?php echo EDIT;?>" >    
						       <i class="ti-pencil btn-icon-prepend" style="font-size: 11px;"></i>  
                            </button>
</form></span><span style="float:right"><form action="sp_contmob.php?contid=<?php echo $pdData1['contid'] ?>" method="post">
<button type="submit" title = "Delete"  class="btn btn-outline-danger btn-fw px-1 py-1 m-0"  style="margin-top: 0; margin-bottom: 0; " name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" style="font-size: 11px;" ></i> 
        					</button>
</form></span></td>
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
                          <td colspan="7" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                                
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

