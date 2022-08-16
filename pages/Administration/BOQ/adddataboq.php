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
$boq_flag			= $_SESSION['ne_boq'];
	$boqadm_flag		= $_SESSION['ne_boqadm'];
	$boqentry_flag		= $_SESSION['ne_boqentry'];
//@require_once("get_url.php");
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$itemid 				= $_REQUEST['itemid'];
$boqcode	 			= $_REQUEST['boqcode'];
$boqitem 				= $_REQUEST['boqitem'];
$boqunit				= $_REQUEST['boqunit'];
$boqqty					= $_REQUEST['boqqty'];
$boq_cur_1_rate			= $_REQUEST['boq_cur_1_rate'];
$boqamount=$boqqty*$boq_cur_1_rate;
$boq_cur_2_rate			= $_REQUEST['boq_cur_2_rate'];
$boqfamount =$boqqty*$boq_cur_2_rate;
$boq_cur_3_rate			= $_REQUEST['boq_cur_3_rate'];


$eSqls = "Select * from project_currency ";
  $objDb -> dbQuery($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->totalRecords();
if($eeCount > 0){
	 $abc_res = $objDb->dbFetchArray();
  $cur_1_rate 					= $abc_res['cur_1_rate'];
  $cur_2_rate 					= $abc_res['cur_2_rate'];
  $cur_3_rate 					= $abc_res['cur_3_rate'];
  $base_cur 				= $abc_res['base_cur'];
   $cur_1 					= $abc_res['cur_1'];
  $cur_2 					= $abc_res['cur_2'];
  $cur_3 					= $abc_res['cur_3'];
  
  }
	
	$boqcurrrate=0;	
	$boqfrate=0;
		
 $sSQL = ("INSERT INTO boq (itemid,  boqcode,  boqitem, boqunit, boq_base_currency, boqqty, boq_cur_1,cur_1_exchrate,boq_cur_1_rate,boq_cur_2,cur_2_exchrate,boq_cur_2_rate,boq_cur_3,
cur_3_exchrate,boq_cur_3_rate) VALUES ($itemid,'$boqcode', '$boqitem','$boqunit','$base_cur',$boqqty,'$cur_1','$cur_1_rate', '$boq_cur_1_rate','$cur_2',$cur_2_rate, '$boq_cur_2_rate','$cur_3','$cur_3_rate','0')");
	$objDb1->dbQuery($sSQL);
	//echo $sSQL = ("INSERT INTO boq (itemid,  boqcode,  boqitem, boqunit, boqrate, boqqty, boqamount, boqcurrency,boqcurrrate, boqfamount,boqfcurrency,boqfrate,boqfcurrate) VALUES ($itemid,'$boqcode', '$boqitem','$boqunit', $boq_cur_1_rate,$boqqty,$boqamount,'$base_cur',$boqcurrrate,$boqfamount,'$cur_2',$boqfrate,$boq_cur_2_rate)");
	//$objDb1->dbQuery($sSQL);

	$txtid = $con->lastInsertId();
	$boqid = $txtid;	
	$msg="Saved!";
	
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	//$sSQL = ("INSERT INTO boq_log (log_module,log_title,log_ip, itemid,  boqcode,  boqitem, boqunit, boqrate, boqqty, boqamount, boqcurrency,boqcurrrate, boqfamount,boqfcurrency,boqfrate,boqfcurrate,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$boqcode', '$boqitem','$boqunit', $boqrate,$boqqty,$boqamount,'$boqcurrency',$boqcurrrate,$boqfamount,'$boqfcurrency',$boqfrate,$boqfcurrate,$boqid)");
	//$objDb->execute($sSQL);

?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                     <tr>
                        <th style="width:2%;"></th>
                        <th style="width:5%;"><?php echo "Code";?><span style="color:red;">*</span></th>
						<th style="width:15%;"><?php echo "Item";?><span style="color:red;">*</span></th>
						 <th style="width:5%;"><?php echo "Unit";?><span style="color:red;">*</span></th>
						
						 <th style="width:5%;"><?php echo "Quantity";?><span style="color:red;">*</span></th>
						<?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Rate<span style="color:red;">*</span>&nbsp;<?php if($cur_1==$base_cur) { echo "<br/>(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_1_rate.")";}?></th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Rate<span style="color:red;">*</span>&nbsp;<?php if($cur_2==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_2_rate.")";}?></th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Rate<span style="color:red;">*</span>&nbsp;<?php if($cur_3==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_3_rate.")";}?></th>
						<?php }?>
						<th style="width:3%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php    $sql_a="Select * from boq where itemid=$itemid";
			$res_a=$objDb1->dbQuery($sql_a);
			$i=1;
			while($row3_a=$objDb1->dbFetchArray())
			{
			$boqid=$row3_a['boqid'];
		
			?>
			
			<tr><td><?php echo $i; ?></td>
			<td><?php echo $row3_a['boqcode'];?></td>
			<td><?php echo $row3_a['boqitem'];?></td>
			<td><?php echo $row3_a['boqunit'];?></td>
			<td ><?php echo $row3_a['boqqty'];?></td>
			  <?php if($cur_1!="")
						  {
							  ?>
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
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $boqid;?>,<?php echo $itemid;?> )"/></td>
			</tr>
			<?php
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>
