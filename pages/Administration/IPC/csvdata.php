
<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "IPC Data";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$ipc_flag			= $_SESSION['ne_ipc'];
	$ipcadm_flag		= $_SESSION['ne_ipcadm'];
	$ipcentry_flag		= $_SESSION['ne_ipcentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 

$edit			= $_GET['edit'];




?>

<?php


if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);

            $ipcid ;

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
              $lastIndex= sizeof($line);
                // Get row data
                $ipcid   = $_GET['edit'];
                $boqid   = $line[$lastIndex-9];
                $boqcode = $line[$lastIndex-8];
                $boqdetail  =   preg_replace('/[^A-Za-z0-9\-]/',' ', $line[$lastIndex-7]);  
                $boqrate = $line[$lastIndex-3];
                $ipcqty = $line[$lastIndex-1];
                $ipc_amount = $ipcqty*$boqrate ;
                    $sql1 = "INSERT INTO ipcv_copy (ipcid, boqid, boqcode, boqdetail, boqrate,  ipcqty, ipc_amount) VALUES ('".$ipcid."', '".$boqid."','".$boqcode."', '".$boqdetail."', '".$boqrate."', '".$ipcqty."', '".$ipc_amount."' )";  
                    echo $sql1 ;                      
                    // $db->query($sql1 );
                    $objDb1->dbQuery($sql1);
                // }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';


            // Redirect to the listing page
             header("Location: csvdata.php?msg=1&ipcid=".$ipcid);

        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add IPC Entry</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />

  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../../css/scrollbarStyle.css" rel="stylesheet" />

  <style>
        .margintopCSS {
          margin-top:10px;
        }
    </style>

</head>
<body>
  <div class="container-scroller">

     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->

     <div class="container-fluid page-body-wrapper" id="pagebodywraper">


       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel" id="mainpanel">
      <div class="content-wrapper">

      <?php 
