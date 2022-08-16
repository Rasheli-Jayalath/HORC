<?php
session_start();

if (isset($_REQUEST['pwpin'])) {
	if ($_REQUEST['pwpin'] == '1234') {
		$_SESSION['adminflag']=1;
		$adminflag = $_SESSION['adminflag'];
		} elseif ($_REQUEST['pwpin'] == '5678' || 'Vonly_8159') {
			$_SESSION['adminflag']=2;
			$adminflag = $_SESSION['adminflag'];
			} else {
				header("Location: index.php?msg=0");
				}
	}
$adminflag = $_SESSION['adminflag'];

//$adminflag = 2;
if ($adminflag == 1 || $adminflag == 2) {
include_once("connect.php");
//==========================================================

if (!isset($_REQUEST['back'])) {
	if (isset($_SESSION['srid'])) {
		if (!isset($_REQUEST['stop']) && !isset($_REQUEST['resume'])) { 
			$sridlist = $_SESSION['sridlist'];
			$srid = $_SESSION['srid'];
			$sr_max = $_SESSION['sr_max'];
			if ($srid >= $sr_max-1) {
					$srid = 0;
					$_SESSION['srid'] = $srid;	
					$pidsql = "select pid from t002project where srid = ".$sridlist[$srid];
					// $pidresult = mysqli_query($pidsql);
          // $pidresult =  mysqli_query($db, $pidsql);
          $pidresult = $db->query ( $pidsql)   ;
					// $piddata = mysqli_fetch_array($pidresult);
          $piddata = $pidresult->fetch_array();
					$pid = $piddata['pid'];
					$_SESSION['pid'] = $pid;
					$maxpid=$_SESSION['max_pid'];
					$mode= $_SESSION['mode'];
				} else {
					$_SESSION['srid'] = $srid + 1;
					$srid = $_SESSION['srid'];
					$pidsql = "select pid from t002project where srid = ".$sridlist[$srid];
					$pidresult = $db->query ($pidsql);
					$piddata = $pidresult->fetch_array() ;
					$pid = $piddata['pid'];
					$_SESSION['pid'] = $pid;
					$maxpid=$_SESSION['max_pid'];
					$mode= $_SESSION['mode'];
				}
		} else {
			 if (isset($_REQUEST['stop'])) {
				 $_SESSION['mode'] = 0;
				 $srid = $_SESSION['srid'];
				 $sridlist = $_SESSION['sridlist'];
				 $sr_max = $_SESSION['sr_max'];
				 $pid= $_SESSION['pid'];
				 $maxpid=$_SESSION['max_pid'];
				 $mode= $_SESSION['mode'];
			 }
			 if (isset($_REQUEST['resume'])) {
				 $_SESSION['mode'] = 1;
				 $srid = $_SESSION['srid'];
				 $sridlist = $_SESSION['sridlist'];
				 $sr_max = $_SESSION['sr_max'];
				 $pid= $_SESSION['pid'];
				 $maxpid=$_SESSION['max_pid'];
				 $mode= $_SESSION['mode'];
			 }
	   }
	} else {
	
		$plistsql = "select srid from t002project where srid IS NOT NULL and srid <> '' and srid <> 0 order by srid";
		$plistresult = $db->query($plistsql);
		
		while ($plistdata =  $plistresult->fetch_array()) { 
			$sridlist[] = $plistdata['srid'];
		}
		$srid = 0;
		$sr_max = count($sridlist);
		$_SESSION['sridlist'] = $sridlist;
		$_SESSION['srid'] = $srid;
		$_SESSION['sr_max'] = $sr_max;
		$pidsql = "select pid from t002project where srid = ".$sridlist[$srid];
		$pidresult = $db->query($pidsql);
		$piddata =  $pidresult->fetch_array() ;
		$pid = $piddata['pid'];
		$_SESSION['pid'] = $pid;
		$projSQL = "select max(pid) as pid from t002project";
	  	$projSQLResult = $db->query($projSQL);
	  	$projdata =  $projSQLResult->fetch_array() ;
	  	$maxpid = 	$projdata['pid'];
	  	$_SESSION['mode'] = 1;
	  	$mode= $_SESSION['mode'];
	  	$_SESSION['max_pid']= $maxpid;
	}
} else {
		 $srid= $_SESSION['srid'];
 		 $sridlist = $_SESSION['sridlist'];
	     $maxpid=$_SESSION['sr_max'];
		 $mode= $_SESSION['mode'];
		 $pid = $_SESSION['pid'];
		 $maxpid=$_SESSION['max_pid'];
}

//==========================================================

/*if (!isset($_REQUEST['back'])) {
 if(isset($_SESSION['pid'])) {
   if (!isset($_REQUEST['stop']) && !isset($_REQUEST['resume'])) { 
	 if($_SESSION['pid']>=$_SESSION['max_pid'])
	 {
	   $_SESSION['pid'] = 1;
	  $pid= $_SESSION['pid'];
	  $maxpid=$_SESSION['max_pid'];
	  $mode= $_SESSION['mode'];
	 }
	 else
	 {
	 $pid = $_SESSION['pid']+1;
	 $_SESSION['pid']=$pid;
	 $maxpid=$_SESSION['max_pid'];
	 $mode= $_SESSION['mode'];
	 }
   } else {
	 if (isset($_REQUEST['stop'])) {
		 $_SESSION['mode'] = 0;
	  	 $pid= $_SESSION['pid'];
	     $maxpid=$_SESSION['max_pid'];
		 $mode= $_SESSION['mode'];
	 }
	 if (isset($_REQUEST['resume'])) {
		 $_SESSION['mode'] = 1;
		 $pid= $_SESSION['pid'];
	     $maxpid=$_SESSION['max_pid'];
		 $mode= $_SESSION['mode'];
	 }
   }
 } else {
	  $_SESSION['pid'] = 1;
	  $pid= $_SESSION['pid'];
	  
	  $projSQL = "select max(pid) as pid from t002project";
	  $projSQLResult = mysqli_query($projSQL);
	  $projdata = mysqli_fetch_array($projSQLResult);
	  $maxpid = 	$projdata['pid'];
	  $_SESSION['mode'] = 1;
	  $mode= $_SESSION['mode'];
	  $_SESSION['max_pid']= $maxpid;	  
 }
} else {
		 $pid= $_SESSION['pid'];
	     $maxpid=$_SESSION['max_pid'];
		 $mode= $_SESSION['mode'];
}
*///	  $_SESSION['pid'] = 1;
//	  $pid= $_SESSION['pid'];


$chartSQLD = "SELECT max(ppg_date) as max_date FROM t023project_progress_graph where pid = ".$pid." ";
$chartSQLResultd = $db->query($chartSQLD);
$chartdatad =  $chartSQLResultd->fetch_array() ;
$planned_perc=0;
$actual_perc=0;

$chartSQL="Select a.ppg_id, a.pid, a.planned, a.actual, a.ppg_date From (SELECT ppg_id, pid, planned, actual, ppg_date FROM t023project_progress_graph WHERE pid = ".$pid."  ORDER BY ppg_date DESC limit 3) a order by a.ppg_date ASC";
$chartSQLResult = $db->query($chartSQL);
//$chartdatad['max_date']=date('M d Y');
$planned = array();
$actual = array();
$xaxis = array();
while ($chartdata =  $chartSQLResult->fetch_array() ) {
 $planned_perc=$chartdata['planned'];
$actual_perc=$chartdata['actual'];
$planned[] = number_format($planned_perc,2);
$actual[] =  number_format($actual_perc,2);
$month = substr($chartdata['ppg_date'],5,2);
if ($month == '01' || $month == 01) {$monthtext='Jan';}
if ($month == '02' || $month == 02) {$monthtext='Feb';}
if ($month == '03' || $month == 03) {$monthtext='Mar';}
if ($month == '04' || $month == 04) {$monthtext='Apr';}
if ($month == '05' || $month == 05) {$monthtext='May';}
if ($month == '06' || $month == 06) {$monthtext='Jun';}
if ($month == '07' || $month == 07) {$monthtext='Jul';}
// if ($month == '08' || $month == 08) {$monthtext='Aug';}
// if ($month == '09' || $month == 09) {$monthtext='Sep';}
// if ($month == '10' || $month == 10) {$monthtext='Oct';}
// if ($month == '11' || $month == 11) {$monthtext='Nov';}
// if ($month == '12' || $month == 12) {$monthtext='Dec';}
$yeartext = substr($chartdata['ppg_date'],2,2);
$xaxis[] = $monthtext."-".$yeartext;
}
$planneddata = implode(",",$planned);
$actualdata = implode(",",$actual);
$xaxisdata = "'".implode("','",$xaxis)."'";

$title = "Progress as on ".date('F d, Y',strtotime($chartdatad['max_date'])). " (Civil + E&M)";
$subtitle = "CURRENT + LAST TWO MONTHS PROGRESS";
$categories =  $xaxisdata;
$xaxistitle = "Months";
$yaxistitle = "Percentage";
$data1name = "Planned";
$data1 = $planneddata;
$data2name = "Actual";
$data2 = $actualdata;

$pdSQL = "SELECT pid, pgid,proj_name, proj_length, con_id, cons_id, proj_cont_price, proj_start_date, proj_end_date, proj_src_fund, proj_pc1_amount, proj_main , pcolor , proj_cur FROM t002project where pid = ".$pid;
$pdSQLResult = $db->query($pdSQL);
$pdData =  $pdSQLResult->fetch_array();
$pname = $pdData['proj_name'];
$plength = $pdData['proj_length'];
$pcon = $pdData['con_id'];
$pcons = $pdData['cons_id'];
$pprice = $pdData['proj_cont_price'];
$pstart = $pdData['proj_start_date'];
$pend = $pdData['proj_end_date'];
$psrc = $pdData['proj_src_fund'];
$ppc1 = $pdData['proj_pc1_amount'];
$pcolor = $pdData['pcolor'];
$proj_cur = $pdData['proj_cur'];
} else {
	header("Location: index.php?msg=0");
}
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

     .button-38 {
        /* background-color: #4b4bd6; */
        /* background-image: linear-gradient(to right, #00b4db, #0083b0, 0.01s); */
        background-image: linear-gradient( 95.2deg, rgba(31, 59, 179 ,0.16 ) 26.8%, rgba(31, 59, 179, 0.11) 64% );
        /* box-shadow: rgba(148, 148, 172, 0.2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
        color: black;
        cursor: pointer;
        font-weight: 600;
        margin-left:1%;
        display: inline-block;
        /* font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif; */
        padding: 5px 2px;
        text-align: center;
        text-decoration: none;
        transition: all 250ms;
        /* border: none; */
        font-size: 13px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        /* border: 10px solid #021a3b; */
      }
      .button-38:hover {
        box-shadow: rgba(31, 59, 179 ,.35) 0 -25px 18px -14px inset,rgba(31, 59, 179 ) 0 1px 2px,rgba(31, 59, 179 ,.25) 0 2px 4px,rgba(31, 59, 179 ,.25) 0 4px 8px,rgba(31, 59, 179 ,.25) 0 8px 16px,rgba(31, 59, 179 ,.25) 0 16px 32px;
        transform: scale(1.02) ;
        font-size: 14px;
      } 
      .btn-37 {
        padding: 10px;
        box-shadow: 5px 6px 8px #888888;
      } 
      .btn-37:hover {
        padding: 10px;
        box-shadow: 5px 3px 8px #888888;
      } 

