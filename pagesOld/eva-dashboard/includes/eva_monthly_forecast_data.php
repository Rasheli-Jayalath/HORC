<?php $month=date('m',strtotime($end));
	$year=date('Y',strtotime($end));
	$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
	$end_date=$days."-".$month."-".$year;
	$end_date=date('d-M-Y',strtotime($end_date));?>
<table class="table table-bordered">
<tr bgcolor="000066" style="color:#FFF">
 <?php $coulmns="";
  $coulmns=$objEva->GetForecastingMonthsCount($start,$end);?>
  <td width="140" colspan="<?php echo $coulmns+1;?>" align="left" style="font-size:14px"><strong><?php   
  
		echo "Monthly Forecasting ( From ".date('d-M-Y',strtotime($start))." To ". date('d-M-Y',strtotime($end_date))." )";
	?></strong></td>
</tr>
<tr>
<th style="width:50px">&nbsp;&nbsp;

</th>
 <?php echo $objEva->GetForecastingMonths($start,$end);?>
</tr>
<!--<tr>
  <th>#</th>
  <th >Month</th>
  <th >EAC-2</th>
  <th >ETC-2</th>
  <th >TCPI-1</th>
 
</tr>-->
<?php 
$Parameter = array("EAC-2"=>"eac2", "ETC-2"=>"etc2", "TCPI-1"=>"tcpi1");

foreach($Parameter as $title =>$value) {
  //  echo "Key=" . $title . ", Value=" . $value;
 ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:left; width:50px"><strong><?php echo $title?></strong></td>
<?php 
$i=1;
$reportresult=$objEva->GetMonthlyForecasting($start,$end);
$num=$objEva->totalRecords();
				if($num>=1)
				{
while ($reportdata =$objEva->dbFetchArray()) {
	$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
?>
<td style="text-align:right;"><?php echo number_format($reportdata[$value],2);?></td>
    <?php

} }
?>
</tr>
<?php }?>
</table>