if(isset($_GET['edit'])){
?>

        <div class="row">

          <div class="col-md-10 m-auto  stretch-card">

            <div class="card bg-form">
                <div class="col-md-8 m-auto py-4" style="color:#fff">


                <h2 style="text-align:center">Import CSV File 
                <span style="" >   </span>
                <span style="text-align:right; float:right" ><a href="ipcdata.php" class="btn btn-secondary px-2 py-1" > 
                  <i  class="mdi mdi-keyboard-backspace mb-5 text-bold" style="vertical-align: top;"></i>  Back</a></span>
                </h2>
                <hr>

                <script>
                      function checkFile(fileSubmit){

                        var fileVal = fileSubmit.elements['file'].value;

                        //RegEx for valid file name and extensions.
                        var pathExpression = "[?:[a-zA-Z0-9-_\.]+(?:.csv)";


                        if(fileVal != ""){
                            // if(!fileVal.toString().match(pathExpression) && confirm("The file is not a valid image. Do you want to continue?")){
                            //     fileSubmit.submit();
                            // } else {
                            //     return;
                            // }

                            if(!fileVal.toString().match(pathExpression) ){
                              event.preventDefault();
                              location.reload();
                              alert("The file is not a CSV file. Please choose the correct CSV file !");
                            }

                        } else { 
                            alert("Please add a File !");
                            // if(confirm("Do you want to continue without adding image?")) {
                            //     fileSubmit.submit();
                            // } else {
                            //     return;
                            // }
                          }
                        }
                 </script>
               
        <div class="container">
            <div class="row">
            <!-- CSV file upload form -->
            <div class="col-md-12" id="importFrm" style="margin: 50px 50px 50px 50px;">
                <form action="" method="post" name="fileSubmit" enctype="multipart/form-data">
                    <input type="file" name="file" />
                    <input type="submit" class="btn btn-success" name="importSubmit"  onClick="checkFile(this.form)" value="IMPORT">
                </form>
            </div>
            </div>  
       </div>


      </div>
            </div>
            </div>



         </div>
         <?php }else if(isset($_GET['msg'])&& $_GET['msg']==1){ ?>

         <div class="row"  style = "margin-top: 20px;margin-right:15px; align-items: center; justify-content: center;">

     <?php 
     $verifiedIPCId;
     if(isset($_GET['ipcid'])){
      $verifiedIPCId = $_GET['ipcid'];
     }
     ?>
         <script>
                      function confirmVerify(){
                            if(confirm("Have you checked all these records?")) {
                                fileSubmit.submit();
                            } else {
                              event.preventDefault();
                            
                            }
                        }

                         function confirmDelete(){
                            if(confirm("Do you need to delete all these records?")) {
                                fileSubmit.submit();
                            } else {
                              event.preventDefault();
                             
                            }
                        }
        </script>
	 
<form action="ipcdata.php?verifiedIPCId=<?php echo $verifiedIPCId; ?>" name="reports" id="reports"  method="post"   > 



<div class="row pb-0 m-0">

<div class="col-4">
    <a href="ipcdata.php" > 
   <button  style=" "  class="btn btn-primary  btn-md  py-2" name="">  <i  class="mdi mdi-keyboard-backspace mb-5 text-bold" style="vertical-align: top;"></i> Go Back to IPC data  </button>
</a>
    </div>
    <div class="col-4 text-end mt-2" style="font-size: 15px;">
      Please check all data and select the option. 
    </div>

    <div class="col-2">
<input type="submit" value="VERIFY ALL" style="text-align:center; float: right; margin-bottom: 40px; " onClick="confirmVerify()" class="btn btn-warning  btn-md mb-1" name="submitVerify">

    </div>
    <div class="col-2">
<input type="submit" value="DELETE ALL" style="text-align:center; float: right; margin-bottom: 40px; " onClick="confirmVerify()" class="btn btn-danger  btn-md mb-1" name="submitDelete">

    </div>


</div>

</form>

<div class ="table-responsive" style="width: 103%;">
	<table class="table table-striped" > 
    <tr class="bg-form" style="font-size:12px; color:#CCC;">
    
      <th align="center" width="3%"><strong>ipcvid</strong></th>
      
          <th align="center" width="10%"><strong>ipcid</strong></th>
      <th align="center" width="10%"><strong>boqid</strong></th>
      <th width="10%"><strong>BOQ Code</strong></th>
      <th width="15%"><strong>BOQ Details</strong></th>
      <th width="7%"><strong>BOQ Rate</strong></th>
	  <th width="7%"><strong>IPC QTY</strong></th>
    <th width="7%"><strong>ipc amount</strong></th>
      
	<!--<th align="center" width="10%"><strong>Log
    </strong></th>-->
    </tr>
<strong>
<?php

 $sSQL = "SELECT * FROM ipcv_copy where ipcid= $verifiedIPCId " ;

 $objDb2->dbQuery($sSQL);
 $iCount = $objDb2->totalRecords( );
 if($iCount>0)
 {
	 $j=0;
	while( $res_e2=$objDb2->dbFetchArray())
	
	{
	 $j++;
		
	  $ipcvid 								= $res_e2['ipcvid'];
	  $ipcid 								= $res_e2['ipcid'];
    $boqid 								= $res_e2['boqid'];
    $boqcode 								= $res_e2['boqcode'];
    $boqdetail 								= $res_e2['boqdetail'];
    $boqrate 								= $res_e2['boqrate'];
    $ipcqty 								= $res_e2['ipcqty'];
    $ipc_amount 								= $res_e2['ipc_amount'];
	  
	  

	  $sSQL6 = "SELECT * FROM ipcv_copy where ipcvid= $ipcvid " ;

 	$objDb3->dbQuery($sSQL6);
	$res_e3=$objDb3->dbFetchArray();
	  
	   if($status3=="0")
	  {
	  $status="Active";
	  }
	  else  if($status3=="1")
	  {
	  $status="Inactive";
	  }
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}

?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?php echo $ipcvid ;?> </center> </td>

<td width="210px"><?php echo $ipcid ;?></td>
<td width="210px"><?=$boqid ;?></td>
<td width="100px"><?=$boqcode;?></td>
<td width="180px"  > <?php echo wordwrap($boqdetail,30,"<br>\n"); ?> </td>
<td width="80px"><?=$boqrate;?></td>
<td width="80px"><?=$ipcqty;?></td>
<td width="80px"><?=$ipc_amount;?></td>


<!-- <td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
<button type="button" style="text-align:center;" class="btn btn-outline-info btn-sm" onclick="location.href='ipcdata.php?edit=<?php echo $ipcid;?>'">EDIT</button>
 </td> -->
<!-- <td width="210px" align="right" ><a href="log_ipcdata.php?trans_id=<?php echo $ipcid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>-->
</tr>
<?php        
	}
	}
?>
</table>
</div>

</div>
<?php } ?>
 </div>

        <!-- partial:../../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
<script src="../../../vendors/chart.js/Chart.min.js"></script>
 <!--   <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>-->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <script src="../../../js/settings.js"></script>
  <script src="../../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- <script src="../../../js/navtype_session.js"></script> -->
   <!--  commented because of date picker js files
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->
  <!-- End custom js for this page-->
  <link rel="stylesheet" type="text/css" media="all" href="../../../datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="../../../datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="../../../datepickercode/jquery-ui.js"></script>

 <script>
      $(function(){
        $("#partials-navbar").load("../../../partials/_navbar.php");
      });
  </script>

  <script>
    $(function(){
      $("#partials-theme-setting-wrapper").load("../../../partials/_settings-panel.php");
    });
  </script>

  <script>
    $(function(){
      $("#partials-sidebar-offcanvas").load("../../../partials/_sidebar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-footer").load("../../../partials/_footer.php");
  });
</script>


<!-- Page Load Function -->




</body>

</html>