/* 
tbody {
    display:block;
    max-height:160px;
    overflow-y:scroll;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
} */


      </style>
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
			
            text: '<?php echo $title; ?>'
        },
        subtitle: {
            text: '<?php echo $subtitle; ?>'
        },
        xAxis: {
            categories: [<?php echo $categories; ?>],
			//title: { text: '<?php //echo $xaxistitle; ?>' },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '<?php echo $yaxistitle; ?>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px; background-color: #fff;   opacity: 1; " >{point.key}</span><table style="background-color: #fff;   opacity: 1;" >',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '<?php echo $data1name; ?>',
			data: [<?php echo $data1; ?>],
			 dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'center',
                    x: 0,
                    y: 2,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }

        }, {
            name: '<?php echo $data2name; ?>',
			data: [<?php echo $data2; ?>],
			 dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'center',
                    x: 0,
                    y: 2,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'                        
                    }
                }

        }]
    });
});
</script>

<script src="highcharts.js"></script>
<script src="exporting.js"></script>
<script>
window.onload = function() {
    var countdownElement = document.getElementById('countdown'),
        downloadButton = document.getElementById('download'),
        seconds = 14,
        second = 0,
        interval;

    downloadButton.style.display = 'none';

    interval = setInterval(function() {
        countdownElement.firstChild.data = '' + (seconds - second) + ' seconds';
        if (second >= seconds) {
            downloadButton.style.display = 'block';
            clearInterval(interval);
        }

        second++;
    }, 1000);
}


