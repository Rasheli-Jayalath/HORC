<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= BOQDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
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
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$itemid 				= $_REQUEST['kpiid'];
$activityid 				= $_REQUEST['activityid'];
$temp_id 				= $_REQUEST['temp_id'];
$temp_is_default	    = $_REQUEST['temp_is_default'];

	 $delsq3="delete from kpi_activity where kpiid=$itemid and itemid=$activityid";
	 
		$objDb -> dbQuery($delsq3);

if($temp_is_default==0)
{
	 $delsq4="delete from activity where  aid=$activityid";
	 
		$objDb1 -> dbQuery($delsq4);
}

?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
						<tr>
						<td colspan="13"><form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		$sqlg="Select * from maindata where  isentry=1";
			//$sqlg="Select * from maindata where  isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where a.kpiid=$itemid)";
			$resg=$objDb -> dbQuery($sqlg);
			while($row3g=$objDb -> dbFetchArray())
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.itemid FROM kpi_activity a inner join activity b on (a.itemid=b.itemid) where b.itemid=".$itemidd. " and a.kpiid=".$itemid;
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
			   <input type="hidden" value="<?php echo $itemid; ?>" name="txtitemid" id="txtitemid" />
			     <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?>
			    <input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $itemid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				<?php
				}
				?>
			 </div>
			 </form></td></tr>
                    <tr>
					<th style="width:2%;"></th>
                       <th style="width:25%;">Activity</th>
                        
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline Qty";?></th>
						<th style="width:25%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
					
					
					<?php 
$sql_b="SELECT a.kaid, b.aid,b.itemid, b.startdate,b.enddate, b.baseline, b.rid FROM `kpi_activity` a inner join activity b on (a.itemid=b.itemid) where a.kpiid=".$itemid; 
/*$sql_d="Select * from kpi_activity where kpiid=$itemid";*/
			$res_b=$objDb -> dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb -> dbFetchArray())
			{
			$sql_n="Select * from maindata where itemid=".$row3_b['itemid'];
			$res_n=$objDb2 -> dbQuery($sql_n);
			$row3_n=$objDb2 -> dbFetchArray();
			$itemname=$row3_n['itemname'];
			$aid=$row3_b['itemid'];
			$kaid=$row3_b['kaid']
			?>
			
			<tr >
			<td>
			  <?php  if($kpiadm_flag==1)
				{
				?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo $aid; ?>,<?php echo $itemid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?> );" title="Remove size">[X]</a>
			<?php
			}
			?></td>
			<td><b><?php echo $itemname; ?></b></td>
			
			 <?php  
			  
			  
			 $sqlg="Select * from baseline";
			$resg=$objDb1 -> dbQuery($sqlg);
			while($row3g=$objDb1 -> dbFetchArray())
			{
			if($row3g['rid']==$row3_b['rid'])
				{	
			?>
			
			<td><?=$row3g['base_desc'];?></td>
			<?php
				}
			}
			?>		
			<td><?=$row3_b['startdate'];?></td>
			<td ><?=$row3_b['enddate'];?></td>
			<td><?=$row3_b['baseline'];?></td>
			<?php
			$sqlga="Select * from kpi_activity where kaid=".$kaid;
			$resga=$objDb1 -> dbQuery($sqlga);
			$rowa_a=$objDb1 -> dbFetchArray();
			?>
			
			<td><?=$rowa_a['kaweight'];?></td>
			<td>  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"/>
				<?php
				}
				?></td>
			</tr>
			<?php
			$i=$i+1;
			}
		
			?>		
 </tbody>
            </table>
