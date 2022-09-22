<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= MAINDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$mdata_flag			= $_SESSION['ne_mdata'];
	$mdataadm_flag		= $_SESSION['ne_mdataadm'];
	$mdataentry_flag	= $_SESSION['ne_mdataentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 

$itemid 				= $_REQUEST['itemid'];

//$objDb  = new Database( );
//@require_once("get_url.php");


?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                    <tr>
                       <th style="width:2%;"></th>
                        <th style="width:10%;"><?php echo "Code";?><span style="color:red;">*</span></th>
						<th style="width:20%;"><?php echo "Resource";?><span style="color:red;">*</span></th>
						 <th style="width:10%;"><?php echo "Start Date";?><span style="color:red;">*</span><br />(yyyy-mm-dd)</th>
						<th style="width:10%;"><?php echo "End Date";?><span style="color:red;">*</span><br />(yyyy-mm-dd)</th>
						 <th style="width:10%;"><?php echo "Actual Start Date";?><br />(yyyy-mm-dd)</th>
						<th style="width:10%;"><?php echo "Actual End Date";?><br />(yyyy-mm-dd)</th>
						 <th style="width:5%;"><?php echo "Order";?></th>
						<th style="width:5%;"><?php echo "Baseline";?><span style="color:red;">*</span></th>
						<th style="width:5%;"><?php echo "Weight";?><span style="color:red;">*</span></th>
						<th style="width:10%;"><?php echo "Remarks";?></th>
						<th style="width:3%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from activity where itemid=$itemid";
			$res_b=$objDb->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb->dbFetchArray())
			{
			$aid=$row3_b['aid'];
			?>
			
			<tr ><td><?php echo $i; ?></td>
			<td><?=$row3_b['code'];?></td>
			
			  <?php  
			 if($row3_b['rid']==0)
			{
			?>
			<td></td>
			<?php
			}
			else
			{     
			  
				 $sqlg="Select * from resources";
				$resg=$objDb->dbQuery($sqlg);
				while($row3g=$objDb->dbFetchArray())
				{
				if($row3g['rid']==$row3_b['rid'])
					{
							
				?>
				
				<td><?=$row3_b['secheduleid'].": ".$row3g['resource'];?></td>
				<?php
				}
				}
			}
			?>
			<td><?=$row3_b['startdate'];?></td>
			<td ><?=$row3_b['enddate'];?></td>
			<td ><?=$row3_b['actualstartdate'];?></td>
			<td><?=$row3_b['actualenddate'];?></td>
			<td><?=$row3_b['aorder'];?></td>
			<td><?=$row3_b['baseline'];?></td>
			<td><?=$row3_b['weight'];?></td>
			<td><?=$row3_b['remarks'];?></td>
			<td><?php  if($mdataentry_flag==1 || $mdataadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?>)"/>
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