</script>


</head>
<body>
<div class="container-scroller fixed " >
    <div class="page-body-wrapper full-page-wrapper">
      <div class="content-wrapper " >

    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar_dashboard.php';?>  <!-- partial -->
   


      <div class="row " style="padding-top: 2.2%;">
      <div class="col-md-4 grid-margin stretch-card px-2 " >
                        <div class="card p-0 pb-0 " >
                          <div class="card-body p-0 pt-2 pb-0 bg-light  " style="  border-radius: 20px 20px 0px 0px ;" >
                            <!-- <h4 class="card-title">left</h4> -->

                            <div class="table-responsive ">  
                            <h5 class="px-2 pt-2 pb-3" >Project Information 
          <?php if($adminflag==1)
                {
                 ?><span style="float:right"><form action="sp_project_info_update.php" target="_self" method="post"><input type="submit" class="btn btn-primary btn-37 mb-4 py-2 px-4" style="margin-top: -8%;"  name="p_update" id="p_update" value="Update"  /></form></span><?php }?></h5>
                    
                            <table class="table table-striped px-2" style="padding-left: 10px;" >
  <tbody >
                      <tr>
                        <td width="155" class="py-1" >Civilworks Contractor: </td>
                        <td width="112" align="right"  class="py-2 " ><?php 
            if($plength!=""&&$plength!=NULL)
            echo $plength ?></td>
                      </tr>
                      <tr>
                        <td  class="py-1" > E &amp; M Contractor: </td>
                        <td align="right"  class="py-2 pb-2" ><?php echo $pcon; ?></td>
                      </tr>
                      <tr>
                        <td class="py-1" >Consultant (M&amp;E): </td>
                        <td align="right"  class="py-2 pb-2" ><?php echo $pcons; ?></td>
                      </tr>
                      <tr>
                        <td  class="py-1" > Contract Price: ( <?php echo $proj_cur;?> )</td>
                        <td align="right"  class="py-2 pb-2" ><?php if($pprice!=""&&$pprice!=NULL&&$pprice!=0)
            echo number_format($pprice,0); ?></td>
                      </tr>
                      <tr>
                        <td  class="py-1" > Start Date:  </td>
                        <td align="right"  class="py-2 pb-2" >
            <?php if(isset($pstart)&&$pstart!=""&&$pstart!=NULL&&$pstart!="1970-01-01"){echo date("d/m/Y", strtotime($pstart)); }?></td>
                      </tr>
                      <tr>
                        <td  class="py-1" > VO2 Completition Date: </td>
                        <td align="right"  class="py-2 pb-2" > <?php if(isset($pend)&&$pend!=""&&$pend!=NULL&&$pend!="1970-01-01"){echo date("d/m/Y", strtotime($pend));} ?></td>
                      </tr>
                      <tr>
                        <td  class="py-1" > Source of Funds: </td>
                        <td align="right"  class="py-2 pb-2" ><?php echo $psrc; ?></td>
                      </tr>
                      <tr>
                        <td  class="py-1" > Appro. PC-1 Amount:  ( <?php echo $proj_cur;?> )  </td>
                        <td align="right"  class="py-2 pb-2" ><?php if($ppc1!=""&&$ppc1!=NULL&&$ppc1!=0)
            echo number_format($ppc1,0); ?></td>
                      </tr>
                    </tbody>
  </table>
  </div><!-- table-responsive" -->
                            
                          </div>
                        </div>
                      </div>

                        <div class="col-md-4 grid-margin stretch-card pb-0 px-2">
                        <div class="card p-0 pb-0">
                          <div class="card-body p-0 pt-2 pb-0 bg-light  " style="  border-radius: 20px 20px 0px 0px ;">
                            <h4 class="px-2 pt-2">
                          <?php if($adminflag==1)
								  {
								  
							
								   ?><span style="float:right" class="p-0"><form action="sp_progress_graph.php" target="_self" method="post"><input type="submit" class="btn btn-primary btn-37 mb-4 py-2 px-4" style="margin-top: -8%; "  name="g_update" id="g_update" value="Manage"  /></form></span><?php } ?> </h4>
								   <div id="container" style=" margin: 0 auto; height: 82% ;"></div>
                            
                            <!--  -->
                           
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card ">
                              <div class="card-body pb-0 p-0 pt-2 px-3"> -->

                              <div class="col-md-4 grid-margin stretch-card pb-0 px-2">
                        <div class="card p-0 pb-0">
                          <div class="card-body p-0 pt-2 pb-0 bg-light  " style="  border-radius: 20px 20px 0px 0px ;">
                          


                              <?php  
