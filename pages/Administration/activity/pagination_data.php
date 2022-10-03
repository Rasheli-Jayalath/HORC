<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
//$module		= MAINDATA;
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();
$objDb2  		= new Database();
$objDb3  		= new Database();
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

/*error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
if ($uname==null  ) {
header("Location: index.php?init=3");
}*/ 
$edit			= $_GET['edit'];
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
/*if (!empty($_GET["language"])) { //<!-- see this line. checks 
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
@require_once("get_url.php");
*/$msg						= "";

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

if($saveBtn != "")
{

if(count($txtcode) >= 1){
			
				for($i = 0; $i < count($txtcode); $i++){

 $sSQL = ("INSERT INTO activity (itemid,  code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks) VALUES ($itemid,'$txtcode[$i]', '$txtscheduleid[$i]','$txtstartdate[$i]', '$txtenddate[$i]','$txtastartdate[$i]','$txtaenddate[$i]',$txtorder[$i],$txtbaseline[$i],'$txtremarks[$i]')");
	$objDb->dbQuery($sSQL);
	$txtid = $con->lastInsertId();
	$aid = $txtid;
	
	$msg="Saved!";
		}
					}
 
}

if($updateBtn !=""){
	
 $uSql = "Update activity SET 
			
			 code         		= '$txtcode',
			 secheduleid  		= '$txtscheduleid',
			 startdate			= '$txtstartdate',
			 enddate        	= '$txtenddate',
			 actualstartdate  	= '$txtastartdate',
			 actualenddate		= '$txtaenddate',
			 aorder        		= $txtorder,
			 baseline  			= $txtbaseline,
			 remarks			= '$txtremarks'			
			where aid 			= $edit ";
		  
 	if($objDb->dbQuery($uSql)){
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL2 = ("INSERT INTO activity_log (log_module,log_title,log_ip, itemid, code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$txtcode', '$txtscheduleid','$txtstartdate', '$txtenddate','$txtastartdate','$txtaenddate',$txtorder,$txtbaseline,'$txtremarks',$edit)");
	$objDb->dbQuery($sSQL2);
	

		
		
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
	header("location: activityentry.php?subaid=".$itemid);

}

if($edit != ""){
 $eSql = "Select * from activity where aid=$edit";
  $objDb -> dbQuery($eSql);
  $eCount = $objDb->totalRecords();
	if($eCount > 0){
		$res_e=$objDb->dbFetchArray();
	  $code 					= $res_e['code'];
	  $secheduleid	 			= $res_e['secheduleid'];
	  $startdate				= $res_e['startdate'];
	  $enddate 					= $res_e['enddate'];
	  $actualstartdate 			= $res_e['actualstartdate'];
	  $actualenddate	 		= $res_e['actualenddate'];
	  $aorder					= $res_e['aorder'];
	  $baseline 				= $res_e['baseline'];
	  $remarks 					= $res_e['remarks'];
	 	
	}
}
$temp_id=1;
/*$btem="SELECT * FROM `baseline_template` WHERE temp_is_default=1";
			  $resbtemp=mysql_query($btem);
			  $row3tmpg=mysql_fetch_array($resbtemp);
			  $temp_id=$row3tmpg["temp_id"];*/
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





<table class="reference" style="width:100%" > 
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <?php
	  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
      <th width="30%" style="text-align:center; vertical-align:middle"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  else
	  {
	  ?>
	   <th style="text-align:center; vertical-align:middle" width="50%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  ?>
	  <th style="text-align:center; vertical-align:middle" width="5%"><span class="label"><?php echo CODE;?></span></th>
	  <th style="text-align:center; vertical-align:middle" width="5%"><span class="label"></span><?php echo IS_ENTRY; ?></span></th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><span class="label"><?php echo RESOURCE;?></span></th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><?php echo START;?> <br />(yyyy-mm-dd)</th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><?php echo END;?> <br />(yyyy-mm-dd)</th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><?php echo AVAILED;?></th>
     <!-- <th style="text-align:center; vertical-align:middle" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reports"  onclick="group_checkbox();"/></strong></th>-->
	    <?php
	  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
	   <th style="text-align:center; vertical-align:middle" width="20%"><?php echo ACTION; ?>
  </th>
	 <?php
	 }
	 ?>
	<!-- <th style="text-align:center; vertical-align:middle" width="2%"><?php echo LOG;?>
     </th>-->
	 
     </tr>

<?php




$sSQL = "";
if($_GET['pcd']) {
	$sqlCheck = "SELECT parentgroup, parentcd, activitylevel FROM maindata where itemid= $pcd";	
	$objDb3->dbQuery($sqlCheck);
	$row = $objDb3->dbFetchArray();
	$pGroup = $row['parentgroup'];
	$oneParentcd = $row['parentcd'];
    $activitylevel = $row['activitylevel'];


	if($activitylevel==4){
		$aLevel1 =  substr($pGroup,0,13);
		$aLevel2 =  substr($pGroup,0,20);
		$sSQL .= "SELECT * FROM maindata where  parentcd = 0 OR parentgroup = '$aLevel1' OR parentgroup = '$aLevel2' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%' order by parentgroup, parentcd  limit $start,$per_page";
	}else if($activitylevel==3){
		$aLevel1 =  substr($pGroup,0,13);
		$sSQL .= "SELECT * FROM maindata where  parentcd = 0 OR parentgroup = '$aLevel1' OR itemid = $oneParentcd  OR parentgroup LIKE '$pGroup%'  order by parentgroup, parentcd  limit $start,$per_page";
	}else{
		$sSQL .= "SELECT * FROM maindata where   parentcd = 0 OR itemid = $oneParentcd OR parentgroup LIKE '$pGroup%'  order by parentgroup, parentcd  limit $start,$per_page";

	}

}else{
	$sSQL .= "SELECT * FROM maindata order by parentgroup, parentcd  limit $start,$per_page";
}
$sSQL; // this is necessary, dont remove this line.
		$sqlresult = $objDb->dbQuery($sSQL);
        $recordsCount = $objDb->totalRecords();




//////////

while ($data = $objDb->dbFetchArray()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from maindata where itemid = ".$cdlist[0];
	$cdsqlresult12 =  $objDb1->dbQuery($cdsql2);
	$cddata1 = $objDb1->dbFetchArray();
	$itemname = $cddata1['itemname'];
	
				

				
?>

		<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from maindata where itemid = ".$cdlist[$items-1];
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
					elseif($j==6)
					{
					
					//brown
					$colorr="#99CCCC";
					}
					elseif($j==7)
					{
					
					//brown
					$colorr="#CC66CC";
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
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
		
		<?php 
		if($isentry1=="Yes")
		{
		
		$sql_b="Select * from activity where itemid=$itemid AND temp_id=$temp_id";
			$res_b=$objDb2->dbQuery($sql_b);
			$i=1;
			while($row3_b=$objDb2->dbFetchArray())
			{
			$aid=$row3_b['aid'];
			?>
			
			
			
			
			  <?php  
			   
			  
				 $sqlg="Select * from baseline where rid=".$row3_b['rid'] ;
				$resg=$objDb1->dbQuery($sqlg);
				$row3g=$objDb1->dbFetchArray();
				
							
				?>
				
				<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><?php if($row3g['base_desc']!="") { echo $row3g['base_desc']; } else { echo "&nbsp;"; }?></td>
				
              
			<td style=" font-size:10px; text-align:center;  color: #000000; background-color: <?php echo $colorr; ?>"><?=$row3_b['startdate'];?></td>
			<td style=" font-size:10px; text-align:center;  color: #000000; background-color: <?php echo $colorr; ?>"><?=$row3_b['enddate'];?></td>
			<td style=" font-size:10px;  text-align:right;  color: #000000; background-color: <?php echo $colorr; ?>"><?=$row3_b['baseline'];?></td>
			<?php
			$i=$i+1;
			}
			}
			else
			{
			?>
            
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<?php
			}
			?>
		<!--<td style=" font-size:10px; text-align:center;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">		</td>-->
		<?php  if($activitylevel==0)
		{
		$editlink='subactivity.php';
		$redirect="subactivity.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		else if($activitylevel>0)
		{
		$editlink='subactivity.php';
		$redirect="subactivity.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		$deletelink='subactivity.php';
		$deletelinkoutput='output.php';
		
		  ?>
		
			 <?php
	  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
		
		  <?php if($cddata['isentry']==0)
		{	
		?>
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=650,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		<?php
		 }?>
		 <?php  if($activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=650,height=550,scrollbars=yes');" >Edit</a> 
		
		<?php if($mdataadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Activity and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=550,height=650,scrollbars=yes');" >Edit</a>  
		
		<?php 
			 if($mdataadm_flag==1)
		{
		?>
		|
	
			<a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Activity and all of its child?')">Delete</a>
			<?php
			
		}
		?>
		
		<?php } ?>
		 	 </td>
		<?php
		}
		?>
		 <!--<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="log.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" target="_blank"><?php echo LOG;?></a>
	
		 </td>-->
	
		</tr>
		<tr>
		<td colspan="10">
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
					//document.getElementById("addnew"+id).style.display="block";
					
				 // document.getElementById("search").style.border="1px solid #A5ACB2";
				  
				
				 
				}
			  }
			
			  xmlhttp3.open("GET","reloadmaindata.php?itemid="+id,true);
			  xmlhttp3.send();
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 
		  <?php
		  }
		  ?>
		</td></tr>
		
	
	<?php        
			}
		
	?>

	</table>
	<h6 class="text-end mt-1"> Number of Records : <?php echo $recordsCount ?> </h6>