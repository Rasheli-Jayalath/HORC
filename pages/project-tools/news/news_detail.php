<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
$objNews 		= new News();
$news_cdd=$_GET['news_cd'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>

<!-- my lightbox  -->
<link href="lightbox/css/lightbox.css" rel="stylesheet" />

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
                  <h4 class="card-title">News Detail<span style="float:right; font-weight:12px"> <a href="news_info.php">Back</a></span></h4>
                 
                  <div class="table-responsive">
                   
       		
 <?php
 	$objNews->setProperty("news_cd", $news_cdd);
	//$objNews->setProperty("limit", PERPAGE);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		$rows = $objNews->dbFetchArray(1);
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<div class="wrapper d-flex align-items-center justify-content-between py-2 ">
                                        <div class="d-flex" style="width:100%">
                                           <?php  
										   $typei_arr=explode(".",$rows['newsfile']);
										  $typei= $typei_arr[1];
										  if(($rows['newsfile']!="") && ( $typei=='jpg' || $typei=='jpeg' || $typei=='png' || $typei=='gif')) {?> <a href="<?php echo NEWS_URL.$rows['newsfile'] ;?>" data-lightbox="roadtrip"  data-title="image" target="_blank"><img class="img-lg rounded-10" src="news/<?php echo $rows['newsfile'] ;?>" alt="profile"></a> <?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "../../../images/no_image.png" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?>
                                          <div class="wrapper ms-3" style=" width:80%">
                                           <h4 class="card-title"><?php echo $rows['title'];?></h4>
                                           
                  <p class="card-description wrapper">
                  <?php print $rows['details'];?>
                 
                  </p>
                  <?php
			if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="")&& ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			$file3=$rows['newsfile3'];
			$file4=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile2'];
			$file2=$rows['newsfile3'];
			$file3=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile3'];
			$file3=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			$file3=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			$file3=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']!="") )
			{
			$file1=$rows['newsfile3'];
			$file2=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile2'];
			$file2=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile2'];
			$file2=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']=="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile2'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']=="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile4'];
			}
			else
			{
			$file1="";
			$file2="";
			$file3="";
			$file4="";
			}
			
			
			?>
			<table><tr><td><?php if($file1!="")
			{ ?><a href="news/<?php echo $file1 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="news/<?php echo $file1 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			<td><?php if($file2!="")
			{ ?><a href="news/<?php echo $file2 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="news/<?php echo $file2 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			<td><?php if($file3!="")
			{ ?>
			<a href="news/<?php echo $file3 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="news/<?php echo $file3 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			<td><?php if($file4!="")
			{ ?>
			<a href="news/<?php echo $file4 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="news/<?php echo $file4 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			</tr>
			</table>
                  
                                          </div>
                                          
                                           <div class="text-muted" style="float:right; width:10%; text-align:right"><?php echo date('d-m-Y', strtotime($rows['newsdate']));?></div>
                                        </div>
                                       
                                      </div>
    		
			
			
		
			
			
			
    		<?php
			
    }
	
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

<!-- lightbox js -->
<script src="lightbox/js/lightbox.min.js"></script>
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

