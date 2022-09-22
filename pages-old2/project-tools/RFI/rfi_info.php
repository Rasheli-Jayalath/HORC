
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
$rfi_id			= $_GET['rfi_id'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );






if(isset($_REQUEST['delete'])){
	echo $rfi_id;
  $insert_q2="DELETE FROM tbl_rfi_lab  WHERE rfi_id='$rfi_id'";
  $sql_pro2= $objDb->dbQuery($insert_q2);
if ($sql_pro2 == TRUE) {
  $message=  "Record Deleted Successfully";
$activity=$insertid." - Record Deleted Successfully";
} else {
  $message= "Error in Deleting record";
}
}

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
<style>
        .margintopCSS {
          margin-top:10px;
        }   
        
        .text-34{
  background-color: #151563;
  border-radius: 10px;
  /* box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
  padding-bottom: 12px;
  padding-top: 12px;
  border-radius: 5px 5px;
  color: white;
  font-size: 100%;
}
table{
   
   border:  double ;
   }
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
}
.new_div li {
    list-style: outside none none;
}
        
.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("../../../images/images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 130px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}

.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 0px 20px;
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
.button-34 {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(26, 26, 125);
  color: #1a1a7d;
  /* box-shadow: rgba(34, 34, 199, .02) 0 -25px 18px -14px inset,rgba(34, 34, 199, .05) 0 1px 2px,rgba(34, 34, 199, .05) 0 2px 4px,rgba(34, 34, 199, .05) 0 4px 8px,rgba(34, 34, 199, .05) 0 8px 16px,rgba(34, 34, 199, .10) 0 16px 32px; */
  box-shadow: none;
  padding: 15px 1px;
  border-radius: 0px;
  font-size: 73%;

  font-weight: 900;
  margin-left:0%;
}
.button-34:hover {
  background-color: #1f1f91;
  color: #fff;
  font-weight: 900;
  font-size: 75%;
  transform: scale(1.05) ;
}
.button-35 {

  padding: 12px 2px;

  font-size: 73%;
  font-weight: 700;
  margin-left:0%;
}
.button-35:hover {
  transform: scale(1.0) ;
  font-size: 85%;
}
.sm-unLine {

  font-weight: 600;
  /* text-decoration-line: underline;
  text-decoration: underline solid #1f1f91 1px;
  text-underline-position: under; */
  
  /* border-bottom: 3px solid #f9dd94; */
 
}

/* .sm-unLine::after {
  content: "";
  display: block;

  padding-top: 3px;
  border-bottom: 2px solid #f9dd94;
} */

/* #u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145 );

  border-radius:10px 30px;
  padding:3.8px;
} */
 

    </style>
<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>

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


    <button  class="  col-sm-2 button-33" href="general_report_parameter.php" onclick="window.open('general_report_parameter.php', 'Upload Photos ','width=1600px,height=850px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Generate Report</button> 


<button  class="col-sm-2 button-33" onclick="location.href='RFI_input.php'  ;" name="add" id="add" value=""> <?php echo "Add New RFI"?> </button>


	</div>
	
