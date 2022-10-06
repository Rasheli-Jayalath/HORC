<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= KPIDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
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
$edit			= $_GET['edit'];

//@require_once("get_url.php");
$msg						= "";

$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$kpiid						= $_REQUEST['txtitemid'];
$act_s						= $_REQUEST['act'];
//$length=count($act_s);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$aorder_list=$_POST["aorder"];
	$item_list=$_POST["itemid"];
	$size_l=sizeof($item_list);
	$size_a=sizeof($aorder_list);
	$msg="";
	if($size_l==$size_a)
	{
	for($i=0; $i<$size_a;$i++)
	{
		$sq="Update kpidata SET aorder='".$aorder_list[$i]."' WHERE itemid=".$item_list[$i];
		$objDb->dbQuery($sq);
	}
	$msg= "Order has been updated";
	}
	
}



?>

<?php

$per_page = 50;
if($_GET) {
	$page=$_GET['page'];
}
$start = ($page-1)*$per_page;

?>


<table class="reference" style="width:100%;  ">
       <tr style="text-decoration:inherit; color:#CCC; background-color:#333333">
	  
      <th align="center" width="50%"><strong>KPI Name</strong></th>
	  <th align="center" width="5%"><strong>KPI Code</strong></th>
	  <th width="5%"><strong>Weight</strong></th>
	   <th align="center" width="5%"><strong>Isentry</strong></th>
      <?php
	   if($kpientry_flag==1 || $kpiadm_flag==1)
	{
	?>
	   <th align="center" width="20%"><strong>Action
     </strong></th>
	 <?php
	 }
	 ?>
     </tr>
<?php $btem="Select * from kpi_templates where 	is_active=1";
			  $resbtemp=$objDb1->dbQuery($btem);
			   $rowsnum=$objDb1->totalRecords();
			   $row3tmpg=$objDb1->dbFetchArray();
			  $temp_id=$row3tmpg["temp_id"];
			?>
            
            <?php 
