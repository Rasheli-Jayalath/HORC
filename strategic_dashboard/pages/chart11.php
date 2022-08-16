<?php
session_start();

if (isset($_REQUEST['pwpin'])) {
	if ($_REQUEST['pwpin'] == 'Nmway_5489') {
		$_SESSION['adminflag']=1;
		$adminflag = $_SESSION['adminflag'];
		} elseif ($_REQUEST['pwpin'] == 'Vonly_8159') {
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

if (!isset($_REQUEST['back'])) {
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
//	  $_SESSION['pid'] = 1;
//	  $pid= $_SESSION['pid'];


$chartSQLD = "SELECT max(sp_date) as max_date FROM overall_project_progress where pid = ".$pid." ";
$chartSQLResultd = mysqli_query($chartSQLD);
$chartdatad = mysqli_fetch_array($chartSQLResultd);
$planned_perc=0;
$actual_perc=0;

$chartSQL="Select a.ppg_id, a.pid, a.planned, a.actual, a.ppg_date From (SELECT ppg_id, pid, planned, actual, ppg_date FROM t023project_progress_graph WHERE pid = ".$pid."  ORDER BY ppg_date DESC limit 3) a order by a.ppg_date ASC";
$chartSQLResult = mysqli_query($chartSQL);
$chartdatad['max_date']=date('M d Y');
$planned = array();
$actual = array();
$xaxis = array();
while ($chartdata = mysqli_fetch_array($chartSQLResult)) {
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
if ($month == '08' || $month == 08) {$monthtext='Aug';}
if ($month == '09' || $month == 09) {$monthtext='Sep';}
if ($month == '10' || $month == 10) {$monthtext='Oct';}
if ($month == '11' || $month == 11) {$monthtext='Nov';}
if ($month == '12' || $month == 12) {$monthtext='Dec';}
$yeartext = substr($chartdata['ppg_date'],2,2);
$xaxis[] = $monthtext."-".$yeartext;
}
$planneddata = implode(",",$planned);
$actualdata = implode(",",$actual);
$xaxisdata = "'".implode("','",$xaxis)."'";

$title = "Progress as on ".date('F d, Y',strtotime($chartdatad['max_date']));
$subtitle = "CURRENT + LAST TWO MONTHS PROGRESS";
$categories =  $xaxisdata;
$xaxistitle = "Months";
$yaxistitle = "Percentage";
$data1name = "Planned";
$data1 = $planneddata;
$data2name = "Actual";
$data2 = $actualdata;

$pdSQL = "SELECT pid, pgid,proj_name, proj_length, con_id, cons_id, proj_cont_price, proj_start_date, proj_end_date, proj_src_fund, proj_pc1_amount, proj_main , pcolor FROM t002project where pid = ".$pid;
$pdSQLResult = mysqli_query($pdSQL);
$pdData = mysqli_fetch_array($pdSQLResult);
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
} else {
	header("Location: index.php?msg=0");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($mode == 1) {?>
<META HTTP-EQUIV="refresh" CONTENT="15">
<?php } ?>
<title>Tarbela 4th Extension  Hydropower Project</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<style type="text/css">
${demo.css}
</style>

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
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
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

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


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
<div class="top-box-set" >

<h1 align="center" style="background-color:<?php echo $pcolor; ?> "><?php echo $pname; ?></h1>
<img src="nha1.jpg" alt="nha logo" width="68.12"  height="60.98" style="position:absolute; top: 0px; left: 20px;"  />
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 100px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
<span style="position:absolute; top: 21px; right: 20px;font-family:Verdana, Geneva, sans-serif; font-size: 1.9em;font-weight:bold; color:#4CAF50; background-color:#FFF">PMU</span>
<!--<img src="nha2.jpg" alt="nha logo" width="104.64" style="position:absolute; top: 20px; right: 20px;" />-->
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="box">

  <table  style="border:1px; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="2"><h3>Project Information 
					  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_project_info_update.php" target="_self" method="post"><input type="submit" name="p_update" id="p_update" value="update"  /></form></span><?php }?></h3> </th></thead>
                      <tbody>
                        <tr>
                          <td width="155"><strong>Total Length:</strong></td>
                          <td width="112" align="right"><?php 
						  if($plength!=""&&$plength!=NULL&&$plength!=0)
						  echo $plength. " KM"; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Contractor:</strong></td>
                          <td align="right"><?php echo $pcon; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Consultant (AER):</strong></td>
                          <td align="right"><?php echo $pcons; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Contract Price:</strong></td>
                          <td align="right"><?php if($pprice!=""&&$pprice!=NULL&&$pprice!=0)
						  echo number_format($pprice,0); ?></td>
                        </tr>
                        <tr>
                          <td><strong>Start Date:</strong></td>
                          <td align="right">
						  <?php if(isset($pstart)&&$pstart!=""&&$pstart!=NULL&&$pstart!="1970-01-01"){echo date("d/m/Y", strtotime($pstart)); }?></td>
                        </tr>
                        <tr>
                          <td><strong>Completition Date:</strong></td>
                          <td align="right"> <?php if(isset($pend)&&$pend!=""&&$pend!=NULL&&$pend!="1970-01-01"){echo date("d/m/Y", strtotime($pend));} ?></td>
                        </tr>
                        <tr>
                          <td><strong>Source of Funds:</strong></td>
                          <td align="right"><?php echo $psrc; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Appro. PC-1 Amount:</strong></td>
                          <td align="right"><?php if($ppc1!=""&&$ppc1!=NULL&&$ppc1!=0)
						  echo number_format($ppc1,0); ?></td>
                        </tr>
                      </tbody>
    </table>
  </figure>
  <figure class="box1"> <?php if($adminflag==1)
								  {
								  
							
								   ?><span style="float:right"><form action="sp_progress_graph.php" target="_self" method="post"><input type="submit" name="g_update" id="g_update" value="Manage"  /></form></span><?php } ?>
								   <div id="container" style="min-width: 310px; height: 272px; margin: 0 auto"></div></figure>
  <figure class="box2">
<?php  
/*$apSQL = "SELECT b.act_name, a.ppt_id, a.pid, a.act_id, a.ppt_planned as planned_percent, a.ppt_actual as actual_percent, a.ppt_date FROM t024project_progress_table a left outer join t011activities b on a.act_id = b.act_id where a.ppt_date = (select max(t.ppg_date) from t023project_progress_graph t where t.pid=".$pid.") AND a.pid=".$pid." and a.act_id<>7 order by b.act_order";*/
$others="others";
$apSQL = "SELECT ppt_id,pid, act_id,ppt_planned as planned_percent,ppt_actual as actual_percent FROM t024project_progress_table where  pid=$pid and act_id!='$others' order by ppt_id";
 
$apSQLResult = mysqli_query($apSQL);
?>  
  
  <table  style="border:thick #000; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="3"><h3>Major Items Progress as on 
					  <?php echo date('F d, Y',strtotime($chartdatad['max_date']));?><?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_major_items.php" target="_self" method="post"><input type="submit" name="i_update" id="i_update" value="Update"  /></form></span><?php }?></h3></th></thead>
                        <tr>
                          <th rowspan="2"  style="text-align:center; vertical-align:middle">Description</th>
                          <th colspan="2" style="text-align:center; vertical-align:middle">Progress</th>
                        </tr>
                        <tr>
                          <th>Planned</th>
                          <th>Achieved</th>
                        </tr>
                      <tbody>
<?php
		while ($apdata = mysqli_fetch_array($apSQLResult)) {
					echo '<tr><td>'.$apdata['act_id'].'</td><td align="right">'.number_format($apdata['planned_percent'],2). " %".'</td><td align="right">'.number_format($apdata['actual_percent'],2). " %". '</td></tr>';
		}
?> 
      </tbody>
    </table>

  </figure>
  
  <figure class="box3">
  <?php  
  
$funSQL1 = "SELECT fid,fund_year1,fund_year2,fund_psdp_alloc_y1,fund_psdp_alloc_y2, fund_released, fund_expense, fund_paid FROM t003funds WHERE pid = ".$pid;
$funSQLResult1 = mysqli_query($funSQL1);
$fundata1 = mysqli_fetch_array($funSQLResult1);
$fid = $fundata1['fid']; 
$year1 = $fundata1['fund_year1']; 
$year2 = $fundata1['fund_year2'];
$alloc1 = $fundata1['fund_psdp_alloc_y1']; 
$alloc2 = $fundata1['fund_psdp_alloc_y2']; 
$release = $fundata1['fund_released'];
$expense = $fundata1['fund_expense'];
$paid = $fundata1['fund_paid'];
 
?>  
 




  <table  style="border:thick #000; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="4"><h3>Financial Status till Date in Million 
					  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_financial_info_input.php?fid=<?php echo $fid; ?>" target="_self" method="post"><input type="submit" name="f_update" id="f_update" value="Update"  /></form></span><?php } ?></h3></th>
                     </thead>
                      <tbody>
                        <tr>
                          <td width="56" rowspan="2"><strong>PSDP Allocation</strong></td>
                          <td width="56"><?php echo $year1; ?></td>
                          <td width="84" align="right"><?php if($alloc1!=""&&$alloc1!=NULL&&$alloc1!=0)
						  echo number_format($alloc1,3); ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $year2; ?></td>
                          <td width="84" align="right"><?php if($alloc2!=""&&$alloc2!=NULL&&$alloc2!=0)
						  echo number_format($alloc2,3); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Funds Release
                          d</strong></td>
                          <td align="right"><?php if($release!=""&&$release!=NULL&&$release!=0)
						  echo number_format($release,3); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Expenditure</strong></td>
                          <td align="right"><?php if($expense!=""&&$expense!=NULL&&$expense!=0)
						  echo number_format($expense,3); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Payment to Contractor</strong></td>
                          <td align="right"><?php if($paid!=""&&$paid!=NULL&&$paid!=0)
						  echo number_format($paid,3); ?></td>
                        </tr>
                      </tbody>
                    </table> 
  </figure>
  <figure class="box4">
<?php  
$issueSQL = "SELECT iss_id, iss_title, iss_detail FROM t012issues where pid = ".$pid. " order by iss_id asc limit 100";
$issueSQLResult = mysqli_query($issueSQL);
?>  
                      
<table  style="border:thick #000; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="2"><h3>Major/Current Issues  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_issues_info.php" target="_self" method="post"><input type="submit" name="i_update" id="i_update" value="Manage"  /></form></span><?php } ?></h3> </th></thead></table>

<marquee id="MARQUEE1" style="text-align: left; float: left; height: 210px;" scrollamount="3" onmouseout="this.start();" onmouseover="this.stop();" direction="up" behavior="scroll">







                      <ul class="list-unstyled timeline widget">
<?php
                while ($issuedata = mysqli_fetch_array($issueSQLResult)) {
				$iss_id=$issuedata['iss_id'];
					   echo '<li>';
                        echo '<div class="block">';
                          echo '<div class="block_content">';
                            echo '<h2 class="title">';
                               echo "<a href='sp_issue.php?iss_id=$iss_id' target='_self'>".$issuedata['iss_title'].'</a>';
                            echo '</h2>';
                           
                          echo '</div>';
                        echo '</div>';
                      echo '</li>';
				}
?>
                     </ul>
		

 </marquee>
  
  </figure>
<figure class="box5">

<table  style="border:thick #000; width:100%; height:100%; padding:0px;">
                      <thead><th colspan="2"><h3>More...</h3></th></thead>
                      <tbody>
                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_pc1.php"><input type="submit" value="PC-1 Summary" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_align.php"><input type="submit" value="Alignment Plan/ Camps" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_design.php"><input type="submit" value="Design Progress" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_typx.php"><input type="submit" value="Typical X-Section" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_landacq.php"><input type="submit" value="Land Acquisition" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_cashflow.php"><input type="submit" value="Cash Flow Requirement" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_reloc.php"><input type="submit" value="Relocation of Utilities" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_bridge.php"><input type="submit" value="Bridge Structures" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_contmob.php"><input type="submit" value="Contractor's Mobilization" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_interchanges.php"><input type="submit" value="Interchanges/ Services Areas" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_security_info.php"><input type="submit" value="Security" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_culverts.php"><input type="submit" value="Culverts/ Underpasses" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_photo.php"><input type="submit" value="Progress Photographs" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_qaqc.php"><input type="submit" value="QA/QC Tests" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>
                        
                        <tr><td  style="width:50%;padding:0px; margin:0px;"><span style="width:50%; height:100%; padding:0px; margin:0px;"><form action="sp_section_progress.php"><input type="submit" value="Section Wise Progress" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></span></td>
                        <td style="width:50%;padding:0px; margin:0px;"><span style="width:50%; height:100%; padding:0px; margin:0px;"><form action="sp_finstatus.php"><input type="submit" value="Financial Status" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></span></td></tr>
                        <tr><td  style="width:50%;"><span style="width:50%; height:100%; padding:0px; margin:0px;"><form action="sp_maindashboard.php"><input type="submit" value="Projects List" style="width:100%; height:40px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></span></td>
                          <td style="width:50%"> <span style="width:50%; height:100%; padding:0px; margin:0px;"><a href="http://www.egcpakistan.com/index.php?id=it" target="_blank"><img src="egc.jpg" width="40px" style="padding:0px;" align="right" /><img src="smec.jpg" width="100px" style="padding:0px;" align="right" /></a></span> </td>
                        </tr>
                      </tbody>
    </table> 
  </figure>
</div>
</body>
</html>
