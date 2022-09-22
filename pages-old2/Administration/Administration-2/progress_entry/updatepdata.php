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
$module="Update Progress Entry";

$pgid 					= $_REQUEST['pgid'];
$pid 					= $_REQUEST['pid'];
$itemid 				= $_REQUEST['itemid'];
$rid	 				= $_REQUEST['rid'];
$temp_id	 			= $_REQUEST['temp_id'];
$progress 				= $_REQUEST['progress'];
if($progress==''||$progress==NULL)
{
	$progress=0;
}
$progressdate1 			= $_REQUEST['progressdate'];
$progressdate=$progressdate1."-01";
 $pdate=date('Y-m-d',strtotime($progressdate));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;									
$progressdate=$pdate;


function removeProgress($itemid)
{
$objDb11  		= new Database();
$objDb4  		= new Database();
$objDbp  		= new Database();
$objDbaa  		= new Database();
$objDba 		= new Database();
$objDb 		= new Database();
$aSql = "Select * from activity where itemid=$itemid";
$objDb11->dbQuery($aSql);
$res_a=$objDb11->dbFetchArray();
$aid=$res_a['aid'];
$startdate=$res_a['startdate'];
$enddate=$res_a['enddate'];
$baseline=$res_a['baseline'];
$p_group=$parentgroup;

$eSqlr = "Select * from maindata where itemid=$itemid";
$q_ryr=$objDb4->dbQuery($eSqlr);
$res_sr=$objDb4->dbFetchArray();

	$itemid			=$res_sr['itemid'];
	$parentcd		=$res_sr['parentcd'];
	$parentgroup	=$res_sr['parentgroup'];
	$activitylevel  =$res_sr['activitylevel'];
	$stage			=$res_sr['stage'];
	$itemcode		=$res_sr['itemcode'];
	$itemname		=$res_sr['itemname'];
	$isentry  		=$res_sr['isentry'];
	$txtactivities	="";
	$txtresources	="";
	 $ar_list=explode("_",$parentgroup);
	
	$arr_size=$activitylevel-1;
	$itemids=0;
	  	  $planned_array = array();
	while($arr_size>=0)
	{
		$itemids=(int) $ar_list[$arr_size];
		
		 $pSql = "Select * from planned where itemid=$itemid";
		$planned_ry=$objDbp->dbQuery($pSql);
		while($res_planned=$objDbp->dbFetchArray())
		{
		
		$budgetdate=$res_planned["budgetdate"];
		$actual_qty=$res_planned["actual_qty"];
		$aaSql_child = "UPDATE activity0 SET  total_progress=total_progress-$actual_qty, commulative_progress=commulative_progress-$actual_qty where itemid=$itemids AND 
		budgetdate='$budgetdate'";
		
		$objDbaa->dbQuery($aaSql_child);
		}
   
   $arr_size--;
	}
	
	
$eSql_child2 = "delete from progress where itemid=$itemid";
    $objDb->dbQuery($eSql_child2);
	

}
removeProgress($itemid);
$sSQL = ("INSERT INTO progress (itemid, progressdate, progressqty) VALUES ($itemid,'$progressdate', $progress)");
	$objDb->dbQuery($sSQL);
	$msg="Updated!";
	
	$log_module  = $module." Module";
	$log_title   = "Updated ".$module." Record";
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
				
				<td><?php echo  $row3g['base_desc'];?></td>
				<?php
				}
				}
			}
			?>
			<td><?php echo $row3_c['startdate'];?></td>
			<td ><?php echo $row3_c['enddate'];?></td>
			<td><?php echo $row3_c['baseline'];?></td>
			<?php
			$sql_d="Select * from progress where itemid=$itm_id and left(progressdate,7)='$progressdate1' ";
			$res_d=$objDb1->dbQuery($sql_d);
			$row3_d=$objDb1->dbFetchArray();			
			$progressqty=$row3_d['progressqty'];
			$pgidd=$row3_d['pgid'];
			?>
			
			<td><input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  /><?php echo $progressqty;?></td>
			<?php if($objDb1->totalRecords( )>0)
			{
			?>
			
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data(<?php echo $pgidd; ?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
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
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data1(<?php echo $aid;?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?></td>
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