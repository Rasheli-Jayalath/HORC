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
  $db->query ("Delete from t0071pc1summary where pc1_id=".$_REQUEST['pc1_id']);
}

//===============================================

/*$pdSQL = "SELECT a.ptid,a.pgid,a.pid,b.proj_name, a.description,a.test,a.comp1,a.comp2,a.total_val,b.pcolor FROM t999prototype a left outer join t002project b on (a.pid=b.pid)  where a.pid = ".$pid;
$pdSQLResult = mysql_query($pdSQL);
$pdData = mysql_fetch_array($pdSQLResult);
$pname = $pdData['proj_name'];
 $pcolor = $pdData['pcolor'];*/
 
 
 $pdSQL = "SELECT pc1_id, pid, item_id, description, price,f1,f2,f3, display_order FROM t0071pc1summary where pid = ".$pid;
$pdSQLResult = $db->query ($pdSQL);

 
/*ptid
pgid
pid	
description	
test	
comp1	
comp2	
total_val*/
} else {
	header("Location: index.php?msg=0");
}
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



</head>
<body>
<div class="container-scroller" >
    <div class="container-fluid page-body-wrapper full-page-wrapper " >
      <div class="content-wrapper " style="padding-top: 100px; padding-bottom: 100px;">
    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar.php';?>  <!-- partial -->
   

<!-- Page content  -->
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> PC1 Summary </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end" >  
  <?php if($adminflag==1)
	{
	 ?>

<button type="button" class="col-sm-2 button-33" onclick="location.href='sp_pc1_input.php';" > Add New Record </button>
<?php } 

?>
<button type="button" class="col-sm-2 button-33" onclick="location.href='chart1.php';" >  Back </button>

	</div>
</div>



 <div style="" class="table-responsive">
  <table width="100%" class="table table-bordered  table-striped"  >
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">Item ID</th>
                                  <th width="37%" style="text-align:center">Description</th>
                                  <th width="12%" style="text-align:center">IBRD (<?php echo $proj_cur;?>)</th>
                                  <th width="12%" style="text-align:center">IDA (<?php echo $proj_cur;?>)</th>
                                  <th width="12%" style="text-align:center">WAPDA/GOP (<?php echo $proj_cur;?>)</th>
                                  <th width="12%" style="text-align:center">Total (<?php echo $proj_cur;?>)</th>
								   <?php if($adminflag==1)
								  {
								   ?>
								  <th width="10%" colspan="2" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  	  if($pdSQLResult->num_rows >=1)
							  {
							  while($pdData = $pdSQLResult->fetch_array())
							  { ?>
                        <tr>
                          <td class="py-3" align="center"><?php echo $pdData['item_id'];?></td>
                          <td class="py-3" align="left"><?php echo $pdData['description'];?></td>
                          <td class="py-3" align="right"><?php if($pdData['f1']!=""&&$pdData['f1']!=NULL)echo number_format($pdData['f1'],2);?></td>
                          <td class="py-3" align="right"><?php if($pdData['f2']!=""&&$pdData['f2']!=NULL)
						   echo number_format($pdData['f2'],2);?></td>
                          <td class="py-3" align="right"><?php if($pdData['f3']!=""&&$pdData['f3']!=NULL)
						  echo number_format($pdData['f3'],2);?></td>
                          <td class="py-3" align="right"><?php if($pdData['price']!=""&&$pdData['price']!=NULL)
						  echo number_format($pdData['price'],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td class="py-3" align="right"><span style="float:left"><form action="sp_pc1_input.php?pc1_id=<?php echo $pdData['pc1_id'] ?>" method="post">
               <button type="submit" title="Edit" class="btn btn-outline-primary btn-fw px-1  py-1  " style="margin-top: 0; margin-bottom: 0; " name="edit" id="edit" value="<?php echo EDIT;?>" >    
						       <i class="ti-pencil btn-icon-prepend m-0" style="font-size: 11px;" ></i>  
                            </button></form></span>
               </td><td class="py-3" align="right"><span style="float:right">
               <form action="sp_pc1.php?pc1_id=<?php echo $pdData['pc1_id'] ?>" method="post">
               <button type="submit" title = "Delete"  class="btn btn-outline-danger btn-fw px-1 py-1 m-0"  style="margin-top: 0; margin-bottom: 0; " name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" style="font-size: 11px;"  ></i> 
        					</button></form></span></td>
						   <?php
						   }?>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="9" >No Record Found</td>
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

