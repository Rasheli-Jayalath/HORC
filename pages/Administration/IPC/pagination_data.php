
<!-- 
Please note: this filter option is work upto level 4,  can have any number of levels, all other records will display after level4. 
 -->

<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "ADD_IPC";
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
    $pcd ='';

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 


$edit			= $_GET['edit'];

//@require_once("get_url.php");
$msg						= "";



?>

<?php

$per_page = 50;
if($_GET) {
	$page=$_GET['page'];
}
$start = ($page-1)*$per_page;

?>
<?php 
if($_GET['pcd']) {
	$pcd = $_GET['pcd']; 
}
?>

<table class="reference" style="width:100%">
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <th align="center" width="50%"><strong>Item Name</strong></th>
	  <th align="center" width="15%"><strong>Stage</span></strong></th>
	  <th align="center" width="15%"><strong>Item Code</strong></th>
	   <th align="center" width="15%"><strong>Isentry</strong></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reports"  onclick="group_checkbox();"/></strong></th>
	  	 
     </tr>

<?php
$sSQL = "";
if($_GET['pcd']) {
	$sqlCheck = "SELECT parentgroup, parentcd, activitylevel FROM boqdata where itemid= $pcd";	
	$objDb3->dbQuery($sqlCheck);
	$row = $objDb3->dbFetchArray();
	$pGroup = $row['parentgroup'];
	$oneParentcd = $row['parentcd'];
    $activitylevel = $row['activitylevel'];


	if($activitylevel==4){
		$aLevel1 =  substr($pGroup,0,13);
		$aLevel2 =  substr($pGroup,0,20);
		$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR parentgroup = '$aLevel1' OR parentgroup = '$aLevel2' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' AND stage='BOQ' and isentry=0  order by parentgroup, parentcd  limit $start,$per_page";
	}else if($activitylevel==3){
		$aLevel1 =  substr($pGroup,0,13);
		$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR parentgroup = '$aLevel1' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' AND stage='BOQ' and isentry=0 order by parentgroup, parentcd  limit $start,$per_page";
	}else{
		$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR itemid = $oneParentcd OR parentgroup LIKE '$pGroup%' AND stage='BOQ'and isentry=0  order by parentgroup, parentcd  limit $start,$per_page";

	}

}else{
	$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR stage='BOQ' and isentry=0  order by parentgroup, parentcd  limit $start,$per_page";
}
$sSQL; // this is necessary, dont remove this line.
		$sqlresult = $objDb->dbQuery($sSQL);
        $recordsCount = $objDb->totalRecords();
while ($data = $objDb->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	
	$cdsql2 = "select * from boqdata where itemid = ".$cdlist[0];
	$cdsqlresult12 = $objDb1->dbQuery($cdsql2);
	$cddata1 = $objDb1->dbFetchArray();
$itemname = $cddata1['itemname'];
		

				
?>

		<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from boqdata where stage='BOQ' and itemid = ".$cdlist[$items-1];
		$cdsqlresult = $objDb2->dbQuery($cdsql);
		$cddata = $objDb2->dbFetchArray();
		$itemid = $cddata['itemid'];
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
			<script>
function AddNewSizeProject<?php echo $itemid; ?>(){
	
   var count=0;
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:right; width:100px"/><input type="text" name="txtboqcode" id="txtboqcode"  size="25" style="text-align:right; width:100px"/>';
	var td3 = '<input type="text" name="txtboqitem" id="txtboqitem"  size="25" style="text-align:right; width:100px"/>';
	var td4 = '<input type="text" name="txtboqunit" id="txtboqunit"  size="25" style="text-align:right; width:100px"/>';
	var td6 = '<input type="text" name="txtboqqty"  id="txtboqqty"  size="25" style="text-align:right; width:100px"/>';
	
	<?php if($cur_1!="")
						  {?>
	var td8 = '<input type="text" name="boq_cur_1_rate" id="boq_cur_1_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php 
	}?>
	<?php if($cur_2!="")
						  {?>
	var td9 = '<input type="text" name="boq_cur_2_rate" id="boq_cur_2_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php }?>
	<?php if($cur_3!="")
						  {?>
	var td11 = '<input type="text" name="boq_cur_3_rate" id="boq_cur_3_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php }?>

	var td14 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	if(count==1)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td14);
	}
	if(count==2)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td9,td14);
	}
	if(count==3)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td9,td11,td14);
	}
	
	doAddTr(arrTds, 'tblPrdSizesProject<?php echo $itemid; ?>');
}
</script>
			
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
		<td rowspan="2"></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parentcd==0){	
			echo "<b>".$itemname."</b>";
			}
			else
			{
			echo $h.$cddata['itemname'];
		
			}
		  
		  
		   ?>
		</td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $cddata['itemcode'];?></td>
		<?php /*?><td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td><?php */?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $isentry1;?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">		</td>
		
		</tr>
		<tr>
		<td colspan="6">
			 <?php
		 $cdsql_a = "select * from boqdata where parentcd = '$cddata[itemid]' and isentry=1 and stage='BOQ'";
		$cdsqlresult_a = $objDb1->dbQuery($cdsql_a);
		if($objDb1->totalRecords()>0)
	
		{	
		?>
		
		
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
		
			var id=<?php echo $itemid; ?>;
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
			
			  xmlhttp3.open("GET","reloadipc.php?itemid="+id,true);
			  xmlhttp3.send();
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 
		 <div class="msg_list" style="display:inline">
		 <?php  
		 $sql_p="Select ipcid,left(ipcmonth,7) as ipcmmonth from ipc where status=0";
 		$res_p=$objDb2->dbQuery($sql_p);
		if($objDb2->totalRecords()>0)
		{
		 ?>
		  <div class="msg_head"  onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		  <?php
		  }
		  else
		  {
		  ?>
		 <div class="msg_head"  onclick="addipcmonth()">+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 <?php
		  }
		  ?>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 

	
			</div>	
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancel_data(<?php echo $itemid; ?>)" />
			  <?php
			  }
			  ?>

	</div>
		  </div>
		  <?php
		  }
		  ?>
		</td></tr>
		
	
	<?php        
			}
		
	?>

	</table>
    <h6 class="text-end mt-1"> Number of Records : <?php echo $recordsCount ?> </h6>