/*$apSQL = "SELECT b.act_name, a.ppt_id, a.pid, a.act_id, a.ppt_planned as planned_percent, a.ppt_actual as actual_percent, a.ppt_date FROM t024project_progress_table a left outer join t011activities b on a.act_id = b.act_id where a.ppt_date = (select max(t.ppg_date) from t023project_progress_graph t where t.pid=".$pid.") AND a.pid=".$pid." and a.act_id<>7 order by b.act_order";*/
$others="others";
$apSQL = "SELECT ppt_id,pid, act_id,ppt_planned as planned_percent,ppt_actual as actual_percent FROM t024project_progress_table where  pid=$pid and act_id!='$others' order by ppt_id";
 
$apSQLResult = $db->query($apSQL);
?>  
    <h4 class="px-2 pt-2"> Progress of Major Items  as of
          <?php if($adminflag==1)
                {
                 ?><span style="float:right" class="p-0" ><form action="sp_major_items.php"  target="_self" method="post"><input type="submit" name="i_update" id="i_update" value="Update" class="btn btn-primary btn-37 mb-4 py-2 px-4" style="margin-top: -8%;" /></form></span>
                 <?php }?>
                 <?php echo  "<h6 class=\"px-2\">".date('F d, Y',strtotime($chartdatad['max_date']))  ."</h6>";   ?>
                </h4>
  


                    <div class="table-responsive px-2 " >  
  <table  style="" class="table table-hover px-2 ">

  
 
    <thead>
    <tr>
                          <th class="px-0 text-center py-0 " rowspan="2" style=" font-size: 13px; font-weight: 700;" >Description</th>
                          <th class="px-0 text-center py-0 pb-2" colspan="2" style=" font-size: 13px; font-weight: 700;" >Progress</th>
                        </tr>
                        <tr>
                          <th class="px-0 text-start py-2" style=" font-size: 13px; font-weight: 700;" >Planned</th>
                          <th class="px-0 text-end py-0" style=" font-size: 13px; font-weight: 700;" >Achieved</th>
                        </tr>
                  </thead>
                      <tbody >
