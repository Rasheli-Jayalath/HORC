<?php
include_once("../../config/config.php");
$objDb0  		= new Database();
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2 		= new Database();
$objDb3 		= new Database();
$objDbB 		= new Database();
$objDbG 		= new Database();
$objDbG1 		= new Database();
$objDbG2 		= new Database();
$objDbG3 		= new Database();
$objDbG4 		= new Database();
$ObjKpiDash1 = new KpiDashboard();
$ObjKpiDash2 = new KpiDashboard();
$ObjKpiDash3 = new KpiDashboard();
$ObjKpiDash4 = new KpiDashboard();
$ObjKpiDash5 = new KpiDashboard();
$ObjKpiDash6 = new KpiDashboard();
$ObjKpiDash7 = new KpiDashboard();
$ObjKpiDash8 = new KpiDashboard();
$ObjKpiDash9 = new KpiDashboard();
$ObjKpiDash10 = new KpiDashboard();
$ObjKpiDash11 = new KpiDashboard();
$ObjKpiDash22 = new KpiDashboard();
$ObjKpiDash33 = new KpiDashboard();
$ObjKpiDash99 = new KpiDashboard();
$parentcd=NULL;
$lid=0;
$temp_id=1;
 $kpiids = $_GET['kpiids'];
$itemname = $_GET['itemname'];
$sql_1="SELECT * FROM project ";
	$objDb0->dbQuery($sql_1);
	 $iiCounti = $objDb0->totalRecords();
	 if($iiCounti>0)
	 {
		$prows = $objDb0->dbFetchArray();
		$pstart=$prows["pstart"];
	 }
if(isset($kpiids)&&$kpiids!=0&&$kpiids!='')
{
    $sql="SELECT parentcd, parentgroup FROM kpidata where kpiid=".$kpiids;
	$objDb->dbQuery($sql);
	 $iiCount = $objDb->totalRecords();
	 if($iiCount>0)
	 {
		$pcdrows = $objDb->dbFetchArray();
		$parentcd=$pcdrows["parentcd"];
		$parentgroup=$pcdrows["parentgroup"];
	 }

} 
?>
<?php
if(isset($_REQUEST["start_date"]))
 {
 $kpi_start=date('Y-m',strtotime($_REQUEST["start_date"]));
 $start=$kpi_start;
 $qs="SELECT scid from kpiscale where scmonth='$kpi_start'";
$objDb->dbQuery($qs);
 $qsdata=$objDb->dbFetchArray();
 $start_scid=$qsdata["scid"];

 $till_end=$kpi_start;
 }
 
 else
 {
 $sql="SELECT min(scmonth) as min_scmonth, max(scmonth) as max_scmonth FROM `kpiscale`";
 $objDb->dbQuery($sql);
  $result=$objDb->totalRecords();
 if($result!=0)
 {
 $data=$objDb->dbFetchArray();
 $kpi_start=$data["min_scmonth"];
  $start=$kpi_start;
 $qs="SELECT scid from kpiscale where scmonth='$kpi_start'";
$objDb->dbQuery($qs);
 $qsdata=$objDb->dbFetchArray();
 $start_scid=$qsdata["scid"];
 $kpi_end=$data["max_scmonth"];
 $end=$kpi_end;
  $qe="SELECT scid from kpiscale where scmonth='$kpi_end'";
 $objDb->dbQuery($qe);
 $qedata=$objDb->dbFetchArray();
 $end_scid=$qedata["scid"];
 $gend=$kpi_end;
 $till_end=$kpi_start;

 /*$kpi_gend=$data["kpi_gend"];
 $kpi_gend_m=date('m',strtotime($kpi_gend));
 $kpi_gend_y=date('Y',strtotime($kpi_gend));
 $gend=$kpi_gend_y."-".$kpi_gend_m;*/
 }

 }
 
 if(isset($_REQUEST["end_date"]))
 {
  $kpi_end=date('Y-m',strtotime($_REQUEST["end_date"]));
  $end=$kpi_end;
 $qe="SELECT scid from kpiscale where scmonth='$kpi_end'";
  $objDb->dbQuery($qe);
 $qedata=$objDb->dbFetchArray();
 $end_scid=$qedata["scid"];
 $gend=$kpi_end;
 $kpi_till_end=$kpi_end;
 $till_end=$kpi_till_end; // KPI UP Till END
 $qt="SELECT scid,scmonth from kpiscale where scmonth='$till_end'";
 $objDb->dbQuery($qt);
 $qedata=$objDb->dbFetchArray();
  $till_end_scid=$qedata["scid"];
  $till_end_scmonth=$qedata["scmonth"];
  $gend=$till_end;
 }
 
	?>
