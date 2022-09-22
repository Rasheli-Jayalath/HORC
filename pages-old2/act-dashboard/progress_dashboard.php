<?php //include('act-top-cache.php'); ?>
<?php
include_once("../../config/config.php");
$objDb  		= new Database();
$objEva  		= new EVADashboard();
$temp_id			= $_GET['temp_id'];
$msg	= "";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PMIS</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
   <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../css/basic-styles.css">
 <!-- endinject -->
 
  <script src="datepickercode/jquery.min.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
 <script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<script src="highcharts/js/highcharts-more.js"></script>
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script type="text/javascript">
function GetActivity(){
	
	var qString = '';
	
	var output_var=document.main_dash.output_id.value;
	
	var act_var=document.main_dash.act_id.value;
	
	
	if(document.main_dash.str_obj.value != "" && document.main_dash.str_obj.value != 0)
	{
		
		qString += 'obj=' + escape(document.main_dash.str_obj.value);
	}
	if(document.main_dash.outcome_id.value != "" && document.main_dash.outcome_id.value != 0)
	{
		
		qString += '&outcome=' + escape(document.main_dash.outcome_id.value);
	}
	if(document.main_dash.output_id.value != "" && document.main_dash.output_id.value != 0)
	{
		
		qString += '&output=' + escape(document.main_dash.output_id.value);
	}
	
	if(output_var!= "" && output_var != 0 &&  act_var!= "" && act_var != 0)
	{
		
		qString += '&activity=' + escape(act_var);
	}
	<?php if(isset($_REQUEST["activity"])&&$_REQUEST["activity"]!=""&&$_REQUEST["activity"]!=0)
	{?>
	
		var sub_act_str=document.getElementById('sub_act_id_' + <?php echo $_REQUEST["activity"];?>).value;
		if(sub_act_str!=0&&sub_act_str!="")
		{
		qString += '&sub_act_id_'+<?php echo $_REQUEST["activity"];?>+'='+ escape(sub_act_str);
		}
		//alert(sub_act_str);
	<?php }?>
		<?php if(isset($_REQUEST["sub_act_id_".$_REQUEST["activity"]])&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=""&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=0)
	{?>
	
		var sub_act_str_1=document.getElementById('sub_act_id_' + <?php echo $_REQUEST["sub_act_id_".$_REQUEST["activity"]];?>).value;
		if(sub_act_str_1!=0&&sub_act_str_1!="")
		{
		qString += '&sub_act_id_'+<?php echo $_REQUEST["sub_act_id_".$_REQUEST["activity"]];?>+'='+ escape(sub_act_str_1);
		}
		//alert(sub_act_str);
	<?php }?>
	document.location = 'progress_dashboard.php?' + qString;
}
function GetNextLevel(value,div_name)
{
	
	 var str=div_name;
	var div_id=str.substr(7, 8);
	
	  div_id=parseInt(div_id)+1;
	 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("str_obj_div_"+div_id).innerHTML=xmlhttp.responseText;

	 
    }
  }

  xmlhttp.open("GET","findnextlevelAct.php?parentgroup="+value+"&div_id="+div_id,true);
  xmlhttp.send();
}
</script>
</head>
<body>

<?php //include("includes/functions_progress_dashboard.php");?>

   <div class="container-scroller"> 
    
    <!-- partial:partials/_navbar.html -->
    <div id="partials-navbar"></div>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper" id="pagebodywraper">

      <!-- partial:partials/_settings-panel.html -->
      <div id="partials-theme-setting-wrapper"></div>
      <!-- partial -->

      <!-- partial:partials/_sidebar.html -->
      <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
      <!-- partial -->

      <!-- Main Panel Starts -->

      <div class="main-panel" id="mainpanel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true"> Overview</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="indicators-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Indicators</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">EVA Graphs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">EVA Tabular Data</a>
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
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                    <table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="25%" align="left" valign="top" style="border-right: solid 1px #ccc;"><div id="wrapper_MemberLogin" style="margin:10px;">
  <h1 style="color:#000;"><?php echo "Activity Monitoring Dashboard";?> </h1>
  <div class="clear"></div>
  <div id="LoginBox" class="borderRound borderShadow" style="padding:10px; width:300px">
    <form action="progress_dashboard.php" method="get" name="main_dash" id="main_dash" >
    <input type="hidden" id="temp_id" name="temp_id" value="<?php echo $temp_id;?>"  />
      <table border="0px" cellpadding="0px" cellspacing="0px" align="center"  >
      <?php $mquery = "select max(activitylevel) as max_activitylevel from maindata  ";
				$mresult = mysql_query($mquery);
				$mdata = mysql_fetch_array($mresult); 
				$max_activitylevel=$mdata["max_activitylevel"];
				$i=0;
				$levl="";
				while( $i<=$max_activitylevel)
				{
					if($i==0) $level=COMP;
					elseif($i==1) $level=SUB_COMP;
					elseif($i==2) $level=ACT;
					else $level=SUB_ACT;
				?>
        <tr>
          <td ><strong>
            <label> <?php echo $level;?>: </label>
          </strong></td>
          <td><div id="str_obj_div_<?php echo $i;?>">
            <select name="itemid_<?php echo $i;?>" id="itemid_<?php echo $i;?>" onchange="GetNextLevel(this.value,this.name)">
             <option value="0"><?php echo $level;?></option>
              <?php
			  
			    $str_g_query = "select * from maindata WHERE activitylevel=".$i;
			    if(isset($_GET["parentcd"])&&$_GET["parentcd"])
				{
					$str_g_query .=" and parentcd=".$_GET["parentcd"];
				}
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['parentgroup']; ?>"  <?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]==$str_g_data['parentgroup'])
			{?> selected="selected" <?php }?>>
								<?php echo $str_g_data['itemcode']."-".$str_g_data['itemname']; ?>
								</option>
							  <?php
				}
				?>
            </select>
          </div></td>
        </tr>
        <?php
		$i++ ; 
		}?>
        
         <tr >
          <td style="padding-top:20px" align="center" colspan="2">
            <input type="submit" value="Generate Report"  id="uLogin2"/>
            </td>
            <td></td>
            </tr>
      </table>
     
    </form>
    
  </div>
