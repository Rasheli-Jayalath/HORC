<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= BOQDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
$objDb4  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$kpi_flag			= $_SESSION['ne_kpi'];
$kpiadm_flag		= $_SESSION['ne_kpiadm'];
$kpientry_flag		= $_SESSION['ne_kpientry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$aid 				= $_REQUEST['aid'];
$kpiid 				= $_REQUEST['kpiid'];
$temp_id 				= $_REQUEST['temp_id'];
$temp_is_default	    = $_REQUEST['temp_is_default'];




?>

<?php if($temp_is_default==1)
{?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $kpiid; ?>">
				<tr>
						<td colspan="13"><form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $kpiid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
			  $sqlg="Select * from maindata where  isentry=1";
		
/*			$sqlg="Select * from maindata where  isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where a.kpiid=$kpiid)";
*/			$resg=$objDb -> dbQuery($sqlg);
			while($row3g=$objDb -> dbFetchArray())
			{
			$kpiidd=$row3g['itemid'];
			$sqlw="SELECT a.itemid FROM kpi_activity a inner join activity b on (a.itemid=b.itemid) where b.itemid=".$kpiidd. " and a.kpiid=".$kpiid;
			$sql_resw=$objDb1 -> dbQuery($sqlw);
			if($objDb1 -> totalRecords()>0)
			{
			?>
			<option value="<?php echo $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
			  <option value="<?php echo $row3g['itemid'];?>" ><?php echo $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo $kpiid; ?>" name="txtitemid" id="txtitemid" />
			    <input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $kpiid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				
			 </div>
			 </form></td></tr>
                    <tr>
					<th style="width:20%;">Activity</th>
                      
                       
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:15%;"><?php echo "End Date";?></th>
						<th style="width:15%;"><?php echo "Baseline Qty";?></th>
						<th style="width:25%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php 

 $sql_a="SELECT b.aid,b.itemid,b.startdate,b.enddate, b.baseline, b.temp_id, b.rid FROM `kpi_activity` a inner join activity b on (a.itemid=b.itemid) where a.kpiid=".$kpiid; 
			$res_a=$objDb3 -> dbQuery($sql_a);
			$i=1;
			while($row3=$objDb3 -> dbFetchArray())
			{
			$sql_n="Select * from maindata where itemid=".$row3['itemid'];
			$res_n=$objDb1 -> dbQuery($sql_n);
			$row3_n=$objDb1 -> dbFetchArray();
			$itemname=$row3_n['itemname'];
			if($row3['itemid']==$aid){
			?>
			<tr >
			
			<td><b><?php echo $itemname; ?></b><input id="kpiid" name="kpiid" type="hidden" value="<?php echo $kpiid; ?>"/></td>
			
			 <?php 
			 if($row3['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=$objDb2 -> dbQuery($sqlg);
			while($row3g=$objDb2 -> dbFetchArray())
			{
				if($row3g['rid']==$row3['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			
			<td><?php echo $row3['startdate']; ?></td>
			<td ><?php echo $row3['enddate']; ?></td>
			
			<td><?php echo $row3['baseline']; ?></td>
			
			<?php
			$sqlga="Select * from kpi_activity where itemid=$row3[itemid] and kpiid=$kpiid";
			$resga=$objDb4 -> dbQuery($sqlga);
			$rowa_a=$objDb4 -> dbFetchArray();
			$kaid=$rowa_a['kaid'];
			?>
			
			<td><input id="kaweight" name="kaweight" type="number" step="0.01"  value="<?php echo $rowa_a['kaweight'];?>"/></td>
			
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Update" name="update" id="update"  onclick="update_data(<?php echo $kaid;?>,<?php echo $row3['aid'];?>,<?php echo $row3['rid'];?>,<?php echo $temp_id;?>,<?php echo  $temp_is_default; ?>)"/>
			<?php
			}
			?>
			</td>
			</tr>
			<?php

			}
			else
			{
			
			?>
			
			<tr ><td><b><?php echo $itemname; ?></b></td>
			
			 <?php 
			 if($row3['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=$objDb2 -> dbQuery($sqlg);
			while($row3g=$objDb2 -> dbFetchArray())
			{
				if($row3g['rid']==$row3['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			
			<td><?php echo $row3['startdate'];?></td>
			<td ><?php echo $row3['enddate'];?></td>
			<td><?php echo $row3['baseline'];?></td>
			<?php
			$sqlga1="Select * from kpi_activity where itemid=$row3[itemid] and kpiid=$kpiid";
			$resga1=$objDb -> dbQuery($sqlga1);
			$rowa_a1=$objDb -> dbFetchArray();
			?>
			
			<td><?php echo $rowa_a1['kaweight'];?></td>
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  disabled="disabled" />
			<?php
			}
			?></td>
			</tr>
			
			<?php
			}
			$i=$i+1;
			}
			
			?>		
 </tbody>
            </table>
<?php }
else
{?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $kpiid; ?>">
				<tr>
						<td colspan="13"><form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $kpiid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where  isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where a.kpiid=$kpiid)";
			$resg=$objDb -> dbQuery($sqlg);
			while($row3g=$objDb -> dbFetchArray())
			{
			$kpiidd=$row3g['itemid'];
			$sqlw="SELECT a.itemid FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where b.itemid=".$kpiidd;
			$sql_resw=$objDb1 -> dbQuery($sqlw);
			if($objDb1 -> totalRecords()>0)
			{
			?>
			<option value="<?php echo $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
			  <option value="<?php echo $row3g['itemid'];?>" ><?php echo $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo $kpiid; ?>" name="txtitemid" id="txtitemid" />
			    <input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $kpiid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				
			 </div>
			 </form></td></tr>
                    <tr>
						
						<th style="width:20%;"><?php echo  "Activity";?></th>
						 <th style="width:10%;"><?php echo  "Start Date";?></th>
						<th style="width:10%;"><?php echo  "End Date";?></th>
                        <th style="width:15%;"><?php echo  "Baseline Item";?></th>
						<th style="width:10%;"><?php echo  "Total";?></th>
                        <th style="width:10%;"><?php echo  "Total Available";?></th>
                        <th style="width:10%;"><?php echo  "Allocated";?></th>
						<th style="width:10%;"><?php echo  "Weight";?></th>
						<th style="width:5%;"><?php echo  "Action";?></th>
                    </tr>
<?php 

 $sql_a="SELECT b.aid,b.itemid,b.startdate,b.enddate, b.baseline, b.temp_id, b.rid FROM `kpi_activity` a inner join activity b on (a.itemid=b.aid) where a.kpiid=".$kpiid." AND b.temp_id=$temp_id";  
			$res_a=$objDb2 -> dbQuery($sql_a);
			$i=1;
			while($row3=$objDb2 -> dbFetchArray())
			{
			$sql_n="Select * from maindata where itemid=".$row3['itemid'];
			$res_n=$objDb -> dbQuery($sql_n);
			$row3_n=$objDb -> dbFetchArray();
			$itemname=$row3_n['itemname'];
			if($row3['aid']==$aid){
			if(isset($row3['itemid'])&&$row3['itemid']!=0&&$row3['itemid']!='')
			   {
			 $sqlgb="Select * from baseline where rid=".$row3['rid']." AND temp_id=$temp_id"; 
			$resgb=$objDb1 -> dbQuery($sqlgb);  
			$row3gb=$objDb1 -> dbFetchArray();
			$total_quantity=$row3gb['quantity'];
			
			 $sql_au="Select sum(baseline) as used_q from activity where rid=".$row3['rid']." AND temp_id=$temp_id"; 
			$res_au=$objDb3 -> dbQuery($sql_au);
			$row3u=$objDb3 -> dbFetchArray();
			 $remaining=$total_quantity - $row3u['used_q'];
			
			
			 $sql_as="Select baseline from activity where itemid=".$row3['itemid']." AND temp_id=".$temp_id;
			$res_as=$objDb4 -> dbQuery($sql_as);
			$row3s=$objDb4 -> dbFetchArray();
			$u_r_quantity=$remaining+$row3s['baseline'];
			
			   }?>
			<tr >
			
			<td><b><?php echo $itemname; ?></b><input id="kpiid" name="kpiid" type="hidden" value="<?php echo $kpiid; ?>"/></td>
			<td><?php echo $row3['startdate']; ?></td>
			<td ><?php echo $row3['enddate']; ?></td>
			<td><select name="txtrid"   onchange="getQuantity(this.value)">
			   <?php  
			$sqlg="Select * from baseline where temp_id=".$temp_id;
			$resg=$objDb1 -> dbQuery($sqlg);
			?>
			<option value="0">Select Baseline</option>
			<?php
			while($row3g=$objDb1 -> dbFetchArray())
			{
			
				if($row3g['rid']==$row3['rid'])
				{
				$sele = " selected" ;
				}
				else
				{
				$sele = "" ;
				}
				
				
			?>
			  <option value="<?php echo  $row3g['rid'];?>"  <?php echo  $sele; ?>><?php echo  $row3g['base_desc']; ?> </option>
			  <?php
			  }
			   ?>
			   </select></td>
            <td><input type="hidden" name="h_remaining_quantity" id="h_remaining_quantity"  value="<?php echo $total_quantity;?>"><input type="text"  name="total_quantity" id="total_quantity" value="<?php echo $total_quantity;?>"  readonly="" style="width:105px"/></td>
			<td><input type="hidden" name="u_r_quantity" id="u_r_quantity"  value="<?php echo $u_r_quantity; ?>"><input type="text"  name="remaining_quantity" id="remaining_quantity" value="<?php echo $remaining;?>"  readonly="" style="width:105px"/></td>
            <td><input type="text"  name="used_quantity" id="used_quantity" value="<?php echo $row3['baseline']; ?>" style="width:105px" onKeyUp="showResult(remaining_quantity.value,this.value,h_remaining_quantity.value,u_r_quantity.value,<?php echo $row3['itemid'] ?>)"/></td>
             
			<?php /*?><td><?php echo $row3['baseline']; ?></td><?php */?>
			
			<?php
			$sqlga="Select * from kpi_activity where itemid=$row3[aid] and kpiid=$kpiid";
			$resga=$objDb3 -> dbQuery($sqlga);
			$rowa_a=$objDb3 -> dbFetchArray();
			$kaid=$rowa_a['kaid'];
			?>
			
			<td><input id="kaweight" name="kaweight" type="text" value="<?php echo $rowa_a['kaweight'];?>" style="width:105px"/></td>
			
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Update" name="update" id="update"  onclick="update_data(<?php echo $kaid;?>,<?php echo $row3['aid'];?>,txtrid.value,<?php echo $temp_id;?>,<?php echo  $temp_is_default; ?>)"/>
			<?php
			}
			?>
			</td>
			</tr>
			<?php

			}
			else
			{
			
			?>
			
			<tr ><td><b><?php echo $itemname; ?></b></td>
			
			
			
			<td><?php echo $row3['startdate'];?></td>
			<td ><?php echo $row3['enddate'];?></td>
             <?php 
			 if($row3['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=$objDb1 -> dbQuery($sqlg);
			while($row3g=$objDb1 -> dbFetchArray())
			{
				if($row3g['rid']==$row3['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			<td><?php echo $row3['baseline'];?></td>
            <td>0</td>
            <td>0</td>
			<?php
			$sqlga1="Select * from kpi_activity where itemid=$row3[aid] and kpiid=$kpiid";
			$resga1=$objDb3 -> dbQuery($sqlga1);
			$rowa_a1=$objDb3 -> dbFetchArray();
			?>
			
			<td><?php echo $rowa_a1['kaweight'];?></td>
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  disabled="disabled" />
			<?php
			}
			?></td>
			</tr>
			
			<?php
			}
			$i=$i+1;
			}
			
			?>		
 </tbody>
            </table>
<?php } ?>