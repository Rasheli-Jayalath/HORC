<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		    = new Database();
$objCommon 	  	= new Common();
$objAdminUser 	= new AdminUser();
$objNews 	    	= new News();
$strusername				= $_SESSION['ne_username'];
	$superadmin_flag 		= $_SESSION['ne_sadmin'];
	$news_flag			= $_SESSION['ne_news'];
	$newsadm_flag		= $_SESSION['ne_newsadm'];
	$newsentry_flag	= $_SESSION['ne_newsentry'];
if ($strusername==null  )
	{
		header("Location: ../../../index.php?init=3");
	}
else if ($news_flag==0)
	{
		header("Location: ../../../index.php?init=3");
	}


if($_GET['mode'] == 'delete'){
	$objNews->setProperty('news_cd', $_GET['news_cd']);
	 $sql_ii="SELECT * FROM `rs_tbl_news` where news_cd='$_GET[news_cd]'"; 
		$sql_newi=$objDb->dbQuery($sql_ii);
		
		$sql_resnew=$objDb->dbFetchArray();
		if($sql_resnew['newsfile']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile']);
		}
		if($sql_resnew['newsfile1']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile1']);
		}
		if($sql_resnew['newsfile2']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile2']);
		}
		if($sql_resnew['newsfile3']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile3']);
		}
		if($sql_resnew['newsfile4']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile4']);
		}
	$objNews->actNews('D');
	
	$objCommon->setMessage('News deleted successfully!', 'Info');
	redirect('news_info.php');
}
if($_GET['mode'] == 'active')
{
$n_cd=$_GET['news_cd'];
$sqll="update rs_tbl_news set status='Y' where news_cd='$n_cd'";
//mysql_query($sqll);
}
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
   <link rel="stylesheet" href="../../../css/CssMessages.css">

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
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


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
/*table{
    border:  double ;

    }*/
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
}
	