if(isset($row3tmpg["kpi_temp_id"])&&$row3tmpg["kpi_temp_id"]!=""&&$row3tmpg["kpi_temp_id"]!=0)
{
$sSQL = "SELECT * FROM kpidata where 	kpi_temp_id=".$row3tmpg["kpi_temp_id"]." order by aorder limit $start,$per_page";
		$sqlresult = $objDb->dbQuery($sSQL);
while ($data = $objDb->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$aorder = $data['aorder'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from kpidata where kpiid = ".$cdlist[0];
	$cdsqlresult12 = $objDb1->dbQuery($cdsql2);
	$cddata1 = $objDb1->dbFetchArray();
	$itemname = $cddata1['itemname'];
		
?>
<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from kpidata where kpiid = ".$cdlist[$items-1];
		$cdsqlresult = $objDb2->dbQuery($cdsql);
		$cddata = $objDb2->dbFetchArray();
		$kpiid = $cddata['kpiid'];
		$parentcd = $cddata['parentcd'];
		$stage=$cddata['stage'];
		$activitylevel=$cddata['activitylevel'];
		if($cddata['isentry']==0)
				{
				$isentry1="No";
				}
				else
				{
				$isentry1="Yes";
				}

			?>
			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>">
			  <?php
		/*	if($parentcd==0){	
			echo "<b>".$itemname."</b>";
			}
			else
			{*/
			echo $h.$cddata['itemname'];
			//}
		   ?>
		    </td>
        <input type="hidden" id="itemid[]" name="itemid[]" value="<?php echo $kpiid;?>" />
		<?php /*?><td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td><?php */?>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $cddata['itemcode'];?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?php echo $cddata['weight'];?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $isentry1;?></td>
       <?php /*?> <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input type="text" value="<?php echo $aorder;?>"  id="aorder[]" name="aorder[]" style="width:25px"/></td><?php */?>
		<?php 
		if($activitylevel>=0)
		{ 
		$editlink='subkpi.php';
		$redirect="subkpi.php?subaid=$kpiid&levelid=$activitylevel";
		$redirect_title="Add SubKPI"; 
		}
/*	   else if($stage=='KPI' && $activitylevel==0)
		{
		$editlink='strategic_goal_kpi.php';
		$redirect="outcome_kpi.php?item=$kpiid";
		$redirect_title="Add Outcome";
		}
		else if($stage=='KPI' && $activitylevel==1)
		{
		$editlink='outcome_kpi.php';
		$redirect="output_kpi.php?item=$kpiid";
		$redirect_title="Add Output";
		}
		else if($stage=='KPI' && $activitylevel==2)
		{
		$editlink='output_kpi.php';
		$redirect="kpi.php?item=$kpiid";
		$redirect_title="Add KPI";
		}
		else if($stage=='KPI' && $activitylevel=3)
		{
		$editlink='kpi.php';
		$redirect="subkpi.php?subaid=$kpiid&levelid=$activitylevel";
		$redirect_title="Add SubKPI";
		}*/
		
			//echo $activitylevel;
		$deletelink='subkpi.php';
		  ?>
		
		<?php
	  if($kpientry_flag==1 || $kpiadm_flag==1)
	{
	?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		
		<?php if($cddata['isentry']==0)
		{	
		?>
		  		  
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		 <?php
		 }?>
		 <?php  if($stage=='KPI' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $kpiid;?>&item=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$kpiid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($kpiadm_flag==1)
		{
		?>
		
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $kpiid;?>"   onclick="return confirm('Are you sure you want to delete this KPI and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $kpiid;?>&item=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel;?>', '<?php echo "Edit ".$kpiid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($kpiadm_flag==1)
		{
		?>
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $kpiid;?>" onclick="return confirm('Are you sure you want to delete this KPI and all of its child?')">Delete</a><?php } } ?>
		
		 	 </td>
			 <?php
			 }
			 ?>
		<?php /*?> <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="logkpi.php?trans_id=<?php echo $kpiid ; ?>&module=<?php echo $module?>" target="_blank">Log</a>
	
		 </td><?php */?>
	
		</tr>	
        
        <tr>
		<td colspan="7">
			 <?php
	if($cddata['isentry']==1)
		{	
		?>
		<script>
		function callmsgbody<?php echo $kpiid; ?>()
		{
		var id=<?php echo $kpiid; ?>;
		var temp_id=<?php echo $temp_id; ?>;
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp3=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
			xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
		  }

  		xmlhttp3.onreadystatechange=function() {
    	if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
      	document.getElementById("abc"+id).innerHTML=xmlhttp3.responseText;
		}
  		}
    
	  xmlhttp3.open("GET","reloadkpi.php?kpiid="+id+"&temp_id="+temp_id,true);
	  xmlhttp3.send();

	$('div[class^="msg_body"]').not('.msg_body<?php echo $kpiid;?>').hide();
	$(".msg_body<?php echo $kpiid;?>").show(); 
	$(this).next(".msg_body<?php echo $kpiid;?>").slideToggle(600);
		}

		</script> 
		
		 <div class="msg_list" style="display:inline;">
		    <div class="msg_head" onclick="callmsgbody<?php echo $kpiid; ?>()" >+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $kpiid;?>" style="display:none" >
		 	<div id="abc<?php echo $kpiid;?>"> 
	

	
			</div>	
					
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $kpiid;?>)" />
			  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancel_data(<?php echo $kpiid;?>)" />
			  <?php
			  }
			  ?>

	</div>
		 </div>
		  <?php
		  }
		  ?>
		</td>
		</tr>	


		
		
		
	
	<?php        
			}
}
else
{?>

<tr><tr><td colspan="12"> <?php echo $msg="Please Add KPI Template"; ?> </td></tr>
<?php }
	?>

	</table>