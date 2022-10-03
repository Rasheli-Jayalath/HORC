
<!-- 
Please note: this filter option is work upto level 4,  can have any number of levels, all other records will display after level4. 
 -->
 <?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "Add Progress";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
$objAdminUser   = new AdminUser();
$pcd ='';
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$spg_flag			= $_SESSION['ne_spg'];
	$spgadm_flag		= $_SESSION['ne_spgadm'];
	$spgentry_flag		= $_SESSION['ne_spgentry'];

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$edit			= $_GET['edit'];

//@require_once("get_url.php");
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$itemid						= $_REQUEST['txtitemid'];

$txtcode					= $_REQUEST['txtcode'];
$txtscheduleid				= $_REQUEST['txtscheduleid'];
$txtstartdate				= $_REQUEST['txtstartdate'];
$txtenddate					= $_REQUEST['txtenddate'];
$txtastartdate				= $_REQUEST['txtastartdate'];
$txtaenddate				= $_REQUEST['txtaenddate'];
$txtorder					= $_REQUEST['txtorder'];
$txtbaseline				= $_REQUEST['txtbaseline'];
$txtremarks				   = $_REQUEST['txtremarks'];
$temp_id=1;

if($clear!="")
{

$txtcode 					= '';
$txtscheduleid 				= '';
$txtstartdate				= '';
$txtenddate 				= '';
$txtastartdate 				= '';
$txtaenddate				= '';
$txtorder 					= '';
$txtbaseline 				= '';
$txtremarks					= '';

}




if($edit != ""){
 $eSql = "Select * from activity where aid=$edit";
  $objDb -> dbQuery($eSql);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$eRes = $objDb->dbFetchArray();
	  $code 					= $eRes['code'];
	  $secheduleid	 			= $eRes['secheduleid'];
	  $startdate				= $eRes['startdate'];
	  $enddate 					= $eRes['enddate'];
	  $actualstartdate 			= $eRes['actualstartdate'];
	  $actualenddate	 		= $eRes['actualenddate'];
	  $aorder					= $eRes['aorder'];
	  $baseline 				= $eRes['baseline'];
	  $remarks 					= $eRes['remarks'];
	 	
	}
}

if(isset($temp_id)&&$temp_id!="")
{
$btem="SELECT * FROM baseline_template WHERE temp_id=$temp_id";
			 $objDb2 -> dbQuery($btem);
			  $row3tmpg=$objDb2->dbFetchArray();
			  $temp_title=$row3tmpg["temp_title"];
}

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
	  <th align="center" width="15%"><span class="label">Stage</span></th>
	  <th align="center" width="15%"><span class="label">Item Code</span></th>
	  <th width="10%"><strong>Weight</strong></th>
	   <th align="center" width="10%"><span class="label">Isentry</span></th>
<!--      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reportsp"  onclick="group_checkbox();"/></strong></th>
-->		 
     </tr>
<?php


$sSQL = "";
if($_GET['pcd']) {
	$sqlCheck = "SELECT parentgroup, parentcd, activitylevel FROM maindata where itemid= $pcd";	
	// echo '<br>tuurr';
	// echo $sqlCheck ;
	// echo '<br>';
	$objDb3->dbQuery($sqlCheck);
	$row = $objDb3->dbFetchArray();
	$pGroup = $row['parentgroup'];
	$oneParentcd = $row['parentcd'];
    $activitylevel = $row['activitylevel'];


	if($activitylevel==4){
		$aLevel1 =  substr($pGroup,0,13);
		$aLevel2 =  substr($pGroup,0,20);
		$sSQL .= "SELECT * FROM maindata where  parentcd = 0 OR parentgroup = '$aLevel1' OR parentgroup = '$aLevel2' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%'  and isentry=0  order by parentgroup, parentcd  limit $start,$per_page";
	}else if($activitylevel==3){
		$aLevel1 =  substr($pGroup,0,13);
		$sSQL .= "SELECT * FROM maindata where  parentcd = 0 OR parentgroup = '$aLevel1' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%'  and isentry=0 order by parentgroup, parentcd  limit $start,$per_page";
	}else{
		$sSQL .= "SELECT * FROM maindata where   parentcd = 0 OR itemid = $oneParentcd OR parentgroup LIKE '$pGroup%' and isentry=0  order by parentgroup, parentcd  limit $start,$per_page";

	}

}else{
	$sSQL .= "SELECT * FROM maindata where   parentcd = 0 OR isentry=0  order by parentgroup, parentcd  limit $start,$per_page";
}
$sSQL; // this is necessary, dont remove this line.

		$sqlresult = $objDb2->dbQuery($sSQL);
        $recordsCount = $objDb2->totalRecords();


		// $sSQL = "SELECT * FROM maindata where  isentry=0 order by parentgroup, parentcd  limit $start,$per_page";
		// $sqlresult = $objDb2->dbQuery($sSQL);
