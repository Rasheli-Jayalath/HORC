<?php
include_once("../../../config/config.php");
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();

$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData = $objDb->dbFetchArray();
$pid=$pData["pid"];
//===============================================
if(isset($_REQUEST['delete'])&&isset($_REQUEST['risk_id'])&$_REQUEST['risk_id']!="")
{

 $objDb->dbQuery("Delete from   tbl_risk_register where risk_id=".$_REQUEST['risk_id']);
 //header("Location: sp_design.php");
}
 $pdSQL = "SELECT a.*,b.* FROM tbl_daily_site_entry a left join structures b on (a.lid=b.lid) order by a.lid";
$objDb->dbQuery($pdSQL);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('../news/includes/metatag.php'); ?>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Site Diary</title>
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
 
     <div class=" page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->
      <div class="main-panel " id="mainpanel">
       <div class="content-wrapper">
          <!-- class="content-wrapper" -->
            <div class="row">
           <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Daily Site Diary</h4>
                  
    
                  <div class="table-responsive">
                    
                     <table class="table table-striped">
                      <thead>
 
                                <tr>
                                  <th width="2%" ><?php echo "#";?></th>
                                  
                                  <th width="10%" >Date</th>
                                  <th width="20%" ><?php echo "Title";?></th>
                                  <th width="20%" ><?php echo "Deatil";?></th>
							
								  <th width="10%" ><?php echo "Photo";?></th>
								 
								  <th width="10%" >Action</th>
								  
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							   $current=0;
                 $prev=0;
                 $comp="";
                 $comp2="";
							  if($objDb->totalRecords()>=1)
							  {


                  
								  $i=0;
							  while($pdData = $objDb->dbFetchArray())
							  {






                  $current=$pdData["dsid"];
                  $comp=$pdData["title"];
                  if($comp2!=$comp){?>
                    <tr class="">
                               
                    <td align="left" colspan="13" class="" style=" text-transform:capitalize; background: #BEBEBE   ; font-size:20px"><span ><strong><?php echo $comp?></strong></span></td>
                   
                  </tr>
                  <?php  $comp2=$comp;} else{

}
if($prev!=$current)
{


								  $pdSQL1 = "SELECT  * FROM photos where dsid=".$pdData["dsid"];
								  $pdSQLResult1 = $objDb1->dbQuery($pdSQL1);
								  $photodata=$objDb1->dbFetchArray();
								  $i++; ?>
                        <tr>
                          <td align="center" style="font-size:13px"><?php echo $i;?></td>
                         
                          <td align="left" style="font-size:13px"><?php if($pdData['pdate']!=""|| $pdData['pdate']!="0000-00-00") echo date('d-m-Y',strtotime($pdData['pdate']));?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['item_name'];?></td>
                          <td align="left" style="font-size:13px"><?php echo $pdData['item_desc'];?></td>
                          <td align="left" style="font-size:13px"> <a  href="<?php echo  "dailysitephotos/".$photodata['file_name']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" ><img src="<?php echo "dailysitephotos/".$photodata['file_name']; ?>"  border="0" width="150px" height="112px" title=""/></a></td>
						 
						   <td align="center" style="font-size:13px; text-align:center">
						 


               <span style="float:right">
               <form action="#" method="post">
						   <button type="submit" title="Edit" class="btn btn-outline-warning btn-fw  py-1  "  name="delete" id="delete" value="<?php echo "Delete";?>" onclick="return confirm('Delete This record?')">
						   <i class="ti-trash btn-icon-prepend" ></i>  
             				</button></form></span>

               
               <form action="#" method="post">
						   <button type="submit" title="Edit" class="btn btn-outline-warning btn-fw  py-1  "  name="edit" id="edit" value="<?php echo EDIT;?>" >
						   <i class="ti-pencil btn-icon-prepend" ></i>  
             				</button></form>
                        </tr>
						<?php
						}
                }}else
						{
						?>
						<tr>
                          <td colspan="8" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
        </table></td></tr>
  
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