<!-- Table 1 goes here -->
<h4 style="margin-top:20px;text-align:center; font-weight:800" id="tabletitlename"><?php echo $itemname ?></h4>
<?php /*?><table   align="center" class="project"  height="265px">
	<tr ><td><div id="container" style="min-width: 310px;height:223px;"></div>
								 </td></tr></table><?php */?>
     <!-- Main data table ends here -->

<table class="table table-bordered normaltextsize" id="tobeappliedtable">
         <thead>
<tr bgcolor="000066" style=" color:#FFF">
<td colspan="100" align="center"><span class="white"><strong><?php echo $pdata["pdetail"];?> (KPI Progress Report)</strong></span></td>
</tr>
<tr>

  <th width="5%" ></th>
  <th width="40%"></th>
  <th  width="4%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <?php if($start>$pstart)
  {?>
   <th  width="5%">&nbsp;</th>
   <?php }?>
    <?php 
	
	 $scalesql = "SELECT DISTINCT(scquarter),scyear FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
     $objDb1->dbQuery($scalesql);
	 $total_rows = $objDb1->totalRecords();
		
while($scalerows=$objDb1->dbFetchArray())
{
	$scalesqln = "SELECT count(scmonth) as tmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."'  AND scquarter=".$scalerows["scquarter"]." AND scyear='".$scalerows["scyear"]."'";
  
   $objDb2->dbQuery($scalesqln);
	$trowsres = $objDb2->dbFetchArray();
  $scalerows["scquarter"] ."-";
  $total_rows1=$trowsres["tmonth"];
    
 ?>
  <th <?php if($total_rows1==3)
	{?>colspan="3" <?php } elseif($total_rows1==2){?>colspan="2"<?php } else{?> colspan="1"<?php }?> width="9%">Quarter <?php echo $scalerows["scquarter"]." ".$scalerows["scyear"];?> </th>
<?php }?>
</tr>
<tr >
<th width="5%" height="37">#</th>
<th width="40%"><div align="left">Indicators</div></th>
<th width="4%">UOM</th>
<th width="5%">Baseline</th>
<th width="5%">Total Achieved/Target</th>
<th width="5%">% Weighted</th>
<th width="5%">Achieved/Target</th>
<th>Aggregation</th>
<?php /*?><?php if($start>$pstart)
  {?>
<th>Till  <?php 
echo $till_last_month=date("M Y",strtotime("$start -1 month")); ?></th>
<?php }?><?php */?>
 <?php 
 $sql_g="TRUNCATE kpi_dashboard_graph";
$objDbG->dbQuery($sql_g);
$scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$objDb->dbQuery($scalesql);
$total_rows = $objDb->totalRecords();
while($scalerows = $objDb->dbFetchArray())
{
	$scmonth=$scalerows["scmonth"];

$vmonth= date('m',strtotime($scmonth));
$vyear= date('Y',strtotime($scmonth));
$vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
$scmonth=$scmonth."-".$vmonth_days;
$sql_g="INSERT INTO kpi_dashboard_graph(a_month,planned,actual) VALUES('".$scmonth."', '0' , '0' )";
$objDbG->dbQuery($sql_g);
 
$dprogress_month=date('M',strtotime($scalerows["scmonth"])); ?>
<th><?php echo $dprogress_month;?></th>
<?php }?> 
</tr>
</thead>
<tbody>
<?php 
$mob_weighted_progress=0;
$current=0;
$prev=0;
$current1=0;
$prev1=0;
$current2=0;
$prev2=0;
//$latest_month=0;
$latest_achieved=0;
$pro_prog=0;
$pro_prog_p=0;
$baseline=0;
$todate=0;
$tolast=0;
$ptodate=0;
$ptolast=0;

$reportquery ="SELECT * FROM kpidata where parentcd=".$kpiids ;
$reportquery .=" order by parentgroup ASC ";
$i=0;
$progress=0;
$pcurrent=0;
$pprev=0;

$objDb3->dbQuery($reportquery);
 $numrows = $objDb3->totalRecords();