while ($data = $objDb2->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from maindata where itemid = ".$cdlist[0];
	$cdsqlresult12 = $objDb1->dbQuery($cdsql2);
	$cddata1 = $objDb1->dbFetchArray();
	$itemname = $cddata1['itemname'];
	
				

				
?>
<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		 $cdsql = "select * from maindata where itemid = ".$cdlist[$items-1];
		$cdsqlresult = $objDb->dbQuery($cdsql);
		$cddata = $objDb->dbFetchArray();
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
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:right; width:100px"/><input type="text" name="txtcode" id="txtcode"  size="25" style="text-align:right; width:100px"/>';
	var td4 = '<input type="text" name="txtstartdate" id="txtstartdate" onClick=add_sd("txtstartdate");  size="25" style="text-align:right; width:100px" />';
                                   
	var td5 = '<input type="text" name="txtenddate" id="txtenddate" onClick=add_ed("txtenddate"); size="25" style="text-align:right; width:100px"/>';
	var td6 = '<input type="text" name="txtastartdate" id="txtastartdate" onClick=add_asd("txtastartdate"); size="25" style="text-align:right; width:100px"/>';
	var td7 = '<input type="text" name="txtaenddate"  id="txtaenddate"  onClick=add_aed("txtaenddate"); size="25" style="text-align:right; width:100px"/>';
	var td8 = '<input type="text" name="txtorder"  id="txtorder"  size="25" style="text-align:right; width:100px"/>';
	var td9 = '<input type="text" name="txtbaseline" id="txtbaseline"  size="25" style="text-align:right; width:100px"/>';
	var td10 = '<input type="text" name="txtweight" id="txtweight"  size="25" style="text-align:right; width:100px"/>';
	var td11 = '<input type="text" name="txtremarks" id="txtremarks"  size="25" style="text-align:right; width:100px"/>';
	var td12 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
	var td3 = '<select name="txtscheduleid" id="txtscheduleid" style="width:70px">' + "\n";

	
	<?php 
	 $sqlg="Select * from baseline where temp_id=$temp_id";
			$resg=$objDb1->dbQuery($sqlg);
			while($row3g=$objDb1->dbFetchArray())
			{
			?>
	td3 	+= "\t" + '<option value="<?php echo $row3g['rid'];?>"><?php echo $row3g['base_desc'];?></option>' + "\n";
	<?php }?>
	
	td3 	+= '</select>' + "\n";
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	var arrTds = new Array(td1, td2, td3,td4, td5, td6,td7, td8, td9,td10,td11,td12);
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
			<td style=" font-size:12px; color: #000000; background-color: <?php echo $colorr; ?>">
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
		<td style=" font-size:12px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td>
		<td style=" font-size:12px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<td style=" font-size:12px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td>
		<td style=" font-size:12px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
<!--		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reportsp" onclick="group_checkbox();">		</td>
-->		
		</tr>
<tr>
		<td colspan="8">
			 <?php
		$cdsql_a = "select * from maindata where parentcd = '$cddata[itemid]' and isentry=1 ";
		$cdsqlresult_a = $objDb->dbQuery($cdsql_a);
		if($objDb->totalRecords()>0)
			 
	/*if($cddata['isentry']==1)*/
		{	
		?> 
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
		
			var id=<?php echo $itemid; ?>;
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
					document.getElementById("addnew"+id).style.display="block";
					
				 // document.getElementById("search").style.border="1px solid #A5ACB2";
				  
				
				 
				}
			  }
			
			  xmlhttp3.open("GET","reloadprogress.php?itemid="+id+"&temp_id="+temp_id,true);
			  xmlhttp3.send();
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 
			</div>	
			 		
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php  if($spgentry_flag==1 || $spgadm_flag==1)
				{
				?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancelp_data(<?php echo $itemid; ?>)" />
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