<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();

$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData = $objDb->dbFetchArray();
$pid=$pData["pid"];
$dpentry_flag=1;
$dpadm_flag=1;
// $edit			= $_GET['edit'];

//===============================================
if(isset($_REQUEST['delete'])&&isset($_REQUEST['risk_id'])&$_REQUEST['risk_id']!="")
{

 $objDb->dbQuery("Delete from   tbl_risk_register where risk_id=".$_REQUEST['risk_id']);
 //header("Location: sp_design.php");
}
 $pdSQL="SELECT a.*, b.* ,c.* FROM `tbl_risk_register` a left join tbl_risk_register_context b on(a.risk_con_id=b.risk_con_id) left join structures c on (b.lid=c.lid) ORDER BY a.risk_con_id ";
$objDb->dbQuery($pdSQL);
// $pData =$objDb->dbFetchArray();

	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('../news/includes/metatag.php'); ?>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Risk Register</title>
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
           <h4 class="text-center text-34" style="  letter-spacing: 4px"> RISK REGISTER </h4> 
    <div class="col-sm-12 text-end pt-3 pb-3" >  
    <?php  if($dpentry_flag==1 || $dpadm_flag==1){?>
   <?php if($pid != ""&&$pid!=0){?>  
    <button  class="  col-sm-2 button-33" href="risk_reg_item.php" onclick="window.open('risk_reg_item.php', 'Upload Photos ','width=800px,height=650px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Risk Context</button> 
    <button class="  col-sm-2 button-33" href="risk_reg_input.php"     onclick="window.open('risk_reg_input.php', 'Upload Photos ','width=800px,height=750px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  >Add New Risk</button>
    <?php }}?>
  

       
         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
       <div class="content-wrapper">
          <!-- class="content-wrapper" -->
            <div class="row">
            <div class="col-md-4 grid-margin grid-margin-md-1 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Likelihood Rating</h4>
                   <div class="table-responsive">
                <table cellpadding="0" cellspacing="0"  class="table table-striped">
      
     
       <thead>
         <tr>
         <th>Score</th>
        <th  >Likelihood</th>
        <th  >Description</th>
        </tr>
       </thead>
      <tr >
        <td  >1</td>
        <td  >10%</td>
        <td >Unlikely</td>
        </tr>
      <tr >
        <td  >2</td>
        <td  >25%</td>
        <td >Remote</td>
        </tr>
      <tr >
        <td  >3</td>
        <td  >50%</td>
        <td >Occasional</td>
        </tr>
      <tr >
        <td  >4</td>
        <td  >75%</td>
        <td >Likely</td>
        </tr>
      <tr >
        <td  >5</td>
        <td  >99%</td>
        <td >Very Likely</td>
        </tr>
    </table>
    			</div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin grid-margin-md-1 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Impact Rating</h4>
                  <div class="table-responsive">
                  <table  class="table table-striped">
       <thead>
    <tr>
      <th >Score</th>
      <th >Description</th>
    </tr>
    </tr>
    </thead>
    <tr>
      <td >1</td>
      <td >No Impact</td>
    </tr>
    <tr>
      <td >2</td>
      <td >Low</td>
    </tr>
    <tr>
      <td >3</td>
      <td >Medium</td>
    </tr>
    <tr>
      <td >4</td>
      <td >High</td>
    </tr>
    <tr>
      <td >5</td>
      <td >Very high</td>
    </tr>
  </table>
  				</div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin grid-margin-md-1 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Risk    Score Rating &amp; Color Code</h4>
                  <div class="table-responsive">
                  <table  class="table table-striped">
       <thead>
    <tr>
                 
      <th ></th>
    </tr>
    <tr>
      <td bgcolor="#FF0000" style="vertical-align:center; text-align:center; background:#F00" >More than 12</td>
      <td  style="vertical-align:center; text-align:center;background:#F00">High</td>
    </tr>
    <tr>
      <td style="vertical-align:center; text-align:center; background-color:#FF0">6 to 12</td>
      <td style="vertical-align:center; text-align:center;background-color:#FF0"">Medium</td>
      </tr>
    <tr>
      <td style="vertical-align:center; text-align:center; background-color:#0F0">Less than 6</td>
      <td style="vertical-align:center; text-align:center;background-color:#0F0">Low</td>
      </tr>
  </table>
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
                       <tr style="border:1px solid #d4d4d4">
                       <th width="2%" style="text-align:center; vertical-align:middle">SN#</th>
                                  <th width="2%" style="text-align:center; vertical-align:middle">Risk ID</th>
                                  <th width="2%" style="text-align:center">Risk Status</th>
                                  <th width="15%" style="text-align:center">Risk Consequence Hazard</th>
                                  <th width="15%" style="text-align:center">Risk Cause (Description)</th>
                                  <th width="4%" style="text-align:center">Likelihood Score </th>
								  <th width="4%" style="text-align:center">Impact Score</th>
								  <th width="4%" style="text-align:center">Risk Score</th>
								  <th width="15%" style="text-align:center">Risk Control Measure</th>
								  <th width="8%" style="text-align:center">Risk Action Owner</th>
                                  <th width="8%" style="text-align:center">Action By Date</th>
                                  <th width="4%" style="text-align:center">RRLS</th>
                                  <th width="4%" style="text-align:center">RRIS</th>
                                  <th width="4%" style="text-align:center">RRS</th>
                                  <th width="15%" style="text-align:center">Comments</th>
                                 
								  <?php if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
								<th width="10%" style="text-align:center" colspan="2">Action</th>
								  <?php
								  }
								  ?>
								  
								 
								  
                                </tr>
                        </thead>
                         <tbody>
							  <?php
							  $current="";
							  $prev="";
                $comp="";
                $comp2="";
                $count=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData =$objDb->dbFetchArray())
							  { 
                  $count=$count+1;
							  $current=$pdData["title"];
                $comp=$pdData["risk_con_id"];

                if($current2!=$current){?>
                  <tr class="">
                             
                  <td align="left" colspan="17" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $current?></strong></span></td>
                 
                </tr>
               
                <?php  $current2=$current;} else{

                }

							  if($comp2!=$comp)
							  {?>
                              <tr>
                          <td align="left" colspan="20" style="text-transform:capitalize; font-size:16px"><span ><strong><?php echo $pdData['risk_con_code']."-".$pdData['ris_con_desc'];?></strong></span></td>
                         
                        </tr>
                              <?php } ?>
                         <?php if($pdData['risk_no']!='')
							  {
								  $totl_impact=0;
								  $rss=0;
								  $totl_impact_color='';
								  $rss_color='';
								  $totl_impact=$pdData['risk_impact_score']*$pdData['risk_impact_score'];
								  $rss=$pdData['risk_rrls']*$pdData['risk_rris'];
								  $colr_qury="select * from tbl_risk_score_rating_color where risk_score_low_val<=". $totl_impact." AND risk_score_high_val>=".$totl_impact;
								  $col_SQLResult = $objDb1->dbQuery($colr_qury);
								  if ($col_SQLResult == TRUE) {
									  $col_data=$objDb1->dbFetchArray();
									 
								  }
								 $rrs_colr_qury="Select * from tbl_risk_score_rating_color where risk_score_low_val<=". $rss." AND risk_score_high_val>".$rss;
								  $rrs_col_SQLResult =  $objDb2->dbQuery($rrs_colr_qury);
								  if ($rrs_col_SQLResult == TRUE) {
									  
									  $rrs_col_data=$objDb2->dbFetchArray();
									 $rss_color=$rrs_col_data["risk_color"];
								  }?>     
                        <tr>
                        <td align="center"><?php echo $count;?></td>
                          <td align="center"><?php echo $pdData['risk_no'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php if($pdData['risk_status']==1) echo "Open"; else echo "Close";?></td>
                          <td align="left" style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_cons_hazard'];?></td>
                          <td align="left" style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_cause'];?></td>
                          <td style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_like_score'];?></td>
                          <td style="text-align:center;vertical-align:middle"><?php echo $pdData['risk_impact_score'];?></td>
                          <td style="text-align:center; vertical-align:middle;background-color:<?php echo $col_data["risk_color"];?>" ><?php echo $totl_impact;?></td>
                          <td style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_control_measure'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo $pdData['risk_owner'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo date('d-m-Y',strtotime($pdData['risk_lastdate']));?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo $pdData['risk_rrls'];?></td>
                          <td style="text-align:center;vertical-align:middle;"><?php echo $pdData['risk_rris'];?></td>
                          <td style="text-align:center;vertical-align:middle;background-color:<?php echo $rss_color;?>"><?php echo $rss ;?></td>
                          <td style="text-align:center; vertical-align:middle"><?php echo $pdData['risk_comments'];?></td>
						   
						   
						    <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
							<td align="right">
              <span style="float:right">
              
                  <button class="btn btn-outline-warning btn-fw px-1 py-1 " href="risk_reg_input.php"     onclick="window.open('risk_reg_input.php?risk_id=<?php echo $pdData['risk_id'] ?>', 'Risk Register ','width=800px,height=750px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  ><i class="ti-pencil btn-icon-prepend" ></i></button>

              </span>
						   <!-- <span style="float:right"><form action="project_risk_input.php?risk_id=<?php echo $pdData['risk_id'] ?>" method="post">
               <input type="submit" name="edit" id="edit" value="Edit" /></form></span> -->
						     </td>
						   <?php  
							}
							if($dpadm_flag==1)
								  {
								   ?>
						   <td align="right">
						  
                           
                             <span style="float:right"><form action="risk_register.php?risk_id=<?php echo $pdData['risk_id'] ?>" method="post">
               <button type="submit" title="Delete" class="btn btn-outline-danger btn-fw px-1 py-1 " name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" >
               <i class="ti-trash btn-icon-prepend" ></i> 
        					</button></form></span>
                         
						  <?php
						   }
						   ?>
                        </tr>
                        <?php }?>
						<?php
						$comp2=$comp;
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


</body>
</html>

