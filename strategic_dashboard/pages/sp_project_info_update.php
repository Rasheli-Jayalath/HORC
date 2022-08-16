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
/*
brid
pgid
pid
serial
description
total
inprogress
completed
*/



if(isset($_REQUEST['update']))
{

	//$pid=$_REQUEST['pid'];
	$proj_length=$_REQUEST['proj_length'];
	$con_id=$_REQUEST['con_id'];
	$comp1=$_REQUEST['comp1'];
	$comp2=$_REQUEST['comp2'];
	$cons_id=$_REQUEST['cons_id'];
	$proj_cont_price=$_REQUEST['proj_cont_price'];
	$proj_start_date=$_REQUEST['proj_start_date'];
	$proj_end_date=$_REQUEST['proj_end_date'];
	$proj_src_fund=$_REQUEST['proj_src_fund'];
	$proj_pc1_amount=$_REQUEST['proj_pc1_amount'];
	$proj_cur=$_REQUEST['proj_cur'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t002project SET proj_length='$proj_length', con_id='$con_id', comp1='$comp1', comp2='$comp2', cons_id='$cons_id',  proj_cont_price='$proj_cont_price',  proj_start_date='$proj_start_date', proj_end_date='$proj_end_date',proj_src_fund='$proj_src_fund', proj_pc1_amount='$proj_pc1_amount' , proj_cur='$proj_cur' where pid=$pid";
	
	$sql_proresult=mysqli_query($db, $sql_pro) or die(mysqli_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysqli_error($db);
}
	

//header("Location: sp_project_info_update.php");
}


$pdSQL1="SELECT pid,pgid,proj_name,proj_length,con_id,comp1,comp2, cons_id,proj_cont_price,proj_start_date,proj_end_date,proj_src_fund,proj_pc1_amount,proj_cur  FROM t002project  where pid = ".$pid;
$pdSQLResult1 = mysqli_query($db, $pdSQL1) or die(mysqli_error());
$pdData1 = mysqli_fetch_array($pdSQLResult1);

	$proj_name=$pdData1['proj_name'];
	$proj_length=$pdData1['proj_length'];
	$con_id=$pdData1['con_id'];
	$comp1=$pdData1['comp1'];
	$comp2=$pdData1['comp2'];
	$cons_id=$pdData1['cons_id'];
	$proj_cont_price=$pdData1['proj_cont_price'];
	$proj_start_date=$pdData1['proj_start_date'];
	$proj_end_date=$pdData1['proj_end_date'];
	$proj_src_fund=$pdData1['proj_src_fund'];
	$proj_pc1_amount=$pdData1['proj_pc1_amount'];
	$proj_cur=$pdData1['proj_cur'];

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
      <div class="content-wrapper " style="padding-top: 80px; padding-bottom: 20px;">
    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar.php';?>  <!-- partial -->
   

<!-- Page content  -->
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> Project Information </h4> 


<!--  -->

<div class="row" > 
<div class=" col-sm-2" > </div>
  <form id="inputForm"  action="sp_project_info_update.php" target="_self" method="post" class=" col-sm-8" >

  <div class=" grid-margin stretch-card pt-4" >
              <div class="card " >
                <div class="card-body text-center pb-5 " style="padding-right: 40px;">

				  <?php echo $message; ?>

          <div class="row  pt-4">
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Civilworks Contractor : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text"   name="proj_length" id="proj_length" value="<?php echo $proj_length; ?>" />
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  E &amp; M Contractor : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="con_id" id="con_id" value="<?php echo $con_id; ?>"   />
                            </div>
                          </div>
                        </div>
            </div>


            <div class="row  ">
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Company 1 : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="comp1" id="comp1" value="<?php echo $comp1; ?>"  />
                            <p style="font-size: 10px;"> (Displayed on Contractor Mobilization and QA/QC Tests)	 </p>
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Company 2 : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text"  name="comp2" id="comp2" value="<?php echo $comp2; ?>" />
                            <p style="font-size: 10px;"> (Displayed on Contractor Mobilization and QA/QC Tests)	 </p>
                            </div>
                          </div>
                        </div>
            </div>

            <div class="row  ">
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Consultant(M&E): </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text"  name="cons_id" id="cons_id" value="<?php echo $cons_id; ?>"   />
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Contract Price : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="proj_cont_price" id="proj_cont_price" value="<?php echo $proj_cont_price; ?>" />
                            </div>
                          </div>
                        </div>
            </div>


            <div class="row  ">
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Start Date : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="proj_start_date" id="proj_start_date" value="<?php echo $proj_start_date; ?>"   />
                            <p>  yyyy-mm-dd</p>
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  VO2 Completion Date : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text"  name="proj_end_date" id="proj_end_date" value="<?php echo $proj_end_date; ?>" />
                            <p>  yyyy-mm-dd</p>
                            </div>
                          </div>
                        </div>
            </div>

            <div class="row  ">
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Source of Funds : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="proj_src_fund" id="proj_src_fund" value="<?php echo $proj_src_fund; ?>"   />
                            </div>
                          </div>
                        </div>       
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Appro. PC-1 Amount : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text" name="proj_pc1_amount" id="proj_pc1_amount" value="<?php echo $proj_pc1_amount; ?>" />
                            </div>
                          </div>
                        </div>
            </div>


            <div class="row  pb-5">
                        <div class="col-md-6  ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Currency : </label>
                            <div class="col-sm-8 text-start">
                            <input class=" form-control bg-light text-dark "   type="text"  name="proj_cur" id="proj_cur" value="<?php echo $proj_cur; ?>" />
                            </div>
                          </div>
                        </div>       
              
            </div>

               

 

   <button type="submit" class="btn btn-primary me-2 text-center"   name="update" id="update" value="Update"  style="width:20%; margin-left: 40px;  margin-left: 40px; "> Update </button>


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