</div>
<div class="main-panel2" id="mainpanel2">
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
                     
                    </div>
                  </div>
                </div>


				<div class="tab-content tab-content-basic">

                 <div class="tab-pane fade show active" id="rfi_report" role="tabpanel" aria-labelledby="rfi_report"> 
                 	<div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
					  <h4 class="card-title text-center pt-4 pb-1">RFI Details</h4>
					  
					  <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                     <h4 class="card-title">RFI List</h4>
                       
					 <div class="table-responsive">

                    <table class="table table-striped">
                      <thead>
                                <tr>
								<th  > S#</th> 
                                  <th  > RFI Number</th>                                
                                  <th  > RFI Ref Number</th>
                                  
                                  <th >  Date</th>
                                  <th > Activity Location</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab a left join structures b on (a.lid=b.lid) order by rfi_id";
							
							$objSDb->dbQuery($pdSQL);
							

							$current="";
							$prev="";
							$comp="";
							$comp2="";
							  
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {
								$counter=$counter+1;

								$current=$pdData["rfi_id"];
                				$comp=$pdData["title"];
							  if($comp2!=$comp){?>
                  <tr class="">
                             
                  <td align="left" colspan="13" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $comp?></strong></span></td>
                 
                </tr>
               
                <?php  $comp2=$comp;} else{

                }
							  if($prev!=$current)
							  {?> 
								 
								  <tr>
								  <td ><?php  echo $counter;?>  
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
						   <i class="ti-pencil btn-icon-prepend" ></i>  
             				</button></form>
						  
						   </td>	

						   <td align="right">
						   <span style="float:right"><form action="rfi_info.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>
                           
						<td>
							<form>
								<a href="<?php if($qual_data!=""){ echo "rfi_docs/".$qual_data;}?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="qual_repo" id="qual_repo" > Quality Report </button>
							</a> </form>   
                            </td>
                            <td>
							<form>
								<a href="<?php if($surv_data!=""){ echo  "rfi_docs/".$surv_data;}?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="surv_repo" id="surv_repo" > Survey Report </button>
							</a> </form>   
                            </td>

							<td>
							<form>
								<a href="<?php if($ins_data!=""){ echo  "rfi_docs/".$ins_data;}?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="ins_repo" id="ins_repo" > Inspection Report </button>
							</a> </form>   
                            </td>

                        
							  </tr>
						<?php
						$prev=$current;

						}
						}
					}
						else
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
					  </div>
                      </div>
                </div>
              </div>
					 
                  <div class="tab-pane fade show" id="surv_report" role="tabpanel" aria-labelledby="surv_report"> 
                  <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
					  <h4 class="card-title text-center pt-4 pb-1">Survey Details</h4>

					  <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                     <h4 class="card-title">Survey Detail List</h4>
					 <div class="table-responsive">
                    <table class="table table-striped"  >
                      <thead>
						  
                                <tr >
								<th  > S#</th> 
                                  <th  > Surveyor Name</th>                                
                                  <th  > Survey Report</th>
                                  
                                  <th >  Date</th>
                                  <th > Survey comments</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody >
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab a left join structures b on (a.lid=b.lid) WHERE NOT Survey_Surveyor_name= '' order by rfi_id";
							
							$objSDb->dbQuery($pdSQL);
							$current="";
							$prev="";
							$comp="";
							$comp2="";
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {

								$counter=$counter+1;

								$current=$pdData["rfi_id"];
                				$comp=$pdData["title"];
							  if($comp2!=$comp){?>
                  <tr class="">
                             
                  <td align="left" colspan="13" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $comp?></strong></span></td>
                 
                </tr>
               
                <?php  $comp2=$comp;} else{

                }
							  if($prev!=$current)
							  {?> 
								  
								  <tr>
								  <td ><?php  echo $counter;?>  
								  <td ><?php  echo $pdData['Survey_Surveyor_name'];?>  
								  <td ><?php echo wordwrap($pdData['Survey_report'],70,"<br>\n")  ;?>  
								  <td ><?php echo wordwrap($pdData['Survey_Date_time'],70,"<br>\n")  ;?>  
								  <td ><?php echo wordwrap($pdData['Survey_comments'],70,"<br>\n")  ;?>  

								 
								  <?php  $qual_data=$pdData['Quality_test_report_document'];?>
								  <?php  $rfi_id=$pdData['rfi_id'];?>
								  <?php  $surv_data=$pdData['Survey_document'];?>
								  <?php  $ins_data=$pdData['Inspection_document'];?>

								  <td >
						    
								  <form action="RFI_input.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
						   <button type="submit" title="Edit" class="btn btn-outline-warning btn-fw  py-1  "  name="edit" id="edit" value="<?php echo "EDIT";?>" >
						   <i class="ti-pencil btn-icon-prepend" ></i> EDIT 
             				</button></form>
						  
						   </td>	

						   <td align="right">
						   <span style="float:right"><form action="rfi_info.php?rfi_id=<?php echo $pdData['rfi_id'] ?> method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>
                           
                            <td>
							<form>
								<a href="rfi_docs/<?php echo  $surv_data;?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="surv_repo" id="surv_repo" > Survey Report </button>
							</a> </form>   
                            </td>
                          
							  </tr>
						<?php
												$prev=$current;
							  }
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
				</div>
					 
					 </div>  
			</div>
					 
				  </div>
                  <div class="tab-pane fade show" id="qual_report" role="tabpanel" aria-labelledby="qual_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Quality Details</h4>
                   
					  <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Quality Details List</h4>

 <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                                <tr>
								<th  > S#</th> 
                                  <th  > Quality Engineer Name</th>                                
                                  <th  > Quality Test Sample Number</th>
                                  
                                  <th >  Date</th>
                                  <th > Quality Test Report</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab a left join structures b on (a.lid=b.lid) WHERE NOT Quality_MT_Engineer_name = '' order by rfi_id";
							
							$objSDb->dbQuery($pdSQL);
							$current="";
							$prev="";
							$comp="";
							$comp2="";
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {
								 
								$counter=$counter+1;

								$current=$pdData["rfi_id"];
                				$comp=$pdData["title"];
							  if($comp2!=$comp){?>
                  <tr class="">
                             
                  <td align="left" colspan="13" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $comp?></strong></span></td>
                 
                </tr>
               
                <?php  $comp2=$comp;} else{

                }
							  if($prev!=$current)
							  {?> 
								  
								  <tr>

								  <td ><?php  echo $counter;?>  
								  <td ><?php  echo $pdData['Quality_MT_Engineer_name'];?>  
								  <td ><?php  echo $pdData['Quality_test_sample_numbers'];?>  
								  <td ><?php  echo $pdData['Quality_testing_Date_time'];?> 
								  <td ><?php echo wordwrap($pdData['Quality_test_report'],70,"<br>\n")  ;?>  
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
						   <span style="float:right"><form action="rfi_info.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>

							<td>
							<form>
								<a href="<?php if($qual_data!=""){ echo  "rfi_docs/".$qual_data;}?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="qual_repo" id="qual_repo" > Quality Report </button>
							</a> </form>   
                            </td>

                            
                            
							  </tr>
						<?php
						$prev=$current;
					}
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
                  <div class="tab-pane fade show" id="inspect_report" role="tabpanel" aria-labelledby="inspect_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Inspection Details</h4>
                   
					  <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Inspection Details List</h4>

 <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                                <tr>
								<th  > S#</th> 
                                  <th  > Inspector Name</th>                                
                                  <th  > Inspection Report</th>
                                  
                                  <th >  Date</th>
                                  <th > Inspection Comments</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab a left join structures b on (a.lid=b.lid) WHERE NOT Inspection_inspector_name = '' order by rfi_id";
							
							$objSDb->dbQuery($pdSQL);
							$current="";
							$prev="";
							$comp="";
							$comp2="";
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {
								  
								$counter=$counter+1;

								$current=$pdData["rfi_id"];
                				$comp=$pdData["title"];
							  if($comp2!=$comp){?>
                  <tr class="">
                             
                  <td align="left" colspan="13" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $comp?></strong></span></td>
                 
                </tr>
               
                <?php  $comp2=$comp;} else{

                }
							  if($prev!=$current)
							  {?> 
								  
								  <tr>
								  <td ><?php  echo $counter;?>  
								  <td ><?php  echo $pdData['Inspection_inspector_name'];?>  
								  <td ><?php echo wordwrap($pdData['Inspection_report'],70,"<br>\n")  ;?>  
								  <td ><?php  echo $pdData['Inspection_Date_time'];?>  
								  <td ><?php echo wordwrap($pdData['Inspection_comments'],70,"<br>\n")  ;?>  


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
						   <span style="float:right"><form action="rfi_info.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>
                         
                            <td>
							<form>
								<a href="rfi_docs/<?php echo  $ins_data;?>" target="_blank">
                            <button type="button" class="btn btn-primary btn-rounded btn-fw" name="ins_repo" id="ins_repo">  Inspection Report </button>
							</a> </form>   
                            </td>
							  </tr>
						<?php
						$prev=$current;
					}
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
                  <div class="tab-pane fade show" id="app_report" role="app_report" aria-labelledby="qual_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
					  <h4 class="card-title text-center pt-4 pb-1">Approval Details</h4>
                      <div class="col-lg-12 grid-margin stretch-card">
					                <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Approval Details List</h4>

 <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                                <tr>
								<th  > S#</th> 
                                  <th  > Approval Authority</th>                                
                                  <th  > Authority Name</th>
                                  
                                  <th >  Approval Status</th>
                                  <th > Approval Comments</th>
                            
								  <th  colspan="5"> Action </th>					  
                                </tr>
                              </thead>
                              <tbody>
							  <?php  
              $pdSQL = "SELECT  * FROM tbl_rfi_lab a left join structures b on (a.lid=b.lid) WHERE NOT Approval_authority_name = '' order by rfi_id";
							
							$objSDb->dbQuery($pdSQL);
							$current="";
							$prev="";
							$comp="";
							$comp2="";
							  if($objSDb->totalRecords()>=1)
							  {
								  $counter=0;
							  while($pdData = $objSDb->dbFetchArray())
							  {
								  
								$counter=$counter+1;

								$current=$pdData["rfi_id"];
                				$comp=$pdData["title"];
							  if($comp2!=$comp){?>
                  <tr class="">
                             
                  <td align="left" colspan="13" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $comp?></strong></span></td>
                 
                </tr>
               
                <?php  $comp2=$comp;} else{

                }
							  if($prev!=$current)
							  {?> 
								  
								  <tr>
								  <td ><?php  echo $counter;?>  
								  <td ><?php  if($pdData['Approval_authority']=="1"){echo "Client";}else{echo "Consultant";}?>  
								  <td ><?php  if($pdData['Approval_authority_name']=="1"){echo "option 1";}else{echo "option 2";}?>  
								  <td ><?php  if($pdData['Approval_status']=="1"){echo "Approved";}else if($pdData['Approval_status']=="2"){echo "Rejected";}else{echo "Partially Approved";}?>  
								  <td ><?php echo wordwrap($pdData['Approval_comments'],70,"<br>\n")  ;?>  


								  <?php  $qual_data=$pdData['Approval_documents'];?>
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
						   <span style="float:right"><form action="rfi_info.php?rfi_id=<?php echo $pdData['rfi_id'] ?>" method="post">
							
						   <button type="submit" title = "Delete" class="btn btn-outline-danger btn-fw py-1"  name="delete" id="delete" value="" onclick="return confirm('Are you sure?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> 
      					  </button> </form></span>
						    </td>
                            <td>
								<form>
								<a href="rfi_docs/<?php echo  $qual_data;?>" target="_blank">
                            <button type="button"  class="btn btn-primary btn-rounded btn-fw" name="qual_repo" id="qual_repo" href="www.google.com">Approval Report </button>
							  </a> </form>   
						</td>
                            
							  </tr>
						<?php
						$prev=$current;
					}
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
			
             </div>
                </div>
              </div>
            </div>
          </div>
        </div>


   
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