<?php
		while ($apdata = $apSQLResult->fetch_array() ) {
					echo '<tr><td  class="px-0 py-0" style=" font-size: 12px;" >'.$apdata['act_id'].'</td><td  class="px-0 py-2 text-start" style=" font-size: 12px;" align="right">'.number_format($apdata['planned_percent'],2). " %".'</td><td  class="px-0 py-0 text-end" style=" font-size: 12px;" align="right">'.number_format($apdata['actual_percent'],2). " %". '</td></tr>';
		}
?> 
      </tbody>
    </table> </div><!-- table-responsive" -->
                                  
  
                              </div>

                            </div>

                          </div>

                    </div>
                    <div class="row p-0" style="margin-top: -0.7%;">

                      <div class="col-lg-8 d-flex flex-column pt-0">
                        
                        <div class="row flex-grow pt-0">


                       

                      
                          <div class="col-md-6 col-lg-6 grid-margin stretch-card px-2 pb-0 ">
                            <div class="card ">
                              <div class="card-body p-2 bg-light  " style="  border-radius: 0px 0px 20px 20px  ;"> 

                              <?php  
  
  $funSQL1 = "SELECT fid,fund_year1,fund_year2 ,fund_year3,fund_year4,fund_psdp_alloc_y1,fund_psdp_alloc_y2,fund_psdp_alloc_y3,fund_psdp_alloc_y4, fund_released, fund_expense, fund_paid FROM t003funds WHERE pid = ".$pid;
  $funSQLResult1 = $db->query($funSQL1);
  $fundata1 = $funSQLResult1->fetch_array();
  $fid = $fundata1['fid']; 
  $year1 = $fundata1['fund_year1']; 
  $year2 = $fundata1['fund_year2'];
  $year3 = $fundata1['fund_year3'];
  $year4 = $fundata1['fund_year4'];
  $alloc1 = $fundata1['fund_psdp_alloc_y1']; 
  $alloc2 = $fundata1['fund_psdp_alloc_y2']; 
  $alloc3 = $fundata1['fund_psdp_alloc_y3']; 
  $alloc4 = $fundata1['fund_psdp_alloc_y4']; 
  $release = $fundata1['fund_released'];
  $expense = $fundata1['fund_expense'];
  $paid = $fundata1['fund_paid'];
   
  ?>  

                      <h4 class="px-2 pt-1 pb-4">Financial Status till Date in <?php echo $proj_cur;?> 
					  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_financial_info_input.php?fid=<?php echo $fid; ?>" target="_self" method="post">
                   <input type="submit" name="f_update" id="f_update" value="Update" class="btn btn-primary btn-37 mb-4 py-2 px-4" style="margin-top: -8%;"  /></form></span><?php } ?></h4>
                   <div class="table-responsive">  
                              <table  class="table table-striped"style="margin-top: -0.5%;">
