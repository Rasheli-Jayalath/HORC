<!-- 
Please note: this filter option is work upto level 4,  can have any number of levels, all other records will display after level4. 
 -->

<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= BOQDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb5 		= new Database();
$objDb8 		= new Database();
$objAdminUser   = new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$user_type=$_SESSION['ne_user_type'];
$uname 	= $_SESSION['ne_username'];
$boq_flag			= $_SESSION['ne_boq'];
	$boqadm_flag		= $_SESSION['ne_boqadm'];
	$boqentry_flag		= $_SESSION['ne_boqentry'];
	$pcd ='';

if ($uname==null  ) {
header("Location: ../../index.php?init=3");
} 
$edit			= $_GET['edit'];
/*$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}
$objDb  		= new Database( );
@require_once("get_url.php");*/
$msg						= "";
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
		$sq="Update boqdata SET aorder='".$aorder_list[$i]."' WHERE itemid=".$item_list[$i];
		$objDb->dbQuery($sq);
	}
	$msg= "Order has been updated";
	}
	
}
$eSqls = "Select * from project_currency ";
  $objDb -> dbQuery($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->totalRecords();
	if($eeCount > 0){
		$res_e=$objDb->dbFetchArray();
	  $cur_1_rate 					= $res_e['cur_1_rate'];
	  $cur_2_rate 					= $res_e['cur_2_rate'];
	  $cur_3_rate 					= $res_e['cur_3_rate'];
	  $base_cur 				= $res_e['base_cur'];
	  $cur_1 					= $res_e['cur_1'];
	  $cur_2 					= $res_e['cur_2'];
	  $cur_3 					= $res_e['cur_3'];
	  
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
      <?php
	   if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
      <th align="center" width="50%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  else
	  {
	  ?>
	   <th align="center" width="70%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  ?>
	 <!-- <th align="center" width="5%"><strong>Stage</span></strong></th>-->
	  <th align="center" width="10%"><strong><?php echo CODE;?></strong></th>
	<!--  <th width="5%"><strong>Weight</strong></th>-->
	   <th align="center" width="5%"><strong><?php echo IS_ENTRY;?></strong></th>
            
      
	  <?php
	 if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
	   <th align="center" width="30%"><strong><?php echo ACTION;?>
     </strong></th>
	 <?php
	 }
	 ?>
	<!-- <th align="center" width="5%"><strong><?php echo LOG;?>-->
     </strong></th>
	 
     </tr>

<?php
$sSQL = "";
if($_GET['pcd']) {
	$sqlCheck = "SELECT parentgroup, parentcd, activitylevel FROM boqdata where itemid= $pcd";	
	$objDb8->dbQuery($sqlCheck);
	$row = $objDb8->dbFetchArray();
	$pGroup = $row['parentgroup'];
	$oneParentcd = $row['parentcd'];
	$activitylevel = $row['activitylevel'];

	if($activitylevel==4){
		$aLevel1 =  substr($pGroup,0,13);
		$aLevel2 =  substr($pGroup,0,20);
		$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR parentgroup = '$aLevel1' OR parentgroup = '$aLevel2' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' AND stage='BOQ' order by parentgroup, parentcd  limit $start,$per_page";
	}else if($activitylevel==3){
		$aLevel1 =  substr($pGroup,0,13);
		$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR parentgroup = '$aLevel1' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' AND stage='BOQ' order by parentgroup, parentcd  limit $start,$per_page";
	}else{
		$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR  itemid = $oneParentcd OR parentgroup LIKE '$pGroup%' AND stage='BOQ' order by parentgroup, parentcd  limit $start,$per_page";
	
	}


}else{
	$sSQL .= "SELECT * FROM boqdata where  parentcd = 0 OR stage='BOQ' order by parentgroup, parentcd  limit $start,$per_page";
}
    $sSQL;     // this is necessary, dont remove this line. 
	$sqlresult = $objDb5->dbQuery($sSQL);
	$recordsCount = $objDb5->totalRecords();
while ($data = $objDb5->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$aorder = $data['aorder'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from boqdata where itemid = ".$cdlist[0];
	$cdsqlresult12 = $objDb->dbQuery($cdsql2);
	$cddata1 = $objDb->dbFetchArray();
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
				$isentry1=NO;
				}
				else
				{
				$isentry1=YES;
				}

			?>
			<script>
function AddNewSizeProject<?php echo $itemid; ?>(){

    var count=0;
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:left; width:100px"/><input type="text" name="txtboqcode" id="txtboqcode"  size="25" style="text-align:left; width:100px"/>';
	var td3 = '<input type="text" name="txtboqitem" id="txtboqitem"  size="25" style="text-align:left; width:200px"/>';
	var td4 = '<input type="text" name="txtboqunit" id="txtboqunit"  size="25" style="text-align:left; width:100px"/>';
	var td6 = '<input type="text" name="txtboqqty"  id="txtboqqty"  size="25" style="text-align:left; width:100px"/>';
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
	var td14 = '<input type="button" id="save" name="save" value="Save"  onClick=add_data(txtitemid.value); />'
	
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
        <input type="hidden" id="itemid[]" name="itemid[]" value="<?php echo $itemid;?>" />
		<?php /*?><td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td><?php */?>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<?php /*?><td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td><?php */?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
         
		<?php 
		if($stage=='BOQ' && $activitylevel==0)
		{
		$editlink='boq.php';
		$redirect="subboq.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubBOQ";
		}
		else if($stage=='BOQ' && $activitylevel>0)
		{
		$editlink='subboq.php';
		$redirect="subboq.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubBOQ";
		}
		$deletelink='subboq.php';
		  ?>
		<?php
		if($boqentry_flag==1 || $boqadm_flag==1)
		{
		?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
	
		<?php if($cddata['isentry']==0)
		{	
		?>
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=450,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		 <?php
		 }?>
		 	<?php  if($stage=='BOQ' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=450,scrollbars=yes');" >Edit</a> 
		<?php
		if($boqadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this BOQ and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=450,scrollbars=yes');" >Edit</a>
		<?php
		if($boqadm_flag==1)
		{
		?>
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this BOQ and all of its child?')">Delete</a><?php } } ?>
		
		 	 </td>
			 <?php
			 }
			 ?>
		<!-- <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="logboq.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" ><?php echo LOG;?></a>
	
		 </td>-->
	
		</tr>
		<tr>
		<td colspan="8">
			 <?php
	if($cddata['isentry']==1)
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
					document.getElementById("addnew"+id).style.display="block";
					
				 // document.getElementById("search").style.border="1px solid #A5ACB2";
				  
				
				 
				}
			  }
			
			  xmlhttp3.open("GET","reloadboq.php?itemid="+id,true);
			  xmlhttp3.send();
			
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext"><?php echo ADD_DATA;?></span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 

			</div>	
			 <?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			 <div id="addnew<?php echo $itemid; ?>" style="float:right;">
			 <a onClick="AddNewSizeProject<?php echo $itemid; ?>();" href="javascript:void(null);"><?php echo ADD_NEW;?></a></div>
			 <?php
			 }
			 ?>
			
			  <input type="button" value="<?php echo CLOSE;?>" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			  <input type="button" value="<?php echo CANCEL;?>" name="cancel" id="cancel" onclick="cancel_data(<?php echo $itemid; ?>)" />
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
	<h6 class="text-end  mt-1"> Number of Records : <?php echo $recordsCount ?> </h6>