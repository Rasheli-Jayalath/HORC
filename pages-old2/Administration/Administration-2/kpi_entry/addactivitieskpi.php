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

 $itemid 				= $_REQUEST['itemid'];
$temp_id 				= $_REQUEST['temp_id'];
 $temp_is_default	    = $_REQUEST['temp_is_default'];
 $act_s					= $_REQUEST['act'];
 $arr_act=explode("_",$act_s);
//print_r($arr_act);
 $length=count($arr_act);

if($temp_is_default==1 && $act_s!="" )
{
	?>
<?php if($length>0)
{
	
		for($i=0; $i<$length; $i++)
		{
		
		$eSql_l = "Select * from activity where itemid=".$arr_act[$i];
  		$res_sql=$objDb -> dbQuery($eSql_l);
	 	$numrows=$objDb -> totalRecords();
			if($numrows>0)
			{
				while($rows=$objDb -> dbFetchArray())
				{
				//$aid=$rows['aid'];
				$aid=$rows['itemid'];
				//$actual_itemid=$rows['itemid'];
					$eSql_2 = "Select * from kpi_activity where kpiid=$itemid and itemid=$aid";
					$res_sq2=$objDb1 -> dbQuery($eSql_2);
					if($objDb1 -> totalRecords()>0)
					{
					}
					else
					{
					$sSQL = ("INSERT INTO kpi_activity (kpiid,itemid) VALUES ($itemid,$aid)");
					$objDb2 -> dbQuery($sSQL);
					}
				
				}
			}
			
		}
		
}

?>
<table  width="100%">
            	<tbody id="tblPrdSizesProject<?php echo  $itemid; ?>">
				<tr><td colspan="13">
				<form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo  $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo  $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		$sqlg="Select * from maindata where isentry=1";
		//echo 	$sqlg="Select * from maindata where isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where a.kpiid=$itemid)";
			$resg=$objDb -> dbQuery($sqlg);
			while($row3g=$objDb -> dbFetchArray())
			{
			$itemidd=$row3g['itemid'];
		 	$sqlw="SELECT a.itemid FROM kpi_activity a inner join activity b on (a.itemid=b.itemid) where b.itemid=".$itemidd. " and a.kpiid=".$itemid;
			$sql_resw=$objDb2 -> dbQuery($sqlw);
			if($objDb2 -> totalRecords()>0)
			{
				
			?>
			<option value="<?php echo  $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			
			?>
			  <option value="<?php echo  $row3g['itemid'];?>" ><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo  $itemid; ?>" name="txtitemid" id="txtitemid" />
			      <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo  $itemid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
                        <th style="width:25%;"><?php echo  "Activity";?></th>
						<th style="width:25%;"><?php echo  "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo  "Start Date";?></th>
						<th style="width:25%;"><?php echo  "End Date";?></th>
						<th style="width:25%;"><?php echo  "Baseline Qty";?></th>
						<th style="width:25%;"><?php echo  "Weight";?></th>
						<th style="width:25%;"><?php echo  "Action";?></th>
						
                        
                        
                    </tr>
				
			<?php
			$sql_a="SELECT b.aid,b.itemid,b.startdate,b.enddate, b.baseline,  b.rid FROM `kpi_activity` a inner join `activity` b on (a.itemid=b.itemid) where a.kpiid=".$itemid; 
			$res_a=$objDb4 -> dbQuery($sql_a);
			$i=1;
			while($row3_a=$objDb4 -> dbFetchArray())
			{
			 $itemidd=$row3_a['itemid'];
			 $sql_n="Select * from maindata where itemid='$itemidd'";
			$res_n=$objDb1 -> dbQuery($sql_n);
			$row3_n=$objDb1 -> dbFetchArray();
			$itemname=$row3_n['itemname'];
			/*$itemname_with_resource=$itemname." - ".$row3_a['secheduleid'];*/
			$aid=$row3_a['itemid'];
			?>
			
			<tr >
			<td>
			  <?php  if($kpiadm_flag==1)
				{
				?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo  $aid; ?>,<?php echo  $itemid; ?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?> );" title="Remove size">[X]</a><?php
			}
			?></td>
			<td><b><?php echo  $itemname; ?></b></td>
			
			 <?php  
			  
			  
			  $sqlg="Select * from `baseline`";
			$resg=$objDb3 -> dbQuery($sqlg);
			while($row3g=$objDb3 -> dbFetchArray())
			{
			if($row3g['rid']==$row3_a['rid'])
				{
						
			?>
			
			<td><?php echo $row3g['base_desc'];?></td>
			<?php
				}
			}
			?>
			
			<td><?php echo $row3_a['startdate'];?></td>
			<td ><?php echo $row3_a['enddate'];?></td>
			
			<td><?php echo $row3_a['baseline'];?></td>
			
			<?php
			$sqlga="Select * from kpi_activity where itemid=$aid and kpiid=$itemid";
			$resga=$objDb -> dbQuery($sqlga);
			$rowa_a=$objDb -> dbFetchArray();
			?>
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo  $aid;?>,<?php echo  $itemid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"  /><?php
				}
				?></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			
			?>	
					
                </tbody>
            </table>
<?php }
else
{?>
<?php if($length>0 && $act_s!="")
{
	
		for($i=0; $i<$length; $i++)
		{
		
		$eSql_l = "Select * from activity where itemid=".$arr_act[$i];
  		$res_sql=$objDb1 -> dbQuery($eSql_l);
	 	$numrows=$objDb1 -> totalRecords();
			if($numrows>0)
			{
				while($rows=$objDb1 ->dbFetchArray())
				{
					$startdate=$rows["startdate"];
					$enddate=$rows["enddate"];
					$itemida=$rows["itemid"];
				echo	$saSQL = ("INSERT INTO activity (itemid,startdate,enddate,temp_id) VALUES ($itemida,'$startdate','$enddate',$temp_id)");
					$objDb2 ->dbQuery($saSQL);
					$aid = $con->lastInsertId();
					
					$eSql_2 = "Select * from kpi_activity where kpiid=$itemid and itemid=$aid";
					$res_sq2=$objDb ->dbQuery($eSql_2);
					if($objDb ->totalRecords()>0)
					{
					}
					else
					{
				echo	$sSQL = ("INSERT INTO kpi_activity (kpiid,itemid) VALUES ($itemid,$aid)");
					$objDb3->dbQuery($sSQL);
					}
				
				}
			}
			
		}
		
}
?>
<table  width="100%">
            	<tbody id="tblPrdSizesProject<?php echo  $itemid; ?>">
				<tr><td colspan="13">
				<form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo  $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo  $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where a.kpiid=$itemid )";
			$resg=$objDb->dbQuery($sqlg);
			while($row3g=$objDb->dbFetchArray())
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.itemid FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where b.itemid=".$itemidd. " AND b.temp_id=".$temp_id;
			$sql_resw=$objDb1->dbQuery($sqlw);
			if($objDb1->totalRecords()>0)
			{
			?>
			<option value="<?php echo  $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
			  <option value="<?php echo  $row3g['itemid'];?>" ><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo  $itemid; ?>" name="txtitemid" id="txtitemid" />
			      <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo  $itemid; ?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
						<th style="width:25%;"><?php echo  "Activity";?></th>
						 <th style="width:15%;"><?php echo  "Start Date";?></th>
						<th style="width:25%;"><?php echo  "End Date";?></th>
                        <th style="width:25%;"><?php echo  "Baseline Item";?></th>
                        <th style="width:25%;"><?php echo  "Allocated";?></th>
						<th style="width:25%;"><?php echo  "Weight";?></th>
						<th style="width:25%;"><?php echo  "Action";?></th>
						
                        
                        
                    </tr>
				
			<?php
			$sql_a="SELECT b.aid,b.itemid,b.startdate,b.enddate, b.baseline,  b.rid FROM `kpi_activity` a inner join `activity` b on (a.itemid=b.aid) where a.kpiid=".$itemid." AND b.temp_id=$temp_id"; 
			$res_a=$objDb->dbQuery($sql_a);
			$i=1;
			while($row3_a=$objDb->dbFetchArray())
			{
			$itemidd=$row3_a['itemid'];
			 $sql_n="Select * from maindata where itemid='$itemidd'";
			$res_n=$objDb1->dbQuery($sql_n);
			$row3_n=$objDb1->dbFetchArray();
			$itemname=$row3_n['itemname'];
			/*$itemname_with_resource=$itemname." - ".$row3_a['secheduleid'];*/
			$aid=$row3_a['aid'];
			?>
			
			<tr >
			<td>
			  <?php  if($kpiadm_flag==1)
				{
				?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo  $aid; ?>,<?php echo  $itemid; ?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?> );" title="Remove size">[X]</a><?php
			}
			?></td>
			<td><b><?php echo  $itemname; ?></b></td>
			<td><?php echo $row3_a['startdate'];?></td>
			<td ><?php echo $row3_a['enddate'];?></td>
			 <?php 
			 if($row3_a['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
				if($row3g['rid']==$row3_a['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			<td><?php echo $row3_a['baseline'];?></td>
			<?php
			$sqlga="Select * from kpi_activity where itemid=$aid and kpiid=$itemid";
			$resga=$objDb2->dbQuery($sqlga);
			$rowa_a=$objDb->dbFetchArray();
			?>
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo  $aid;?>,<?php echo  $itemid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"  /><?php
				}
				?></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			
			?>	
					
                </tbody>
            </table>
			
<?php }?>