<tbody>
                      
                       <tr >
                         <td class="py-1 pb-2 "><strong>Funds Released</strong></td>
                         <td align="right" class="py-0"><?php if($release!=""&&$release!=NULL&&$release!=0)
						  echo number_format($release,3); ?></td>
                       </tr>
                       <tr>
                         <td class="py-1 pb-2 "><strong>Expenditure</strong></td>
                         <td align="right" class="py-0"><?php if($expense!=""&&$expense!=NULL&&$expense!=0)
						  echo number_format($expense,3); ?></td>
                       </tr>
                       <tr>
                         <td class="py-1 pb-2 "><strong>Payment to Contractor</strong></td>
                         <td align="right" class="py-0"><?php if($paid!=""&&$paid!=NULL&&$paid!=0)
						  echo number_format($paid,3); ?></td>
                       </tr>
      </tbody>
    </table> 
    </div><!-- table-responsive" -->


    
    <h6 class = "pt-4 pb-2 text" style=" font-size: 14px; font-weight: 800;">Project Expected Completion Dates 
              <?php if($adminflag==1)
                    {
                     ?><!--<span style="float:right"><form action="sp_financial_info_input.php?fid=<?php echo $fid; ?>" target="_self" method="post"><input type="submit" name="f_update" id="f_update" value="Update"  /></form></span>--><?php } ?></h6>
                        <div class="table-responsive">  
  <table  style="" class= "table p-0">
                    <tr>
                            <th class="px-0 pt-0 pb-2 text-center"  align="center"  style=" font-size: 14px; font-weight: 600;" >Component</th>
                            <th class="px-0  pt-0 pb-2 text-center"  align="center"  style=" font-size: 14px; font-weight: 600;"> Planned Date</th>
                            <th class="px-0  pt-0 pb-2 text-center"  align="center"  style=" font-size: 14px; font-weight: 600;"> Expected Date</th>
                          </tr>
                       <tbody>
                         <tr>
                           <td align="center" class="px-0 py-1 pb-2">Overall Project</td>
                           <td align="center" class="px-0 py-1 pb-2">22-02-2019</td>
                           <td align="center" class="px-0 py-1 pb-2">22-02-2019</td>
                         </tr>
                       <tr>
                           <td align="center" class="px-0 py-1 pb-2">Unit - 17</td>
                           <td align="center" class="px-0 py-1 pb-2">25-02-2018</td>
                           <td align="center" class="px-0 py-1 pb-2">25-02-2018</td>
                         </tr>
              <tr>
                           <td align="center" class="px-0 py-1 pb-2">Unit - 16</td>
                           <td align="center" class="px-0 py-1 pb-2">30-04-2018</td>
                           <td align="center" class="px-0 py-1 pb-2">30-04-2018</td>
                         </tr>
               <tr>
                           <td align="center" class="px-0 py-1 pb-2">Unit - 15</td>
                           <td align="center" class="px-0 py-1 pb-2">30-05-2018</td>
                           <td align="center" class="px-0 py-1 pb-2">30-05-2018</td>
                         </tr>
                </tbody>
                      </table>
  
                      </div><!-- table-responsive" -->
                              </div>

                            </div>

                          </div>

                          <div class="col-6 grid-margin stretch-card px-2 pb-0">
                          <div class="card ">
                            <div class="card-body p-2 bg-light  " style="  border-radius: 0px 0px 20px 20px  ;"> 
                            <h4>More...</h4>
                            <div class="">  
                            <table  style="border:thick #000; width:100%; height:100%; padding:0px;">
                     
                     
                            <tbody >
                                      <tr style="padding:0px; margin:0px;">
                                        <td width="50%"  class="px-1 py-0 pb-1">
                                          <form action="sp_pc1.php">
                                            <button class="btn  button-38" type="submit" value="PC-1 Summary" style="width:100%; height:25px; margin:0px; font-size: small; padding:0px;">
                                            PC-1 Summary</button>
                                          </form>
                                        </td>
                                        <td width="50%" style="" class="px-1 py-0 pb-1">
                                          <form action="sp_align.php">
                                            <button class="btn  button-38" type="submit" value="Project Layout Plan" style="width:100%; height:25px; margin:0px; font-size: small; padding:0px; ">
                                            Project Layout Plan </button></form>
                                        </td>
                                      </tr>
              
                                      <tr style="padding:0px; margin:0px;">
                                        <td style="" class="px-1 py-0 pb-1"><span style="width:50%; height:100%; padding:0px; font-size: small; margin:0px;">
                                          <form action="sp_finstatus.php">
                                            <button class="btn  button-38" type="submit" value="Financial Status" style="width:100%; height:25px; margin:0px; font-size: small; padding:0px; ">
                                            Financial Status</button>
                                          </form></span></td><td width="50%" style="  " class="px-1 py-0 pb-1">
                                            <form action="sp_typx.php">
                                              <button class="btn  button-38" type="submit" value="Line Balance Diagram" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                              Line Balance Diagram </button>
                                          </form></td></tr>
              
                                      <tr style="padding:0px; margin:0px;"><td width="50%" style="  " class="px-1 py-0 pb-1">
                                        <form action="sp_contmob.php">
                                          <button class="btn  button-38" type="submit" value="Contractor&#39;s Mobilization" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Contractor's Mobilization</button></form></td><td width="50%" style="  " class="px-1 py-0 pb-1">
                                          <form action="sp_gphoto.php">
                                            <button class="btn  button-38" type="submit" value="Graphical Progress" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                            Graphical Progress</button>
                                          </form></td></tr>
              
                                      <tr style="padding:0px; margin:0px;"><td width="50%" style="  " class="px-1 py-0 pb-1" >
                                        <form action="sp_cashflow.php">
                                          <button class="btn  button-38"  type="submit" value="Cash Flow Requirement" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Cash Flow Requirement</button>
                                          </form></td><td width="50%" style="  " class="px-1 py-0 pb-1">
                                          <form action="sp_photo.php">
                                          <button class="btn  button-38"  type="submit" value="Progress Photographs" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Progress Photographs</button>
                                          </form></td></tr>
              
                                      <tr style="padding:0px; margin:0px;"><td width="50%" style="  " class="px-1 py-0 pb-1">
                                        <form action="sp_security_info.php">
                                          <button class="btn button-38"  type="submit" value="Security" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Security</button>
                                          </form></td><td width="50%" style="  " class="px-1 py-0 pb-1">
                                          <form action="sp_dphoto.php">
                                            <button class="btn button-38"  type="submit" value="Drawings" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                            Drawings</button>
                                          </form></td></tr>
              
                                      <tr style="padding:0px; margin:0px;"><td style=""  class="px-1 py-0 pb-1"><span style="width:50%; height:100%; padding:0px; margin:0px;">
                                        <form action="sp_component_wise.php">
                                          <button class="btn button-38"  type="submit" value="Component Wise KPIs" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Component Wise KPIs </button>
                                          </form></span></td><td width="50%" style="  " class="px-1 py-0 pb-1">
                                          <form action="sp_video.php">
                                            <button class="btn button-38" type="submit" value="Videos" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                            Videos</button>
                                          </form></td></tr>
              
                                      <tr style="padding:0px; margin:0px;"><td width="50%" style="  " class="px-1 py-0 pb-1">
                                        <form action="sp_deva.php">
                                          <button class="btn button-38" type="submit" value="Earned Value Analysis" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Earned Value Analysis </button>
                                          </form></td><td width="50%" style="  " class="px-1 py-0 pb-1">
                                          <form action="sp_qaqc.php">
                                            <button class="btn button-38" type="submit" value="QA/QC Tests" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                            QA/QC Tests</button>
                                          </form></td></tr>
                                      
                                      <tr><td width="50%" style="  " class="px-1 py-0 pb-1">
                                        <form action="sp_financial_disbur.php">
                                          <button class="btn button-38"  type="submit" value="Financial Disbursments" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Financial Disbursments</button>
                                          </form></td>
                                  <td width="50%" style="  " class="px-1 py-0 pb-1">
                                    <form action="sp_dpm_vo2.php">
                                      <button class="btn button-38" type="submit" value="VO2 Critical Analysis" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                      VO2 Critical Analysis</button>
                                          </form></td>    </tr>
                                      <tr><td style="width:50%;" class="px-1 py-0 pb-1"><span style="width:50%; height:100%; padding:0px; margin:0px;">
                                        <form action="sp_maindashboard.php">
                                          <button class="btn button-38" type="submit" value="Projects List" style="width:100%; height:25px; margin:0px; padding:0px; font-size: small;">
                                          Projects List</button>
                                          </form></span></td>
                                        <td style="width:50%">     
        </td>
                                      </tr>
                                      
                                    </tbody>
    </table> <span class = "text-end" style="  width:50%; height:5%; padding : 0px; margin: 0px; float: right"><a href="http://www.egcpakistan.com/index.php?id=it" target="_blank"><img src="sj.png" width="150px" style="marging-top:10px; "></a></span> 
    </div><!-- table-responsive" -->
                    </div>
                          </div>
                        </div>

                        </div>
                      </div>

                      <div class="col-lg-4 d-flex flex-column">
                        

                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card px-2 pb-0">
                            <div class="card card-rounded">
                              <div class="card-body card-rounded p-2 bg-light  " style="  border-radius: 0px 0px 20px 20px  ;"> 

                              <?php  
