<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
if (isset($_REQUEST['select'])) {
	$pid = $_REQUEST['pid'];
	$sridlist = $_SESSION['sridlist'];
	$srid = array_search($_REQUEST['srid'], $sridlist);
	$_SESSION['pid'] = $pid;
	$_SESSION['srid'] = $srid;
	$_SESSION['mode'] = 0;
	header("Location: chart1.php?back=1");
} else {
	$pid = $_SESSION['pid'];
	$_SESSION['mode'] = 0;
}
include_once("connect.php");
include_once("functions.php");
$nsrid_arra1y=array();

//===============================================
/*if(isset($_REQUEST['delete']))
{

$db->query ("Update t002project SET proj_status=2 where pid=".$_REQUEST['pid']);
}*/

if(isset($_REQUEST['reorder']))
{
	$reorder = 1;
}

if(isset($_REQUEST['saveorder']))
{
	$reorder = 0;	
	$message="";
	$count = count($_POST['pid_s']);
	$nsrid_array=$_POST['nsrid'];
	
	foreach($nsrid_array as $k => $v) {
    if ($v == 0) {
    	unset($nsrid_array[$k]);
    }
	}
		
	$nsrid_arra1y= array_unique( array_diff_assoc( $nsrid_array, array_unique( $nsrid_array ) ) );
	 print_r($nsrid_arra1y);
	$count_duplicate=count($nsrid_arra1y);
	
	if($count_duplicate>=1)
	{
	$reorder = 1;
	$message=  "Duplicate order number is not allowed";
	$reprint=1;
	}
	else
	{
	for($i=0;$i<$count;$i++)
	{	
	$nsrid_order=$_POST['nsrid'][$i];
	$pid=$_POST['pid_s'][$i];
	
	
	
	$sql = "update t002project set srid='$nsrid_order' where pid = '$pid'";
	$result = $db->query ($sql);
	
	
	}
	}
	
	

	
	
}


 $pdSQL = "SELECT a.pid, a.pgid, a.srid, a.proj_name FROM (SELECT pid, pgid, srid, proj_name FROM t002project where srid <> 0 order by srid ) a UNION SELECT pid, pgid, srid, proj_name FROM t002project where srid = 0";
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
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> Projects List </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end " >  
	<?php if($adminflag==1)
								  {
								   ?>

  <form action="sp_maindashboard.php" method="post" >
  <button type="button" class="col-sm-2 button-33" onclick="location.href='sp_maindashboard_input.php';" > Add New Record </button>

  <?php if ($reorder == 1) { ?>
	<button type="submit" class="col-sm-2 button-33" name="saveorder" id="saveorder" value="Save Order" > Save Order </button>
	<?php } else {?>
		<button type="submit" class="col-sm-2 button-33" name="reorder" id="reorder" value="Re-Order" > Re-Order</button>
	<?php } ?>
	<span style="text-align:left; color:red"> <?php echo $message; ?></span>
 <?php } ?>
 
<button type="button" class="col-sm-2 button-33" onclick="location.href='chart1.php';" >  Back </button>

	</div>
</div>
<!--  -->



<table style="width:100%; height:100%">

  <tr style="height:100%"><td align="left" >

   <div class="MainDiv" >
  <div style=" height:485px;">
  <table width="46%" class="table table-bordered table-striped" align="right">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <?php if ($reorder == 1) { ?> 
                                  <th width="5%" style="text-align:center; vertical-align:middle">Order</th>
                                  <?php } ?>
                                  <th width="70%" style="text-align:center">Project Name</th>
								  <th width="25%" colspan="2" style="text-align:center">Action</th>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if($pdSQLResult ->num_rows>=1)
							  {
							  $j=0;
							  while($pdData = $pdSQLResult->fetch_array())
							  {
							
							   ?>
                        <tr style="color:<?php echo(array_key_exists($j, $nsrid_arra1y)== true ? "red" : "black");?>">
                          <td align="center"><?php echo $pdData['srid'];?></td>
                          <?php if ($reorder == 1) { ?> 
                          <td align="center"><input type="hidden" name="pid_s[]" id="pid_s[]" value="<?php echo $pdData['pid'] ?>" /><input type="text" name="nsrid[]" id="nsrid[]" value="<?php echo ($reprint==1 ? $nsrid_array[$j] : $pdData['srid']); $j=$j+1;  
						   ?>" style="width:30px;" onkeypress="return isNumberKey(event)"  /></td>
                          <?php } ?>
                          <td align="left"><?php echo $pdData['proj_name'];?></td>
						   <td align="right">
						   <form action="sp_maindashboard.php" method="post"><input type="hidden" name="pid" id="pid" value="<?php echo $pdData['pid'] ?>" /><input type="hidden" name="srid" id="srid" value="<?php echo $pdData['srid'] ?>" /><input type="submit" class="btn btn-outline-primary btn-fw px-1  py-1 " name="select" id="select" value="Select" <?php if ($pdData['srid'] == NULL || $pdData['srid'] == '' || $pdData['srid'] == 0) {echo 'disabled="disabled"';} ?> /></form>
						   </td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="sp_maindashboard_input.php?pid=<?php echo $pdData['pid'] ?>" method="post"><input type="submit" class="btn btn-outline-primary btn-fw px-1  py-1 " name="edit" id="edit" value="Edit" /></form></span><!--<span style="float:right"><form action="sp_maindashboard.php?pid=<?php //echo $pdData['pid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>--></td>
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
                        </table></div>
                        </div>
						<?php if($adminflag==1)
								  {
								   ?>
						</form>

<?php
}
?>
                        </td></tr>
  
  </table>
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

