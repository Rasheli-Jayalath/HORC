<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "Add Progress Entry";
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
//$uname = $_SESSION['uname'];

$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$pid 					= $_REQUEST['pid'];
$itemid 				= $_REQUEST['itemid'];
$rid	 				= $_REQUEST['rid'];
$progress 				= $_REQUEST['progress'];
if($progress==''||$progress==NULL)
{
	$progress=0;
}
$progressdate1 			= $_REQUEST['progressdate'];
$temp_id	 			= $_REQUEST['temp_id'];
$progressdate=$progressdate1."-01";
$pdate=date('Y-m-d',strtotime($progressdate));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;         
$progressdate=$pdate;


 
$sSQL = ("INSERT INTO progress (itemid, progressdate, progressqty) VALUES ($itemid,'$progressdate', $progress)");
	$objDb->dbQuery($sSQL);
	$pgid = $con->lastInsertId();
	$msg="Saved!";
	
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO progress_log (log_module,log_title,log_ip, itemid, rid, progressdate, progressqty,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,$rid,'$progressdate', $progress,$pgid)");
	//$objDb1->dbQuery($sSQL);

?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                       <th style="width:20%;"></th>
                        
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						<th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline";?></th>
						<th style="width:25%;"><?php echo "Progress As on ".$progressdate1;?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from maindata where parentcd=$pid";
			$res_b=$objDb2->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb2->dbFetchArray())
			{
			$itm_id=$row3_b['itemid'];
			$sql_c="Select * from activity where itemid=$itm_id AND temp_id=$temp_id";
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
				 $sqlg="Select * from baseline where temp_id=$temp_id";
				$resg=$objDb->dbQuery($sqlg);
				while($row3g=$objDb->dbFetchArray())
				{
				if($row3g['rid']==$row3_c['rid'])
					{
							
				?>
				
				<td><?=$row3g['base_desc'];?></td>
				<?php
				}
				}
			}
			?>
			<td><?=$row3_c['startdate'];?></td>
			<td ><?=$row3_c['enddate'];?></td>
			<td><?=$row3_c['baseline'];?></td>
			
			
			<?php
			$sql_d="Select * from progress where itemid=$itm_id and left(progressdate,7)='$progressdate1'";
			$res_d=$objDb->dbQuery($sql_d);
			$row3_d=$objDb->dbFetchArray();			
			$progressqty=$row3_d['progressqty'];
			$pgidd=$row3_d['pgid'];
			?>
			
			
			<input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $progressqty;?></td>
			<?php if($objDb->totalRecords( )>0)
			{
			?>
			
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data(<?php echo $pgidd; ?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/></td>
			<?php
			}
			else
			{
			?>
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data1(<?php echo $aid;?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/></td>
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