<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module="Update IPC Entry";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$ipc_flag			= $_SESSION['ne_ipc'];
	$ipcadm_flag		= $_SESSION['ne_ipcadm'];
	$ipcentry_flag		= $_SESSION['ne_ipcentry'];


$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$ipcvid 				= $_REQUEST['ipcvid'];
$pid 					= $_REQUEST['pid'];
$boqid 					= $_REQUEST['boqid'];
$ipcid	 				= $_REQUEST['ipcid'];
$progress 				= $_REQUEST['progress'];
$progressdate1 			= $_REQUEST['progressdate'];
//$remarks 			= $_REQUEST['remarks'];
//$attach_link 		= $_REQUEST['attach_link'];
$progressdate=$progressdate1."-01";

//@require_once("get_url.php");
$eSqls = "Select * from project_currency ";
  $objDb -> dbQuery($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->totalRecords();
if($eeCount > 0){
	$eeRes = $objDb->dbFetchArray();
  $cur_1_rate 					= $eeRes['cur_1_rate'];
  $cur_2_rate 					= $eeRes['cur_2_rate'];
  $cur_3_rate 					= $eeRes['cur_3_rate'];
  $base_cur 				= $eeRes['base_cur'];
  $cur_1 					= $eeRes['cur_1'];
  $cur_2 					= $eeRes['cur_2'];
  $cur_3 					= $eeRes['cur_3'];
  
  }
//$file_path="project_data";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}

	
  if($progress =="")
  {
	$progress=0;
  }
  else{
	$progress=$progress;
  }
  $sSQL = "UPDATE ipcv SET
		ipcqty			=$progress
		where ipcvid=$ipcvid and ipcid=$ipcid and boqid=$boqid";  
	$objDb1->dbQuery($sSQL);
	$msg="Updated!";
	
	$sql_p="Select lid,ipcid,left(ipcmonth,7) as ipcmmonth from ipc where status=0";
 $res_p=$objDb1->dbQuery($sql_p);
 $row3_p=$objDb1->dbFetchArray();
$ipcmonth=$row3_p['ipcmmonth'];
$ipcid=$row3_p['ipcid'];
$lid=$row3_p['lid'];
  $sql_iip="Select itemname from boqdata where itemid=".$lid;
			$res_bc=$objDb3->dbQuery($sql_iip);
			$row3_bc=$objDb3->dbFetchArray();
			 $itemname=$row3_bc['itemname'];
			
			

			 $sql_pn="Select parentgroup from boqdata where parentcd=$pid and isentry=1 limit 0,1";
			$res_pn=$objDb1->dbQuery($sql_pn);
			$row3_pn=$objDb1->dbFetchArray();
			$pgroup_pn=$row3_pn['parentgroup'];	
			$arr_pn=explode("_",$pgroup_pn);
			 $item_pn=$arr_pn[1];
			 $item_pn = ltrim($item_pn, "0");
			$sql_pn1="Select itemname from boqdata where itemid=$item_pn";
			$res_pn1=$objDb2->dbQuery($sql_pn1);
			$row3_pn1=$objDb2->dbFetchArray();

?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                        <th style="width:5%;"></th>
                        <th style="width:5%;"><?php echo "Code";?></th>
						<th style="width:15%;"><?php echo "Item";?></th>
						 <th style="width:5%;"><?php echo "Unit";?></th>
						 <th style="width:5%;"><?php echo "Quantity";?></th>
							<?php if($cur_1!="")
                                  {?>
                                 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Rate&nbsp;<?php if($cur_1==$base_cur) { echo "<br/>(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_1_rate.")";}?></th>
                                <?php }?>
                                   <?php if($cur_2!="")
                                  {?>
                                 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Rate&nbsp;<?php if($cur_2==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_2_rate.")";}?></th>
                                <?php }?>
                                   <?php if($cur_3!="")
                                  {?>
                                 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Rate&nbsp;<?php if($cur_3==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_3_rate.")";}?></th>
                                <?php }?>
						<th style="width:15%;"><?php echo "IPC As on ".$ipcmonth?><?php if($lid==$item_pn) { echo " <span style='color:white; background-color:green'>(Active)</span>"; } else { echo " <span style='color:white; background-color:red'>(Inactive) </span>"; }?> <?php echo "<br/> Package Name:  ".$row3_pn1['itemname'];?> </th>
						<th style="width:5%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from boqdata where parentcd=$pid and isentry=1";
			$res_b=$objDb2 -> dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb2 -> dbFetchArray())
			{
			$itm_id=$row3_b['itemid'];
			$sql_a="Select * from boq where itemid=$itm_id";
			$res_a=$objDb -> dbQuery($sql_a);
			$j=1;
			while($row3_a=$objDb -> dbFetchArray())
			{
			$boqid=$row3_a['boqid'];
			?>
			
			<tr >
			
			<td><?php echo $row3_b['itemname']; ?></td>
			<td><?php echo $row3_a['boqcode'];?></td>
			<td><?php echo $row3_a['boqitem'];?></td>
			<td><?php echo $row3_a['boqunit'];?></td>
			<td><?php echo $row3_a['boqqty'];?></td>
	         <?php if($cur_1!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_1_rate'];?></td>
            <?php }?>
             <?php if($cur_2!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_2_rate'];?></td>
            <?php }?>
             <?php if($cur_3!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_3_rate'];?></td>
            <?php }?>
			<?php
			$sql_d="Select * from ipcv where boqid=$boqid and ipcid=$ipcid";
			$res_d=$objDb1 -> dbQuery($sql_d);
			$row3_d=$objDb1 -> dbFetchArray();			
			$ipcqty=$row3_d['ipcqty'];
			$ipcvid=$row3_d['ipcvid'];
			//$ipcremarks=$row3_d['remarks'];
			//$ipcattach_link=$row3_d['attach_link'];
			?>
			
			
			
			
		<input type="hidden" value="<?php echo $progressdate1 ;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $ipcqty;
			/*echo "<br/>";
			echo $ipcremarks;
			echo "<br/>";
			echo $ipcattach_link;*/?></td>
			<?php if($objDb1 -> totalRecords()>0)
			{
			?>
			
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			?>
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data1(<?php echo $boqid;?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			
			?>
			</tr>
		
			<?php
			$j=$j+1;
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>