$issueSQL = "SELECT iss_id, iss_title, iss_detail FROM t012issues where pid = ".$pid. " order by iss_id asc limit 100";
$issueSQLResult = $db->query($issueSQL);
?>  
                      

                   <h4 class="pb-3">Major Issues and Recommendation <?php if($adminflag==1)
								  {
								   ?><span style="float:right" class="p-1"><form action="sp_issues_info.php" target="_self" method="post"><input type="submit" name="i_update" id="i_update" value="Manage"  class="btn btn-primary btn-37 mb-4 py-2 px-4" style="margin-top: -8%;" /></form></span><?php } ?></h4> 
                   
              

<marquee id="MARQUEE1" style="text-align: left; float: left; height:85%; margin-top: -3%;" scrollamount="3" onmouseout="this.start();" onmouseover="this.stop();" direction="up" behavior="scroll">
                
<?php
                while ($issuedata = $issueSQLResult->fetch_array() ) {
				$iss_id=$issuedata['iss_id'];
					  //  echo '';
                        // echo '<div class=" ">';
                          // echo '<div class=" ">';
                            echo '<h4 class=" pb-2">';
                               echo "<a class=\" text-primary \" style=\" text-decoration: none; font-size: 16px\" href='sp_issue.php?iss_id=$iss_id' target='_self'>".$issuedata['iss_title'].'</a>';
                            echo '</h4>';
                           
                          // echo '</div>';
                        // echo '</div>';
                      // echo '';
				}
?>
 </marquee>
             

                              </div>

                            </div>

                          </div>

                        </div>
                      </div>
                    

                    </div>

        
                    

                  
        <!-- partial:partials/_footer.php -->
         <?php include '../partials/_footer_dashboard.php';?> 
         <!-- partial -->
  


      
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

