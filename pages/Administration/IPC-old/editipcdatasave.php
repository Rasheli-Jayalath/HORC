<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
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

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$boqid 					= $_REQUEST['boqid'];
$pid 					= $_REQUEST['pid'];
$itemid 				= $_REQUEST['itemid'];
$ipcid	 				= $_REQUEST['ipcid'];
$progressdate1 			= $_REQUEST['progressdate'];


//@require_once("get_url.php");
$eSqls = "Select * from project_currency ";
  $objDb -> dbQuery($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->totalRecords();
if($eeCount > 0){
	$eeRes1= $objDb->dbFetchArray();
  $cur_1_rate 				= $eeRes1['cur_1_rate'];
  $cur_2_rate 				= $eeRes1['cur_2_rate'];
  $cur_3_rate 				= $eeRes1['cur_3_rate'];
  $base_cur 				= $eeRes1['base_cur'];
  $cur_1 					= $eeRes1['cur_1'];
  $cur_2 					= $eeRes1['cur_2'];
  $cur_3 					= $eeRes1['cur_3'];
  
  }
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
			$res_b=$objDb1->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb1->dbFetchArray())
			{
				
			$itm_id=$row3_b['itemid'];	
			
			$sql_a="Select * from boq where itemid=$itm_id";
			$res_a=$objDb2->dbQuery($sql_a);
			$j=1;
			while($row3_a=$objDb2->dbFetchArray())
			{
			$boqidd=$row3_a['boqid'];
			?>
			
			<tr>
			<td><?php echo $row3_b['itemname']; ?></td>
			<td><?php echo $row3_a['boqcode']; ?></td>
			<td><?php echo $row3_a['boqitem']; ?></td>
			<td><?php echo $row3_a['boqunit']; ?></td>
			<td><?php echo $row3_a['boqqty']; ?></td>
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
			
			if($boqidd==$boqid)
			{
			$ipcqty="";
			?>
			
			<td>
			<input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  />			
			<input type="number" step="0.01" value="<?php echo $ipcqty;?>" name="txtprogress" id="txtprogress"  />
          <!--  <br/> Remarks: <input type="text" value="" name="remarks" id="remarks"  />-->
         <!--  <br/> Attachment: <input type="text" value="" name="attach_link" id="attach_link"  />--></td>			
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Update" name="save" id="save"  onclick="saveipc_data(<?php echo $pid;?>,<?php echo $boqidd;?>,<?php echo $ipcid;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			$sql_d="Select * from ipcv where boqid=$boqidd and ipcid=$ipcid";
			$res_d=$objDb->dbQuery($sql_d);
			$row3_d=$objDb->dbFetchArray();			
			$ipcqty=$row3_d['ipcqty'];
			$ipcvid=$row3_d['ipcvid'];
			?>
			
			<td><?php echo $ipcqty;?></td>
			<?php if($objDb->totalRecords()>0)
			{
			?>
			
			<td><?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?><input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
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
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data1(<?php echo $boqidd;?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
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
			$j=$j+1;
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>