</div>
<table cellpadding="4px" cellspacing="0px" align="center" width="80%" style="border: solid 1px #ccc; margin:10px 10px 10px 30px" > 
    <tr style="background-color:<?php echo $bgcolor;?>; border-bottom-color:#FFF">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/green.png" width="25px" title="Completed" style="vertical-align:middle">&nbsp;&nbsp;<span >Completed</span>
</td>
</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/red.png" width="25px" title="Delayed Against Schedule" style="vertical-align:middle">&nbsp;&nbsp;<span >Delayed Against Schedule</span>
</td>

</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/yellow.png" width="25px" title="Continued" style="vertical-align:middle">&nbsp;&nbsp;<span style="vertical-align:middle" >Continued</span>
</td>

</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;border-bottom-color:#FFF">
<img src="images/indicators/pink.png" width="25px" title="Indicator for Quantity Overuse"  style="vertical-align:middle">&nbsp;&nbsp;<span style="vertical-align:middle" >Indicator for Quantity Overuse</span>
</td>
</tr>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;">
<img src="images/indicators/blue.png" width="25px" title="Not yet Started" style="vertical-align:middle" >&nbsp;&nbsp;<span style="vertical-align:middle" >Not yet Started</span>
</td>

</tr>
    </table>
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" />      
</td>
<td width="75%" align="left" valign="top">
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<?php //////////Activity  Title here
$url=basename($_SERVER['REQUEST_URI']);
list($str1,$str2)=explode('?',$url);
$param=explode('&',$str2);
$temp_levels=explode('=',$param[0]);
$temp_id=$temp_levels[1];
$parentgroup="";
$subquery="";
 $size=count($param);
if($size>1)
{
$para_count= count($param);
$j=$para_count;
$count=$size;
for($i=0; $i<=$para_count; $i++)
{
	
$data_levels=explode('=',$param[$i]);
$data_level_id=$data_levels[1];


$data_level_param=$data_levels[0];
if($data_level_id!=0)
{
$adata=getActDataLevel($data_level_id);
$adetail=$adata["itemcode"]."-".$adata["itemname"];
$aweight=$adata["weight"];
$afactor=$adata["factor"];
$aparentgroup=$adata["parentgroup"];
	
	if($count<$size)
	{
	//$parentgroup.="_";	
	
	}
	$parentgroup=$data_level_id;
	$parentcd=$adata["itemid"];
	$count--;
}
}
if($parentgroup!=""&&$parentgroup!=0)
{
  $gdetailq="SELECT* from maindata where parentgroup='".$parentgroup."'";
 $gdetailqresult = mysql_query($gdetailq);
  $gdetailqdata=mysql_fetch_array($gdetailqresult);
  if($gdetailqdata['itemid']!=""&&$gdetailqdata['itemid']!=0)
  {
	/*  $reportquery_sub1="SELECT sum(baseline) as baseline, unit FROM kpi_base_level_report where kpiid=".$gdetailqdata['kpiid']." Group By kpiid,scid";
  
	$reportresult_sub1 = mysql_query($reportquery_sub1);
    $reportdata_sub1 = mysql_fetch_array($reportresult_sub1);*/
	
  }
}
}
?>

 <?php //include("includes/pdo_level_progress_dashboard.php");?>
<?php //include("includes/outcome_level_progress_dashboard.php");?>
<?php //include("includes/output_level_progress_dashboard.php");?>
<?php //include("includes/mainactivity_level_progress_dashboard.php");?>
<?php //include("includes/activity_level_progress_dashboard.php");?>
<?php //include("includes/data_level_progress_dashboard.php");?>
</td>
</tr>
</table>
          
                  </div>
                  <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences"> 
                     <div class="row">
            <div class="col-lg-6 grid-margin ">
              <div class="card">
                <div class="card-body">
                <?php include("includes/eva_latest_indicator_value_text.php");?>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin ">
              <div class="card">
                <div class="card-body">
                  
                 <?php include("includes/eva_latest_indicator_value.php");?>
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
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
 
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <script src="../../js/Chart.roundedBarCharts.js"></script>
  <!-- <script src="js/navtype_session.js"></script> -->
  <!-- End custom js for this page-->

  <script>
      $(function(){
        $("#partials-navbar").load("../../partials/_navbar.html");
      });
  </script>

  <script>
    $(function(){
      $("#partials-theme-setting-wrapper").load("../../partials/_settings-panel.html");
    });
  </script>

  <script>
    $(function(){
      $("#partials-sidebar-offcanvas").load("../../partials/_sidebar.html");
    });
</script>

<script>
  $(function(){
    $("#partials-footer").load("../../partials/_footer.html");
  });
</script>



</body>

</html>