.text_width_table{
	max-width: 350px;
    word-wrap: initial;
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
  width:100%;
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


 

    </style>
    <!--<script>
    /* Do normal confirmatoin */
function doConfirm(msg){
	if(confirm(msg)){
		return true;	
	}
	else{
		return false;
	}
}
</script>-->
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
          <div class="row">
             <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">News & Events</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Inactive News</a>
                    
                  </ul>
                  <?php if($newsentry_flag==1 || $newsadm_flag==1)
				{
				?>
                  <div>
                    <div class="btn-wrapper">
                    <button type="button" class="px-3 button-33" onclick="window.open('news_form.php', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"> Add New Record </button>
                    </div>
                  </div>
                   <?php
				}
				?>
                </div>
                <div class="tab-content tab-content-basic">

                   <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                     
                       
  <?php echo $objCommon->displayMessage();?>
        
 <?php
 	$objNews->setProperty("status", "Y");
	$objNews->setProperty("orderby", "newsdate desc");
	//$objNews->setProperty("limit", 10);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
            <div class="row">
                    
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <div class="wrapper d-flex align-items-center justify-content-between py-2 " >
                                        <div class="d-flex" style="width:100%">
                                           <?php 
										   $typei_arr=explode(".",$rows['newsfile']);
										  $typei= $typei_arr[1];
										   if(($rows['newsfile']!="") && ( $typei=='jpg' || $typei=='jpeg' || $typei=='png' || $typei=='gif')) {?> <a href="news_detail.php?news_cd=<?php echo $rows['news_cd'];?>"  target="_blank"><img class="img-lg rounded-10" src="news/<?php echo $rows['newsfile'] ;?>" alt="profile"></a> <?php }
										   
		   else if(($rows['newsfile']!="") && ( $typei=='pdf' || $typei=='doc' || $typei=='docx')) {?> 
           <a href="news/<?php echo $rows['newsfile']?>" target="_blank">
           <img class="img-lg rounded-10" src="../../../images/file.png" alt="profile"> </a><?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "../../../images/no_image.png" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?>
                                          <div class="wrapper ms-3" style=" width:80%">
										  <?php
										   $title	= str_replace("999","'",$rows['title']);
										  ?>
                                           <h4 class="card-title"><?php echo substr($title,0,100);?></h4>
                                           
                  <p class="card-description wrapper">
                  <?php print substr(str_replace("999","'",$rows['details']),0,300).'...'?>
                  <br/>
                   <a href="news_detail.php?news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none"><?php echo "Read More";?> </a>
                  </p>
                  
                                          </div>
                                          
                                           <div class="text-muted" style=" float:right;width:10%; text-align:right"><?php echo date('d-m-Y', strtotime($rows['newsdate']));?></div>
                                           
                                           
                                        </div>
                                        
                                       
                                      </div>
               <div class="text-muted" style=" float:right;width:10%; text-align:right"> <?php if($newsentry_flag==1 || $newsadm_flag==1 )
				{
				?>
                  <!--<button type="button" class="btn btn-link" onclick="window.open('news_form.php?news_cd=<?php echo $rows['news_cd'];?>', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"> <?php echo EDIT;?></button>-->
				<a onclick="window.open('news_form.php?news_cd=<?php echo $rows['news_cd'];?>', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"  title="Edit" style="text-decoration:none; color:#0d6efd; cursor:pointer" ><?php echo EDIT;?></a>
				<?php
				}
				?>
				 <?php if($newsadm_flag==1)
				{
				?>
				 | 
                
                 <a  style="text-decoration:none; cursor:pointer" onClick="return doConfirm('<?php echo DEL_MSG?>');"  href="news_info.php?mode=delete&news_cd=<?php echo $rows['news_cd'];?>"  title="Delete"><?php echo DEL;?></a>
				<?php
				}
				?></div>
                                     
                               
                </div>
              </div>
            </div>
            
            
            
            
            
          </div>
          <?php
			$sno++;
		}
    }
	else{
	?><?php echo 'No news found.';?>
    <?php }?>
		
	 
                  
                    
                  </div>
                  <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences"> 
                      <?php
 	$objNews->setProperty("status", "N");
	$objNews->setProperty("orderby", "newsdate desc");
	//$objNews->setProperty("limit", 10);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
            <div class="row">
                    
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <div class="wrapper d-flex align-items-center justify-content-between py-2 " >
                                        <div class="d-flex" style="width:100%">
                                           <?php 
										   $typei_arr=explode(".",$rows['newsfile']);
										   $total_length=count($typei_arr);
										  $typei= $typei_arr[$total_length-1];
										  
										   if(($rows['newsfile']!="") && ( $typei=='Jpg' || $typei=='jpg' || $typei=='jpeg' || $typei=='png' || $typei=='gif')) {?> <a href="news_detail.php?news_cd=<?php echo $rows['news_cd'];?>" target="_blank"><img class="img-lg rounded-10" src="news/<?php echo $rows['newsfile'] ;?>" alt="profile"></a> <?php }
										   
		   else if(($rows['newsfile']!="") && ( $typei=='pdf' || $typei=='doc' || $typei=='docx')) {?> 
           <a href="news_detail.php?news_cd=<?php echo $rows['news_cd'];?>" target="_blank">
           <img class="img-lg rounded-10" src="../../../images/file.png" alt="profile"> </a><?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "../../../images/no_image.png" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?>
                                          <div class="wrapper ms-3" style=" width:80%">
                                           <h4 class="card-title"><?php echo substr(str_replace("999","'",$rows['title']),0,100);?></h4>
                                           
                  <p class="card-description wrapper">
                  <?php print substr(str_replace("999","'",$rows['details']),0,300).'...'?>
                  <br/>
                   <a href="news_detail.php?news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none"><?php echo "Read More";?> </a>
                  </p>
                  
                                          </div>
                                          
                                           <div class="text-muted" style=" float:right;width:10%; text-align:right"><?php echo date('d-m-Y', strtotime($rows['newsdate']));?></div>
                                           
                                           
                                        </div>
                                        
                                       
                                      </div>
               <div class="text-muted" style=" float:right;width:10%; text-align:right"> <?php if($newsentry_flag==1 || $newsadm_flag==1 )
				{
				?>
                  <!--<button type="button" class="btn btn-link" onclick="window.open('news_form.php?news_cd=<?php echo $rows['news_cd'];?>', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"> <?php echo EDIT;?></button>-->
				<a onclick="window.open('news_form.php?news_cd=<?php echo $rows['news_cd'];?>', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"  title="Edit" style="text-decoration:none; color:#0d6efd; cursor:pointer" ><?php echo EDIT;?></a>
				<?php
				}
				?>
				 <?php if($newsadm_flag==1)
				{
				?>
				 | 
                
                 <a  style="text-decoration:none; cursor:pointer" onClick="return doConfirm('<?php echo DEL_MSG?>');"  href="news_info.php?mode=delete&news_cd=<?php echo $rows['news_cd'];?>"  title="Delete"><?php echo DEL;?></a>
				<?php
				}
				?></div>
                                     
                               
                </div>
              </div>
            </div>
            
            
            
            
            
          </div>
          <?php
			$sno++;
		}
    }
	else{
	?><?php echo 'No news found.';?>
    <?php }?>          </div>
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
   <script src="../../../JsCommon.js"></script>
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