while ($reportdata = $objDb3->dbFetchArray()) 
{
	 $progress=0;
	 $till_jan_prog=0;
	 $till_jan_targ=0;
	 $latest_achieved=0;
	 $latest_targets=0;

  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
  $pcurrent=$data_level_id;                           
?>
<?php
$pro_prog_till_month=0;
$pro_targ_till_month=0;

 
if($reportdata['isentry']==1)
  {
	 $reportquery_sub ="SELECT sum(a.baseline) as baseline FROM activity a inner join kpi_activity b on (a.itemid=b.itemid) where  b.kpiid=".$reportdata['kpiid']." Group By b.kpiid order by b.kpiid";
	$objDb->dbQuery($reportquery_sub);
    $reportdata_sub = $objDb->dbFetchArray();
 $i=0;
 $progress=0;
 $pcurrent=0;
 $pprev=0;
 $baseline=$reportdata_sub["baseline"];	
	$till_month_targ=0;
	$till_month_prog=0;?>
<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td rowspan="2" style="text-align:right;"><?php echo $reportdata['itemcode']; ?></td>
  <td rowspan="2" style="text-align:left;"><?php echo $reportdata['itemname']; ?></td>
   <td rowspan="2" style="text-align:center;"><?php echo $reportdata_sub["unit"];?></td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($baseline,0); ?></td>
  <td rowspan="2" style="text-align:right;">&nbsp;</td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'],2)."&nbsp;%"; ?></td>
  <td height="20" style="text-align:right;">Achieved:</td>
  <td style="text-align:right;">Accumulative</td>
  <?php 				
									$latest_month=$end;
									$last_month=$till_end;		
								
									
									
									//$tolast=$ObjKpiDash2->getMilestoneTotalTargetsCLast($till_end_scid,$reportdata['kpiid'],$till_end_scmonth);
									//$ptolast=$ObjKpiDash2->getMilestoneTotalAchieveCLast($till_end_scid,$reportdata['kpiid']);
									//$todate=$ObjKpiDash2->getMilestoneTotalTargetsCLatest($end_scid,$reportdata['itemid']);
									//$ptodate=$ObjKpiDash2->getMilestoneTotalAchieveCLatest($end_scid,$reportdata['itemid']);
									/*if($baseline!=0&&$tolast!=0)
									 {
										  $till_month_targ=($tolast/$baseline)*100;
									 }
									
									if($baseline!=0&&$ptolast!=0)
									 {
										
										$till_month_prog=($ptolast/$baseline)*100;
									 }*/
									if($baseline!=0&&$ptodate!=0)
									 {
										// $progress=($ptodate/$baseline)*100;
										
									 } ?>
<?php /*?>  <td style="text-align:right;"><?php echo number_format($till_month_prog,2). "%";?></td><?php */?>
   <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$objDb->dbQuery($scalesql);
$total_rows = $objDb->totalRecords();
while($scalerows = $objDb->dbFetchArray())
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];
$month_prog=0;
?>
     <?php 
									
									$month_machieve=$ObjKpiDash3->getMilestoneAchieveCCC($scid,$reportdata['kpiid'],$scmonth);
									
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
								 ?>
  <td style="text-align:right;"><?php echo number_format($month_prog,2). "%";?></td>
<?php 

	$vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
					 $sql_g="UPDATE kpi_dashboard_graph SET actual='".$month_prog ."' WHERE a_month='".$scmonth."'";
$objDbG1->dbQuery($sql_g);

}?>
  </tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:right;">Target:</td>
<td style="text-align:right;">Accumulative</td>
<?php /*?><td style="text-align:right;"><?php echo number_format($till_month_targ,2). "%";?></td><?php */?>
   <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$objDb->dbQuery($scalesql);
$total_rows = $objDb->totalRecords();
while($scalerows = $objDb->dbFetchArray())
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];
$month_targ=0;
?>
     <?php 
									
									$month_mtargets=$ObjKpiDash3->getMilestoneTargetsCCC($scid,$reportdata['kpiid'],$scmonth);
									
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }				
																
$vmonth= date('m',strtotime($scmonth));
$vyear= date('Y',strtotime($scmonth));
$vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
$scmonth=$scmonth."-".$vmonth_days;
$sql_g="UPDATE kpi_dashboard_graph SET planned='".$month_targ ."' WHERE a_month='".$scmonth."'";
$objDbG2->dbQuery($sql_g);								
									?>
<td style="text-align:right;"><?php echo number_format($month_targ,2). "%";?></td>
<?php }?>
</tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
<td rowspan="2" style="text-align:right;">&nbsp;</td>
<td rowspan="2" style="text-align:right;">&nbsp;</td>
<td rowspan="2" style="text-align:left;">&nbsp;</td>
<td rowspan="2" style="text-align:left;">&nbsp;</td>
<td height="20" style="text-align:right;"><?php echo number_format($ptodate,2);?></td>
<td style="text-align:left;">&nbsp;</td>
<td style="text-align:right;"><strong>Achieved</strong>:</td>
<td style="text-align:right;"><strong>Monthly</strong></td>
<?php /*?><td style="text-align:right;"><?php echo number_format($ptolast,2);?></td><?php */?>
 <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$objDb->dbQuery($scalesql);
