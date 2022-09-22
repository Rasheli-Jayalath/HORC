
<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
//$ObjMapDrawing  = new  MapsDrawings();
//$ObjMapDrawing2 = new MapsDrawings();
//$ObjMapDrawing3 = new MapsDrawings();
//$ObjMapDrawing4 = new MapsDrawings();
//$user_cd=1;
//$_SESSION['ne_user_type']=1;
//$data_url="drawings/";
//$file_path="pictorial_data";
//$data_url="photos/";

 //$album_id=$_REQUEST['album_id'];

$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.lid.value != ""){
		qString += 'lid=' + escape(frm.lid.value);
	}
	if(frm.iss_status.value != ""){
		qString += '&iss_status=' + escape(frm.iss_status.value);
	}
	
	document.location = 'rfi_info.php?' + qString;
}


</script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RFI</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">

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

 <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
  


</head>
<body>
  <div class="container-scroller">
    
     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->
 
     <div class=" page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">



    
<h4 class="text-center text-34" style="  letter-spacing: 4px"> REQUEST FOR INFORMATION (RFI)  </h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  

	</div>
	<div class="col-sm-10 text-end" >  



<button type="button" class="col-sm-2 button-33" onclick="location.href='RFI_input.php'  ;" name="add" id="add" value=""> <?php echo "Add New RFI"?> </button>


	</div>
	
