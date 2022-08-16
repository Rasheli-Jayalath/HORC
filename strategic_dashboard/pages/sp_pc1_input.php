<?php
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}
include_once("connect.php");
include_once("functions.php");
//===============================================

if(isset($_REQUEST['save']))
{
	
	$item_id=$_REQUEST['item_id'];
	$description=$_REQUEST['description'];
	$price=$_REQUEST['price'];
	$f1=$_REQUEST['f1'];
	$f2=$_REQUEST['f2'];
	$f3=$_REQUEST['f3'];
	$display_order=$_REQUEST['display_order'];
	$message="";
	$pgid=1;
$sql_pro=mysqli_query($db, "INSERT INTO t0071pc1summary (pid,item_id,description, price,f1,f2,f3,display_order) Values(".$pid.",'".$item_id."', '".$description."','".$price."', '".$f1."' , '".$f2."' , '".$f3."' , '".$display_order."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysqli_error($db);
}
	
	$item_id='';
	$description='';
	$price='';
	$f1='';
	$f2='';
	$f3='';
	$display_order='';
}

if(isset($_REQUEST['update']))
{
	$pc1_id=$_REQUEST['pc1_id'];
	$item_id=$_REQUEST['item_id'];
	$description=$_REQUEST['description'];
	$price=$_REQUEST['price'];
	$f1=$_REQUEST['f1'];
	$f2=$_REQUEST['f2'];
	$f3=$_REQUEST['f3'];
	$display_order=$_REQUEST['display_order'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0071pc1summary SET item_id='$item_id', description='$description', price='$price', f1='$f1', f2='$f2', f3='$f3', display_order=$display_order where pc1_id=$pc1_id";
	
	$sql_proresult=mysqli_query($db, $sql_pro) or die(mysqli_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysqli_error($db);
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
header("Location: sp_pc1.php");
}
if(isset($_REQUEST['pc1_id']))
{
$pc1_id=$_REQUEST['pc1_id'];

$pdSQL1="SELECT pc1_id, pid, item_id, description, price, f1, f2, f3 ,display_order FROM t0071pc1summary  where pid = ".$pid." and  pc1_id = ".$pc1_id;

$pdSQLResult1 = mysqli_query($db, $pdSQL1) or die(mysqli_error());
$pdData1 = mysqli_fetch_array($pdSQLResult1);

	$item_id = $pdData1['item_id'];
	$description = $pdData1['description'];
	$price = $pdData1['price'];
	$f1 = $pdData1['f1'];
	$f2 = $pdData1['f2'];
	$f3 = $pdData1['f3'];
	$display_order = $pdData1['display_order'];
}
$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult = mysqli_query($db, $pcrSQL);
$pcrData = mysqli_fetch_array($pcrSQLResult);
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
      <div class="content-wrapper " style="padding-top: 80px; padding-bottom: 20px;" >
    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar.php';?>  <!-- partial -->
   

<!-- Page content  -->
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> PC1 Summary </h4> 


<!--  -->

<div class="row" > 
<div class=" col-sm-2" > </div>
  <form  id="inputForm" action="sp_pc1_input.php" target="_self" method="post" class=" col-sm-8" >

  <div class=" grid-margin stretch-card pt-4" >
              <div class="card " >
                <div class="card-body text-center pb-5" style="padding-right: 40px;" >

				  <?php echo $message; ?>

            <div class="row pt-5 ">
            <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Item ID : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="item_id" id="item_id" value="<?php echo $item_id; ?>" />
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Description : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "  type="text" name="description" id="description" value="<?php echo $description; ?>"  />
                            </div>
                          </div>
                        </div>
            </div>

            <div class="row ">
            <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  IBRD (<?php echo $proj_cur;?>) : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="f1" id="f1" value="<?php echo $f1; ?>" />
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  IDA (<?php echo $proj_cur;?>) : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark " type="text" name="f2" id="f2" value="<?php echo $f2; ?>" />
                            </div>
                          </div>
                        </div>
            </div>
            
            <div class="row ">
            <div class="col-md-6  ">
                          <div class="form-group row" style="" >
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  WAPDA/GOP (<?php echo $proj_cur;?>): </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="f3" id="f3" value="<?php echo $f3; ?>" />
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Price (<?php echo $proj_cur;?>) : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "  type="text" name="price" id="price" value="<?php echo $price; ?>"  />
                            </div>
                          </div>
                        </div>
            </div>
            
            <div class="row pb-5">
            <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Display Order : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "  type="text" name="display_order" id="display_order" value="<?php echo $display_order; ?>"  />
                            </div>
                          </div>
                        </div>       
                   
            </div>

            <?php if(isset($_REQUEST['pc1_id']))
	 {
		 
	 ?>
     <input type="hidden" name="pc1_id" id="pc1_id" value="<?php echo $_REQUEST['pc1_id']; ?>" />
     <button type="submit" name="update" id="update" class="btn btn-primary me-2"  value="Update" style="width:20%;  margin-left: 40px; "> Update </button>
	 <?php
	 }
	 else
	 {
	 ?>
   <button type="submit" name="save" id="save" class="btn btn-primary me-2"  value="Save" style="width:20%; "> Save </button>
   <button class="btn btn-secondary" type="button" style="width:20% ; margin-left : 20px "  onclick="javascript:document.getElementById('inputForm').reset()"   name="cancel" id="cancel" value="Cancel" >Cancel</button>

	 <?php
	 }
	 ?> 

                </div>
              </div>
            </div>


	  
	  
  
  
  </form> 
  <div class=" col-sm-2 pt-4" > <button type="button" class="col-sm-11 button-33" onclick="history.back()" >  Back </button> </div>
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

