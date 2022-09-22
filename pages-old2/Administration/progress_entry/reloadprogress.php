<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$spg_flag			= $_SESSION['ne_spg'];
	$spgadm_flag		= $_SESSION['ne_spgadm'];
	$spgentry_flag		= $_SESSION['ne_spgentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$pid 				= $_REQUEST['itemid'];
$temp_id 				= $_REQUEST['temp_id'];


  $sql_p="Select left(pmonth,7) as pmmonth from progressmonth where status=0";
 $res_p=$objDb->dbQuery($sql_p);
 $row3_p=$objDb->dbFetchArray();
  $pmonth=$row3_p['pmmonth'];

?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                       <th style="width:20%;"></th>
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline";?></th>
						<th style="width:25%;"><?php echo "Progress As on ".$pmonth;?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from maindata where parentcd=$pid and isentry=1";
			$res_b=$objDb2->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb2->dbFetchArray())
			{
			$itm_id=$row3_b['itemid'];
			$sql_c="Select * from activity where itemid=$itm_id AND temp_id=".$temp_id;
			$res_c=$objDb1->dbQuery($sql_c);
			while($row3_c=$objDb1->dbFetchArray())
			{			
			$aid=$row3_c['aid'];
			$rid=$row3_c['rid'];
			?>
			
			<tr ><td><?php echo $row3_b['itemname']; ?></td>
		
			<?php
			 if($row3_c['rid']==0)
			{
			?>
			<td></td>
			<?php
			}
			else
			{   
				 $sqlg="Select * from baseline where temp_id=".$temp_id;
				$resg=$objDb->dbQuery($sqlg);
				while($row3g=$objDb->dbFetchArray())
				{
				if($row3g['rid']==$row3_c['rid'])
					{
							
				?>
				
				<td><?php echo $row3g['base_desc'];?></td>
				<?php
				}
				}
			}
			?>
			
			<td><?php echo $row3_c['startdate'];?></td>
			<td ><?php echo $row3_c['enddate'];?></td>
		    <td><?php echo $row3_c['baseline'];?></td>
			<?php
			 $sql_d="Select * from progress where itemid=$itm_id and left(progressdate,7)='$pmonth'";
			$res_d=$objDb->dbQuery($sql_d);
			$row3_d=$objDb->dbFetchArray();			
			$progressqty=$row3_d['progressqty'];
			$pgidd=$row3_d['pgid'];
			?>
			
			
			<input type="hidden" value="<?php echo $pmonth;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $progressqty;?></td>
			<?php if($objDb->totalRecords()>0)
			{
			?>
			
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data(<?php echo $pgidd; ?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?>
			</td>
			<?php
			}
			else
			{
			?>
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data1(<?php echo $aid;?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?>
			</td>
			<?php
			}
			
			?>
			
			</tr>
			<?php
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>