</div>
<div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab"> 
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#rfi_report" role="tab" aria-controls="rfi_details" aria-selected="true"> RFI Report </a>
                    </li>
                   
                    <li class="nav-item">
                      <a class="nav-link" id="indicators-tab" data-bs-toggle="tab" href="#surv_report" role="tab" aria-selected="false">Survey Report</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab"  href="#inspect_report" role="tab" aria-selected="false">Inspection Report</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab"  href="#qual_report" role="tab" aria-selected="false">Quality  Report</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#app_report" role="tab" aria-selected="false">Approved Report</a>
                    </li>

                 
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                      <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                      <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                    </div>
                  </div>
                </div>
				</div>

				</div>
                </div>
				</div>
				<div class="tab-pane fade show" id="rfi_report" role="tabpanel" aria-labelledby="rfi_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Survey Details</h4>
                   
                   
                   
                    </div>
					</div>
				  </div> 
				 </div>

				<div class="tab-pane fade show" id="surv_report" role="tabpanel" aria-labelledby="surv_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Survey Details</h4>
                   
                   
                   
                    </div>
					</div>
				  </div> 
				 </div>
				 <div class="tab-pane fade show" id="qual_report" role="tabpanel" aria-labelledby="qual_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Quality Details</h4>
                   
                   
                   
                    </div>
					</div>
				  </div> 
				 </div>
				 <div class="tab-pane fade show" id="inspect_report" role="tabpanel" aria-labelledby="inspect_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Inspection Details</h4>
                   
                   
                   
                    </div>
					</div>
				  </div> 
				 </div>
				 <div class="tab-pane fade show" id="app_report" role="app_report" aria-labelledby="qual_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
					  <h4 class="card-title text-center pt-4 pb-1">Inspection Details</h4>
                      <div class="col-lg-12 grid-margin stretch-card">
					                <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Risk Register</h4>

 <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                                <tr>
                                  <th  > RFI Number</th>                                
                                  <th  > RFI Ref Number</th>
                                  
                                  <th >  Date</th>
                                  <th > Activity Location</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab ";
							
							$objSDb->dbQuery($pdSQL);
							  
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {
								  ?>
								  <tr>
								  <td ><?php  echo $pdData['rfi_number'];?>  
								  <td ><?php  echo $pdData['rfi_prev_ref'];?>  
								  <td ><?php  echo $pdData['rfi_Date'];?>  
								  <td ><?php  echo $pdData['rfi_activity_location'];?>  
								  <?php  $qual_data=$pdData['Quality_test_report_document'];?>
								  <?php  $rfi_id=$pdData['rfi_id'];?>
								  <?php  $surv_data=$pdData['Survey_document'];?>
								  <?php  $ins_data=$pdData['Inspection_document'];?>

								  <td >
						    
								  <form action="RFI_input.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
						   <button type="submit" title="Edit" class="btn btn-outline-warning btn-fw  py-1  "  name="edit" id="edit" value="<?php echo EDIT;?>" >
						   <i class="ti-pencil btn-icon-prepend" ></i> EDIT 
             				</button></form>
						  
						   </td>	

						   <td align="right">
						   <span style="float:right"><form action="rfi_info.php?nos_id=" method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>
                            <td>
								<form>
								<a href="rfi_docs/<?php echo  $qual_data;?>" target="_blank">
                            <button type="button"  class="btn btn-primary btn-rounded btn-fw" name="qual_repo" id="qual_repo" href="www.google.com">Quality Report </button>
							  </a> </form>   
						</td>
                            <td>
							<form>
								<a href="rfi_docs/<?php echo  $surv_data;?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="surv_repo" id="surv_repo" > Survey Report </button>
							</a> </form>   
                            </td>
                            <td>
							<form>
								<a href="rfi_docs/<?php echo  $ins_data;?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="ins_repo" id="ins_repo">  Inspection Report </button>
							</a> </form>   
                            </td>
							  </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="11" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						$i=$i+1;
						
						?>
                              </tbody>
        </table>
		</div>
        </div>
        </div>
        </div>
  </div><!-- class="content-wrapper" -->
                   
                   
                   
                    </div>
					</div>
				  </div> 
				 </div>
 <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Risk Register</h4>

 <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                                <tr>
                                  <th  > RFI Number</th>                                
                                  <th  > RFI Ref Number</th>
                                  
                                  <th >  Date</th>
                                  <th > Activity Location</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab";
							
							$objSDb->dbQuery($pdSQL);
							  
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {
								  ?>
								  <tr>
								  <td ><?php  echo $pdData['rfi_number'];?>  
								  <td ><?php  echo $pdData['rfi_prev_ref'];?>  
								  <td ><?php  echo $pdData['rfi_Date'];?>  
								  <td ><?php  echo $pdData['rfi_activity_location'];?>  
								  <?php  $qual_data=$pdData['Quality_test_report_document'];?>
								  <?php  $rfi_id=$pdData['rfi_id'];?>
								  <?php  $surv_data=$pdData['Survey_document'];?>
								  <?php  $ins_data=$pdData['Inspection_document'];?>

								  <td >
						    
								  <form action="RFI_input.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
						   <button type="submit" title="Edit" class="btn btn-outline-warning btn-fw  py-1  "  name="edit" id="edit" value="<?php echo EDIT;?>" >
						   <i class="ti-pencil btn-icon-prepend" ></i> EDIT 
             				</button></form>
						  
						   </td>	

						   <td align="right">
						   <span style="float:right"><form action="rfi_info.php?nos_id=" method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>
                            <td>
								<form>
								<a href="rfi_docs/<?php echo  $qual_data;?>" target="_blank">
                            <button type="button"  class="btn btn-primary btn-rounded btn-fw" name="qual_repo" id="qual_repo" href="www.google.com">Quality Report </button>
							  </a> </form>   
						</td>
                            <td>
							<form>
								<a href="rfi_docs/<?php echo  $surv_data;?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="surv_repo" id="surv_repo" > Survey Report </button>
							</a> </form>   
                            </td>
                            <td>
							<form>
								<a href="rfi_docs/<?php echo  $ins_data;?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="ins_repo" id="ins_repo">  Inspection Report </button>
							</a> </form>   
                            </td>
							  </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="11" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						$i=$i+1;
						
						?>
                              </tbody>
        </table>
		</div>
        </div>
        </div>
        </div>
  </div><!-- class="content-wrapper" -->

   
        <!-- partial:../../partials/_footer.html -->
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
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <!-- <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- <script src="../../js/navtype_session.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


  <!-- End custom js for this page-->



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


<script language="javascript" type="text/javascript">



</script>

<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
function getDates(lcid,lid)
{
	
	if (lcid!=0) {
			var strURL="finddate.php?lid="+lid+"&lcid="+lcid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("location_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
		
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
			
		}

}

function getCanals(lid)
{
 // alert(lid);
	
	if (lid!=0) {
			var strURL="findcanal.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {						
							document.getElementById("canal_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}


function getGalleryView(month) 
	{
	
		var location=document.getElementById("location").value;  
			
		if (month!="") {
			var strURL="findGalleryView.php?date_p="+month+" &location="+location;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('Gallery_View').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}



</script>

</body>
</html>

