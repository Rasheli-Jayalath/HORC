<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "Progress";
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
	if ($uname==null)
{
	header("Location: ../../index.php?init=3");
}


$aid 					= $_REQUEST['aid'];
$pid 					= $_REQUEST['pid'];
$itemid 				= $_REQUEST['itemid'];
$rid	 				= $_REQUEST['rid'];
$progressdate1 			= $_REQUEST['progressdate'];
$temp_id	 			= $_REQUEST['temp_id'];


?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                       <th style="width:20%;"></th>
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						 <th style="width:25%;"><?php echo "End Date";?></th>
						 <th style="width:25%;"><?php echo "Baseline";?></th>
						 <th style="width:25%;"><?php echo "Progress As on ".$progressdate1 ;?></th>
						 <th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from maindata where parentcd=$pid and isentry=1";
			$res_b=$objDb2->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb2->dbFetchArray())
			{
			$itm_id=$row3_b['itemid'];
			$sql_c="Select * from activity where itemid=$itm_id and temp_id=$temp_id";
			$res_c=$objDb1->dbQuery($sql_c);
			while($row3_c=$objDb1->dbFetchArray())
			{			
			$aidd=$row3_c['aid'];
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
				 $sqlg="Select * from baseline where temp_id=$temp_id";
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
			
			if($aidd==$aid)
			{
			$progressqty="";
			?>
			
			<td>
			<input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  />			
			<input type="text" value="<?php echo $progressqty;?>" name="txtprogress" id="txtprogress"  /></td>			
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Update" name="save" id="save"  onclick="savep_data(<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?>
			</td>
			<?php
			}
			else
			{
			$sql_d="Select * from progress where itemid=$itm_id  and left(progressdate,7)='$progressdate1'";
			$res_d=$objDb1->dbQuery($sql_d);
			$row3_d=$objDb1->dbFetchArray();			
			$progressqty=$row3_d['progressqty'];
			$pgidd=$row3_d['pgid'];
			?>
			
			<td><?php echo $progressqty;?></td>
			<?php if($objDb1->totalRecords( ))
			{
			?>
			
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data(<?php echo $pgidd; ?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>,  <?php echo $temp_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			?>
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data1(<?php echo $aidd;?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			
			?>
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
