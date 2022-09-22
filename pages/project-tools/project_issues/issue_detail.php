<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );

//@require_once("get_url.php");
//$user_cd=$uid;
$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
//$pData = mysql_fetch_array($pSQLResult);
 $pid=$pData["pid"];
//$edit			= $_GET['edit'];
//$objDb  		= new Database( );
//@require_once("get_url.php");
$file_path="issues/";
/*include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
$objNews 		= new News();*/
$nos_id=$_GET['nos_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Project News & Events</title>
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
  


</head>
<body>
  <div class="container-scroller">
    
     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->
 
     <div class="page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->
      <div class="main-panel " id="mainpanel">
       <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Issue Detail<span style="float:right; font-weight:12px"> <a href="project_issues_info.php">Back</a></span></h4>
                 
                 
                  <div class="table-responsive">
                   
       		
 <?php
 	//$objNews->setProperty("news_cd", $news_cdd);
	//$objNews->setProperty("limit", PERPAGE);
	//$objNews->lstNews();
	//$Sql = $objNews->getSQL();
	//if($objNews->totalRecords() >= 1){
	//	$sno = 1;
		//$rows = $objNews->dbFetchArray(1);
		$sql="select * from t012issues where nos_id=".$nos_id;
	$objDb->dbQuery($sql);
	$rows=$objDb->dbFetchArray();
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<div class="wrapper d-flex align-items-center justify-content-between py-2 ">
                                        <div class="d-flex">
                                           <?php if($rows['image1']!="") {?> <a href="<?php //echo NEWS_URL.$rows['newsfile'] ;?>" target="_blank"><img class="img-lg rounded-10" src="issues/<?php echo $rows['image1'] ;?>" alt="profile"> <?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "../../../images/no_image.png" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?></a>
                                          <div class="wrapper ms-3">
                                           <h4 class="card-title"><?php echo $rows['iss_title'];?></h4>
                                           
                 
                  <p class="card-description wrapper">
                  <?php print $rows['iss_detail'];?>
                 
                  </p>
                   <p class="card-description wrapper">
                  <?php print "<b>Issue Number: </b>". $rows['iss_no'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php print "<b>Status: </b>" ?>
                  <?php if($rows['iss_status']==0)
				  {
					  echo "Archived";
				  }
				  else if($rows['iss_status']==1)
				  {
					  echo "Active";
				  }
				   else if($rows['iss_status']==2)
				  {
					  echo "Inactive";
				  }?>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php  if($rows['attachment']!="") { echo "<b>Attachment: </b>"?> <a href="<?php echo "issues/".$rows['attachment'];?>" target="_blank">
                          <img src="../../../images/file.png" width="50" height="50"/></a> <?php };?>
                  
                  </p>
                 
                   <p class="card-description wrapper">
                   
                  <?php print "<b>Action: </b>"?><?php if( $rows['action_status']==1)
				  {
				  echo "Pending";
				  }
				  else if( $rows['action_status']==2)
				  {
				  echo "Resolved";
				  }
				  ?><br />
                   
                 
                  </p>
                    <p class="card-description wrapper">
                  <?php print "<b>Remarks: </b>". $rows['iss_remarks'];?>
                 
                  </p>
                  <?php
			if(($rows['image1']!="") && ($rows['image2']!=""))
			{
			$file1=$rows['image1'];
			$file2=$rows['image2'];
			
			}
			else if(($rows['image1']=="") && ($rows['image2']!="") )
			{
			$file1=$rows['image2'];
			
			}
			else if(($rows['image1']!="") && ($rows['image2']==""))
			{
			$file1=$rows['image1'];
			
			}
			
			else
			{
			$file1="";
			$file2="";
			
			}
			
			
			?>
			<table><tr>
            <td><?php if($file1!="")
			{ ?><a href="issues/<?php echo $file1 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="issues/<?php echo $file1 ;?>" border="0" width="120px" height="120px" />&nbsp;&nbsp;&nbsp;&nbsp;</a><?php }
			?></td>
			<td><?php if($file2!="")
			{ ?><a href="issues/<?php echo $file2 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="issues/<?php echo $file2 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			
			</tr>
			</table>
                                          </div>
                                          
                                           <div class="text-muted" style="width:800px"><?php  if($rows['iss_date']=='0000-00-00')
											  {
											  }
											  else
											  {
												 echo date('d, F, Y',strtotime($rows['iss_date']));
											  }?></div>
                                           
                                        </div>
                                        
                                       
                                      </div>
    		
			
			
		
			
			
			
    		<?php
			
   
	
	?>
	
                  
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



</body>
</html>