$total_rows = $objDb->totalRecords();
while($scalerows = $objDb->dbFetchArray())
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];
?>
 <?php 
									$pmonth_machieve=$ObjKpiDash3->getMilestoneAchievePC($scid,$reportdata['kpiid'],$scmonth);
									
									?>
<td style="text-align:right;"><?php 
									echo number_format($pmonth_machieve,2);?></td>
<?php }?>

</tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td height="20" style="text-align:right;"><?php echo number_format($todate,2);?></td>
  <td style="text-align:left;">&nbsp;</td>
  <td style="text-align:right;"><strong>Target</strong>:</td>
  <td style="text-align:right;"><strong>Monthly</strong></td>
 <?php /*?> <td style="text-align:right;"><?php echo number_format($tolast,2);?></td><?php */?>
   <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$objDb->dbQuery($scalesql);
$total_rows = $objDb->totalRecords();
while($scalerows = $objDb->dbFetchArray())
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];

?>
  <?php 	
									$pmonth_mtargets=$ObjKpiDash4->getMilestoneTargetsPC($scid,$reportdata['kpiid'],$scmonth);
									 ?>
  <td style="text-align:right;"><?php 
									echo number_format($pmonth_mtargets,2);?></td>
<?php }?>
</tr>
<?php
 

  }
  
  else
  {
?>

<?php  
$colorq="SELECT 	kpi_color from 	kpi_colors where kpi_actlevel=".$reportdata['activitylevel'];
$objDb->dbQuery($colorq);
 $colordata=$objDb->dbFetchArray();
 ?>
<tr bgcolor="<?php echo $colordata["kpi_color"];?>">
  <td width="5%" rowspan="2" style="text-align:right;"><strong><?php echo $reportdata['itemcode']; ?></strong></td>
  <td width="40%" rowspan="2" style="text-align:left;"><div align="left"><strong><?php echo $reportdata['itemname']; ?></strong></div></td>
  <td width="4%" rowspan="2" style="text-align:center;"><?php echo "%";?></td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'],2)."&nbsp;%"; ?></td>
  <td height="20" align="right" bgcolor="<?php echo $colordata["kpi_color"];?>"><span style="text-align:right;">Achieved:</span></td>
  <td style="text-align:right;">Accumulative</td>
 <?php /*?> <td style="text-align:right;"><?php echo number_format($pro_prog_till_month*100,2). "%";?></td><?php */?>
  <?php	$scalesql = "SELECT scid, scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$objDb->dbQuery($scalesql);
									$total_months = $objDb->totalRecords();
									while($scalerows = $objDb->dbFetchArray())
									{
									
									$i++;
									$scmonth=$scalerows['scmonth'];
									$scid=$scalerows['scid'];
									$pro_prog_month=0;
	 						$pro_prog_month=$ObjKpiDash5->getProjectCommProgC($scid,$reportdata['kpiid'],$scmonth); 
							
								
	 ?>
  <td style="text-align:right;"><?php echo number_format($pro_prog_month,2). "%";?></td>
  
<?php


$vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;

 if($reportdata['kpiid']==4)
 {
 $sql_g="UPDATE kpi_dashboard_graph SET actual='".$pro_prog_month ."' WHERE a_month='".$scmonth."'";
 $objDbG3->dbQuery($sql_g);
 }

 }?>
</tr>
<tr bgcolor="<?php echo $colordata["kpi_color"];?>">
<td width="5%" height="20" align="right" ><span style="text-align:right;">Target:</span></td>
<td style="text-align:right;" width="5%">Accumulative</td>
<?php /*?><td style="text-align:right;" width="5%"><?php echo number_format($pro_targ_till_month*100,2). "%";?></td><?php */?>
<?php	$scalesql = "SELECT scid, scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$objDb->dbQuery($scalesql);
									$total_months = $objDb->totalRecords();
									while($scalerows = $objDb->dbFetchArray())
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
									$scid=$scalerows['scid'];
									 $pro_targ_month=0;
	 								$pro_targ_month=$ObjKpiDash5->getProjectCommTargC($scid,$reportdata['kpiid'],$scmonth);

$vmonth= date('m',strtotime($scmonth));
$vyear= date('Y',strtotime($scmonth));
$vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
$scmonth=$scmonth."-".$vmonth_days;
if($pro_targ_month!=0&&$pro_targ_month=='')
{
 $sql_g="UPDATE kpi_dashboard_graph SET planned='".$pro_targ_month ."' WHERE a_month='".$scmonth."'";
$objDbG4->dbQuery($sql_g);
}

	 ?>
<td style="text-align:right;" width="9%"><?php echo number_format($pro_targ_month,2). "%";?></td>
<?php 

					  
} ?>
<!--<td style="text-align:left;"></td>-->
</tr>


<?php

  }

}
?>
</tbody>
</table>