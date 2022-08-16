<table class="table table-bordered">
<tr bgcolor="000066" style="color:#FFF">
 
  <td  colspan="4" align="left" style="font-size:12px"><strong><?php   
  	//$start_forecast="2013-10-01";
	//$end_forecast="2015-10-01";
	$mi=date('m',strtotime($last));
	$yi=date('Y',strtotime($last));
	$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
	
	$last_date=$yi."-".$mi."-".$days;
		echo "Indicators as on ".date('M, d, Y',strtotime($last_date));
	?></strong></td>
</tr>

<tr>
  <th>#</th>
  <th >Indicator</th>
  <th >Value</th>
  <th >T-L</th>
</tr>
<?php 
//$a_leb_down='<label style="color:#FF0000; font-size:30px; width:50px">&#11015;</label>';
//$a_leb_red_up='<label style="color:#FF0000; font-size:30px; width:50px">&#11014;</label>';
//$d_leb='<label style="color:#0F3; font-size:25px">&#9670;</label>';
//$a_leb_up='<label style="color:#0F3; font-size:25px; width:50px">&#11014;</label>';
//$a_leb_green_down='<label style="color:#0F3; font-size:30px; width:50px">&#11015;</label>';
$a_leb_up='<img src="../../images/images/green-up.png"  width="10px" height="10px"/>';
$a_leb_down='<img src="../../images/images/red-down.png"  width="10px" height="10px"/>';
$d_leb='<img src="../../images/images/diamond.png" width="10px" height="10px"/>';
$a_leb_red_up='<img src="../../images/images/red-up.png"  width="10px" height="10px"/>';
$a_leb_green_down='<img src="../../images/images/green-down.png" width="10px" height="10px"/>';

$i=1;
$bac_ev=0;
$RParameter = array("PV"=>"pv", "EV"=>"ev", "AC"=>"ac","BAC"=>"bac", "CV"=>"cv", "SV"=>"sv", "CPI"=>"cpi","SPI"=>"spi", "EAC-2"=>"eac2","ETC-2"=>"etc2","TCPI-1"=>"tcpi1");
foreach($RParameter as $title =>$value) {
	
  //  echo "Key=" . $title . ", Value=" . $value;
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF"; ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<?php 

$reportresult=$objEva->GetMonthlyIndicatorsValue($last);

$num=$objEva->totalRecords();
				
				if($num>=1)
				{
					
while($reportdata = $objEva->dbFetchArray())
	   {
	//$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
?>
<td style="text-align:center;"><?php echo $i;?></td>
<td style="text-align:left;"><strong><?php echo $title;?></strong></td>
<td style="text-align:right;"><?php echo number_format($reportdata[$value],2);?></td>
<td style="text-align:center;"><?php 
if($value=='pv'||$value=='bac') {
	echo $d_leb;
 }
 if($value=='cv'||$value=='sv'|| $value=='cpi'|| $value=='spi') {
	if($value=='cv'&&  $reportdata[$value]>0)
	{
    echo $a_leb_up;
	}
	elseif($value=='cv'&&  $reportdata[$value]<0)
	{
	echo $a_leb_down;
	}
	elseif($value=='cv'&&  $reportdata[$value]==0)
	{
	echo $d_leb;
	}
	///////////////////// end CV
	if($value=='sv'&&  $reportdata[$value]>0)
	{
    echo $a_leb_up;
	}
	elseif($value=='sv'&&  $reportdata[$value]<0)
	{
	echo $a_leb_down;
	}
	elseif($value=='sv'&&  $reportdata[$value]==0)
	{
	echo $d_leb;
	}
	////////////////// end SV
	if($value=='cpi'&&  $reportdata[$value]>1)
	{
    echo $a_leb_up;
	}
	elseif($value=='cpi'&&  $reportdata[$value]<1)
	{
	echo $a_leb_down;
	}
	elseif($value=='cpi'&&  $reportdata[$value]==1)
	{
	echo $d_leb;
	}
	//////////////// end CPI
	if($value=='spi'&&  $reportdata[$value]>1)
	{
    echo $a_leb_up;
	}
	elseif($value=='spi'&&  $reportdata[$value]<1)
	{
	echo $a_leb_down;
	}
	elseif($value=='spi'&&  $reportdata[$value]==1)
	{
	echo $d_leb;
	}
	//////////////// end CPI
 }
 
 ///////////// end Indexs
 if($value=='ev' &&  $reportdata['ev']<$reportdata['pv'] ){
	echo  $a_leb_down;
	 }
	elseif($value=='ev' &&  $reportdata['ev']>$reportdata['pv'] ){
	echo  $a_leb_up;
	 }
	 elseif($value=='ev' &&  $reportdata['ev']==$reportdata['pv'] ){
	echo  $d_leb;
	 }
/////////////////// end EV

if($value=='ac' &&  $reportdata['ac']>$reportdata['ev'] ){
	echo  $a_leb_red_up;
	 }
	elseif($value=='ac' &&  $reportdata['ac']<$reportdata['ev'] ){
	echo  $a_leb_green_down;
	 }
	 elseif($value=='ac' &&  $reportdata['ac']==$reportdata['ev'] ){
	echo  $d_leb;
	 }
/////////////////// end AC

if($value=='eac2' &&  $reportdata['eac2']>$reportdata['pv'] ){
	echo  $a_leb_red_up;
	 }
	elseif($value=='eac2' &&  $reportdata['eac2']<$reportdata['pv'] ){
	echo  $a_leb_green_down;
	 }
	 elseif($value=='eac2' &&  $reportdata['eac2']==$reportdata['pv'] ){
	echo  $d_leb;
	 }
/////////////////// end AEC-2
$bac_ev=$reportdata['bac']-$reportdata['ev'];
if($value=='etc2' &&  $reportdata['etc2']>$bac_ev ){
	echo  $a_leb_red_up;
	 }
	elseif($value=='etc2' &&  $reportdata['etc2']<$bac_ev ){
	echo  $a_leb_green_down;
	 }
	 elseif($value=='etc2' &&  $reportdata['etc2']==$bac_ev ){
	echo  $d_leb;
	 }
/////////////////// end ETC-2


if($value=='tcpi1' &&  $reportdata['tcpi1']>1 ){
	echo  $a_leb_red_up;
	 }
	elseif($value=='tcpi1' &&  $reportdata['tcpi1']<1 ){
	echo  $a_leb_green_down;
	 }
	 elseif($value=='tcpi1' &&  $reportdata['tcpi1']==1 ){
	echo  $d_leb;
	 }
/////////////////// end TCPI-1
 ?>
</td>
    <?php

} }
$i++;
?>
</tr>
<?php }?>
</table>