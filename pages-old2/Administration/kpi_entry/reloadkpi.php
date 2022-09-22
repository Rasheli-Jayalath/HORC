<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= BOQDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3 		= new Database();
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
$kpiid 				= $_REQUEST['kpiid'];
$temp_id 			= $_REQUEST['temp_id'];


 $btem="SELECT * FROM baseline_template WHERE temp_id=$temp_id";
			  $resbtemp=$objDb -> dbQuery($btem);
			  $row3tmpg=$objDb->dbFetchArray();
			  $temp_is_default=$row3tmpg["temp_is_default"];


?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                <tr>
						<td colspan="13">
                        <form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 <select name="act[]" id="act<?php echo $kpiid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			  <?php 
			  		 $sqlg="Select * from maindata where isentry=1";
			//echo $sqlg="Select * from maindata where isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.itemid=b.aid) where a.kpiid=$kpiid  )";
			$resg=$objDb3 -> dbQuery($sqlg);
			while($row3g=$objDb3 -> dbFetchArray())
			{
			$kpiidd=$row3g['itemid'];
			$sqlw="SELECT a.itemid FROM kpi_activity a inner join activity b on (a.itemid=b.itemid) where b.itemid=".$kpiidd. " AND b.temp_id=".$temp_id. " and a.kpiid=".$kpiid;
			$sql_resw=$objDb1 -> dbQuery($sqlw);
			$sqlp="SELECT * FROM maindata where itemid=".$row3g['parentcd'];
			$sql_resp=$objDb2 -> dbQuery($sqlp);
			$row3p=$objDb2 -> dbFetchArray();
			
			if($objDb1 -> totalRecords()>0)
			{
			?>
			<option value="<?php echo $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo $row3p["itemname"]."-".$row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
            <option value="<?php echo $row3g['itemid'];?>" ><?php echo $row3p["itemname"]."-".$row3g['itemcode']." : ".$row3g['itemname']; ?>
            </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo $kpiid; ?>" name="txtitemid" id="txtitemid" />
			   <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?>
			    <input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $kpiid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                   <tr>
					<th style="width:2%;"></th>
                       
						<th style="width:25%;"><?php echo "Activity";?></th>
                        <th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline Qty";?></th>
						<th style="width:25%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
                    
                    
                    <?php 
/* */
 $sql_b="SELECT a.kaid, b.aid,b.itemid,b.startdate,b.enddate, b.baseline, b.rid FROM kpi_activity a inner join activity b on (a.itemid=b.itemid) where a.kpiid=".$kpiid." AND b.temp_id=$temp_id"; 
/*$sql_d="Select * from kpi_activity where milestoneid=$kpiid";*/
			$res_b=$objDb3->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb3->dbFetchArray())
			{
			$sql_n="Select * from maindata where itemid=".$row3_b['itemid'];
			$res_n=$objDb2->dbQuery($sql_n);
			$row3_n=$objDb2->dbFetchArray();
			$itemname=$row3_n['itemname'];
			$aid=$row3_b['itemid'];
			$kaid=$row3_b['kaid'];
			//echo $row3_b['rid'];
			?>
			<tr >
			<td>
			<?php  if($kpiadm_flag==1)
			{
			?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo $aid; ?>,<?php echo $kpiid; ?> ,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>);" title="Remove size">[X]</a>
			<?php
			}
			?>
			</td>
			<td><b><?php echo $itemname; ?></b></td>
			
			 <?php 
			 if($row3_b['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from baseline ";
			$resg=$objDb1->dbQuery($sqlg);
			while($row3g=$objDb1->dbFetchArray())
			{
				if($row3g['rid']==$row3_b['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			<td><?php echo $row3_b['startdate'];?></td>
			<td><?php echo $row3_b['enddate'];?></td>
			<td><?php echo $row3_b['baseline'];?></td>
			<?php
			$sqlga="Select * from kpi_activity where kaid=".$kaid;
			$resga=$objDb->dbQuery($sqlga);
			$rowa_a=$objDb->dbFetchArray();
			?>
			
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $kpiid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"/>
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
